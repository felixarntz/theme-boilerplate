'use strict'; // eslint-disable-line

const webpack = require( 'webpack' );
const merge = require( 'webpack-merge' );
const CleanPlugin = require( 'clean-webpack-plugin' );
const CopyWebpackPlugin = require( 'copy-webpack-plugin' );
const ExtractTextPlugin = require( 'extract-text-webpack-plugin' );
const FriendlyErrorsWebpackPlugin = require( 'friendly-errors-webpack-plugin' );
const StyleLintPlugin = require( 'stylelint-webpack-plugin' );
const UglifyJSPlugin = require( 'uglifyjs-webpack-plugin' );
const UnminifiedWebpackPlugin = require( 'unminified-webpack-plugin' );
const WebpackRTLPlugin = require( 'webpack-rtl-plugin' );
const StringReplacePlugin = require( 'string-replace-webpack-plugin' );
const { default: ImageminPlugin } = require( 'imagemin-webpack-plugin' );
const imageminMozjpeg = require( 'imagemin-mozjpeg' );

const config = require( './config' );

let copy = [];
for ( let file of config.copyScripts ) {
	copy.push({
		from: file,
		to: './js/[name].[ext]',
	});
}
if ( config.imagesDir ) {
	copy.push({
		from: config.imagesDir,
		to: config.imagesDir,
		toType: 'dir',
	});
}

let webpackConfig = {
	context: config.paths.dev,
	entry: config.entry,
	output: {
		path: config.paths.dist,
		publicPath: config.publicPath,
		filename: 'js/[name].min.js',
	},
	stats: {
		hash: false,
		version: false,
		timings: false,
		children: false,
		errors: false,
		errorDetails: false,
		warnings: false,
		chunks: false,
		modules: false,
		reasons: false,
		source: false,
		publicPath: false,
	},
	module: {
		rules: [
			{
				enforce: 'pre',
				test: /\.js$/,
				include: config.paths.dev,
				use: 'eslint',
			},
			{
				enforce: 'pre',
				test: /\.(js|s?[ca]ss)$/,
				include: config.paths.dev,
				loader: 'import-glob',
			},
			{
				test: /\.js$/,
				exclude: [
					/(node_modules|bower_components)(?![/|\\](bootstrap|foundation-sites))/,
				],
				use: [
					{
						loader: 'cache',
					},
					{
						loader: 'buble',
						options: {
							objectAssign: 'Object.assign',
						},
					},
				],
			},
		],
	},
	resolve: {
		modules: [
			config.paths.dev,
			'node_modules',
			'bower_components',
		],
		enforceExtension: false,
	},
	resolveLoader: {
		moduleExtensions: ['-loader'],
	},
	externals: {
		jquery: 'jQuery',
	},
	plugins: [
		new FriendlyErrorsWebpackPlugin(),
		new webpack.LoaderOptionsPlugin({
			test: /\.js$/,
			options: {
				eslint: {
					failOnWarning: false,
					failOnError: true,
				},
			},
		}),
		new webpack.ProvidePlugin({
			$: 'jquery',
			jQuery: 'jquery',
			'window.jQuery': 'jquery',
		}),
		new ImageminPlugin({
			optipng: {
				optimizationLevel: 7,
			},
			gifsicle: {
				optimizationLevel: 3,
			},
			pngquant: {
				quality: '65-90',
				speed: 4,
			},
			svgo: {
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
			},
			plugins: [
				imageminMozjpeg({
					quality: 75,
				}),
			],
			disable: config.enabled.watcher,
		}),
	],
};

// TODO: Initial replacements, POT.

/* eslint-disable global-require */ /** Let's only load dependencies as needed */

if (config.env.production) {
	webpackConfig.plugins.push(new webpack.NoEmitOnErrorsPlugin());
}

if (config.enabled.watcher) {
	webpackConfig.entry = require('./util/addHotMiddleware')(webpackConfig.entry);
	webpackConfig = merge(webpackConfig, require('./webpack.config.watch'));
}

module.exports = webpackConfig;
