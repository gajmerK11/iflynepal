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
			'TAAN'                => 'https://taan.org.np/',
			'NMA'                 => '',
			'KEEP'                => '',
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
