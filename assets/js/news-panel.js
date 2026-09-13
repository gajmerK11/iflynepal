/**
 * The News panel in the block editor's document sidebar.
 *
 * Three fields an editor sets on a story and nothing else does: whether it sits
 * in the Top News row at the head of the archive, the topic line that prints
 * beside the News flag in the hero, and the place the story is filed from,
 * which prints both in the details row and at the head of the standfirst.
 *
 * The Top News toggle is capped at three, which is a fact about the whole
 * post type rather than about this post, so it has to be asked of the server:
 * /iflynepal/v1/top-news answers with the count and with the three stories
 * holding the places, so an editor who has run out is told which to free
 * rather than left to hunt for them. It is asked again whenever the window is
 * focused, because freeing a place happens in another tab.
 *
 * Written against the wp.* globals rather than built from JSX: the theme has no
 * editor build step, and this is small enough not to want one.
 *
 * @package IFly_Nepal
 * @since   1.0.0
 */

( function ( wp ) {
	var registerPlugin = wp.plugins.registerPlugin;
	var PluginDocumentSettingPanel = wp.editPost.PluginDocumentSettingPanel;
	var useSelect = wp.data.useSelect;
	var useDispatch = wp.data.useDispatch;
	var ToggleControl = wp.components.ToggleControl;
	var TextControl = wp.components.TextControl;
	var el = wp.element.createElement;
	var useState = wp.element.useState;
	var useEffect = wp.element.useEffect;
	var apiFetch = wp.apiFetch;
	var __ = wp.i18n.__;

	var settings = window.iflynepalNews || {};
	var TOP = settings.topMeta || '_iflynepal_news_top';
	var TOPIC = settings.topicMeta || '_iflynepal_news_topic';
	var PLACE = settings.placeMeta || '_iflynepal_news_place';
	var LIMIT = settings.limit || 3;

	registerPlugin( 'iflynepal-news-panel', {
		render: function () {
			var meta = useSelect( function ( select ) {
				return select( 'core/editor' ).getEditedPostAttribute( 'meta' );
			}, [] );

			var editPost = useDispatch( 'core/editor' ).editPost;

			var isTop = Boolean( meta && meta[ TOP ] );
			var topic = ( meta && meta[ TOPIC ] ) || '';
			var place = ( meta && meta[ PLACE ] ) || '';

			var state = useState( { count: 0, posts: [] } );
			var top = state[ 0 ];
			var setTop = state[ 1 ];

			useEffect( function () {
				var alive = true;

				function read() {
					apiFetch( { path: '/iflynepal/v1/top-news' } ).then( function ( data ) {
						if ( alive ) {
							setTop( { count: data.count, posts: data.posts } );
						}
					} );
				}

				read();
				window.addEventListener( 'focus', read );

				return function () {
					alive = false;
					window.removeEventListener( 'focus', read );
				};
			}, [] );

			var full = top.count >= LIMIT && ! isTop;

			function set( key, value ) {
				var next = {};
				next[ key ] = value;
				editPost( { meta: next } );
			}

			return el(
				PluginDocumentSettingPanel,
				{
					name: 'iflynepal-news-panel',
					title: __( 'News', 'iflynepal' ),
				},
				el( ToggleControl, {
					label: __( 'Show in Top News', 'iflynepal' ),
					help: __( 'The row of three at the head of the News archive.', 'iflynepal' ),
					checked: isTop,
					disabled: full,
					onChange: function ( value ) {
						set( TOP, value );
					},
				} ),
				full
					? el(
							'div',
							{ className: 'iflynepal-news-panel__notice' },
							el(
								'p',
								null,
								__( 'Top News already holds three stories. Turn one of these off — and save it — to free a place:', 'iflynepal' )
							),
							el(
								'ul',
								null,
								top.posts.map( function ( post ) {
									return el(
										'li',
										{ key: post.id },
										el(
											'a',
											{
												href: post.edit_link,
												target: '_blank',
												rel: 'noreferrer',
											},
											post.title
										)
									);
								} )
							)
					  )
					: null,
				el( TextControl, {
					label: __( 'Topic', 'iflynepal' ),
					help: __( 'Beside the News flag in the hero, in small capitals. For example: Festivals & travel.', 'iflynepal' ),
					value: topic,
					onChange: function ( value ) {
						set( TOPIC, value );
					},
				} ),
				el( TextControl, {
					label: __( 'Dateline', 'iflynepal' ),
					help: __( 'Where the story is filed from. For example: Kathmandu. Empty removes it.', 'iflynepal' ),
					value: place,
					onChange: function ( value ) {
						set( PLACE, value );
					},
				} )
			);
		},
	} );
} )( window.wp );
