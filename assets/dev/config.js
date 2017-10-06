const path = require( 'path' );
const { argv } = require( 'yargs' );

const isProduction = !! ( ( argv.env && argv.env.production ) || argv.p );
const rootPath = process.cwd();

const config = {
	entry: {
		main: [
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
	publicPath: `/app/themes/sage/${path.join( rootPath, 'assets/dist' )}/`,
	manifest: {},
	open: true,
	//copy: 'images/**/*',
	copy: [
		'./js/html5.js',
	],
	proxyUrl: 'http://localhost:3000',
	paths: {
		root: rootPath,
		dev: path.join( rootPath, 'assets/dev' ),
		dist: path.join( rootPath, 'assets/dist' ),
	},
	enabled: {
		sourceMaps: ! isProduction,
		optimize: isProduction,
		watcher: !! argv.watch,
	},
	watch: [],
};

module.exports = config;

if (process.env.NODE_ENV === undefined) {
	process.env.NODE_ENV = isProduction ? 'production' : 'development';
}

/**
 * If your publicPath differs between environments, but you know it at compile time,
 * then set SAGE_DIST_PATH as an environment variable before compiling.
 * Example:
 *   SAGE_DIST_PATH=/wp-content/themes/sage/dist yarn build:production
 */
if (process.env.SAGE_DIST_PATH) {
	module.exports.publicPath = process.env.SAGE_DIST_PATH;
}

/**
 * If you don't know your publicPath at compile time, then uncomment the lines
 * below and use WordPress's wp_localize_script() to set SAGE_DIST_PATH global.
 * Example:
 *   wp_localize_script('sage/main.js', 'SAGE_DIST_PATH', get_theme_file_uri('dist/'))
 */
// Object.keys(module.exports.entry).forEach(id =>
//   module.exports.entry[id].unshift(path.join(__dirname, 'helpers/public-path.js')));
