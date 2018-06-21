/**
 * File get-customize-action.js.
 *
 * Function to get the Customize action for a given panel.
 */

export default ( panel ) => {
	const { __, sprintf } = window.wp.i18n;
	const panelInstance   = panel && panel.length ? window.wp.customize.panel.instance( panel ) : undefined;

	if ( panelInstance ) {
		return sprintf( __( 'Customizing &#9656; %s', 'super-awesome-theme' ), panelInstance.params.title );
	}

	return __( 'Customizing', 'super-awesome-theme' );
};
