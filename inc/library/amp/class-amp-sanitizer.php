<?php
/**
 * Super_Awesome_Theme_AMP_Sanitizer class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class performing theme-specific AMP sanitization.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_AMP_Sanitizer extends AMP_Base_Sanitizer {

	/**
	 * XPath for the DOMDocument.
	 *
	 * @since 1.0.0
	 * @var DOMXPath
	 */
	protected $xpath;

	/**
	 * Sanitizes the HTML contained in the DOMDocument.
	 *
	 * @since 1.0.0
	 */
	public function sanitize() {
		$this->xpath = new DOMXPath( $this->dom );

		$this->add_amp_indicator();
		$this->force_svg_support();
		$this->fix_header_image();
		$this->support_mobile_menu_toggle();
		$this->support_side_navbar_toggle();
	}

	/**
	 * Adds an AMP indicator class to the html tag.
	 *
	 * @since 1.0.0
	 */
	protected function add_amp_indicator() {
		$this->dom->documentElement->setAttribute(
			'class',
			'amp ' . $this->dom->documentElement->getAttribute( 'class' )
		);
	}

	/**
	 * Forces SVG support, replacing no-svg class name with svg class name.
	 *
	 * @since 1.0.0
	 */
	protected function force_svg_support() {
		$this->dom->documentElement->setAttribute(
			'class',
			preg_replace(
				'/(^|\s)no-svg(\s|$)/',
				' svg ',
				$this->dom->documentElement->getAttribute( 'class' )
			)
		);
	}

	/**
	 * Fixes the header image appearance by adjusting its layout attribute.
	 *
	 * @since 1.0.0
	 */
	protected function fix_header_image() {
		$header_image = $this->xpath->query( '//div[@id = "wp-custom-header"]//amp-img' );

		if ( ! $header_image->length ) {
			return;
		}

		$header_image = $header_image->item( 0 );
		$header_image->setAttribute( 'layout', 'responsive' );
	}

	/**
	 * Adds support for the mobile menu toggle, which is otherwise controlled by JS.
	 *
	 * @since 1.0.0
	 */
	protected function support_mobile_menu_toggle() {
		$state_id = $this->args['state_id'];

		$navigation = $this->dom->getElementById( 'site-navigation' );
		$button     = $this->xpath->query( '//nav[@id = "site-navigation"]//button[ contains( @class, "menu-toggle" ) ]' );

		$navigation_class = $navigation->getAttribute( 'class' );

		$navigation->setAttribute(
			AMP_DOM_Utils::get_amp_bind_placeholder_prefix() . 'class',
			"{$state_id}.mobileMenuExpanded ? '{$navigation_class} toggled' : '{$navigation_class}'"
		);

		if ( ! $button->length ) {
			$navigation->setAttribute( 'class', $navigation_class . ' toggled' );
			return;
		}

		$button = $button->item( 0 );

		$button->setAttribute( 'on', "tap:AMP.setState( { {$state_id}: { mobileMenuExpanded: ! {$state_id}.mobileMenuExpanded } } )" );
		$button->setAttribute(
			AMP_DOM_Utils::get_amp_bind_placeholder_prefix() . 'aria-expanded',
			"{$state_id}.mobileMenuExpanded ? 'true' : 'false'"
		);
	}

	/**
	 * Adds support for the side navbar toggle as necessary, which is otherwise controlled by JS.
	 *
	 * @since 1.0.0
	 */
	protected function support_side_navbar_toggle() {
		$state_id = $this->args['state_id'];

		$navbar = $this->dom->getElementById( 'site-navbar' );
		$button = $this->xpath->query( '//div[@id = "site-navbar"]//button[ contains( @class, "site-navbar-toggle" ) ]' );

		$navbar_class = $navbar->getAttribute( 'class' );

		$navbar->setAttribute(
			AMP_DOM_Utils::get_amp_bind_placeholder_prefix() . 'class',
			"{$state_id}.sideNavbarExpanded ? '{$navbar_class} toggled' : '{$navbar_class}'"
		);

		if ( ! $button->length ) {
			$navbar->setAttribute( 'class', $navbar_class . ' toggled' );
			return;
		}

		$button = $button->item( 0 );

		$button->setAttribute( 'on', "tap:AMP.setState( { {$state_id}: { sideNavbarExpanded: ! {$state_id}.sideNavbarExpanded } } )" );
		$button->setAttribute(
			AMP_DOM_Utils::get_amp_bind_placeholder_prefix() . 'aria-expanded',
			"{$state_id}.sideNavbarExpanded ? 'true' : 'false'"
		);
	}
}
