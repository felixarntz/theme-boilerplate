/* ---- THE FOLLOWING CONFIG SHOULD BE EDITED ---- */

const pkg = require( './package.json' );

const tags = [
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

const config = {
	textDomain: 'super-awesome-theme',
	domainPath: '/languages/',
	themeName: 'Super Awesome Theme',
	themeURI: pkg.homepage,
	author: pkg.author.name,
	authorURI: pkg.author.url,
	description: pkg.description,
	version: pkg.version,
	license: 'GNU General Public License v2 or later',
	licenseURI: 'https://www.gnu.org/licenses/gpl-2.0.html',
	tags: tags.join( ', ' ),
	contributors: [ 'flixos90' ].join( ', ' ),
	minRequired: '4.7',
	testedUpTo: '4.9',
	translateURI: 'https://translate.wordpress.org/projects/wp-themes/super-awesome-theme'
};

/* ---- DO NOT EDIT BELOW THIS LINE ---- */

// WP theme header for style.css
const themeheader =	'Theme Name: ' + config.themeName + '\n' +
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
const readmeheader =	'Contributors: ' + config.contributors + '\n' +
					'Stable tag: ' + config.version + '\n' +
					'Version: ' + config.version + '\n' +
					'Requires at least: ' + config.minRequired + '\n' +
					'Tested up to: ' + config.testedUpTo + '\n' +
					'License: ' + config.license + '\n' +
					'License URI: ' + config.licenseURI + '\n' +
					'Tags: ' + config.tags;

const gplNote =	'This program is free software: you can redistribute it and/or modify\n' +
				'it under the terms of the GNU General Public License as published by\n' +
				'the Free Software Foundation, either version 2 of the License, or\n' +
				'(at your option) any later version.\n\n' +
				'This program is distributed in the hope that it will be useful,\n' +
				'but WITHOUT ANY WARRANTY; without even the implied warranty of\n' +
				'MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the\n' +
				'GNU General Public License for more details.';


/* ---- REQUIRED DEPENDENCIES ---- */

const gulp = require( 'gulp' );

const autoprefixer = require( 'gulp-autoprefixer' );
const babel        = require( 'gulp-babel' );
const csscomb      = require( 'gulp-csscomb' );
const eslint       = require( 'gulp-eslint' );
const imagemin     = require( 'gulp-imagemin' );
const jscs         = require( 'gulp-jscs' );
const rename       = require( 'gulp-rename' );
const replace      = require( 'gulp-replace' );
const rtlcss       = require( 'gulp-rtlcss' );
const run          = require( 'gulp-run' );
const sass         = require( 'gulp-sass' );
const sort         = require( 'gulp-sort' );
const stylelint    = require( 'gulp-stylelint' );
const uglify       = require( 'gulp-uglify' );
const wpPot        = require( 'gulp-wp-pot' );

const browserSync     = require( 'browser-sync' ).create();
const del             = require( 'del' );
const imageminMozjpeg = require( 'imagemin-mozjpeg' );
const PluginError     = require( 'plugin-error' );
const webpack         = require( 'webpack-stream' );

/* ---- MAIN TASKS ---- */

// default task
gulp.task( 'default', [ 'sass', 'js', 'img', 'pot' ]);

// browser sync task
gulp.task( 'browser-sync', done => {
	if ( ! process.env.PROXY ) {
		done( new PluginError( 'browser-sync', 'PROXY environment variable not specified' ) );
		return;
	}

	browserSync.init({
		proxy: process.env.PROXY,
	});
	done();
});

// watch task (calling 'js' initially somehow kills the process)
gulp.task( 'watch', [ 'browser-sync', 'sass', 'img' ], () => {
	gulp.watch( 'assets/src/sass/**/*.scss', [ 'compile-sass' ] );
	gulp.watch( 'assets/src/js/**/*.js', [ 'compile-js' ] );
	gulp.watch([
		'assets/src/images/**/*.gif',
		'assets/src/images/**/*.jpg',
		'assets/src/images/**/*.png',
		'assets/src/images/**/*.svg',
	], [ 'img' ] );

	gulp.watch([
		'*.php',
		'inc/**/*.php',
		'template-parts/**/*.php',
		'templates/**/*.php',
		'*.css',
		'assets/dist/js/**/*.js',
		'assets/dist/images/**/*.gif',
		'assets/dist/images/**/*.jpg',
		'assets/dist/images/**/*.png',
		'assets/dist/images/**/*.svg',
	]).on( 'change', browserSync.reload );
});

// build the theme
gulp.task( 'build', [ 'readme' ], () => {
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
gulp.task( 'lint-sass', done => {
	gulp.src( './assets/src/sass/**/*.scss' )
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
gulp.task( 'compile-sass', done => {
	gulp.src( 'assets/src/sass/*.scss' )
		.pipe( replace( /^\/\*! --- Theme header will be inserted here automatically\. --- \*\//, '/*!\n' + themeheader + '\n\n' + config.themeName + ' WordPress Theme, Copyright (C) ' + (new Date()).getFullYear() + ' ' + config.author + '\n\n' + gplNote + '\n*/' ) )
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
			suffix: '-rtl',
		}) )
		.pipe( gulp.dest( './' ) )
		.on( 'end', done );
});

// lint JavaScript
gulp.task( 'lint-js', done => {
	gulp.src( './assets/src/js/**/*.js' )
		.pipe( eslint() )
		.pipe( eslint.format() )
		.pipe( eslint.failAfterError() )
		.pipe( jscs() )
		.pipe( jscs.reporter() )
		.on( 'end', done );
});

// compile JavaScript
gulp.task( 'compile-js', done => {
	const files = {
		theme: './assets/src/js/theme.js',
		'customize-controls': './assets/src/js/customize-controls.js',
		'customize-preview': './assets/src/js/customize-preview.js',
		'custom-header.customize-controls': './assets/src/js/custom-header.customize-controls.js',
		'custom-header.customize-preview': './assets/src/js/custom-header.customize-preview.js',
		'wp-i18n': './assets/src/js/wp-i18n.js',
	};
	gulp.src( './assets/src/js/theme.js' )
		.pipe( webpack({
			entry: files,
			output: {
				filename: '[name].js',
			},
		}) )
		.pipe( babel({
			presets: [
				'env',
			],
			plugins: [
				[
					'@wordpress/babel-plugin-makepot',
					{
						'output': './languages/' + config.textDomain + '.js.pot',
					},
				],
			],
		}) )
		.pipe( gulp.dest( './assets/dist/js/' ) )
		.pipe( uglify() )
		.pipe( rename({
			extname: '.min.js',
		}) )
		.pipe( gulp.dest( './assets/dist/js/' ) )
		.on( 'end', () => {
			gulp.src( './languages/' + config.textDomain + '.js.pot' )
				.pipe( run( 'npx pot-to-php ./languages/' + config.textDomain + '.js.pot ./inc/js-i18n.php ' + config.textDomain ) )
				.pipe( gulp.dest( './languages/' ) )
				.on( 'end', () => {
					del([
						'./languages/' + config.textDomain + '.js.pot',
					]);
					done();
				});
		});
});

// minify images
gulp.task( 'img', done => {
	gulp.src([
			'./assets/src/images/**/*.gif',
			'./assets/src/images/**/*.jpg',
			'./assets/src/images/**/*.png',
			'./assets/src/images/**/*.svg',
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
			}),
		]) )
		.pipe( gulp.dest( './assets/dist/images/' ) )
		.on( 'end', done );
});

// generate POT file
gulp.task( 'pot', done => {
	gulp.src([
		'./*.php',
		'./inc/**/*.php',
		'./template-parts/**/*.php',
		'./templates/**/*.php',
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
				'x-textdomain-support': 'yes',
			},
		}) )
		.pipe( gulp.dest( './languages/' + config.textDomain + '.pot' ) )
		.on( 'end', done );
});

// replace the theme header in readme.txt
gulp.task( 'readme', done => {
	gulp.src( './readme.txt' )
		.pipe( replace( /=== (.+) ===([\s\S]+)== Description ==/m, '=== ' + config.themeName + ' ===\n\n' + readmeheader + '\n\n== Description ==' ) )
		.pipe( gulp.dest( './' ) )
		.on( 'end', done );
});

/* ---- INITIAL SETUP TASK: Change the replacements, run the command once and then delete it from here ---- */

gulp.task( 'init-replace', done => {
	const replacements = {
		'super-awesome-theme'             : 'my-new-theme-name',
		'SUPER_AWESOME_THEME'             : 'MY_NEW_THEME_NAME',
		'super_awesome_theme'             : 'my_new_theme_name',
		'Super_Awesome_Theme'             : 'My_New_Theme_Name',
		'Super Awesome Theme'             : 'My New Theme Name',
		'SuperAwesomeTheme'               : 'MyNewThemeName',
		'superAwesomeTheme'               : 'myNewThemeName',
		'Super Awesome Author'            : 'My Author',
		'info@super-awesome-author.org'   : 'info@my-author.org',
		'https://super-awesome-author.org': 'https://my-author.org',
	};

	const files = [
		'./*.php',
		'./inc/**/*.php',
		'./template-parts/**/*.php',
		'./templates/**/*.php',
		'./tests/**/*.php',
		'./assets/dist/js/**/*.js',
		'./assets/src/js/**/*.js',
		'./assets/src/sass/style.scss',
		'./style.css',
		'./style-rtl.css',
		'./gulpfile.js',
		'./composer.json',
		'./package.json',
		'./phpcs.xml',
		'./readme.txt',
		'./README.md',
	];

	let task = gulp.src( files, { base: './' });

	Object.keys( replacements ).forEach( key => {
		task = task.pipe( replace( key, replacements[ key ] ) );
	});

	task.pipe( gulp.dest( './' ) )
		.on( 'end', done );
});
