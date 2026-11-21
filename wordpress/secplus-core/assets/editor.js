/**
 * "SEO & review" document panel for pages and posts (no build step).
 */
( function ( wp ) {
	if ( ! wp || ! wp.plugins ) {
		return;
	}
	var el = wp.element.createElement;
	var c = wp.components;
	var __ = wp.i18n.__;
	var useSelect = wp.data.useSelect;
	var useDispatch = wp.data.useDispatch;
	var Panel = ( wp.editor && wp.editor.PluginDocumentSettingPanel ) || ( wp.editPost && wp.editPost.PluginDocumentSettingPanel );
	if ( ! Panel ) {
		return;
	}

	function SeoPanel() {
		var data = useSelect( function ( select ) {
			var ed = select( 'core/editor' );
			return { type: ed.getCurrentPostType(), meta: ed.getEditedPostAttribute( 'meta' ) || {} };
		}, [] );
		var editPost = useDispatch( 'core/editor' ).editPost;
		if ( data.type !== 'post' && data.type !== 'page' ) {
			return null;
		}
		var meta = data.meta;
		var set = function ( key ) {
			return function ( value ) {
				var m = {};
				m[ key ] = value;
				editPost( { meta: m } );
			};
		};
		var desc = meta.secplus_meta_description || '';
		var children = [
			el( c.TextControl, {
				key: 'title',
				label: __( 'SEO title (optional)', 'secplus-core' ),
				help: __( 'Overrides the page title in search results. Aim for under 60 characters.', 'secplus-core' ),
				value: meta.secplus_seo_title || '',
				onChange: set( 'secplus_seo_title' )
			} ),
			el( c.TextareaControl, {
				key: 'desc',
				label: __( 'Meta description', 'secplus-core' ),
				help: desc.length + ' / 155 ' + __( 'characters recommended', 'secplus-core' ),
				value: desc,
				onChange: set( 'secplus_meta_description' )
			} )
		];
		if ( data.type === 'post' ) {
			children.push(
				el( 'hr', { key: 'hr' } ),
				el( 'p', { key: 'note' }, el( 'strong', null, __( 'Professional review', 'secplus-core' ) ) ),
				el( c.TextControl, {
					key: 'reviewer',
					label: __( 'Reviewed by', 'secplus-core' ),
					help: __( 'Name and title of the qualified reviewer. Shown on the article.', 'secplus-core' ),
					value: meta.secplus_reviewer || '',
					onChange: set( 'secplus_reviewer' )
				} ),
				el( c.TextControl, {
					key: 'reviewed',
					type: 'date',
					label: __( 'Last reviewed', 'secplus-core' ),
					value: meta.secplus_last_reviewed || '',
					onChange: set( 'secplus_last_reviewed' )
				} ),
				el( c.SelectControl, {
					key: 'service',
					label: __( 'Related service (call to action)', 'secplus-core' ),
					value: meta.secplus_related_service || '',
					options: window.secplusServices || [],
					onChange: set( 'secplus_related_service' )
				} )
			);
		}
		return el( Panel, { name: 'secplus-seo', title: __( 'SEO & review', 'secplus-core' ), className: 'secplus-seo-panel' }, children );
	}

	wp.plugins.registerPlugin( 'secplus-seo', { render: SeoPanel, icon: 'search' } );
}( window.wp ) );
