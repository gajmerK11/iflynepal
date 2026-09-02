/**
 * Tailwind configuration.
 *
 * Tokens mirror the custom properties in assets/css/input.css. `important` is
 * off deliberately: this theme layers utilities over the `wp-block-*` CSS
 * classes its markup reuses, and blanket !important makes those impossible to
 * override.
 */
module.exports = {
	content: [
		'./*.php',
		'./inc/**/*.php',
		'./template-parts/**/*.php',
		'./assets/js/**/*.js',
	],
	safelist: [ 'is-docked', 'is-open', 'is-live', 'is-armed', 'is-drawn' ],
	theme: {
		extend: {
			colors: {
				ink: '#212529',
				muted: '#6D757E',
				paper: '#FFFFFF',
				navy: {
					DEFAULT: '#0545A7',
					light: '#0B58D5',
					deep: '#04347D',
					tint: '#7AA8F6',
					accent: '#A9C8F5',
				},
				mist: '#F0F5FF',
				sand: '#E7EFFC',
				gold: {
					DEFAULT: '#F2C879',
					soft: '#FFDC9A',
					pale: '#FFF6E2',
				},
			},
			borderColor: {
				line: 'rgba(5,69,167,.16)',
			},
			borderRadius: {
				lg: '30px',
				md: '20px',
				sm: '14px',
			},
			boxShadow: {
				soft: '0 22px 70px rgba(4,26,64,.16)',
			},
			maxWidth: {
				shell: '1240px',
			},
			fontFamily: {
				sans: [ 'Poppins', 'ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'sans-serif' ],
				display: [ 'Poppins', 'ui-sans-serif', 'system-ui', '-apple-system', 'Segoe UI', 'sans-serif' ],
				accent: [ 'Cormorant Garamond', 'Georgia', 'serif' ],
				hand: [ 'Caveat', 'Segoe Script', 'cursive' ],
			},
			transitionTimingFunction: {
				brand: 'cubic-bezier(.22,.7,.24,1)',
			},
			screens: {
				nav: '1081px',
			},
		},
	},
	plugins: [],
};
