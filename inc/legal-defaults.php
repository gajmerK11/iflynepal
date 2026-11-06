<?php
/**
 * Legal pages: the default copy of every editable piece.
 *
 * Generated from the original template parts, so each string keeps the exact
 * msgid it had there and existing translations still apply. Written in the
 * mini-markup described in inc/legal-content.php; an editor changes it in the
 * Customizer, and anything left alone keeps coming from here.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default clause bodies for the privacy page, keyed by clause anchor.
 *
 * @since 1.0.0
 *
 * @return array[] Lines of mini-markup per anchor.
 */
function iflynepal_privacy_clause_body_defaults() {
	return array(
		'who-we-are' => array(
			'- ' . sprintf( __( 'Our website address is %s.', 'iflynepal' ), '[{site_host}]({site_url})' ),
			'- ' . __( 'We are a leading <strong>travel and adventure agency in Nepal</strong>, offering trekking, cultural tours, retreats, workshops, volunteering, wildlife safaris, and multi-country experiences.', 'iflynepal' ),
		),
		'information-we-collect' => array(
			'# ' . __( 'Personal information', 'iflynepal' ),
			__( 'We may collect the following when you interact with our site or services:', 'iflynepal' ),
			'- ' . __( '<strong>Name, email address, phone number</strong>, and mailing address.', 'iflynepal' ),
			'- ' . __( '<strong>Passport details</strong> for booking and permit processing.', 'iflynepal' ),
			'- ' . __( 'Travel preferences and <strong>health-related information</strong> (when necessary).', 'iflynepal' ),
			'- ' . __( 'Feedback, comments, or questions submitted via forms.', 'iflynepal' ),
			'# ' . __( 'Payment information', 'iflynepal' ),
			'- ' . __( 'Payments made through our site are securely processed by <strong>trusted third-party providers</strong>.', 'iflynepal' ),
			'- ' . __( 'We <strong>do not store</strong> your credit card or sensitive payment information.', 'iflynepal' ),
		),
		'automatic-information' => array(
			'- ' . __( '<strong>IP address, device type</strong>, and browser information.', 'iflynepal' ),
			'- ' . __( '<strong>Location data</strong> (if enabled).', 'iflynepal' ),
			'- ' . __( 'Pages visited, time spent, and click activity.', 'iflynepal' ),
		),
		'tracking-technologies' => array(
			__( 'We use cookies to improve your browsing experience. Cookies help us:', 'iflynepal' ),
			'- ' . __( 'Remember your <strong>preferences</strong>.', 'iflynepal' ),
			'- ' . __( '<strong>Analyse website performance</strong>.', 'iflynepal' ),
			'- ' . __( 'Customise content and offers.', 'iflynepal' ),
			'!cookie ' . sprintf( __( 'You can manage cookie settings through your browser or opt out of certain tracking. See our %s for the full detail.', 'iflynepal' ), '[' . __( 'Cookie Policy', 'iflynepal' ) . '](/cookie-policy/)' ),
		),
		'media-uploads' => array(
			'- ' . __( 'If you upload images (e.g. in blog comments), we advise <strong>removing embedded location data (EXIF GPS)</strong>, as visitors may extract such data.', 'iflynepal' ),
		),
		'comments' => array(
			'- ' . __( 'We collect the data shown in the <strong>comment form</strong>.', 'iflynepal' ),
			'- ' . __( 'We also collect your <strong>IP address and browser user agent string</strong> to help detect spam.', 'iflynepal' ),
			'- ' . __( 'If you are using <strong>Gravatar</strong>, an anonymised email string may be used to display your profile photo.', 'iflynepal' ),
		),
		'embedded-content' => array(
			'- ' . __( 'Our blog or informational pages may include <strong>embedded content</strong> (videos, maps, articles, etc.).', 'iflynepal' ),
			'- ' . __( 'These behave as if you visited the other website, which <strong>may collect data, use cookies, or track your interaction</strong>.', 'iflynepal' ),
		),
		'how-we-use-data' => array(
			__( 'We use your data to:', 'iflynepal' ),
			'- ' . __( 'Process bookings and issue <strong>confirmations</strong>.', 'iflynepal' ),
			'- ' . __( 'Customise itineraries and provide personalised experiences.', 'iflynepal' ),
			'- ' . __( 'Respond to enquiries and offer customer support.', 'iflynepal' ),
			'- ' . __( 'Send newsletters, updates, and promotional content &mdash; <strong>only with your consent</strong>.', 'iflynepal' ),
			'- ' . __( 'Comply with legal requirements or resolve disputes.', 'iflynepal' ),
		),
		'data-sharing' => array(
			__( 'We <strong>do not sell your data</strong>. We may share information with:', 'iflynepal' ),
			'- ' . __( '<strong>Trusted third-party service providers</strong> (e.g. hotel partners, trekking guides, transportation companies).', 'iflynepal' ),
			'- ' . __( '<strong>Payment processors</strong> and booking systems.', 'iflynepal' ),
			'- ' . __( '<strong>Legal authorities</strong>, only if required by law.', 'iflynepal' ),
		),
		'data-retention' => array(
			'=warn ' . __( 'Comments and related metadata', 'iflynepal' ) . ' | ' . __( 'Stored indefinitely', 'iflynepal' ),
			'= ' . __( 'Booking and contact data', 'iflynepal' ) . ' | ' . __( 'Administrative, legal or tax purposes', 'iflynepal' ),
			'=ok ' . __( 'Account information, if you create an account', 'iflynepal' ) . ' | ' . __( 'Editable by you at any time', 'iflynepal' ),
		),
		'your-rights' => array(
			'@ ' . __( 'A copy of your data', 'iflynepal' ) . ' | ' . __( 'Request a copy of the personal data we hold about you.', 'iflynepal' ),
			'@ ' . __( 'Corrections or updates', 'iflynepal' ) . ' | ' . __( 'Ask us to correct or update any information that is wrong or out of date.', 'iflynepal' ),
			'@ ' . __( 'Deletion of your data', 'iflynepal' ) . ' | ' . __( 'Request deletion, except data we must retain for legal reasons.', 'iflynepal' ),
			'!mail ' . sprintf( __( 'Please contact us at %s for any data access or removal request.', 'iflynepal' ), '[{email}](mailto:{email})' ),
		),
		'data-security' => array(
			'- ' . __( 'We implement <strong>secure protocols</strong> to safeguard your personal data.', 'iflynepal' ),
			'- ' . __( 'While no system is completely immune, we strive to maintain the <strong>highest standards</strong> in data protection.', 'iflynepal' ),
		),
		'data-transfers' => array(
			'- ' . __( 'Visitor comments may be checked through an <strong>automated spam detection service</strong>.', 'iflynepal' ),
			'- ' . __( 'Booking data may be securely transferred to <strong>local service providers</strong> as needed for trip operations.', 'iflynepal' ),
		),
		'third-party-links' => array(
			'- ' . __( 'Our website may link to third-party sites (e.g. insurance providers, affiliate travel blogs).', 'iflynepal' ),
			'- ' . __( 'We are <strong>not responsible for the privacy practices</strong> of these websites.', 'iflynepal' ),
		),
		'policy-changes' => array(
			'- ' . __( 'We may update this Privacy Policy from time to time. Updates will be <strong>posted on this page</strong>.', 'iflynepal' ),
			'- ' . __( 'Significant changes will be communicated via <strong>email or site notification</strong>.', 'iflynepal' ),
		),
	);
}

/**
 * Default clause bodies for the terms page, keyed by clause anchor.
 *
 * @since 1.0.0
 *
 * @return array[] Lines of mini-markup per anchor.
 */
function iflynepal_terms_clause_body_defaults() {
	return array(
		'booking-payment' => array(
			'- ' . __( 'A <strong>deposit (typically 20&ndash;30%)</strong> is required to confirm your booking. The remaining balance is payable prior to the start of your trip or on arrival, depending on the itinerary.', 'iflynepal' ),
			'- ' . __( 'Payment methods include bank transfer, major credit cards, or online gateways. Any associated <strong>transaction charges are borne by the client</strong>.', 'iflynepal' ),
			'- ' . __( 'A booking is only confirmed once we issue a <strong>confirmation email</strong>.', 'iflynepal' ),
		),
		'cancellation-refunds' => array(
			'# ' . __( 'By the client', 'iflynepal' ),
			'= ' . __( '30+ days prior to departure', 'iflynepal' ) . ' | ' . __( 'Full refund minus transaction &amp; admin fees', 'iflynepal' ),
			'= ' . __( '15&ndash;29 days prior to departure', 'iflynepal' ) . ' | ' . __( '50% refund', 'iflynepal' ),
			'=warn ' . __( 'Less than 15 days prior', 'iflynepal' ) . ' | ' . __( 'No refund', 'iflynepal' ),
			'- ' . __( 'Within 15 days, a booking <strong>may be transferred</strong> to a future date or another person, subject to availability.', 'iflynepal' ),
			'- ' . __( 'No refund will be made for <strong>unused services</strong> once the trip has commenced.', 'iflynepal' ),
			'# ' . __( 'By iFly Nepal', 'iflynepal' ),
			'- ' . __( 'If we cancel due to unforeseen events (e.g. natural disasters, political unrest), a <strong>full refund or credit</strong> will be offered.', 'iflynepal' ),
			'- ' . __( 'If cancellation is due to <strong>force majeure</strong>, we are not liable for compensation beyond the refund of received payments.', 'iflynepal' ),
		),
		'travel-insurance' => array(
			'- ' . __( 'Travel insurance is <strong>mandatory</strong> for all trekking, adventure and high-altitude trips.', 'iflynepal' ),
			'- ' . __( 'Your policy must include <strong>emergency evacuation, medical coverage, and trip cancellation / interruption</strong>.', 'iflynepal' ),
			'- ' . __( 'iFly Nepal is not responsible for expenses resulting from your failure to secure proper insurance.', 'iflynepal' ),
		),
		'health-fitness' => array(
			'- ' . __( 'Certain trips (e.g. trekking, volunteering, wellness retreats) require a <strong>minimum level of physical fitness</strong>.', 'iflynepal' ),
			'- ' . __( 'It is your responsibility to consult with a physician and ensure you are in good health before participating.', 'iflynepal' ),
			'- ' . __( 'You must inform us of any <strong>medical conditions, allergies, or dietary restrictions</strong> in advance.', 'iflynepal' ),
		),
		'visa-entry' => array(
			'- ' . __( 'Most travellers can obtain a Nepal visa on arrival at Tribhuvan International Airport or land borders. Ensure your passport is <strong>valid for at least 6 months</strong>.', 'iflynepal' ),
			'- ' . __( 'iFly Nepal is not responsible for visa denials, immigration issues, or delays caused by border regulations.', 'iflynepal' ),
		),
		'flight-delays' => array(
			'- ' . __( '<strong>Lukla, Jomsom, Pokhara</strong> and other mountain flights are prone to weather-related delays or cancellations.', 'iflynepal' ),
			'- ' . __( 'We recommend scheduling <strong>buffer days</strong> and securing travel insurance that covers such disruptions.', 'iflynepal' ),
			'- ' . __( 'Alternative arrangements (helicopter charter, rescheduling, overland options) may be offered <strong>at additional cost</strong>.', 'iflynepal' ),
		),
		'risk-liability' => array(
			'- ' . __( 'Many activities (e.g. trekking, rafting, safaris) involve inherent risks such as <strong>altitude sickness, accidents, or unforeseen events</strong>.', 'iflynepal' ),
			'- ' . __( 'By booking, you agree to participate at your own risk and release iFly Nepal and its representatives from any liability related to injury, loss, or damage.', 'iflynepal' ),
			'- ' . __( 'Our liability is <strong>limited to the cost of the tour purchased</strong>.', 'iflynepal' ),
		),
		'safety-emergency' => array(
			'- ' . __( 'iFly Nepal&#8217;s guides are trained in <strong>first aid and altitude safety</strong> and carry basic medical kits and emergency protocols.', 'iflynepal' ),
			'- ' . __( 'In serious situations, we may organise <strong>helicopter evacuation at the traveller&#8217;s expense</strong> unless covered by insurance.', 'iflynepal' ),
			'- ' . __( 'Travellers must follow guide instructions and safety guidelines during the trip.', 'iflynepal' ),
		),
		'sustainable-travel' => array(
			__( 'We encourage all clients to:', 'iflynepal' ),
			'- ' . __( 'Respect <strong>local cultures, customs and religious sites</strong>.', 'iflynepal' ),
			'- ' . __( 'Minimise plastic and environmental impact by using reusable gear.', 'iflynepal' ),
			'- ' . __( 'Support <strong>local businesses and artisans</strong>.', 'iflynepal' ),
			'- ' . __( 'Avoid activities or purchases that exploit wildlife or people.', 'iflynepal' ),
			'!leaf ' . sprintf( __( 'By travelling with us, you agree to uphold our %s and contribute to responsible tourism in Nepal.', 'iflynepal' ), '[' . __( 'Sustainability Policy', 'iflynepal' ) . '](/sustainable-policy/)' ),
		),
		'volunteering' => array(
			'- ' . __( 'Volunteering placements are run in collaboration with <strong>vetted local organisations</strong>.', 'iflynepal' ),
			'- ' . __( 'Travellers are expected to behave ethically, respectfully, and within the bounds of their assigned role.', 'iflynepal' ),
			'- ' . __( 'iFly Nepal is not liable for personal disputes, loss, or misunderstandings during placements.', 'iflynepal' ),
		),
		'itinerary-changes' => array(
			'- ' . __( 'We reserve the right to make necessary changes to the itinerary, accommodation, or services due to unforeseen circumstances (weather, strikes, availability).', 'iflynepal' ),
			'- ' . __( 'Every effort will be made to provide <strong>comparable alternatives</strong> with minimal disruption.', 'iflynepal' ),
		),
		'complaints-disputes' => array(
			'- ' . __( 'If you encounter any issues during your trip, notify your guide or contact us <strong>immediately</strong> so we can resolve it.', 'iflynepal' ),
			'- ' . __( 'Formal complaints must be submitted <strong>in writing within 14 days</strong> of the trip&#8217;s conclusion.', 'iflynepal' ),
			'- ' . __( 'Any disputes shall be governed by the <strong>laws of Nepal</strong>, and legal proceedings will take place in <strong>Kathmandu District Court</strong>.', 'iflynepal' ),
		),
		'privacy-data' => array(
			'- ' . __( 'We collect only <strong>essential personal information</strong> to process bookings and deliver services.', 'iflynepal' ),
			'- ' . __( 'Your data is <strong>never sold or misused</strong>.', 'iflynepal' ) . ' ' . sprintf( __( 'See our full %s for details.', 'iflynepal' ), '[' . __( 'Privacy Policy', 'iflynepal' ) . '](/privacy-policy/)' ),
		),
		'final-acceptance' => array(
			__( 'By confirming your booking with iFly Nepal, you acknowledge that you have <strong>read, understood, and agreed</strong> to these Terms &amp; Conditions.', 'iflynepal' ),
		),
	);
}

/**
 * Default clause bodies for the cookie page, keyed by clause anchor.
 *
 * @since 1.0.0
 *
 * @return array[] Lines of mini-markup per anchor.
 */
function iflynepal_cookie_clause_body_defaults() {
	return array(
		'what-are-cookies' => array(
			__( 'Cookies are <strong>small data files stored on your device</strong> when you visit our site. They help us improve your experience, remember your preferences, and analyse site traffic.', 'iflynepal' ),
		),
		'cookie-types' => array(
			'- ' . __( '<strong>Essential cookies</strong> — necessary for basic site functionality, such as security, navigation and booking.', 'iflynepal' ),
			'- ' . __( '<strong>Analytical cookies</strong> — we use tools like Google Analytics to understand how visitors interact with our website. These cookies are anonymous and help us improve site performance.', 'iflynepal' ),
			'- ' . __( '<strong>Functional cookies</strong> — these remember your preferences, such as language or region, to enhance your experience.', 'iflynepal' ),
			'- ' . __( '<strong>Advertising cookies</strong> — we may partner with advertising networks, such as Facebook or Google Ads, to display relevant ads based on your browsing behaviour.', 'iflynepal' ),
		),
		'third-party-cookies' => array(
			'- ' . __( 'Our site may contain <strong>embedded content</strong> — videos or social media buttons, for example — which may place its own cookies.', 'iflynepal' ),
			'- ' . __( 'We <strong>do not control these cookies</strong>. Please refer to the policies of the sites they come from.', 'iflynepal' ),
		),
		'cookie-management' => array(
			__( 'You can manage or disable cookies in your browser settings:', 'iflynepal' ),
			'~ ' . __( 'Google Chrome', 'iflynepal' ) . ' | https://support.google.com/chrome/answer/95647',
			'~ ' . __( 'Mozilla Firefox', 'iflynepal' ) . ' | https://support.mozilla.org/en-US/kb/enhanced-tracking-protection-firefox-desktop',
			'~ ' . __( 'Safari', 'iflynepal' ) . ' | https://support.apple.com/en-us/105082',
			'~ ' . __( 'Microsoft Edge', 'iflynepal' ) . ' | https://support.microsoft.com/en-us/microsoft-edge/delete-cookies-in-microsoft-edge-63947406-40ac-c3b8-57b9-2a946a29ae09',
		),
		'policy-updates' => array(
			__( 'We may revise this Cookie Policy to reflect changes in <strong>law or technology</strong>. Check back periodically to stay informed.', 'iflynepal' ),
		),
	);
}

/**
 * Default clause bodies for the sustainability page, keyed by clause anchor.
 *
 * @since 1.0.0
 *
 * @return array[] Lines of mini-markup per anchor.
 */
function iflynepal_sustainability_clause_body_defaults() {
	return array(
		'introduction' => array(
			__( 'At iFly Nepal, we believe that tourism should benefit <strong>people, planet, and prosperity</strong>. As a responsible travel company, we are committed to ensuring that our operations protect the natural environment, uplift local communities, and celebrate cultural heritage while providing life-changing experiences for our travellers.', 'iflynepal' ),
			__( 'We recognise that sustainability is not just an environmental concern — it is an integrated approach involving ethical business practices, community empowerment, cultural respect, and climate-conscious travel. This policy outlines the commitments, values and practices that guide all aspects of our operations and partnerships.', 'iflynepal' ),
		),
		'environment' => array(
			'- ' . __( 'Reduce greenhouse gas emissions and <strong>offset unavoidable carbon</strong>.', 'iflynepal' ),
			'- ' . __( 'Promote <strong>low-impact travel</strong>, especially trekking, cycling, and nature tours.', 'iflynepal' ),
			'- ' . __( 'Discourage single-use plastics and promote <strong>refillable water systems</strong>.', 'iflynepal' ),
			'- ' . __( 'Support biodiversity conservation and <strong>avoid wildlife exploitation</strong>.', 'iflynepal' ),
			'- ' . __( 'Adopt energy-efficient, water-saving, and waste-reducing office practices.', 'iflynepal' ),
		),
		'community' => array(
			'- ' . __( 'Prioritise <strong>local guides, homestays, artisans</strong>, and transport providers.', 'iflynepal' ),
			'- ' . __( 'Invest in community projects such as <strong>school support, health care, and training</strong>.', 'iflynepal' ),
			'- ' . __( 'Facilitate voluntourism programmes with <strong>genuine community benefit</strong>.', 'iflynepal' ),
			'- ' . __( 'Encourage travellers to shop, eat, and stay local.', 'iflynepal' ),
		),
		'fair-employment' => array(
			'- ' . __( 'Comply with <strong>Nepal’s labour laws</strong> and international human rights standards.', 'iflynepal' ),
			'- ' . __( 'Ensure <strong>fair wages, safe working conditions, and insurance</strong> for all staff and field crew.', 'iflynepal' ),
			'- ' . __( 'Provide regular training and capacity-building for our team.', 'iflynepal' ),
			'- ' . __( 'Maintain a <strong>safe, inclusive, and harassment-free</strong> workplace.', 'iflynepal' ),
		),
		'ethical-conduct' => array(
			'- ' . __( 'Operate transparently and maintain <strong>financial integrity</strong>.', 'iflynepal' ),
			'- ' . __( '<strong>Prohibit bribery, fraud, and corruption</strong> at all levels.', 'iflynepal' ),
			'- ' . sprintf( __( 'Respect the privacy and data of all customers and staff — see our %s.', 'iflynepal' ), '[' . __( 'Privacy Policy', 'iflynepal' ) . '](/privacy-policy/)' ),
			'- ' . __( 'Promote honesty, safety, and respect in all services delivered.', 'iflynepal' ),
		),
		'governance' => array(
			'- ' . __( 'A dedicated <strong>Sustainability Coordinator</strong> oversees implementation, reporting, and continuous improvement of our policies.', 'iflynepal' ),
			'- ' . __( 'Sustainability is a <strong>standing agenda item</strong> in all management meetings.', 'iflynepal' ),
			'- ' . __( 'We periodically assess performance through <strong>measurable KPIs</strong>.', 'iflynepal' ),
		),
		'in-the-field' => array(
			'- ' . __( 'Educate clients and guides on responsible trekking and <strong>Leave No Trace</strong> principles.', 'iflynepal' ),
			'- ' . __( 'Encourage porters and staff to <strong>collect waste on trails</strong> where possible.', 'iflynepal' ),
			'- ' . __( 'Choose <strong>eco-certified accommodation</strong> and transport services.', 'iflynepal' ),
			'- ' . __( 'Recommend <strong>filtered or boiled water</strong> over bottled water to travellers.', 'iflynepal' ),
			'- ' . __( 'Partner only with suppliers who adhere to fair trade and sustainability standards.', 'iflynepal' ),
		),
		'in-the-office' => array(
			'- ' . __( 'Use <strong>LED lighting</strong>, minimise power use, and follow a “switch off” protocol.', 'iflynepal' ),
			'- ' . __( 'Recycle waste and use <strong>reusable containers</strong> and office supplies.', 'iflynepal' ),
			'- ' . __( 'Print only when necessary and use <strong>FSC-certified or recycled paper</strong>.', 'iflynepal' ),
			'- ' . __( 'Offer water stations, avoiding plastic bottles in-office.', 'iflynepal' ),
		),
		'transportation' => array(
			'- ' . __( 'Regularly service vehicles for <strong>fuel efficiency and emission control</strong>.', 'iflynepal' ),
			'- ' . __( 'Promote the use of <strong>electric vehicles</strong> where possible.', 'iflynepal' ),
			'- ' . __( '<strong>Offset carbon emissions</strong> from flights and transport through verified projects.', 'iflynepal' ),
		),
		'food-beverage' => array(
			'- ' . __( 'Partner with <strong>local farms</strong> and prefer organic, seasonal, and vegetarian options.', 'iflynepal' ),
			'- ' . __( 'Minimise <strong>food waste</strong> in tours and office events.', 'iflynepal' ),
			'- ' . __( 'Provide reusable containers for packed meals and discourage single-use packaging.', 'iflynepal' ),
		),
		'cultural-heritage' => array(
			'- ' . __( 'Provide <strong>cultural briefings</strong> to travellers before tours.', 'iflynepal' ),
			'- ' . __( 'Respect <strong>sacred sites, local customs, and dress codes</strong>.', 'iflynepal' ),
			'- ' . __( 'Avoid and discourage purchase of <strong>illicit or unsustainable souvenirs</strong>.', 'iflynepal' ),
		),
		'monitoring' => array(
			'- ' . __( 'Hold <strong>biannual internal reviews</strong> and sustainability training sessions.', 'iflynepal' ),
			'- ' . __( 'Include sustainability feedback in <strong>client post-trip evaluations</strong>.', 'iflynepal' ),
			'- ' . __( 'Regularly update policies based on staff input, client feedback, and industry innovations.', 'iflynepal' ),
			'- ' . __( 'Establish a <strong>grievance mechanism</strong> for local stakeholders.', 'iflynepal' ),
		),
		'public-communication' => array(
			'- ' . __( 'Share our <strong>sustainability progress</strong> on our website and social media.', 'iflynepal' ),
			'- ' . __( 'Engage travellers through <strong>pre-departure materials</strong> and on-trip education.', 'iflynepal' ),
			'- ' . __( 'Promote sustainable tourism advocacy in partnership with <strong>NGOs and networks</strong>.', 'iflynepal' ),
		),
		'policies-in-practice' => array(
			__( 'We operate under specific guiding frameworks, including:', 'iflynepal' ),
			'✓ ' . __( 'Sustainable Excursions & Code of Conduct', 'iflynepal' ),
			'✓ ' . __( 'Sustainable Accommodation Standards', 'iflynepal' ),
			'✓ ' . __( 'Sustainable Procurement Policy', 'iflynepal' ),
			'✓ ' . __( 'Anti-Corruption and Fair Trade Policy', 'iflynepal' ),
			'✓ ' . __( 'Transportation & Carbon Offset Plan', 'iflynepal' ),
			'✓ ' . __( 'Plastic-Free & Waste Management Guide', 'iflynepal' ),
			'✓ ' . __( 'Partner & Supplier Sustainability Criteria', 'iflynepal' ),
			'✓ ' . __( 'Forbidden Souvenirs & Wildlife Protection Policy', 'iflynepal' ),
			'!leaf ' . sprintf( __( 'Travelling with us means agreeing to uphold this policy — see the sustainability clause in our %s.', 'iflynepal' ), '[' . __( 'Terms & Conditions', 'iflynepal' ) . '](/terms-and-conditions/#sustainable-travel)' ),
		),
	);
}

/**
 * Default page-heading copy, per page: the hero headline and pill, the heading
 * above the clauses and the title of the index beside them.
 *
 * @since 1.0.0
 *
 * @param string $page Page key.
 * @return string[] Defaults keyed by field.
 */
function iflynepal_legal_head_defaults( $page ) {
	$all = array(
		'privacy' => array(
			'hero_title'  => sprintf( __( 'Privacy %s', 'iflynepal' ), '<em>' . __( 'Policy', 'iflynepal' ) . '</em>' ),
			'hero_pill'   => __( 'Read the policy', 'iflynepal' ),
			'head_kicker' => __( 'Your data', 'iflynepal' ),
			'head_title'  => __( 'Privacy <span class="underline">Policy</span>', 'iflynepal' ),
			'head_lead'   => __( 'What we collect, why we collect it, who it is shared with, how long we keep it, and the rights you have over it.', 'iflynepal' ),
			'index_title' => __( 'On this page', 'iflynepal' ),
		),
		'terms' => array(
			'hero_title'  => sprintf( __( 'Terms & %s', 'iflynepal' ), '<em>' . __( 'Conditions', 'iflynepal' ) . '</em>' ),
			'hero_pill'   => __( 'Read the terms', 'iflynepal' ),
			'head_kicker' => '',
			'head_title'  => __( 'Terms &amp; <span class="underline">Conditions</span>', 'iflynepal' ),
			'head_lead'   => __( 'Please read these before confirming your booking. They cover payment, cancellation, insurance, safety and how we resolve any issue.', 'iflynepal' ),
			'index_title' => __( 'On this page', 'iflynepal' ),
		),
		'cookie' => array(
			'hero_title'  => sprintf( __( 'Cookie %s', 'iflynepal' ), '<em>' . __( 'Policy', 'iflynepal' ) . '</em>' ),
			'hero_pill'   => __( 'Types of cookies', 'iflynepal' ),
			'head_kicker' => __( 'The policy in full', 'iflynepal' ),
			'head_title'  => __( 'Cookie <span class="underline">Policy</span>', 'iflynepal' ),
			'head_lead'   => __( 'What cookies are, whose cookies run on our pages, how to manage them, and how this policy changes over time.', 'iflynepal' ),
			'index_title' => __( 'On this page', 'iflynepal' ),
		),
		'sustainability' => array(
			'hero_title'  => sprintf( __( 'Sustainability %s', 'iflynepal' ), '<em>' . __( 'Policy', 'iflynepal' ) . '</em>' ),
			'hero_pill'   => __( 'Read the policy', 'iflynepal' ),
			'head_kicker' => __( 'The policy in full', 'iflynepal' ),
			'head_title'  => __( 'Sustainability <span class="underline">Policy</span>', 'iflynepal' ),
			'head_lead'   => __( 'Our core values, how they are integrated across operations, and how we keep improving on them.', 'iflynepal' ),
			'index_title' => __( 'On this page', 'iflynepal' ),
		),
	);

	return isset( $all[ $page ] ) ? $all[ $page ] : array();
}

/**
 * Default copy of the extra block above the clauses on the Cookie and
 * Sustainability pages (the four cookie types, the six promises).
 *
 * @since 1.0.0
 *
 * @param string $page Page key.
 * @return array Defaults keyed by field, or an empty array for a page without one.
 */
function iflynepal_legal_extra_defaults( $page ) {
	$all = array(
		'cookie' => array(
			'kicker' => __( 'Types of cookies we use', 'iflynepal' ),
			'title'  => __( 'Four kinds, and <span class="underline">what each does</span>', 'iflynepal' ),
			'lead'   => __( 'Only the first is required for the site to work. The other three you can decline in your browser at any time.', 'iflynepal' ),
			'cards'  => implode(
				"\n",
				array(
					'@! ' . __( 'Type 01', 'iflynepal' ) . ' | ' . __( 'Essential Cookies', 'iflynepal' ) . ' | ' . __( 'Necessary for basic site functionality — security, navigation, and booking.', 'iflynepal' ) . ' | ' . __( 'Always on', 'iflynepal' ),
					'@ ' . __( 'Type 02', 'iflynepal' ) . ' | ' . __( 'Analytical Cookies', 'iflynepal' ) . ' | ' . __( 'Tools like Google Analytics show us how visitors use the site. These cookies are anonymous and help us improve performance.', 'iflynepal' ) . ' | ' . __( 'Optional', 'iflynepal' ),
					'@ ' . __( 'Type 03', 'iflynepal' ) . ' | ' . __( 'Functional Cookies', 'iflynepal' ) . ' | ' . __( 'Remember your preferences — such as language or region — to improve your experience.', 'iflynepal' ) . ' | ' . __( 'Optional', 'iflynepal' ),
					'@ ' . __( 'Type 04', 'iflynepal' ) . ' | ' . __( 'Advertising Cookies', 'iflynepal' ) . ' | ' . __( 'We may partner with advertising networks — Facebook or Google Ads, for example — to show relevant ads based on your browsing.', 'iflynepal' ) . ' | ' . __( 'Optional', 'iflynepal' ),
				)
			),
		),
		'sustainability' => array(
			'kicker' => __( 'Our commitment', 'iflynepal' ),
			'title'  => __( 'Six promises we <span class="underline">hold ourselves to</span>', 'iflynepal' ),
			'lead'   => __( 'Sustainability is not just an environmental concern — it is an integrated approach involving ethical business, community empowerment, cultural respect and climate-conscious travel.', 'iflynepal' ),
			'cards'  => implode(
				"\n",
				array(
					'@ ' . __( 'Minimise our environmental footprint', 'iflynepal' ) . ' | ' . __( 'Across every part of our operations, from the trail to the office.', 'iflynepal' ),
					'@ ' . __( 'Promote social equity', 'iflynepal' ) . ' | ' . __( 'Empower the local communities who host and guide our travellers.', 'iflynepal' ),
					'@ ' . __( 'Foster cultural sensitivity', 'iflynepal' ) . ' | ' . __( 'Preserve heritage and respect the customs of every place we visit.', 'iflynepal' ),
					'@ ' . __( 'Uphold fair labour and human rights', 'iflynepal' ) . ' | ' . __( 'Fair wages, safe conditions and insurance for all staff and field crew.', 'iflynepal' ),
					'@ ' . __( 'Operate with transparency', 'iflynepal' ) . ' | ' . __( 'Accountability and integrity in how we run and report on the business.', 'iflynepal' ),
					'@ ' . __( 'Engage clients and partners', 'iflynepal' ) . ' | ' . __( 'Bring travellers and suppliers into our sustainability efforts, not around them.', 'iflynepal' ),
				)
			),
		),
	);

	return isset( $all[ $page ] ) ? $all[ $page ] : array();
}
