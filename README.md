# Super Awesome Theme (Boilerplate)

This is my personal theme boilerplate, initially based on [\_s](http://underscores.me/), partly inspired by [Twenty Seventeen](https://wordpress.org/themes/twentyseventeen/), with lots of additional features.

## Features

The following is a non-comprehensive list of features in addition to everything that \_s supports:

* Gutenberg supported
* Full Customizer support, mostly with JavaScript-powered live previews
* Very lightweight: No jQuery anywhere, only 1 CSS and 1 JavaScript asset to load in a regular request
* SVG icon set loaded in the footer, with an easy-to-use utility function to print icons in an accessible way
* Dynamic detection of post type support for different features and taxonomies
* Granular color control via the Customizer
* Customizer panel for content type options: For each post type, it can be individually decided whether information like date, author, taxonomies etc. should be displayed or not
* Support for either a full-width or wrapped layout (by calling `add_filter( 'super_awesome_theme_use_wrapped_layout', '__return_true' )`)
* Customizer section for sidebar settings, with three sidebar modes:
    * No Sidebar
    * Left Sidebar
    * Right Sidebar
* "Distraction Free Mode": Particularly useful for very focused pages (like a login page or a checkout page), the view is rendered with fewer distractions:
    * No sidebar
    * No footer widgets
    * Alternative site navigation menu
* Templates:
    * Full Width (no sidebar, regardless of global setting)
    * Distraction Free (as described above)
    * Account (page that is restricted to logged-in users)
    * Login (shows a login form)
* Menus:
    * Primary Menu
    * Primary Menu (Distraction-Free)
    * Social Links Menu
    * Footer Menu
* Sidebars:
    * Primary Sidebar
    * Blog Sidebar (can be enabled/disabled)
    * 3 Footer Widget Areas
* AJAX-powered comment submissions
* Accessible primary navigation with keyboard
* Maximum page width limited, and maximum content width limited further on pages with no sidebar, in order to keep line lengths readable
* Granular and organized template part files for easy tweaking / overriding in a child theme
* Solid attachment template support, including display of metadata
* Flexible whether template parts should be loaded per post type and/or post format
* Dedicated template part for comments
* Graceful fallback if minimum required WordPress version is not being used
* Easy-to-use Gulp workflow for linting and compiling assets
* ES6 JavaScript
* Reusable CSS classes for typical elements
* Editor style mimicking the frontend layout
* Styling of special multisite pages `wp-signup.php` and `wp-activate.php`
* Compliant with code and documentation standards
* Plugin support for the following:
    * [Easy Digital Downloads](https://wordpress.org/plugins/easy-digital-downloads/)
    * [(Gutenberg, but that will soon not be a plugin anymore)](https://wordpress.org/plugins/gutenberg/)
    * [Jetpack](https://wordpress.org/plugins/jetpack/)
    * [Torro Forms](https://wordpress.org/plugins/torro-forms/)
    * [WooCommerce](https://wordpress.org/plugins/woocommerce/)
    * [WP Subtitle](https://wordpress.org/plugins/wp-subtitle/)

This is a work in progress. A few of the above items may be incomplete still.

## Requirements

Minimum WordPress version: 4.7

## Getting Started

To create your own theme, download this repository. For the next steps, let's assume your theme should be called `Taco World`.

1. Rename the directory to `taco-world`.
2. Open `gulpfile.js` and scroll to the bottom.
3. Replace every value in the `replacements` object with your new theme name or theme author data in the appropriate format. For example, replace `my-new-theme-name` with `taco-world`, `MY_NEW_THEME_NAME` with `TACO_WORLD` and so on. Replace the author name, email and website with your respective data.
4. Save the changes.
5. Run `npm install` in the console.
6. Run `gulp init-replace` in the console.
7. Open `gulpfile.js` again and remove the entire bottom section that starts with `INITIAL SETUP TASK`, save the file afterwards.
8. Check the `package.json` file. You might wanna update some details to your preferences.
9. Check the top of `gulpfile.js`, containing the `tags` and `config` objects. You might wanna update some details to your preferences.
10. Run `gulp build` once to compile everything.

Now you're good to go! One more thing: If you want to publish the theme on wordpress.org, it's recommended to remove the `/languages` directory, plus set the `config.domainPath` to `false` and remove the `pot` task in `gulpfile.js`.

## Common Gulp Tasks

* `gulp sass`: Lints and compiles CSS/Sass
* `gulp js`: Lints and compiles JavaScript
* `gulp img`: Compresses images
* `gulp pot`: Refreshes POT file
* `gulp readme`: Replaces the header and description in the readme with latest data
* `gulp build`: Runs all of the above tasks

TODO: codeclimate.yml, PHPCS, PHPMD
