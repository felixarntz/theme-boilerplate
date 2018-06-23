/**
 * File content-types.customize-controls.js.
 *
 * Theme Customizer handling for content type controls.
 */

import getCustomizeAction from './customize/get-customize-action';

( ( wp, data ) => {
	const api                 = wp.customize;
	const { __, _x, sprintf } = wp.i18n;
	const currentPostType     = new api.Value( '' );
	const hasPageHeader       = new api.Value( false );

	api.bind( 'ready', () => {
		api.panel.instance( 'content_types', panel => {
			const customizeAction = getCustomizeAction( panel.id );

			data.postTypes.forEach( postType => {
				const sectionId = 'content_type_' + postType.slug;

				[ 'supports', 'taxonomies', 'extraFields' ].forEach( param => {
					postType[ param ] = postType[ param ].length ? postType[ param ] : [];
				});

				api.section.add( new api.Section( sectionId, {
					panel:           panel.id,
					title:           postType.label,
					customizeAction: customizeAction,
				}) );

				api.instance( postType.slug + '_use_page_header', setting => {
					api.control.add( new api.Control( setting.id, {
						setting: setting.id,
						section: sectionId,
						label:   __( 'Use Page Header?', 'super-awesome-theme' ),
						type:    'checkbox',
					}) );
				});

				if ( postType.supports.includes( 'excerpt' ) ) {
					api.instance( postType.slug + '_use_excerpt', setting => {
						setting.transport = 'postMessage';

						api.control.add( new api.Control( setting.id, {
							setting: setting.id,
							section: sectionId,
							label:   __( 'Use Excerpt in archives?', 'super-awesome-theme' ),
							type:    'checkbox',
						}) );
					});
				}

				api.instance( postType.slug + '_show_date', setting => {
					setting.transport = 'postMessage';

					api.control.add( new api.Control( setting.id, {
						setting: setting.id,
						section: sectionId,
						label:   __( 'Show Date?', 'super-awesome-theme' ),
						type:    'checkbox',
					}) );
				});

				if ( postType.supports.includes( 'author' ) ) {
					api.instance( postType.slug + '_show_author', setting => {
						setting.transport = 'postMessage';

						api.control.add( new api.Control( setting.id, {
							setting: setting.id,
							section: sectionId,
							label:   __( 'Show Author Name?', 'super-awesome-theme' ),
							type:    'checkbox',
						}) );
					});

					api.instance( postType.slug + '_show_authorbox', setting => {
						setting.transport = 'postMessage';

						api.control.add( new api.Control( setting.id, {
							setting:  setting.id,
							section:  sectionId,
							label:    __( 'Show Author Box?', 'super-awesome-theme' ),
							type:     'checkbox',
							priority: 120,
						}) );
					});
				}

				postType.taxonomies.forEach( taxonomy => {
					api.instance( postType.slug + '_show_terms_' + taxonomy.slug, setting => {
						setting.transport = 'postMessage';

						api.control.add( new api.Control( setting.id, {
							setting:  setting.id,
							section:  sectionId,
							label:    sprintf( _x( 'Show %s?', 'taxonomy', 'super-awesome-theme' ), taxonomy.label ),
							type:     'checkbox',
							priority: 100,
						}) );
					});
				});

				postType.extraFields.forEach( extraField => {
					api.instance( extraField.slug, setting => {
						setting.transport = 'postMessage';

						api.control.add( new api.Control( setting.id, {
							setting: setting.id,
							section: sectionId,
							label:   extraField.label,
							type:    'checkbox',
						}) );
					});
				});
			});
		});

		// Handle the currentPostType value.
		api.previewer.bind( 'currentPostType', value => {
			currentPostType.set( value );
		});

		// Handle the hasPageHeader value.
		api.previewer.bind( 'hasPageHeader', value => {
			hasPageHeader.set( value );
		});
	});

} )( window.wp, window.themeContentTypesControlsData );
