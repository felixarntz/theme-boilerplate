const path = require( 'path' );
const { argv } = require( 'yargs' );

const isProduction = !! ( ( argv.env && argv.env.production ) || argv.p );
const rootPath = process.cwd();

function getLastPathSegment( path ) {
	let parts = path.replace( /^[\/]+|[\/]+$/g, '' ).split( '/' );

	return parts.pop();
}

const config = {
	entry: {
		theme: [
			'./js/theme.js',
			'./sass/style.scss',
		],
		customizer: [
			'./js/customizer.js',
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
