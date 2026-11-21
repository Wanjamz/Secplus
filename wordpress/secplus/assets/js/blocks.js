/**
 * Editor registration for SecPlus theme blocks (no build step; uses WordPress globals).
 */
( function ( wp ) {
	if ( ! wp || ! wp.blocks ) {
		return;
	}
	var el = wp.element.createElement;
	var Fragment = wp.element.Fragment;
	var be = wp.blockEditor;
	var c = wp.components;
	var SSR = wp.serverSideRender;
	var __ = wp.i18n.__;

	function preview( name ) {
		return function ( props ) {
			var blockProps = be.useBlockProps( { className: 'sp-ssr-preview' } );
			return el( 'div', blockProps, el( SSR, { block: name, attributes: props.attributes, urlQueryArgs: { post_id: wp.data.select( 'core/editor' ) ? wp.data.select( 'core/editor' ).getCurrentPostId() : 0 } } ) );
		};
	}

	function register( name, title, icon, extra ) {
		if ( wp.blocks.getBlockType( name ) ) {
			wp.blocks.unregisterBlockType( name );
		}
		wp.blocks.registerBlockType( name, Object.assign( {
			apiVersion: 3,
			title: title,
			icon: icon,
			category: 'design',
			edit: preview( name ),
			save: function () {
				return null;
			}
		}, extra || {} ) );
	}

	register( 'secplus/icon', __( 'SecPlus Icon', 'secplus' ), 'star-empty', {
		attributes: {
			icon: { type: 'string', default: 'check' },
			variant: { type: 'string', default: 'tint' },
			size: { type: 'string', default: 'md' },
			className: { type: 'string' }
		},
		edit: function ( props ) {
			var a = props.attributes;
			var blockProps = be.useBlockProps();
			return el( Fragment, null,
				el( be.InspectorControls, null,
					el( c.PanelBody, { title: __( 'Icon', 'secplus' ), initialOpen: true },
						el( c.SelectControl, {
							label: __( 'Icon', 'secplus' ),
							value: a.icon,
							options: window.secplusIcons || [],
							onChange: function ( v ) { props.setAttributes( { icon: v } ); }
						} ),
						el( c.SelectControl, {
							label: __( 'Style', 'secplus' ),
							value: a.variant,
							options: [
								{ value: 'tint', label: __( 'Light blue disc', 'secplus' ) },
								{ value: 'solid', label: __( 'Blue disc', 'secplus' ) },
								{ value: 'dark', label: __( 'Navy disc', 'secplus' ) },
								{ value: 'plain', label: __( 'No background', 'secplus' ) }
							],
							onChange: function ( v ) { props.setAttributes( { variant: v } ); }
						} ),
						el( c.SelectControl, {
							label: __( 'Size', 'secplus' ),
							value: a.size,
							options: [
								{ value: 'sm', label: __( 'Small', 'secplus' ) },
								{ value: 'md', label: __( 'Medium', 'secplus' ) },
								{ value: 'lg', label: __( 'Large', 'secplus' ) }
							],
							onChange: function ( v ) { props.setAttributes( { size: v } ); }
						} )
					)
				),
				el( 'div', blockProps, el( SSR, { block: 'secplus/icon', attributes: a } ) )
			);
		}
	} );

	register( 'secplus/breadcrumbs', __( 'SecPlus Breadcrumbs', 'secplus' ), 'menu-alt3' );
	register( 'secplus/copyright', __( 'SecPlus Copyright', 'secplus' ), 'editor-code' );
	register( 'secplus/article-meta', __( 'SecPlus Article Meta', 'secplus' ), 'info-outline' );
	register( 'secplus/related-posts', __( 'SecPlus Related Insights', 'secplus' ), 'excerpt-view', {
		attributes: { count: { type: 'number', default: 3 }, className: { type: 'string' } }
	} );
	register( 'secplus/guide-links', __( 'SecPlus Guide Links', 'secplus' ), 'book', {
		attributes: { slugs: { type: 'array', default: [] }, title: { type: 'string', default: 'Related guides' }, className: { type: 'string' } }
	} );
	register( 'secplus/topic-cards', __( 'SecPlus Insight Topics', 'secplus' ), 'category' );
	register( 'secplus/related-service', __( 'SecPlus Related Service', 'secplus' ), 'businessperson' );
}( window.wp ) );
