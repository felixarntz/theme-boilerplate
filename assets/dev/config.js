const path = require( 'path' );
const { argv } = require( 'yargs' );

const isProduction = !! ( ( argv.env && argv.env.production ) || argv.p );
const rootPath = process.cwd();

function getLastPathSegment( path ) {
	let parts = path.replace( /^[\/]+|[\/]+$/g, '' ).split( '/' );

	return parts.pop();
}

var pkg = require( '../../package.json' );

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

const config = {
	themeData: {
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
		testedUpTo: '4.9',
		translateURI: 'https://translate.wordpress.org/projects/wp-themes/super-awesome-theme',
	},
	entry: {
		theme: [
			'./js/theme.js',
			'./sass/style.scss',
		],
		'customize-controls': [
			'./js/customize-controls.js',
		],
		'customize-preview': [
			'./js/customize-preview.js',
		],
	},
	env: {
		production: isProduction,
		development: ! isProduction,
	},
	imagesDir: false, // alternative: './images'
	copyScripts: [
		'./js/html5.js',
	],
	publicPath: '/wp-content/themes/' + getLastPathSegment( rootPath ),
	proxyUrl: 'http://localhost:3000',
	paths: {
		root: rootPath,
		dev: path.join( rootPath, 'assets/dev' ),
		dist: path.join( rootPath, 'assets/dist' ),
	},
	open: true,
	enabled: {
		sourceMaps: ! isProduction,
		watcher: !! argv.watch,
	},
	watch: [],
};

module.exports = config;

if (process.env.NODE_ENV === undefined) {
	process.env.NODE_ENV = isProduction ? 'production' : 'development';
}
