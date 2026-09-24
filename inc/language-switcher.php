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

	$iflynepal_current = '';
	foreach ( $iflynepal_languages as $iflynepal_lang ) {
		if ( ! empty( $iflynepal_lang['current_lang'] ) ) {
			$iflynepal_current = $iflynepal_lang['name'];
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
			<?php echo esc_html( $iflynepal_current ); ?>
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
						<?php echo esc_html( $iflynepal_lang['name'] ); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php
}
