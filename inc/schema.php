<?php
/**
 * Site-wide structured data, added to the graph Yoast SEO already prints.
 *
 * Yoast writes the WebPage, WebSite, BreadcrumbList and Organization pieces.
 * This file only enriches them with what the theme owns — the head office,
 * opening hours, social profiles and memberships printed in the footer and trust
 * strip, and the homepage FAQ — so the schema cannot drift from the visible page.
 * Everything is server-rendered into the one JSON-LD block, which is what keeps
 * it safe behind the Cloudflare page cache.
 *
 * Nothing here runs unless Yoast's schema filters fire, so deactivating Yoast
 * removes the output cleanly instead of printing a second, competing block.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Splits the footer's head-office address into schema.org address parts.
 *
 * The footer holds one free-text address, so the parts are read from its
 * punctuation: the last part is the country, and working back from it come the
 * region, the locality and the street. "Subarna Shamsher Marg, Kathmandu,
 * Bagmati Province, Nepal" gives all four; a shorter address simply gives fewer.
 *
 * @since 1.0.0
 *
 * @return array PostalAddress, or an empty array when the footer has no address.
 */
function iflynepal_schema_postal_address() {
	$text  = str_ireplace( array( '<br>', '<br/>', '<br />' ), ',', iflynepal_footer_office_field( 'address' ) );
	$parts = array_values( array_filter( array_map( 'trim', explode( ',', wp_strip_all_tags( str_replace( "\n", ',', $text ) ) ) ), 'strlen' ) );

	if ( ! $parts ) {
		return array();
	}

	$address = array( '@type' => 'PostalAddress' );
	$country = array_pop( $parts );

	if ( ! $parts ) {
		$address['addressCountry'] = $country;

		return $address;
	}

	$address['addressCountry'] = 'nepal' === strtolower( $country ) ? 'NP' : $country;

	if ( count( $parts ) >= 3 ) {
		$address['addressRegion'] = array_pop( $parts );
	}

	$address['addressLocality'] = array_pop( $parts );

	if ( $parts ) {
		$address['streetAddress'] = implode( ', ', $parts );
	}

	return $address;
}

/**
 * The footer's office hours as an OpeningHoursSpecification.
 *
 * Reads "9:00 AM to 5:00 PM" from the footer. The footer prints no days, so the
 * days come from a filter; Nepal's working week runs Sunday to Friday.
 *
 * @since 1.0.0
 *
 * @return array[] Zero or one specification.
 */
function iflynepal_schema_opening_hours() {
	if ( ! preg_match( '/(\d{1,2}(?::\d{2})?\s*[AP]M)\D+(\d{1,2}(?::\d{2})?\s*[AP]M)/i', iflynepal_footer_office_field( 'hours' ), $match ) ) {
		return array();
	}

	$opens  = strtotime( $match[1] );
	$closes = strtotime( $match[2] );

	if ( false === $opens || false === $closes ) {
		return array();
	}

	/**
	 * Filters the days the office keeps the hours printed in the footer.
	 *
	 * @since 1.0.0
	 *
	 * @param string[] $days schema.org day names.
	 */
	$days = apply_filters( 'iflynepal_schema_opening_days', array( 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday' ) );

	return array(
		array(
			'@type'     => 'OpeningHoursSpecification',
			'dayOfWeek' => array_values( $days ),
			'opens'     => gmdate( 'H:i', $opens ),
			'closes'    => gmdate( 'H:i', $closes ),
		),
	);
}

/**
 * The languages the office answers in, as English names.
 *
 * Polylang names a language in its own tongue ("Français"); schema.org wants
 * the English name or an IETF code, so the code is used.
 *
 * @since 1.0.0
 *
 * @return string[] Language codes, e.g. en, fr.
 */
function iflynepal_schema_languages() {
	if ( function_exists( 'pll_languages_list' ) ) {
		$codes = pll_languages_list( array( 'fields' => 'slug' ) );

		if ( $codes ) {
			return array_values( $codes );
		}
	}

	return array( 'en' );
}

/**
 * The bodies named in the "Licensed & Certified" strip.
 *
 * @since 1.0.0
 *
 * @return array[] Organization nodes, name and (where known) the official site.
 */
function iflynepal_schema_memberships() {
	/**
	 * Filters the memberships printed in the trust strip.
	 *
	 * @since 1.0.0
	 *
	 * @param array $bodies Official URL keyed by name; an empty URL names the body only.
	 */
	$bodies = apply_filters(
		'iflynepal_schema_memberships',
		array(
			'Nepal Tourism Board' => 'https://ntb.gov.np/',
			"Trekking Agencies' Association of Nepal (TAAN)" => 'https://taan.org.np/',
			'Nepal Mountaineering Association'       => 'https://www.nepalmountaineering.org/',
			'Kathmandu Environmental Education Project' => 'https://keepnepal.org/',
		)
	);

	$members = array();

	foreach ( $bodies as $name => $url ) {
		$node = array(
			'@type' => 'Organization',
			'name'  => $name,
		);

		if ( '' !== $url ) {
			$node['url'] = esc_url_raw( $url );
		}

		$members[] = $node;
	}

	return $members;
}

/**
 * Enriches Yoast's Organization with what the footer already says.
 *
 * @since 1.0.0
 *
 * @param array $data Organization piece.
 * @return array
 */
function iflynepal_schema_organization( $data ) {
	$data['@type'] = array( 'Organization', 'TravelAgency' );

	$address = iflynepal_schema_postal_address();

	if ( $address ) {
		$data['address'] = $address;
	}

	$hours = iflynepal_schema_opening_hours();

	if ( $hours ) {
		$data['openingHoursSpecification'] = $hours;
	}

	/**
	 * Filters the head office's coordinates, as array( 'latitude' => …, 'longitude' => … ).
	 *
	 * Empty by default: coordinates are not stored anywhere on the site, and a
	 * guessed pin is worse than none.
	 *
	 * @since 1.0.0
	 *
	 * @param array $geo Latitude and longitude, or empty.
	 */
	$geo = apply_filters( 'iflynepal_schema_geo', array() );

	if ( ! empty( $geo['latitude'] ) && ! empty( $geo['longitude'] ) ) {
		$data['geo'] = array(
			'@type'     => 'GeoCoordinates',
			'latitude'  => (float) $geo['latitude'],
			'longitude' => (float) $geo['longitude'],
		);
	}

	$same_as = isset( $data['sameAs'] ) ? (array) $data['sameAs'] : array();

	foreach ( iflynepal_footer_socials() as $social ) {
		$same_as[] = esc_url_raw( $social['url'] );
	}

	$data['sameAs'] = array_values( array_unique( array_filter( $same_as ) ) );

	$phone = trim( iflynepal_footer_office_field( 'phone' ) );
	$email = sanitize_email( iflynepal_footer_office_field( 'email' ) );

	if ( '' !== $phone || '' !== $email ) {
		$point = array(
			'@type'             => 'ContactPoint',
			'contactType'       => 'customer service',
			'availableLanguage' => iflynepal_schema_languages(),
		);

		if ( '' !== $phone ) {
			$point['telephone'] = $phone;
		}

		if ( '' !== $email ) {
			$point['email'] = $email;
		}

		$data['contactPoint'] = array( $point );
	}

	$data['memberOf'] = iflynepal_schema_memberships();

	if ( defined( 'IFLYNEPAL_PACKAGE_TAXONOMY' ) ) {
		$types = get_terms(
			array(
				'taxonomy'   => IFLYNEPAL_PACKAGE_TAXONOMY,
				'parent'     => 0,
				'hide_empty' => true,
				'fields'     => 'names',
			)
		);

		if ( $types && ! is_wp_error( $types ) ) {
			$data['knowsAbout'] = array_values( $types );
		}
	}

	return $data;
}
add_filter( 'wpseo_schema_organization', 'iflynepal_schema_organization' );

/**
 * The @id of the first graph piece of a type.
 *
 * @since 1.0.0
 *
 * @param array  $graph Graph pieces.
 * @param string $type  schema.org type.
 * @return string The @id, or an empty string.
 */
function iflynepal_schema_piece_id( $graph, $type ) {
	foreach ( $graph as $piece ) {
		if ( isset( $piece['@type'], $piece['@id'] ) && in_array( $type, (array) $piece['@type'], true ) ) {
			return $piece['@id'];
		}
	}

	return '';
}

/**
 * Adds the homepage's FAQ and package list to the graph.
 *
 * The FAQ is read from the same Customizer settings that print the visible
 * accordion, so question and answer text match the page word for word.
 *
 * @since 1.0.0
 *
 * @param array $graph Graph pieces.
 * @return array
 */
function iflynepal_schema_home_graph( $graph ) {
	if ( ! is_front_page() ) {
		return $graph;
	}

	$page_id = iflynepal_schema_piece_id( $graph, 'WebPage' );
	$part_of = $page_id ? array( '@id' => $page_id ) : array();
	$faq     = array();

	foreach ( iflynepal_faq_items() as $item ) {
		$answer = trim( wp_strip_all_tags( $item['answer'] ) );

		if ( '' === $answer ) {
			continue;
		}

		$faq[] = array(
			'@type'          => 'Question',
			'name'           => $item['question'],
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => $answer,
			),
		);
	}

	if ( $faq ) {
		$piece = array(
			'@type'      => 'FAQPage',
			'@id'        => trailingslashit( home_url( '/' ) ) . '#faq',
			'mainEntity' => $faq,
		);

		if ( $part_of ) {
			$piece['isPartOf'] = $part_of;
		}

		$graph[] = $piece;
	}

	if ( function_exists( 'iflynepal_upcoming_departure_packages' ) ) {
		$items    = array();
		$position = 0;

		foreach ( iflynepal_upcoming_departure_packages() as $package ) {
			$items[] = array(
				'@type'    => 'ListItem',
				'position' => ++$position,
				'url'      => get_permalink( $package ),
				'name'     => get_the_title( $package ),
			);
		}

		if ( $items ) {
			$piece = array(
				'@type'           => 'ItemList',
				'@id'             => trailingslashit( home_url( '/' ) ) . '#upcoming-journeys',
				'name'            => __( 'Upcoming journeys', 'iflynepal' ),
				'itemListElement' => $items,
			);

			if ( $part_of ) {
				$piece['isPartOf'] = $part_of;
			}

			$graph[] = $piece;
		}
	}

	return $graph;
}
add_filter( 'wpseo_schema_graph', 'iflynepal_schema_home_graph' );

/**
 * Types the Contact Us page as a ContactPage and ties it to the Organization.
 *
 * Yoast prints every page as a plain WebPage. The page is found by its template
 * so the translated copy is typed the same way.
 *
 * @since 1.0.0
 *
 * @param array $data WebPage piece.
 * @return array
 */
function iflynepal_schema_contact_page( $data ) {
	if ( ! is_page_template( 'page-contact-us.php' ) ) {
		return $data;
	}

	$data['@type']      = 'ContactPage';
	$data['mainEntity'] = array( '@id' => trailingslashit( home_url( '/' ) ) . '#organization' );

	return $data;
}
add_filter( 'wpseo_schema_webpage', 'iflynepal_schema_contact_page' );

/**
 * Puts CollectionPage first in the blog page's type list.
 *
 * Yoast prints the blog page as [ WebPage, CollectionPage ]. The page is a
 * listing, so the specific type leads and WebPage follows.
 *
 * @since 1.0.0
 *
 * @param array $data WebPage graph piece.
 * @return array
 */
function iflynepal_schema_blog_page( $data ) {
	if ( is_home() && ! is_front_page() ) {
		$data['@type'] = array( 'CollectionPage', 'WebPage' );
	}

	return $data;
}
add_filter( 'wpseo_schema_webpage', 'iflynepal_schema_blog_page' );

/**
 * Types a single blog article as a BlogPosting.
 *
 * Yoast prints it as a plain Article. BlogPosting is the schema.org type for one
 * post; Blog itself is the container type for the whole blog, so it is not used.
 *
 * @since 1.0.0
 *
 * @param string|string[] $type Article type.
 * @return string|string[]
 */
function iflynepal_schema_article_type( $type ) {
	return is_singular( array( 'post', IFLYNEPAL_ARTICLE_POST_TYPE ) ) ? 'BlogPosting' : $type;
}
add_filter( 'wpseo_schema_article_type', 'iflynepal_schema_article_type' );

/**
 * Sets the Organization's legal name on the finished graph.
 *
 * Yoast fills legalName from its own settings after the organization filter has
 * run, so the value is set here, once the whole graph is built.
 *
 * @since 1.0.0
 *
 * @param array $graph Graph pieces.
 * @return array
 */
function iflynepal_schema_legal_name( $graph ) {
	/**
	 * Filters the registered company name, as on the registration certificate.
	 *
	 * @since 1.0.0
	 *
	 * @param string $legal_name Legal name.
	 */
	$legal_name = apply_filters( 'iflynepal_schema_legal_name', 'iFly Nepal Pvt. Ltd.' );

	foreach ( $graph as $key => $piece ) {
		if ( isset( $piece['@type'] ) && in_array( 'Organization', (array) $piece['@type'], true ) ) {
			$graph[ $key ]['legalName'] = $legal_name;
		}
	}

	return $graph;
}
add_filter( 'wpseo_schema_graph', 'iflynepal_schema_legal_name', 20 );

/**
 * Adds the homepage's team members and customer reviews to the graph.
 *
 * Both are read from the same getters that print the visible sections, so the
 * names, roles and quotes match the page. No rating is stated: the site stores
 * none, and an invented one is against Google's review guidelines.
 *
 * @since 1.0.0
 *
 * @param array $graph Graph pieces.
 * @return array
 */
function iflynepal_schema_home_people_reviews( $graph ) {
	if ( ! is_front_page() ) {
		return $graph;
	}

	$org_id = iflynepal_schema_piece_id( $graph, 'Organization' );
	$base   = trailingslashit( home_url( '/' ) );

	if ( function_exists( 'iflynepal_team_members' ) ) {
		foreach ( iflynepal_team_members() as $card ) {
			$name = trim( wp_strip_all_tags( $card['name'] ) );
			$role = trim( wp_strip_all_tags( $card['role'] ) );

			$person = array(
				'@type' => 'Person',
				'@id'   => $base . '#team-' . $card['index'],
				'name'  => $name,
			);

			if ( '' !== $role ) {
				$person['jobTitle'] = $role;
			}

			$image = iflynepal_team_member_image_url( $card['index'] );

			if ( '' !== $image ) {
				$person['image'] = esc_url_raw( $image );
			}

			if ( $org_id ) {
				$person['worksFor'] = array( '@id' => $org_id );
			}

			$graph[] = $person;
		}
	}

	if ( function_exists( 'iflynepal_get_testimonials' ) ) {
		foreach ( iflynepal_get_testimonials() as $testimonial ) {
			$review = array(
				'@type'      => 'Review',
				'@id'        => $base . '#review-' . $testimonial['id'],
				'reviewBody' => trim( wp_strip_all_tags( $testimonial['body'] ) ),
			);

			$headline = trim( wp_strip_all_tags( $testimonial['headline'] ) );
			$author   = trim( wp_strip_all_tags( $testimonial['name'] ) );

			if ( '' !== $headline ) {
				$review['name'] = $headline;
			}

			if ( '' !== $author ) {
				$review['author'] = array(
					'@type' => 'Person',
					'name'  => $author,
				);
			}

			if ( $org_id ) {
				$review['itemReviewed'] = array( '@id' => $org_id );
			}

			$graph[] = $review;
		}
	}

	return $graph;
}
add_filter( 'wpseo_schema_graph', 'iflynepal_schema_home_people_reviews' );
