/* ---- THE FOLLOWING CONFIG SHOULD BE EDITED ---- */

var pkg = require( './package.json' );

var tags = [
	'one-column',
	'two-columns',
	'left-sidebar',
	'right-sidebar',
	'flexible-header',
	'accessibility-ready',
	'custom-background',
	'custom-colors',
	'custom-header',
	'custom-menu',
	'custom-logo',
	'editor-style',
	'featured-image-header',
	'featured-images',
	'footer-widgets',
	'full-width-template',
	'post-formats',
	'rtl-language-support',
	'theme-options',
	'threaded-comments',
	'translation-ready'
];

var config = {
	textDomain: 'super-awesome-theme',
	domainPath: '/languages/',
	themeName: 'Super Awesome Theme',
	themeURI: pkg.homepage,
	author: pkg.author.name,
	authorURI: pkg.author.url,
	description: pkg.description,
	version: pkg.version,
	license: 'GNU General Public License v3 or later',
	licenseURI: 'https://www.gnu.org/licenses/gpl-3.0.html',
	tags: tags.join( ', ' ),
	contributors: [ 'flixos90', 'philliproth' ].join( ', ' ),
	minRequired: '4.7',
	testedUpTo: '4.8',
	translateURI: 'https://translate.wordpress.org/projects/wp-themes/super-awesome-theme'
};

/* ---- DO NOT EDIT BELOW THIS LINE ---- */

// WP theme header for style.css
var themeheader =	'Theme Name: ' + config.themeName + '\n' +
					'Theme URI: ' + config.themeURI + '\n' +
					'Author: ' + config.author + '\n' +
					'Author URI: ' + config.authorURI + '\n' +
					'Description: ' + config.description + '\n' +
					'Version: ' + config.version + '\n' +
					'License: ' + config.license + '\n' +
					'License URI: ' + config.licenseURI + '\n' +
					'Text Domain: ' + config.textDomain + '\n' +
					( config.domainPath ? 'Domain Path: ' + config.domainPath + '\n' : '' ) +
					'Tags: ' + config.tags;

// WP theme header for readme.txt
var readmeheader =	'Contributors: ' + config.contributors + '\n' +
					'Stable tag: ' + config.version + '\n' +
					'Version: ' + config.version + '\n' +
					'Requires at least: ' + config.minRequired + '\n' +
					'Tested up to: ' + config.testedUpTo + '\n' +
					'License: ' + config.license + '\n' +
					'License URI: ' + config.licenseURI + '\n' +
					'Tags: ' + config.tags;


/* ---- REQUIRED DEPENDENCIES ---- */

var gulp = require( 'gulp' );

var cleanCss = require( 'gulp-clean-css' );
var concat   = require( 'gulp-concat' );
var csscomb  = require( 'gulp-csscomb' );
var jshint   = require( 'gulp-jshint' );
var rename   = require( 'gulp-rename' );
var replace  = require( 'gulp-replace' );
var sass     = require( 'gulp-sass' );
var sort     = require( 'gulp-sort' );
var uglify   = require( 'gulp-uglify' );
var wpPot    = require( 'gulp-wp-pot' );

/* ---- MAIN TASKS ---- */

// default task (compile Sass and JavaScript and refresh POT file)
gulp.task( 'default', [ 'sass', 'js', 'pot' ]);

// build the theme
gulp.task( 'build', [ 'header-replace', 'readme-replace' ], function() {
	gulp.start( 'default' );
});

/* ---- SUB TASKS ---- */

// compile Sass
gulp.task( 'sass', function( done ) {
	gulp.src( './assets/sass/style.scss' )
		.pipe( sass({
			errLogToConsole: true,
			outputStyle: 'expanded'
		}) )
		.pipe( csscomb() )
		.pipe( gulp.dest( './' ) )
		.on( 'end', done );
});

// compile JavaScript
gulp.task( 'js', function( done ) {
	var builderFiles = [
		'./assets/js/**/*.js',
		'!./assets/js/customize-preview.js',
		'!./assets/js/customize-preview.min.js',
		'!./assets/js/html5.js',
		'!./assets/js/theme.js',
		'!./assets/js/theme.min.js'
	];

	gulp.src( builderFiles )
		.pipe( jshint() )
		.pipe( jshint.reporter( 'default' ) )
		.pipe( jscs() )
		.pipe( jscs.reporter() )
		.pipe( concat( 'theme.js' ) )
		.pipe( banner( assetheader ) )
		.pipe( gulp.dest( './assets/js/' ) )
		.pipe( uglify() )
		.pipe( rename({
			extname: '.min.js'
		}) )
		.pipe( gulp.dest( './assets/js/' ) )
		.on( 'end', function() {
			gulp.src( './assets/js/customize-preview.js' )
				.pipe( jshint() )
				.pipe( jshint.reporter( 'default' ) )
				.pipe( jscs() )
				.pipe( jscs.reporter() )
				.pipe( uglify() )
				.pipe( rename({
					extname: '.min.js'
				}) )
				.pipe( gulp.dest( './assets/js/' ) )
				.on( 'end', done );
		});
});

// generate POT file
gulp.task( 'pot', function( done ) {
	var phpFiles = [
		'./*.php',
		'./inc/**/*.php',
		'./template-parts/**/*.php'
	];

	gulp.src( phpFiles )
		.pipe( sort() )
		.pipe( wpPot({
			domain: config.textDomain,
			headers: {
				'Project-Id-Version': config.themeName + ' ' + config.version,
				'report-msgid-bugs-to': config.translateURI,
				'x-generator': 'gulp-wp-pot',
				'x-poedit-basepath': '.',
				'x-poedit-language': 'English',
				'x-poedit-country': 'UNITED STATES',
				'x-poedit-sourcecharset': 'uft-8',
				'x-poedit-keywordslist': '__;_e;_x:1,2c;_ex:1,2c;_n:1,2; _nx:1,2,4c;_n_noop:1,2;_nx_noop:1,2,3c;esc_attr__; esc_html__;esc_attr_e; esc_html_e;esc_attr_x:1,2c; esc_html_x:1,2c;',
				'x-poedit-bookmars': '',
				'x-poedit-searchpath-0': '.',
				'x-textdomain-support': 'yes'
			}
		}) )
		.pipe( gulp.dest( './languages/' + config.textDomain + '.pot' ) )
		.on( 'end', done );
});

// replace the theme header in assets/sass/style.scss
gulp.task( 'header-replace', function( done ) {
	gulp.src( './assets/sass/style.scss' )
		.pipe( replace( /^\/\*!\s([\s\S]+)WordPress Theme, Copyright \(C\)/, '/*!\n' + themeheader + '\n\n' + config.themeName + ' WordPress Theme, Copyright (C)' ) )
		.pipe( gulp.dest( './assets/sass/' ) )
		.on( 'end', done );
});

// replace the theme header in readme.txt
gulp.task( 'readme-replace', function( done ) {
	gulp.src( './readme.txt' )
		.pipe( replace( /\=\=\= (.+) \=\=\=([\s\S]+)\=\= Description \=\=/m, '=== ' + config.themeName + ' ===\n\n' + readmeheader + '\n\n== Description ==' ) )
		.pipe( gulp.dest( './' ) )
		.on( 'end', done );
});

/* ---- INITIAL SETUP TASK: Change the replacements, run the command once and then delete it from here ---- */

gulp.task( 'init-replace', function( done ) {
	var replacements = {
		'super-awesome-theme': 'my-new-theme-name',
		'SUPER_AWESOME_THEME': 'MY_NEW_THEME_NAME',
		'super_awesome_theme': 'my_new_theme_name',
		'Super_Awesome_Theme': 'My_New_Theme_Name',
		'Super Awesome Theme': 'My New Theme Name',
		'SuperAwesomeTheme'  : 'MyNewThemeName',
		'superAwesomeTheme'  : 'myNewThemeName'
	};

	var files = [
		'./*.php',
		'./inc/**/*.php',
		'./template-parts/**/*.php',
		'./assets/js/**/*.js',
		'./assets/sass/style.scss',
		'./style.css',
		'./gulpfile.js'
	];

	gulp.src( files, { base: './' })
		.pipe( replace( 'super-awesome-theme', replacements['super-awesome-theme'] ) )
		.pipe( replace( 'SUPER_AWESOME_THEME', replacements['SUPER_AWESOME_THEME'] ) )
		.pipe( replace( 'super_awesome_theme', replacements['super_awesome_theme'] ) )
		.pipe( replace( 'Super_Awesome_Theme', replacements['Super_Awesome_Theme'] ) )
		.pipe( replace( 'Super Awesome Theme', replacements['Super Awesome Theme'] ) )
		.pipe( replace( 'SuperAwesomeTheme',   replacements['SuperAwesomeTheme'] ) )
		.pipe( replace( 'superAwesomeTheme',   replacements['superAwesomeTheme'] ) )
		.pipe( gulp.dest( './' ) )
		.on( 'end', done );
});
