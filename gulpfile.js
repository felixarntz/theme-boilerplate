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

var gplNote =	'This program is free software: you can redistribute it and/or modify\n' +
				'it under the terms of the GNU General Public License as published by\n' +
				'the Free Software Foundation, either version 3 of the License, or\n' +
				'(at your option) any later version.\n\n' +
				'This program is distributed in the hope that it will be useful,\n' +
				'but WITHOUT ANY WARRANTY; without even the implied warranty of\n' +
				'MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the\n' +
				'GNU General Public License for more details.';


/* ---- REQUIRED DEPENDENCIES ---- */

var gulp = require( 'gulp' );

var autoprefixer = require( 'gulp-autoprefixer' );
var csscomb      = require( 'gulp-csscomb' );
var eslint       = require( 'gulp-eslint' );
var imagemin     = require( 'gulp-imagemin' );
var jscs         = require( 'gulp-jscs' );
var rename       = require( 'gulp-rename' );
var replace      = require( 'gulp-replace' );
var rtlcss       = require( 'gulp-rtlcss' );
var sass         = require( 'gulp-sass' );
var sort         = require( 'gulp-sort' );
var stylelint    = require( 'gulp-stylelint' );
var uglify       = require( 'gulp-uglify' );
var wpPot        = require( 'gulp-wp-pot' );

var imageminMozjpeg = require( 'imagemin-mozjpeg' );
var webpack         = require( 'webpack-stream' );

/* ---- MAIN TASKS ---- */

// default task
gulp.task( 'default', [ 'sass', 'js', 'img', 'pot' ]);

// build the theme
gulp.task( 'build', [ 'readme-replace' ], function() {
	gulp.start( 'default' );
});

// lint Sass and JavaScript
gulp.task( 'lint', [ 'lint-sass', 'lint-js' ]);

// lint and compile Sass
gulp.task( 'sass', [ 'lint-sass', 'compile-sass' ]);

// lint and compile JavaScript
gulp.task( 'js', [ 'lint-js', 'compile-js' ]);

/* ---- SUB TASKS ---- */

// lint Sass
gulp.task( 'lint-sass', function( done ) {
	gulp.src( './assets/dev/sass/**/*.scss' )
		.pipe( stylelint({
			reporters: [
				{
					formatter: 'string',
					console: true,
				},
			],
		}) )
		.on( 'end', done );
});

// compile Sass
gulp.task( 'compile-sass', function( done ) {
	gulp.src( './assets/dev/sass/style.scss' )
		.pipe( replace( /^\/\*! \-\-\- Theme header will be inserted here automatically\. \-\-\- \*\//, '/*!\n' + themeheader + '\n\n' + config.themeName + ' WordPress Theme, Copyright (C) ' + (new Date()).getFullYear() + ' ' + config.author + '\n\n' + gplNote + '\n*/' ) )
		.pipe( sass({
			errLogToConsole: true,
			outputStyle: 'expanded',
		}) )
		.pipe( autoprefixer({
			browsers: [
				'last 2 versions',
				'android 4',
				'opera 12',
			],
			cascade: false,
		}) )
		.pipe( csscomb() )
		.pipe( gulp.dest( './' ) )
		.pipe( rtlcss() )
		.pipe( rename({
			suffix: '-rtl'
		}) )
		.pipe( gulp.dest( './' ) )
		.on( 'end', done );
});

// lint JavaScript
gulp.task( 'lint-js', function( done ) {
	gulp.src( './assets/dev/js/**/*.js' )
		.pipe( eslint() )
		.pipe( eslint.format() )
		.pipe( eslint.failAfterError() )
		.pipe( jscs() )
		.pipe( jscs.reporter() )
		.on( 'end', done );
});

// compile JavaScript
gulp.task( 'compile-js', function( done ) {
	gulp.src( './assets/dev/js/theme.js' )
		.pipe( webpack({
			entry: {
				theme: './assets/dev/js/theme.js',
				'customize-controls': './assets/dev/js/customize-controls.js',
				'customize-preview': './assets/dev/js/customize-preview.js',
			},
			output: {
				filename: '[name].js',
			},
		}) )
		.pipe( gulp.dest( './assets/dist/js/' ) )
		.pipe( uglify() )
		.pipe( rename({
			extname: '.min.js',
		}) )
		.pipe( gulp.dest( './assets/dist/js/' ) )
		.on( 'end', done );
});

// minify images
gulp.task( 'img', function( done ) {
	gulp.src([
			'./assets/dev/images/**/*.gif',
			'./assets/dev/images/**/*.jpg',
			'./assets/dev/images/**/*.png',
			'./assets/dev/images/**/*.svg',
		])
		.pipe( imagemin([
			imagemin.gifsicle({
				optimizationLevel: 3,
			}),
			imagemin.optipng({
				optimizationLevel: 7,
			}),
			imagemin.svgo({
				plugins: [
					{
						cleanupIDs: false,
					},
					{
						removeComments: true,
					},
					{
						removeHiddenElems: false,
					},
					{
						removeViewBox: false,
					},
					{
						removeUnknownsAndDefaults: false,
					},
				],
			}),
			imageminMozjpeg({
				quality: 75,
			})
		]) )
		.pipe( gulp.dest( './assets/dist/images/' ) )
		.on( 'end', done );
});

// generate POT file
gulp.task( 'pot', function( done ) {
	gulp.src([
		'./*.php',
		'./inc/**/*.php',
		'./template-parts/**/*.php',
	])
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

// replace the theme header in readme.txt
gulp.task( 'readme', function( done ) {
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
		'./assets/dist/js/**/*.js',
		'./assets/dev/js/**/*.js',
		'./assets/dev/sass/style.scss',
		'./style.css',
		'./style-rtl.css',
		'./gulpfile.js',
		'./package.json',
		'./readme.txt'
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
