<?php
/**
 * Language switcher.
 *
 * Polylang is optional infrastructure, not a hard theme dependency: the
 * switcher renders nothing when the plugin is inactive or only one language
 * is configured, so the header layout never breaks if it's deactivated.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Prints the language switcher, or nothing if Polylang isn't set up for it.
 *
 * @since 1.0.0
 *
 * @return void
 */
function iflynepal_render_language_switcher() {
	if ( ! function_exists( 'pll_the_languages' ) ) {
		return;
	}

	$iflynepal_languages = pll_the_languages(
		array(
			'raw'              => 1,
			'hide_if_empty'    => 0,
			'show_flags'       => 0,
			'show_names'       => 1,
			'display_names_as' => 'name',
		)
	);

	if ( ! is_array( $iflynepal_languages ) || count( $iflynepal_languages ) < 2 ) {
		return;
	}

	/*
	 * pll_the_languages() computes a post-type archive's URL in every other
	 * language by swapping the language prefix on the CURRENT url — it has no
	 * translated-post-id to work from the way it does for a singular page. That
	 * breaks any archive whose slug is itself translated (Packages: /packages/
	 * vs /fr/forfaits/, News: /news/ vs /fr/actualites/): the raw swap produces
	 * the untranslated slug under the other language's prefix, e.g.
	 * /fr/packages/ instead of /fr/forfaits/. Both happen to still resolve
	 * (Polylang auto-prefixes the flat fallback rule too), so the link isn't
	 * dead, it's just the wrong slug for that language.
	 *
	 * Re-deriving each language's archive URL through get_post_type_archive_link()
	 * — the same call the page itself uses to print that URL elsewhere — fixes
	 * this for any current or future CPT archive with a translated slug,
	 * without duplicating the slug logic here.
	 */
	if ( is_post_type_archive() && function_exists( 'PLL' ) && PLL() && isset( PLL()->model ) ) {
		$iflynepal_post_type = get_query_var( 'post_type' );

		if ( is_array( $iflynepal_post_type ) ) {
			$iflynepal_post_type = reset( $iflynepal_post_type );
		}

		if ( $iflynepal_post_type ) {
			$iflynepal_saved_curlang = PLL()->curlang;

			foreach ( $iflynepal_languages as &$iflynepal_row ) {
				$iflynepal_target = PLL()->model->get_language( $iflynepal_row['slug'] );

				if ( ! $iflynepal_target ) {
					continue;
				}

				PLL()->curlang = $iflynepal_target;
				$iflynepal_archive_url = get_post_type_archive_link( $iflynepal_post_type );

				if ( $iflynepal_archive_url ) {
					$iflynepal_row['url'] = $iflynepal_archive_url;
				}
			}
			unset( $iflynepal_row );

			PLL()->curlang = $iflynepal_saved_curlang;
		}
	}

	$iflynepal_current      = '';
	$iflynepal_current_slug = '';
	foreach ( $iflynepal_languages as $iflynepal_lang ) {
		if ( ! empty( $iflynepal_lang['current_lang'] ) ) {
			$iflynepal_current      = $iflynepal_lang['name'];
			$iflynepal_current_slug = $iflynepal_lang['slug'];
			break;
		}
	}
	?>
	<div class="iflynepal-lang-switch">
		<button
			type="button"
			class="iflynepal-lang-switch__toggle"
			aria-expanded="false"
			aria-haspopup="true"
			aria-controls="iflynepal-lang-switch-list"
		>
			<?php
			/*
			 * Two labels, one shown at a time by CSS: the full name on
			 * desktop, the short language code (Polylang's own slug, e.g.
			 * "en", "fr") on mobile — the header bar there is too tight
			 * for "ENGLISH" next to the floating WhatsApp bubble's old
			 * seat and the menu toggle.
			 */
			?>
			<span class="iflynepal-lang-switch__full"><?php echo esc_html( $iflynepal_current ); ?></span>
			<span class="iflynepal-lang-switch__short"><?php echo esc_html( $iflynepal_current_slug ); ?></span>
			<svg class="iflynepal-ico" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M6 9l6 6 6-6"/></svg>
		</button>
		<ul id="iflynepal-lang-switch-list" class="iflynepal-lang-switch__list" hidden>
			<?php foreach ( $iflynepal_languages as $iflynepal_lang ) : ?>
				<li>
					<a
						href="<?php echo esc_url( $iflynepal_lang['url'] ); ?>"
						lang="<?php echo esc_attr( $iflynepal_lang['slug'] ); ?>"
						class="iflynepal-lang-switch__link<?php echo ! empty( $iflynepal_lang['current_lang'] ) ? ' is-current' : ''; ?>"
						<?php echo ! empty( $iflynepal_lang['current_lang'] ) ? 'aria-current="true"' : ''; ?>
					>
						<span class="iflynepal-lang-switch__full"><?php echo esc_html( $iflynepal_lang['name'] ); ?></span>
						<span class="iflynepal-lang-switch__short"><?php echo esc_html( $iflynepal_lang['slug'] ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php
}
