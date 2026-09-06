<?php
/**
 * About Nepal page getters and selective-refresh render callbacks.
 *
 * Loaded on every request, not only inside customize_register, because the
 * partial render callbacks below have to exist when the Customizer asks the
 * front end to re-render a fragment.
 *
 * The page is nine chapters that all share one shape — a centred head, a wide
 * banner, then the source copy — so the chapters are a registry rather than
 * nine near-identical runs of code, and the getters take a slug. Only the
 * pieces that differ (Geography's note, People's bands, Flora's regions,
 * Economy's sectors, Safety's list, the Visa permit) have code of their own.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Paragraphs a chapter's prose block can carry.
 *
 * Changing this needs a matching change to the max passed into
 * assets/js/about-country/repeaters.js.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_COUNTRY_PARAGRAPH_MAX = 8;

/**
 * Cards the People chapter can carry.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_COUNTRY_BAND_MAX = 6;

/**
 * Rows the Flora and Fauna chapter can carry.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_COUNTRY_REGION_MAX = 8;

/**
 * Sectors the Economy chapter can carry.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_COUNTRY_SECTOR_MAX = 6;

/**
 * Points the Safety chapter's list can carry.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_COUNTRY_SAFETY_MAX = 16;

/* ------------------------------------------------------------------- hero */

/**
 * Default hero headline.
 *
 * `em` marks the figure that takes the gold accent, the same as the front
 * page's and the About page's headlines. The full stop sits outside the
 * accent, as the design has it.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_COUNTRY_HERO_TITLE_DEFAULT = 'From 60 metres to <em>8,848</em>.';

/**
 * Default hero sub-title.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_COUNTRY_HERO_LEAD_DEFAULT = 'Nepal is located in South Asia between China in the north and India in the south, east and west.';

/**
 * Stand-in hero photograph, used until the client's own image is uploaded.
 *
 * The hero is a photograph under a scrim, so it needs an image to be the thing
 * the design describes at all. The file lives in assets/images/about-country,
 * named for this section, so swapping it is a matter of replacing the file at
 * that path.
 *
 * @since 1.0.0
 */
define( 'IFLYNEPAL_COUNTRY_HERO_IMAGE_DEFAULT', IFLYNEPAL_URI . '/assets/images/about-country/hero-from-60-metres-to-8848.jpg' );

/**
 * Hero headline.
 *
 * @since 1.0.0
 *
 * @return string Headline HTML.
 */
function iflynepal_country_hero_title() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_country_hero_title', IFLYNEPAL_COUNTRY_HERO_TITLE_DEFAULT ) );
}

/**
 * Hero sub-title.
 *
 * @since 1.0.0
 *
 * @return string Sub-title HTML.
 */
function iflynepal_country_hero_lead() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_country_hero_lead', IFLYNEPAL_COUNTRY_HERO_LEAD_DEFAULT ) );
}

/**
 * Hero photograph URL.
 *
 * @since 1.0.0
 *
 * @return string Image URL, falling back to the design's stand-in.
 */
function iflynepal_country_hero_image_url() {
	$attachment_id = (int) get_theme_mod( 'iflynepal_country_hero_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'full' );

		if ( $url ) {
			return $url;
		}
	}

	return IFLYNEPAL_COUNTRY_HERO_IMAGE_DEFAULT;
}

/* --------------------------------------------------------------- chapters */

/**
 * The nine chapters, in the order they appear on the page.
 *
 * `label` is what the index bar shows and is deliberately shorter than the
 * heading — "Flora & fauna" rather than "Flora and Fauna". `mist` marks the
 * chapters that sit on the tinted band, which alternate down the page.
 * `banner` is empty for a chapter the design gives no photograph.
 *
 * @since 1.0.0
 *
 * @return array[] Chapters keyed by slug.
 */
function iflynepal_country_chapters() {
	return array(
		'geography' => array(
			'label'      => __( 'Geography', 'iflynepal' ),
			'eyebrow'    => __( 'Where it sits', 'iflynepal' ),
			'title'      => __( 'Geography', 'iflynepal' ),
			'banner'     => IFLYNEPAL_URI . '/assets/images/about-country/geography-banner.jpg',
			'banner_alt' => __( 'A high Himalayan view in Nepal', 'iflynepal' ),
			'mist'       => false,
			'paragraphs' => array(
				1 => __( 'Nepal is located in South Asia between China in the north and India in the south, east and west. The total land area is 147,181 sq. km including water area of the country that is 3,830 sq. km. The geographical coordinates are 28&deg;00&prime;N 84&deg;00&prime;E. Nepal falls in the temperate zone north of the Tropic of Cancer. Nepal&rsquo;s ecological zone run east to west about 800 km along its Himalayan axis, 150 to 250 km north to south, and is vertically intersected by the river systems. The country is divided into three main geographical regions: Himalayan region, mid hill region and Terai region. The highest point in the country is Mt. Everest (8,848 m) while the lowest point is in the Terai plains of Kechana Kalan in Jhapa (60 m).', 'iflynepal' ),
				2 => __( 'The Terai region, with width of ranging 26 to 32 km and altitude ranging from 60 -305 m, occupies about 17 percent of total land area of the country. Kechana Kalan, the lowest point of the country with an altitude of 60 m, lies in Jhapa district of the eastern Terai. The southern lowland Terai continues to the Bhabar belt covered with the Char Kose Jhadi forests known for rich wildlife. Further north, the Siwalik zone (700 &ndash; 1,500 m) and the Mahabharat range (1,500 &ndash; 2,700 m) give way to the Duns (valleys), such as Trijuga, Sindhuli, Chitwan, Dang and Surkhet. The Midlands (600 &ndash; 3,500 m), north of the Mahabharat range is where the two beautiful valleys of Kathmandu and Pokhara lie covered in terraced rice fields, and surrounded by forested watersheds.', 'iflynepal' ),
				3 => __( 'The Himalayas (above 3,000 m) comprises mountains, alpine pastures and temperate forests limited by the tree-line (4,000 m) and snow line (5,500 m). Eight of the 14 eight-thousanders of the world lie in Nepal: Sagarmatha or Mount Everest (8,848 m), Kanchenjunga (8,586 m), Lhotse (8,516 m), Makalu (8,463 m), Cho Oyu (8,201m), Dhaulagiri (8,167 m), Manaslu (8,163 m) and Annapurna (8,091 m). The inner Himalayan valley (above 3,600 m) such as Mustang and Dolpa are cold deserts sharing topographical characteristics with the Tibetan plateau. Nepal holds the so called &ldquo;waters towers of South Asia&rdquo; with its 6,000 rivers which are snow-fed or dependent on rain. The perennial rivers include Mahakali, Karnali, Narayani and Koshi rivers originating in the Himalayas. Medium-sized rivers like Babai, West Rapti, Bagmati, Kamla, Kankai and Mechi originate in the Midlands and Mahabharat range. A large number of seasonal streams, mostly originating in Siwaliks, flow across the Terai.', 'iflynepal' ),
				4 => __( 'Of 163 wetlands documented, the nine globally recognized Ramsar sites are: Koshi Tappu Wildlife Reserve, Beeshazarital (Chitwan), Jagdishpur Reservoir (Kapilvastu) Ghodaghodi Tal (Kailali) in the Terai, and Gokyo (Solukhumbu), Phoksundo (Dolpa), Rara (Mugu) and Mai Pokhari (Ilam) in the mountain region. There are more than 30 natural caves in the country out of which only a few are accessible by road. Maratika Cave (also known as Haleshi) is a pilgrimage site associated with Buddhism and Hinduism. Siddha Cave is near Bimalnagar along the Kathmandu-Pokhara highway. Pokhara is also known for caves namely Bats&rsquo; shed, Batulechar, Gupteswar, Patale Chhango. The numerous caves around Lo Manthang in Mustang include Luri and Tashi Kabum which house ancient murals and chhortens dating back to the 13th century.', 'iflynepal' ),
			),
		),
		'people'    => array(
			'label'      => __( 'People', 'iflynepal' ),
			'eyebrow'    => __( 'Who lives here', 'iflynepal' ),
			'title'      => __( 'People', 'iflynepal' ),
			'banner'     => IFLYNEPAL_URI . '/assets/images/about-country/people-banner.jpg',
			'banner_alt' => __( 'A cultural gathering in Kathmandu, Nepal', 'iflynepal' ),
			'mist'       => true,
			'paragraphs' => array(
				1 => __( 'The population of Nepal was recorded to be about 26.62 million according to a recent survey done by the Central Bureau of Statistics, Nepal. The population comprises of about a 101 ethnic groups speaking over 92 languages. The distinction in caste and ethnicity is understood more easily with a view of customary layout of the population. Though, there exist numerous dialects, the language of unification is the national language, Nepali. Nepali is the official language of the state, spoken and understood by majority of the population. Multiple ethnic groups have their own mother tongues. English is spoken by many in Government and business offices. It is the mode of education in most private schools of Kathmandu and some other cities.', 'iflynepal' ),
			),
		),
		'history'   => array(
			'label'      => __( 'History', 'iflynepal' ),
			'eyebrow'    => __( 'How it got here', 'iflynepal' ),
			'title'      => __( 'History', 'iflynepal' ),
			'banner'     => IFLYNEPAL_URI . '/assets/images/about-country/history-banner.jpg',
			'banner_alt' => __( 'People walking through Kathmandu Durbar Square', 'iflynepal' ),
			'mist'       => false,
			'paragraphs' => array(
				1 => __( 'Records mention the Gopalas and Mahishapalas believed to have been the earliest rulers with their capital at Matatirtha, the south-west corner of the Kathmandu Valley. From the 7th or 8th Century B.C. the Kirantis are said to have ruled the valley. Their famous King Yalumber is even mentioned in the epic, &lsquo;Mahabharat&rsquo;. Around 300 A.D. the Lichhavis arrived from northern India and overthrew the Kirantis. One of the legacies of the Lichhavis is the Changu Narayan Temple near Bhaktapur, a UNESCO World Heritage Site (Culture), which dates back to the 5th Century. In the early 7th Century, Amshuvarma, the first Thakuri king took over the throne from his father-in-law who was a Lichhavi. He married off his daughter Bhrikuti to the famous Tibetan King Tsong Tsen Gampo thus establishing good relations with Tibet. The Lichhavis brought art and architecture to the valley but the golden age of creativity arrived in 1200 A.D with the Mallas.', 'iflynepal' ),
				2 => __( 'During their 550 year rule, the Mallas built numerous temples and splendid palaces with picturesque squares. It was also during their rule that society and the cities became well organized; religious festivals were introduced and literature, music and art were encouraged. After the death of Yaksha Malla, the valley was divided into three kingdoms: Kathmandu (Kantipur), Bhaktapur (Bhadgaon) and Patan (Lalitpur). Around this time, the Nepal as we know it today was divided into about 46 independent principalities. One among these was the kingdom of Gorkha with a Shah ruler. Much of Kathmandu Valley&rsquo;s history around this time was recorded by Capuchin friars who lived in the valley on their way in and out of Tibet. An ambitious Gorkha King named Prithvi Narayan Shah embarked on a conquering mission that led to the defeat of all the kingdoms in the valley (including Kirtipur which was an independent state) by 1769. Instead of annexing the newly acquired states to his kingdom of Gorkha, Prithvi Narayan decided to move his capital to Kathmandu establishing the Shah dynasty which ruled unified Nepal from 1769 to 2008.', 'iflynepal' ),
				3 => __( 'The history of the Gorkha state goes back to 1559 when Dravya Shah established a kingdom in an area chiefly inhabited by Magars. During the 17th and early 18th centuries, Gorkha continued a slow expansion, conquering various states while forging alliances with others. Prithvi Narayan dedicated himself at an early age to the conquest of the Kathmandu Valley. Recognizing the threat of the British Raj in India, he dismissed European missionaries from the country and for more than a century, Nepal remained in isolation.', 'iflynepal' ),
				4 => __( 'During the mid-19th Century Jung Bahadur Rana became Nepal&rsquo;s first prime minister to wield absolute power relegating the Shah king to mere figureheads. He started a hereditary reign of the Rana Prime Ministers that lasted for 104 years. The Ranas were overthrown in a democracy movement of the early 1950s with support from the-then monarch of Nepal, King Tribhuvan. Soon after the overthrow of the Ranas, King Tribhuvan was reinstated as the Head of the State. In early 1959, Tribhuvan&rsquo;s son King Mahendra issued a new constitution, and the first democratic elections for a national assembly were held. The Nepali Congress Party was victorious and their leader, Bishweshwar Prasad Koirala formed a government and served as prime minister. But by 1960, King Mahendra had changed his mind and dissolved Parliament, dismissing the first democratic government.', 'iflynepal' ),
				5 => __( 'After many years of struggle when the political parties were banned, they finally mustered enough courage to start a People&rsquo;s Movement in 1990. Paving way for democracy, the then-King Birendra accepted constitutional reforms and established a multiparty parliament with King as the Head of State and an executive Prime Minister. In May 1991, Nepal held its first parliamentary elections. In February 1996, the Maoist parties declared People&rsquo;s War against monarchy and the elected government. Then on 1st June 2001, a horrific tragedy wiped out the entire royal family including King Birendra and Queen Aishwarya with many of their closest relatives. With only King Birendra&rsquo;s brother, Gyanendra and his family surviving, he was crowned the king. King Gyanendra abided by the elected government for some time and then dismissed the elected Parliament to wield absolute power. In April 2006, another People&rsquo;s Movement was launched jointly by the democratic parties focusing most energy in Kathmandu which led to a 19-day curfew. Eventually, King Gyanendra relinquished his power and reinstated the Parliament. On November 21, 2006, Prime Minister Girija Prasad Koirala and Maoist chairman Prachanda signed the Comprehensive Peace Agreement (CPA) 2006, committing to democracy and peace for the progress of the country and people. A Constituent Assembly election was held on April 10, 2008. On May 28, 2008, the newly elected Constituent Assembly declared Nepal a Federal Democratic Republic, abolishing the 240 year-old monarchy. Nepal today has a President as Head of State and a Prime Minister heading the Government.', 'iflynepal' ),
			),
		),
		'climate'   => array(
			'label'      => __( 'Climate', 'iflynepal' ),
			'eyebrow'    => __( 'When to come', 'iflynepal' ),
			'title'      => __( 'Climate of Nepal', 'iflynepal' ),
			'banner'     => IFLYNEPAL_URI . '/assets/images/about-country/climate-banner.jpg',
			'banner_alt' => __( 'Lake and mountain landscape in Nepal', 'iflynepal' ),
			'mist'       => true,
			'paragraphs' => array(
				1 => __( 'Climatic conditions of Nepal vary from one place to another in accordance with their geographical features. In the north summers are cool and winters severe, while in the south summers are tropical and winters are mild. Nepal has five seasons: spring, summer, monsoon, autumn and winter.', 'iflynepal' ),
				2 => __( 'In the Terai (south Nepal), summer temperatures exceed 37&deg; C and higher in some areas, winter temperatures range from 7&deg;C to 23&deg;C in the Terai. In mountainous regions, hills and valleys, summers are temperate while winter temperatures can plummet under sub zero. The Kathmandu Valley has a pleasant climate with average summer and winter temperatures of 19&deg;C &ndash; 35&deg;C and 2&deg;C &ndash; 12&deg;C respectively.', 'iflynepal' ),
				3 => __( 'Good to know is that on average temperatures drop 6&deg;C for every 1,000 m you gain in altitude. The Himalayas act as a barrier to the cold winds blowing from Central Asia in winter, and forms the northern boundary of the monsoon wind patterns. Eighty percent of all the rain in Nepal is received during the monsoon (June-September). Winter rains are more pronounced in the western hills. The average annual rainfall is 1,600 mm, but it varies by eco-climatic zones, such as 3,345 mm in Pokhara and below 300 mm in Mustang.', 'iflynepal' ),
				4 => __( 'There is no seasonal constraint on traveling in and through Nepal. Even in December and January, when winter is at its severest, there are compensating bright sun and brilliant views. As with most of the trekking areas in Nepal, the best time to visit are during spring and autumn. Spring is the time for rhododendrons while the clearest skies are found after the monsoon in October and November. However, Nepal can be visited the whole year round. Average temperatures and rainfall during peak summer and winter in three most popular tourist areas:', 'iflynepal' ),
			),
		),
		'politics'  => array(
			'label'      => __( 'Politics', 'iflynepal' ),
			'eyebrow'    => __( 'How it is governed', 'iflynepal' ),
			'title'      => __( 'Politics', 'iflynepal' ),
			'banner'     => IFLYNEPAL_URI . '/assets/images/about-country/politics-banner.jpg',
			'banner_alt' => __( 'Kathmandu Durbar Square in Nepal', 'iflynepal' ),
			'mist'       => false,
			'paragraphs' => array(
				1 => __( 'On the 21 November 2005 a peace agreement between the Government of Nepal and the Maoists was signed, thereby ending a decade long conflict in Nepal. Both sides agreed to a permanent ceasefire.', 'iflynepal' ),
				2 => __( 'In 2008 a Constituent Assembly was sworn in following a democratic election and the Constituent Assembly declared Nepal a republic.', 'iflynepal' ),
				3 => __( 'The Maoist-led coalition government took office in September 2008, but in May 2009 the Prime Minister announced his resignation, increasing political uncertainty.', 'iflynepal' ),
				4 => __( 'A new Prime Minister was sworn in, supported by all parties except the Maoists.', 'iflynepal' ),
			),
		),
		'flora'     => array(
			'label'      => __( 'Flora & fauna', 'iflynepal' ),
			'eyebrow'    => __( 'What grows and what lives here', 'iflynepal' ),
			'title'      => __( 'Flora and Fauna', 'iflynepal' ),
			'banner'     => '',
			'banner_alt' => '',
			'mist'       => false,
			'paragraphs' => array(
				1 => __( 'Ranging from the subtropical forests of the Terai to the great peaks of the Himalayas in the north, Nepal abounds with some of the most spectacular sceneries in the whole of Asia, with a variety of fauna and flora also unparalleled elsewhere in the region. Between Nepal&rsquo;s geographical extremes, one may find every vegetational type, from the treeless steppes of the Trans-Himalayan region in the extreme north and the birch, silver fir, larch and hemlock of the higher valleys to the oak, pine and rhododendron of the intermediate altitudes and the great sal and sissau forests of the south.', 'iflynepal' ),
				2 => __( 'The rolling densely forested hills and broad Dun valleys of the Terai along with other parts of the country, were formerly, renowned for their abundance and variety o wildlife. Though somewhat depleted as a result of agricultural settlements, deforestation, poaching and other causes, Nepal can still boast richer and more varied flora and fauna than any other area in Asia. For practical purposes, Nepal&rsquo;s flora and fauna can be divided into four regions:-', 'iflynepal' ),
			),
		),
		'economy'   => array(
			'label'      => __( 'Economy', 'iflynepal' ),
			'eyebrow'    => __( 'How it earns', 'iflynepal' ),
			'title'      => __( 'Economy', 'iflynepal' ),
			'banner'     => IFLYNEPAL_URI . '/assets/images/about-country/economy-banner.jpg',
			'banner_alt' => __( 'Farmers planting rice in Chitwan, Nepal', 'iflynepal' ),
			'mist'       => true,
			'paragraphs' => array(
				1 => __( 'Nepal is developing county with an agricultural economy. In recent years, the country&rsquo;s efforts to expand into manufacturing industries and other technological sectors have achieved much progress. Farming is the main economic activity followed by manufacturing, trade and tourism. The chief sources of foreign currency earnings are marchandise export, services, tourism and Gurkha remittances. The annual Gross Domestic Product (GDP) is about US$ 4.3 Billion.', 'iflynepal' ),
			),
		),
		'safety'    => array(
			'label'      => __( 'Safety', 'iflynepal' ),
			'eyebrow'    => __( 'Before you go', 'iflynepal' ),
			'title'      => __( 'Safety and security.', 'iflynepal' ),
			'banner'     => IFLYNEPAL_URI . '/assets/images/about-country/safety-banner.jpg',
			'banner_alt' => __( 'A hiker admiring the Everest region in Nepal', 'iflynepal' ),
			'mist'       => false,
			'paragraphs' => array(),
		),
		'visa'      => array(
			'label'      => __( 'Visa & permits', 'iflynepal' ),
			'eyebrow'    => __( 'Paperwork', 'iflynepal' ),
			'title'      => __( 'Visa, Permits and Fees', 'iflynepal' ),
			'banner'     => IFLYNEPAL_URI . '/assets/images/about-country/visa-banner.jpg',
			'banner_alt' => __( 'Historic architecture in Kathmandu, Nepal', 'iflynepal' ),
			'mist'       => true,
			'paragraphs' => array(),
		),
	);
}

/**
 * One chapter's registry entry.
 *
 * @since 1.0.0
 *
 * @param string $slug Chapter slug.
 * @return array The entry, or an empty-valued one for a slug that has none.
 */
function iflynepal_country_chapter( $slug ) {
	$chapters = iflynepal_country_chapters();

	if ( isset( $chapters[ $slug ] ) ) {
		return $chapters[ $slug ];
	}

	return array(
		'label'      => '',
		'eyebrow'    => '',
		'title'      => '',
		'banner'     => '',
		'banner_alt' => '',
		'mist'       => false,
		'paragraphs' => array(),
	);
}

/**
 * Whether a chapter carries an editable prose block.
 *
 * Safety and Visa do not: their bodies are a checklist and a fee schedule,
 * which are components of their own rather than paragraphs.
 *
 * @since 1.0.0
 *
 * @param string $slug Chapter slug.
 * @return bool
 */
function iflynepal_country_chapter_has_prose( $slug ) {
	return in_array( $slug, array( 'geography', 'people', 'history', 'climate', 'politics', 'flora', 'economy' ), true );
}

/**
 * One chapter's kicker.
 *
 * @since 1.0.0
 *
 * @param string $slug Chapter slug.
 * @return string Kicker HTML.
 */
function iflynepal_country_chapter_eyebrow( $slug ) {
	$chapter = iflynepal_country_chapter( $slug );

	return iflynepal_kses_text( get_theme_mod( 'iflynepal_country_' . $slug . '_eyebrow', $chapter['eyebrow'] ) );
}

/**
 * One chapter's heading.
 *
 * @since 1.0.0
 *
 * @param string $slug Chapter slug.
 * @return string Heading HTML.
 */
function iflynepal_country_chapter_title( $slug ) {
	$chapter = iflynepal_country_chapter( $slug );

	return iflynepal_kses_text( get_theme_mod( 'iflynepal_country_' . $slug . '_title', $chapter['title'] ) );
}

/**
 * Whether a chapter is shown at all.
 *
 * Emptying the heading is how the Customizer hides a whole chapter, so the
 * template skips it and the index bar drops its link — the same convention
 * an emptied label uses to remove a button elsewhere in the theme.
 *
 * @since 1.0.0
 *
 * @param string $slug Chapter slug.
 * @return bool
 */
function iflynepal_country_has_chapter( $slug ) {
	return '' !== trim( wp_strip_all_tags( iflynepal_country_chapter_title( $slug ) ) );
}

/**
 * The chapters that are shown, in page order.
 *
 * @since 1.0.0
 *
 * @return array[] Entries with 'slug' and 'label'.
 */
function iflynepal_country_visible_chapters() {
	$visible = array();

	foreach ( iflynepal_country_chapters() as $slug => $chapter ) {
		if ( ! iflynepal_country_has_chapter( $slug ) ) {
			continue;
		}

		$visible[] = array(
			'slug'  => $slug,
			'label' => (string) get_theme_mod( 'iflynepal_country_' . $slug . '_label', $chapter['label'] ),
		);
	}

	return $visible;
}

/**
 * One chapter's banner photograph URL.
 *
 * @since 1.0.0
 *
 * @param string $slug Chapter slug.
 * @return string Image URL, or an empty string when the chapter has no banner.
 */
function iflynepal_country_chapter_image_url( $slug ) {
	$attachment_id = (int) get_theme_mod( 'iflynepal_country_' . $slug . '_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'full' );

		if ( $url ) {
			return $url;
		}
	}

	$chapter = iflynepal_country_chapter( $slug );

	return $chapter['banner'];
}

/**
 * One chapter's banner alt text.
 *
 * An uploaded image brings its own description from the media library; the
 * stand-in falls back to the one the design ships. A banner is illustrative
 * of the chapter it opens rather than decorative, so it is described.
 *
 * @since 1.0.0
 *
 * @param string $slug Chapter slug.
 * @return string Alt text.
 */
function iflynepal_country_chapter_image_alt( $slug ) {
	$attachment_id = (int) get_theme_mod( 'iflynepal_country_' . $slug . '_image', 0 );

	if ( $attachment_id ) {
		$alt = trim( (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) );

		if ( '' !== $alt ) {
			return $alt;
		}
	}

	$chapter = iflynepal_country_chapter( $slug );

	return $chapter['banner_alt'];
}

/**
 * One chapter's paragraphs that have text, in order.
 *
 * Emptying a paragraph is how the Customizer's Remove button deletes it, so an
 * empty slot is skipped rather than rendered as a blank line.
 *
 * @since 1.0.0
 *
 * @param string $slug Chapter slug.
 * @return string[] Paragraph HTML.
 */
function iflynepal_country_chapter_paragraphs( $slug ) {
	$chapter    = iflynepal_country_chapter( $slug );
	$paragraphs = array();

	for ( $i = 1; $i <= IFLYNEPAL_COUNTRY_PARAGRAPH_MAX; $i++ ) {
		$default = isset( $chapter['paragraphs'][ $i ] ) ? $chapter['paragraphs'][ $i ] : '';
		$value   = trim( (string) get_theme_mod( 'iflynepal_country_' . $slug . '_paragraph_' . $i, $default ) );

		if ( '' === $value ) {
			continue;
		}

		$paragraphs[] = $value;
	}

	return $paragraphs;
}

/* ------------------------------------------------- geography: image note */

/**
 * Default copy for the note under the Geography banner.
 *
 * @since 1.0.0
 *
 * @return array Note defaults.
 */
function iflynepal_country_note_defaults() {
	return array(
		'label' => __( 'Highest point', 'iflynepal' ),
		'title' => __( 'Mt. Everest, 8,848 m', 'iflynepal' ),
		'text'  => __( 'The lowest is Kechana Kalan in Jhapa, at 60 m &mdash; the two ends of the country sit 8,788 metres apart.', 'iflynepal' ),
	);
}

/**
 * One field of the Geography note.
 *
 * @since 1.0.0
 *
 * @param string $field One of the keys in iflynepal_country_note_defaults().
 * @return string Stored value, or the default.
 */
function iflynepal_country_note_field( $field ) {
	$defaults = iflynepal_country_note_defaults();
	$default  = isset( $defaults[ $field ] ) ? $defaults[ $field ] : '';

	return (string) get_theme_mod( 'iflynepal_country_note_' . $field, $default );
}

/* --------------------------------------------------------- people: bands */

/**
 * Default cards for the People chapter, as the approved design has them.
 *
 * Each card is a photograph with its name laid over it, so a card is its
 * title and its picture and nothing else.
 *
 * @since 1.0.0
 *
 * @return array[] Defaults indexed from 1.
 */
function iflynepal_country_band_defaults() {
	return array(
		1 => array(
			'title'     => __( 'Northern Himalayan People', 'iflynepal' ),
			'image'     => IFLYNEPAL_URI . '/assets/images/about-country/people-band-01-northern-himalayan.jpg',
			'image_alt' => __( 'High Himalayan terrain in northern Nepal', 'iflynepal' ),
		),
		2 => array(
			'title'     => __( 'Middle Hills and Valley People', 'iflynepal' ),
			'image'     => IFLYNEPAL_URI . '/assets/images/about-country/people-band-02-middle-hills-and-valley.jpg',
			'image_alt' => __( 'A woman carrying milk cans along a rural road in Ilam, Nepal', 'iflynepal' ),
		),
		3 => array(
			'title'     => __( 'Ethnic Diversity in the Kathmandu Valley', 'iflynepal' ),
			'image'     => IFLYNEPAL_URI . '/assets/images/about-country/people-band-03-kathmandu-valley.jpg',
			'image_alt' => __( 'People walking through Kathmandu Durbar Square', 'iflynepal' ),
		),
		4 => array(
			'title'     => __( 'Terai People', 'iflynepal' ),
			'image'     => IFLYNEPAL_URI . '/assets/images/about-country/people-band-04-terai.jpg',
			'image_alt' => __( 'Farmers planting rice in Chitwan, Nepal', 'iflynepal' ),
		),
	);
}

/**
 * One card's defaults, with empty fallbacks for an index that has none.
 *
 * @since 1.0.0
 *
 * @param int $index Card number.
 * @return array Defaults for that card.
 */
function iflynepal_country_band_default( $index ) {
	$defaults = iflynepal_country_band_defaults();

	if ( isset( $defaults[ $index ] ) ) {
		return $defaults[ $index ];
	}

	return array(
		'title'     => '',
		'image'     => '',
		'image_alt' => '',
	);
}

/**
 * One card's photograph URL.
 *
 * @since 1.0.0
 *
 * @param int $index Card number.
 * @return string Image URL, or an empty string when neither set nor defaulted.
 */
function iflynepal_country_band_image_url( $index ) {
	$attachment_id = (int) get_theme_mod( 'iflynepal_country_band_' . $index . '_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'large' );

		if ( $url ) {
			return $url;
		}
	}

	$default = iflynepal_country_band_default( $index );

	return $default['image'];
}

/**
 * One card's photograph alt text.
 *
 * The card's title is laid over the picture and does not describe it, so the
 * image carries a description of its own.
 *
 * @since 1.0.0
 *
 * @param int $index Card number.
 * @return string Alt text.
 */
function iflynepal_country_band_image_alt( $index ) {
	$attachment_id = (int) get_theme_mod( 'iflynepal_country_band_' . $index . '_image', 0 );

	if ( $attachment_id ) {
		$alt = trim( (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) );

		if ( '' !== $alt ) {
			return $alt;
		}
	}

	$default = iflynepal_country_band_default( $index );

	return $default['image_alt'];
}

/**
 * The cards that have a title, in order.
 *
 * Emptying a title is how the Customizer's Remove button deletes a card, so a
 * titleless slot is dropped rather than rendered as a bare photograph.
 *
 * @since 1.0.0
 *
 * @return array[] Cards, each with 'index' and 'title'.
 */
function iflynepal_country_bands() {
	$cards = array();

	for ( $i = 1; $i <= IFLYNEPAL_COUNTRY_BAND_MAX; $i++ ) {
		$default = iflynepal_country_band_default( $i );
		$title   = trim( (string) get_theme_mod( 'iflynepal_country_band_' . $i . '_title', $default['title'] ) );

		if ( '' === $title ) {
			continue;
		}

		$cards[] = array(
			'index' => $i,
			'title' => $title,
		);
	}

	return $cards;
}

/* -------------------------------------------------------- flora: regions */

/**
 * Default rows for the Flora and Fauna chapter, as the design has them.
 *
 * The same component as the About page's What We Offer rows: a photograph, a
 * numeral, a title and a paragraph, alternating sides down the page.
 *
 * @since 1.0.0
 *
 * @return array[] Defaults indexed from 1.
 */
function iflynepal_country_region_defaults() {
	return array(
		1 => array(
			'number'      => '01',
			'title'       => __( 'Tropical Deciduous Monsoon Forest', 'iflynepal' ),
			'description' => __( 'This includes the Terai plains and the broad flat valleys or Duns found between successive hill ranges. The dominant tree species of this area are Sal (Shorea Robusta), sometimes associated with Semal (Bombax malabricum), Asna (Terminalia termentosa), Dalbergia spp and other species, and Pinus rosburghi occurring on the higher ridges of the Churia hills, which in places reach an altitude of 1800m. Tall coarse two-meter high elephant grass originally covered much of the Dun valleys but has now been largely replaced by agricultural settlements. The pipal (ficus religiosa) and the &lsquo;banyan&rsquo; (ficus bengalensis) are to be noticed with their specific natural characteristics. This tropical zone is Nepal&rsquo;s richest area for wildlife, with gaurs, buffaloes, four species of deer, tigers, leopards and other animals found in the forest areas rhinoceros, swamp deer and hot deer found in the valley grasslands and two species of crocodile and the Gangetic dolphin inhabiting the rivers. The principal birds are the peacock, jungle fowl and black partridge, while migratory duck and geese swarm on the ponds and lakes and big rivers of Terai. Terai forests are full of jasmin, minosa, accecia reeds and bamboo.', 'iflynepal' ),
			'image'       => IFLYNEPAL_URI . '/assets/images/about-country/flora-01-tropical-deciduous-monsoon-forest.jpg',
			'image_alt'   => __( 'Lowland forest and grassland wildlife habitat in the Terai', 'iflynepal' ),
		),
		2 => array(
			'number'      => '02',
			'title'       => __( 'Subtropical Mixed Evergreen Forest', 'iflynepal' ),
			'description' => __( 'This includes the Mahabharat Lekh, which rises to a height of about 2400m and comprises the outer wall of the Himalayan range. Great rivers such as the Karnali, Narayani, and Sapta Koshi flow through this area into the broad plains of the Terai. This zone also includes the so-called &lsquo;middle hills&rsquo; which extend northwards in a somewhat confused maze of ridges and valleys to the foot of the great Himalayas. Among the tree species characteristic of this region are Castenopsis indica in association with Schima wallichii, and other species such as Alnus nepalensis, Acer oblongum and various species of oak and rhododendron which cover the higher slopes where deforestation has not yet taken place. Orchids clothe the stems of trees and gigantic climbers smother their heads. The variety and abundance of the flora and fauna increase progressively with decreasing altitude and increasing luxurance of the vegetation. This zone is generally poor in wildlife. The only mammals, which are at all widely distributed, are wild boar, barking deer, serow, ghoral and bears. Different varieties of birds are also found in this zone.', 'iflynepal' ),
			'image'       => IFLYNEPAL_URI . '/assets/images/about-country/flora-02-subtropical-mixed-evergreen-forest.jpg',
			'image_alt'   => __( 'Forested middle hills and river valleys of Nepal', 'iflynepal' ),
		),
		3 => array(
			'number'      => '03',
			'title'       => __( 'Temperate Evergreen Forest', 'iflynepal' ),
			'description' => __( 'Northward, on the lower slopes and spurs of the great Himalayas, oaks and pines are the dominant species up to an altitude of about 2400m above which are found dense conifer forests including Picea, Tusga, Larix and Abies spp. The latter is usually confined to higher elevations with Betula typically marking the upper limit of the tree line. At about 3600 to 3900m, rhododendron, bamboo and maples are commonly associated with the coniferous zone. Composition of he forest varies considerably with coniferous predominating in the west and eracaceous in the east. The wildlife of this region includes the Himalayan bear, serow, ghoral, barking deer and wildboar, with Himalayan tahr sometimes being seen on steep rocky faces above 2400m. The red panda is among the more interesting of the mammals found in this zone; it appears to be fairly distributed in suitable areas of the forest above 1800m. The rich and varied avifauna of this region includes several spectacular and beautiful pheasants, including the Danfe pheasant, Nepal&rsquo;s national bird.', 'iflynepal' ),
			'image'       => IFLYNEPAL_URI . '/assets/images/about-country/flora-03-temperate-evergreen-forest.jpg',
			'image_alt'   => __( 'Conifer forest on the lower slopes of the Himalaya', 'iflynepal' ),
		),
		4 => array(
			'number'      => '04',
			'title'       => __( 'Subalpine and Alpine Zone', 'iflynepal' ),
			'description' => __( 'Above the tree line, rhododendron, juniper scrub and other procumbent woody vegetation may extend to about 4200m where it is then succeeded by t a tundra-like association of short grasses, sedge mosses and alpine plants wherever there is sufficient soil. This continues up to the lower limit of perpetual snow and ice at about 5100m. The mammalian faun is sparse and unlikely to include any species other than Himalayan marmots, mouse hare, tahr, musk deer, snow leopard and occasionally blue sheep. In former times, the wild Yak and great Tibetan sheep could also be sighted in this region and it is possible that a few may still be surviving in areas such as Dolpa and Humla. The bird life at such as lammergeyer, snowcock, snowpatridge, choughs and bunting, with redstarts and dippers often seen along the streams and rivulets. Yaks are the only livestock, which thrive at high altitude. They serve both back and draught animals. The cheeses prepared out of the milk are edible for months. The female Yak provides milk to the Sherpas. Of the wonderful flora and fauna must suffice to indicate what a paradise Nepal is to the lovers of wild animal and bird life, to the naturalists and to the foresters.', 'iflynepal' ),
			'image'       => IFLYNEPAL_URI . '/assets/images/about-country/flora-04-subalpine-and-alpine-zone.jpg',
			'image_alt'   => __( 'Alpine terrain above the tree line in the Nepal Himalaya', 'iflynepal' ),
		),
	);
}

/**
 * One row's defaults, with empty fallbacks for an index that has none.
 *
 * The numeral still gets a value past the four the design ships, so a row
 * added in the Customizer is numbered rather than blank.
 *
 * @since 1.0.0
 *
 * @param int $index Row number.
 * @return array Defaults for that row.
 */
function iflynepal_country_region_default( $index ) {
	$defaults = iflynepal_country_region_defaults();

	if ( isset( $defaults[ $index ] ) ) {
		return $defaults[ $index ];
	}

	return array(
		'number'      => str_pad( (string) $index, 2, '0', STR_PAD_LEFT ),
		'title'       => '',
		'description' => '',
		'image'       => '',
		'image_alt'   => '',
	);
}

/**
 * One row's photograph URL.
 *
 * @since 1.0.0
 *
 * @param int $index Row number.
 * @return string Image URL, or an empty string when neither set nor defaulted.
 */
function iflynepal_country_region_image_url( $index ) {
	$attachment_id = (int) get_theme_mod( 'iflynepal_country_region_' . $index . '_image', 0 );

	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'large' );

		if ( $url ) {
			return $url;
		}
	}

	$default = iflynepal_country_region_default( $index );

	return $default['image'];
}

/**
 * One row's photograph alt text.
 *
 * @since 1.0.0
 *
 * @param int $index Row number.
 * @return string Alt text.
 */
function iflynepal_country_region_image_alt( $index ) {
	$attachment_id = (int) get_theme_mod( 'iflynepal_country_region_' . $index . '_image', 0 );

	if ( $attachment_id ) {
		$alt = trim( (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) );

		if ( '' !== $alt ) {
			return $alt;
		}
	}

	$default = iflynepal_country_region_default( $index );

	return $default['image_alt'];
}

/**
 * The rows that have a title, in order.
 *
 * @since 1.0.0
 *
 * @return array[] Rows, each with 'index', 'number', 'title' and 'description'.
 */
function iflynepal_country_regions() {
	$rows = array();

	for ( $i = 1; $i <= IFLYNEPAL_COUNTRY_REGION_MAX; $i++ ) {
		$default = iflynepal_country_region_default( $i );
		$title   = trim( (string) get_theme_mod( 'iflynepal_country_region_' . $i . '_title', $default['title'] ) );

		if ( '' === $title ) {
			continue;
		}

		$rows[] = array(
			'index'       => $i,
			'number'      => (string) get_theme_mod( 'iflynepal_country_region_' . $i . '_number', $default['number'] ),
			'title'       => $title,
			'description' => (string) get_theme_mod( 'iflynepal_country_region_' . $i . '_description', $default['description'] ),
		);
	}

	return $rows;
}

/* ------------------------------------------------------ economy: sectors */

/**
 * The icons a sector can be given.
 *
 * A fixed set rather than an upload field, for the same reason the Why-trust
 * bullets use one: WordPress refuses SVG uploads by default, and a raster icon
 * cannot take its colour from the surrounding CSS the way these do. Each is
 * drawn in a 24x24 box and stroked rather than filled.
 *
 * @since 1.0.0
 *
 * @return array[] Icons keyed by slug, each with 'label' and 'path'.
 */
function iflynepal_country_sector_icons() {
	return array(
		'agriculture'   => array(
			'label' => __( 'Fields', 'iflynepal' ),
			'path'  => '<path d="M3 20h18M6 20V9M12 20V5M18 20v-7"/>',
		),
		'manufacturing' => array(
			'label' => __( 'Factory', 'iflynepal' ),
			'path'  => '<path d="M3 21V11l6 4V11l6 4V6l6 4v11Z"/>',
		),
		'trade'         => array(
			'label' => __( 'Basket', 'iflynepal' ),
			'path'  => '<path d="M3 7h18l-1.5 12.5a1.5 1.5 0 0 1-1.5 1.3H6a1.5 1.5 0 0 1-1.5-1.3Z"/><path d="M8.5 7V5.5a3.5 3.5 0 0 1 7 0V7"/>',
		),
		'tourism'       => array(
			'label' => __( 'Globe', 'iflynepal' ),
			'path'  => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c2.5 2.6 3.8 5.6 3.8 9S14.5 18.4 12 21c-2.5-2.6-3.8-5.6-3.8-9S9.5 5.6 12 3Z"/>',
		),
	);
}

/**
 * Constrains an icon slug to one this theme draws.
 *
 * @since 1.0.0
 *
 * @param string $value Raw value.
 * @return string A known slug, falling back to the first one registered.
 */
function iflynepal_sanitize_country_sector_icon( $value ) {
	$icons = iflynepal_country_sector_icons();

	if ( isset( $icons[ $value ] ) ) {
		return (string) $value;
	}

	return (string) key( $icons );
}

/**
 * Default sectors for the Economy chapter, as the design has them.
 *
 * @since 1.0.0
 *
 * @return array[] Defaults indexed from 1.
 */
function iflynepal_country_sector_defaults() {
	return array(
		1 => array(
			'icon'        => 'agriculture',
			'title'       => __( 'Agriculture', 'iflynepal' ),
			'description' => __( 'Eight out of 10 Nepalese are engaged in farming and it accounts for more than 40% of the GDP. Rolling fields and neat terraces can be seen all over the Terai flatlands and the hills of Nepal. Even in the highly urbanized Kathmandu Valley, large tracts of land outside the city areas are devoted to farming. Rice is the staple diet in Nepal and around three million tons are produced annually. Other major crops are maize, wheat, millet and barley. Besides food grains, Cash crops Like Sugarcane, oil seeds, tobacco, jute and tea are also cultivated in large quantities.', 'iflynepal' ),
		),
		2 => array(
			'icon'        => 'manufacturing',
			'title'       => __( 'Manufacturing', 'iflynepal' ),
			'description' => __( 'Manufacturing is still at the developmental stage and it represents less than 10% of the GDP. Major industries are woolen carpets, garments, textiles, leather products, paper and cement. Other products made in Nepal are steel utensils, cigarettes, beverages and sugar. There are many modern large-scale factories but the majority are cottage or small scale operations. Most of Nepal&rsquo;s industries are based in the Kathmandu Valley and a string of Small towns in the southern Terai Plains.', 'iflynepal' ),
		),
		3 => array(
			'icon'        => 'trade',
			'title'       => __( 'Trade', 'iflynepal' ),
			'description' => __( 'Commerce has been a major occupation in Nepal since early times. Being situated at the crossroads of the ancient Trans-Himalayan trade route, trading is second nature to the Nepalese people. Foreign trade is characterized mainly by import of manufactured products and export of agricultural raw materials. Nepal imports manufactured goods and petroleum products worth about US$ 1 billion annually. The value of exports is about US$ 315 million. Woolen carpets are Nepal&rsquo;s largest export, earning the country over US$ 135 million per year. Garment exports account for more than US$ 74 million and handicraft goods bring in about US$ 1 million. Other important exports are pulses, hides and skins, jute and medicinal herbs.', 'iflynepal' ),
		),
		4 => array(
			'icon'        => 'tourism',
			'title'       => __( 'Tourism', 'iflynepal' ),
			'description' => __( 'In 1998, a total of 463,684 tourists visited Nepal, making tourism one of the largest industries in the Kingdom. This sector has been expanding rapidly since its inception in the 1950. Thanks to Nepal&rsquo;s natural beauty, rich cultural heritage and the diversity of sight-seeing and adventure opportunities available. At one time, tourism used to be the biggest foreign currency earner for the country. Nepal earned over US$ 152 million from tourism in 1998.', 'iflynepal' ),
		),
	);
}

/**
 * One sector's defaults, with empty fallbacks for an index that has none.
 *
 * @since 1.0.0
 *
 * @param int $index Sector number.
 * @return array Defaults for that sector.
 */
function iflynepal_country_sector_default( $index ) {
	$defaults = iflynepal_country_sector_defaults();

	if ( isset( $defaults[ $index ] ) ) {
		return $defaults[ $index ];
	}

	return array(
		'icon'        => 'agriculture',
		'title'       => '',
		'description' => '',
	);
}

/**
 * The sectors that have a title, in order.
 *
 * @since 1.0.0
 *
 * @return array[] Sectors, each with 'icon', 'title' and 'description'.
 */
function iflynepal_country_sectors() {
	$sectors = array();

	for ( $i = 1; $i <= IFLYNEPAL_COUNTRY_SECTOR_MAX; $i++ ) {
		$default = iflynepal_country_sector_default( $i );
		$title   = trim( (string) get_theme_mod( 'iflynepal_country_sector_' . $i . '_title', $default['title'] ) );

		if ( '' === $title ) {
			continue;
		}

		$sectors[] = array(
			'icon'        => iflynepal_sanitize_country_sector_icon( (string) get_theme_mod( 'iflynepal_country_sector_' . $i . '_icon', $default['icon'] ) ),
			'title'       => $title,
			'description' => (string) get_theme_mod( 'iflynepal_country_sector_' . $i . '_description', $default['description'] ),
		);
	}

	return $sectors;
}

/* --------------------------------------------------------- safety: list */

/**
 * Default points for the Safety chapter, as the design has them.
 *
 * @since 1.0.0
 *
 * @return string[] Defaults indexed from 1.
 */
function iflynepal_country_safety_defaults() {
	return array(
		1  => __( 'Nepal is a safe country to travel or volunteer. There is good access mobile phone and internet', 'iflynepal' ),
		2  => __( 'Cheers ensure your safety during your volunteer placement in Nepal, and to make sure you are placed in a safe environment while volunteering.', 'iflynepal' ),
		3  => __( 'Attacks against tourists, Crime, Scams and Theft are very rare.', 'iflynepal' ),
		4  => __( 'Politically Nepal is continuing to undergo a period of change, and in light of this you should avoid large gatherings and demonstrations. Bandhas (shutdowns), rallies and demonstrations can cause widespread disruption as they are often called at short notice, and disrupt transport. However, in general CN volunteers are not impacted by these types of demonstrations, as their site of volunteering is in close proximity to their accommodation.', 'iflynepal' ),
		5  => __( 'If you plan to go trekking during your stay in Nepal you are advised to use reputable trekking agencies, to keep to established routes, and to always walk in groups. Trekking alone is not recommended.', 'iflynepal' ),
		6  => __( 'Volunteers should also avoid travel on overnight buses in Nepal.', 'iflynepal' ),
		7  => __( 'You should also not become involved with drugs. Being found in possession of even very small quantities of drugs can lead to imprisonment.', 'iflynepal' ),
		8  => __( 'For trekking, Never trek alone. Use a reputable agency, remain on established routes, and walk with at least one other person.', 'iflynepal' ),
		9  => __( 'Altitude sickness is a risk, including on the Annapurna, Langtang and Everest Base Camp treks.', 'iflynepal' ),
		10 => __( 'Make sure your insurance covers your basic health insurance.', 'iflynepal' ),
		11 => __( 'Flights across Nepal, particularly in high mountain areas, can be delayed due to poor weather conditions.', 'iflynepal' ),
	);
}

/**
 * The safety points that have text, in order.
 *
 * @since 1.0.0
 *
 * @return string[] Point HTML.
 */
function iflynepal_country_safety_items() {
	$defaults = iflynepal_country_safety_defaults();
	$items    = array();

	for ( $i = 1; $i <= IFLYNEPAL_COUNTRY_SAFETY_MAX; $i++ ) {
		$default = isset( $defaults[ $i ] ) ? $defaults[ $i ] : '';
		$value   = trim( (string) get_theme_mod( 'iflynepal_country_safety_' . $i, $default ) );

		if ( '' === $value ) {
			continue;
		}

		$items[] = $value;
	}

	return $items;
}

/* ------------------------------------------------ climate: what to bring */

/**
 * Default heading over the packing lists.
 *
 * @since 1.0.0
 */
const IFLYNEPAL_COUNTRY_BRING_TITLE_DEFAULT = 'What to Bring?';

/**
 * Default paragraphs above the packing lists.
 *
 * @since 1.0.0
 *
 * @return string[] Defaults indexed from 1.
 */
function iflynepal_country_bring_defaults() {
	return array(
		1 => __( 'This will vary depending on the time of year in which you visit Nepal and what additional activities you intend to participate in during your stay in Nepal. With the exception of some medicines and high-tech trekking gear, you can buy everything that you would need for your placement in Kathmandu (and it is likely to be cheaper than in your home country). Here are a few suggestions on what to bring:', 'iflynepal' ),
	);
}

/**
 * Heading over the packing lists.
 *
 * @since 1.0.0
 *
 * @return string Heading HTML.
 */
function iflynepal_country_bring_title() {
	return iflynepal_kses_text( get_theme_mod( 'iflynepal_country_bring_title', IFLYNEPAL_COUNTRY_BRING_TITLE_DEFAULT ) );
}

/**
 * The paragraphs above the packing lists that have text, in order.
 *
 * @since 1.0.0
 *
 * @return string[] Paragraph HTML.
 */
function iflynepal_country_bring_paragraphs() {
	$defaults   = iflynepal_country_bring_defaults();
	$paragraphs = array();

	for ( $i = 1; $i <= IFLYNEPAL_COUNTRY_PARAGRAPH_MAX; $i++ ) {
		$default = isset( $defaults[ $i ] ) ? $defaults[ $i ] : '';
		$value   = trim( (string) get_theme_mod( 'iflynepal_country_bring_paragraph_' . $i, $default ) );

		if ( '' === $value ) {
			continue;
		}

		$paragraphs[] = $value;
	}

	return $paragraphs;
}

/* ---------------------------------------------------------- visa: permit */

/**
 * Default copy for the trekking-permit note that closes the page.
 *
 * @since 1.0.0
 *
 * @return array Permit defaults.
 */
function iflynepal_country_permit_defaults() {
	return array(
		'title' => __( 'Trekking Permit', 'iflynepal' ),
		'text'  => __( 'Trekkers planning to travel to controlled areas in Nepal opened for group trekking need to get Trekking Permit issued by the Department of Immigration under the Home Ministry. The government has opened following previously restricted trekking areas for group trekkers. Trekking permits will not be issued to individual trekkers in those trekking areas.', 'iflynepal' ),
	);
}

/**
 * One field of the permit note.
 *
 * @since 1.0.0
 *
 * @param string $field One of the keys in iflynepal_country_permit_defaults().
 * @return string Stored value, or the default.
 */
function iflynepal_country_permit_field( $field ) {
	$defaults = iflynepal_country_permit_defaults();
	$default  = isset( $defaults[ $field ] ) ? $defaults[ $field ] : '';

	return (string) get_theme_mod( 'iflynepal_country_permit_' . $field, $default );
}

/* -------------------------------------------------------- render callbacks */

/**
 * Renders the hero headline.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_country_hero_title() {
	return iflynepal_country_hero_title();
}

/**
 * Renders the hero sub-title.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_country_hero_lead() {
	return iflynepal_country_hero_lead();
}

/**
 * Renders the index bar's links.
 *
 * The bar is built from the chapters that are actually shown, so hiding a
 * chapter by emptying its heading drops its link here too rather than leaving
 * an anchor pointing at nothing.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_country_index() {
	$markup = '';

	foreach ( iflynepal_country_visible_chapters() as $chapter ) {
		$markup .= sprintf(
			'<a class="iflynepal-country-index__link" href="#%1$s">%2$s</a>',
			esc_attr( $chapter['slug'] ),
			esc_html( $chapter['label'] )
		);
	}

	return $markup;
}

/**
 * Renders one chapter's kicker.
 *
 * @since 1.0.0
 *
 * @param string $slug Chapter slug.
 * @return string Markup.
 */
function iflynepal_render_country_chapter_eyebrow( $slug ) {
	return iflynepal_country_chapter_eyebrow( $slug );
}

/**
 * Renders one chapter's heading.
 *
 * @since 1.0.0
 *
 * @param string $slug Chapter slug.
 * @return string Markup.
 */
function iflynepal_render_country_chapter_title( $slug ) {
	return iflynepal_country_chapter_title( $slug );
}

/**
 * Renders one chapter's prose block.
 *
 * One partial for the block rather than one per paragraph: emptying a
 * paragraph removes it, which changes how many there are, and a per-paragraph
 * partial would leave an empty block standing where it had been.
 *
 * @since 1.0.0
 *
 * @param string $slug Chapter slug.
 * @return string Markup.
 */
function iflynepal_render_country_chapter_prose( $slug ) {
	$markup = '';

	foreach ( iflynepal_country_chapter_paragraphs( $slug ) as $paragraph ) {
		$markup .= '<p>' . iflynepal_kses_text( $paragraph ) . '</p>';
	}

	return $markup;
}

/**
 * Renders the Geography note's label.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_country_note_label() {
	return esc_html( iflynepal_country_note_field( 'label' ) );
}

/**
 * Renders the Geography note's heading.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_country_note_title() {
	return iflynepal_kses_text( iflynepal_country_note_field( 'title' ) );
}

/**
 * Renders the Geography note's paragraph.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_country_note_text() {
	return iflynepal_kses_text( iflynepal_country_note_field( 'text' ) );
}

/**
 * Renders the People chapter's cards.
 *
 * One partial for the whole run rather than one per card: removing a card
 * changes how many are left, and the grid is sized off that count.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_country_bands() {
	$markup = '';

	foreach ( iflynepal_country_bands() as $card ) {
		$image = iflynepal_country_band_image_url( $card['index'] );
		$photo = '';

		if ( '' !== $image ) {
			$photo = sprintf(
				'<img loading="lazy" src="%1$s" alt="%2$s">',
				esc_url( $image ),
				esc_attr( iflynepal_country_band_image_alt( $card['index'] ) )
			);
		}

		$markup .= sprintf(
			'<article class="iflynepal-country-band" data-iflynepal-reveal>%1$s<div class="iflynepal-country-band__body"><h3 class="iflynepal-country-band__title">%2$s</h3></div></article>',
			$photo,
			iflynepal_kses_text( $card['title'] )
		);
	}

	return $markup;
}

/**
 * Renders the Flora and Fauna chapter's rows.
 *
 * One partial for the list rather than one per row: the rows alternate sides
 * off their position in the list, so removing one re-sides every row after it.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_country_regions() {
	$markup = '';

	foreach ( iflynepal_country_regions() as $row ) {
		$image  = iflynepal_country_region_image_url( $row['index'] );
		$photo  = '';
		$number = trim( $row['number'] );

		if ( '' !== $image ) {
			$photo = sprintf(
				'<div class="iflynepal-about-offer__photo"><img loading="lazy" src="%1$s" alt="%2$s"></div>',
				esc_url( $image ),
				esc_attr( iflynepal_country_region_image_alt( $row['index'] ) )
			);
		}

		$markup .= sprintf(
			'<article class="iflynepal-about-offer" data-iflynepal-reveal>%1$s<div class="iflynepal-about-offer__copy">%2$s<h3 class="iflynepal-about-offer__title">%3$s</h3><p class="iflynepal-about-offer__desc">%4$s</p></div></article>',
			$photo,
			'' === $number ? '' : '<span class="iflynepal-about-offer__num">' . esc_html( $number ) . '</span>',
			iflynepal_kses_text( $row['title'] ),
			iflynepal_kses_text( $row['description'] )
		);
	}

	return $markup;
}

/**
 * Renders the Economy chapter's sectors.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_country_sectors() {
	$icons  = iflynepal_country_sector_icons();
	$markup = '';

	foreach ( iflynepal_country_sectors() as $sector ) {
		$icon = isset( $icons[ $sector['icon'] ] ) ? $icons[ $sector['icon'] ] : reset( $icons );

		$markup .= sprintf(
			'<div class="iflynepal-country-sector" data-iflynepal-reveal><span class="iflynepal-country-sector__icon"><svg class="iflynepal-ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false">%1$s</svg></span><div class="iflynepal-country-sector__body"><strong class="iflynepal-country-sector__title">%2$s</strong><span class="iflynepal-country-sector__desc">%3$s</span></div></div>',
			wp_kses(
				$icon['path'],
				array(
					'path'   => array( 'd' => array() ),
					'circle' => array(
						'cx' => array(),
						'cy' => array(),
						'r'  => array(),
					),
				)
			),
			iflynepal_kses_text( $sector['title'] ),
			iflynepal_kses_text( $sector['description'] )
		);
	}

	return $markup;
}

/**
 * Renders the Safety chapter's list.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_country_safety() {
	$markup = '';

	foreach ( iflynepal_country_safety_items() as $item ) {
		$markup .= '<li>' . iflynepal_kses_text( $item ) . '</li>';
	}

	return $markup;
}

/**
 * Renders the heading over the packing lists.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_country_bring_title() {
	return iflynepal_country_bring_title();
}

/**
 * Renders the paragraphs above the packing lists.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_country_bring_prose() {
	$markup = '';

	foreach ( iflynepal_country_bring_paragraphs() as $paragraph ) {
		$markup .= '<p>' . iflynepal_kses_text( $paragraph ) . '</p>';
	}

	return $markup;
}

/**
 * Renders the permit note's heading.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_country_permit_title() {
	return iflynepal_kses_text( iflynepal_country_permit_field( 'title' ) );
}

/**
 * Renders the permit note's paragraph.
 *
 * @since 1.0.0
 *
 * @return string Markup.
 */
function iflynepal_render_country_permit_text() {
	return iflynepal_kses_text( iflynepal_country_permit_field( 'text' ) );
}
