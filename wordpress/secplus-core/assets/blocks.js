/**
 * Editor registration for SecPlus Core blocks (no build step).
 */
( function ( wp ) {
	if ( ! wp || ! wp.blocks ) {
		return;
	}
	var el = wp.element.createElement;
	var be = wp.blockEditor;
	var c = wp.components;
	var SSR = wp.serverSideRender;
	var __ = wp.i18n.__;

	wp.blocks.registerBlockType( 'secplus/enquiry-form', {
		apiVersion: 3,
		title: __( 'SecPlus Enquiry Form', 'secplus-core' ),
		icon: 'feedback',
		category: 'widgets',
		edit: function ( props ) {
			var blockProps = be.useBlockProps();
			return el( 'div', blockProps,
				el( c.Notice, { status: 'info', isDismissible: false },
					__( 'Consultation enquiry form. Submissions are saved under SecPlus → Enquiries and emailed to the address in SecPlus → Site settings.', 'secplus-core' )
				),
				el( 'div', { style: { pointerEvents: 'none' } }, el( SSR, { block: 'secplus/enquiry-form', attributes: props.attributes } ) )
			);
		},
		save: function () {
			return null;
		}
	} );

	wp.blocks.registerBlockType( 'secplus/contact-details', {
		apiVersion: 3,
		title: __( 'SecPlus Contact Details', 'secplus-core' ),
		icon: 'phone',
		category: 'widgets',
		attributes: {
			layout: { type: 'string', default: 'stack' },
			className: { type: 'string' }
		},
		edit: function ( props ) {
			var blockProps = be.useBlockProps();
			return el( wp.element.Fragment, null,
				el( be.InspectorControls, null,
					el( c.PanelBody, { title: __( 'Layout', 'secplus-core' ) },
						el( c.SelectControl, {
							label: __( 'Layout', 'secplus-core' ),
							value: props.attributes.layout,
							options: [
								{ value: 'stack', label: __( 'Stacked list', 'secplus-core' ) },
								{ value: 'card', label: __( 'Card', 'secplus-core' ) },
								{ value: 'footer', label: __( 'Compact (footer)', 'secplus-core' ) }
							],
							onChange: function ( v ) { props.setAttributes( { layout: v } ); }
						} ),
						el( 'p', null, __( 'Edit the details under SecPlus → Site settings.', 'secplus-core' ) )
					)
				),
				el( 'div', blockProps, el( SSR, { block: 'secplus/contact-details', attributes: props.attributes } ) )
			);
		},
		save: function () {
			return null;
		}
	} );
}( window.wp ) );
