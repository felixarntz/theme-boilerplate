'use strict'; // eslint-disable-line

const webpack = require('webpack');
const merge = require('webpack-merge');
const CleanPlugin = require('clean-webpack-plugin');
const CopyGlobsPlugin = require('copy-globs-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const FriendlyErrorsWebpackPlugin = require('friendly-errors-webpack-plugin');
const StyleLintPlugin = require('stylelint-webpack-plugin');

const config = require('./config');

let webpackConfig = {
	context: config.paths.dev,
	entry: config.entry,
	output: {
		path: config.paths.dist,
		//publicPath: config.publicPath,
		filename: 'js/[name].js',
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
			/*{
				test: /\.js$/,
				exclude: [/(node_modules|bower_components)(?![/|\\](bootstrap|foundation-sites))/],
				use: [
					{ loader: 'cache' },
					{ loader: 'buble', options: { objectAssign: 'Object.assign' } },
				],
			},*/
			/*{
				test: /\.css$/,
				include: config.paths.dev,
				use: ExtractTextPlugin.extract({
					fallback: 'style',
					use: [
						{ loader: 'cache' },
						{ loader: 'css', options: { sourceMap: config.enabled.sourceMaps } },
						{
							loader: 'postcss', options: {
								config: { path: __dirname, ctx: config },
								sourceMap: config.enabled.sourceMaps,
							},
						},
					],
				}),
			},*/
			{
				test: /\.scss$/,
				include: config.paths.dev,
				use: ExtractTextPlugin.extract({
					fallback: 'style',
					use: [
						{
							loader: 'cache',
						},
						{
							loader: 'css',
							options: {
								sourceMap: config.enabled.sourceMaps,
							},
						},
						{
							loader: 'postcss',
							options: {
								config: {
									path: __dirname,
									ctx: config,
								},
								sourceMap: config.enabled.sourceMaps,
							},
						},
						{
							loader: 'sass',
							options: {
								sourceMap: config.enabled.sourceMaps,
							},
						},
					],
				}),
			},
			/*{
				test: /\.(ttf|eot|woff2?|png|jpe?g|gif|svg|ico)$/,
				include: config.paths.dev,
				loader: 'url',
				options: {
					limit: 4096,
					name: '[path][name].[ext]',
				},
			},*/
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
		/*new CleanPlugin([config.paths.dist], {
			root: config.paths.root,
			verbose: false,
		}),*/
		/**
		 * It would be nice to switch to copy-webpack-plugin, but
		 * unfortunately it doesn't provide a reliable way of
		 * tracking the before/after file names
		 */
		/*new CopyGlobsPlugin({
			pattern: config.copy,
			output: '[path][name].[ext]',
			manifest: config.manifest,
		}),*/
		new CopyWebpackPlugin([
			{
				from: config.copy,
				to: config.paths.dist,
				toType: 'dir',
			},
		]),
		new ExtractTextPlugin({
			filename: 'sass/[name].css',
			allChunks: true,
			disable: config.enabled.watcher,
		}),
		new FriendlyErrorsWebpackPlugin(),
		new webpack.LoaderOptionsPlugin({
			minimize: config.enabled.optimize,
			debug: config.enabled.watcher,
			stats: {
				colors: true,
			},
		}),
		new webpack.LoaderOptionsPlugin({
			test: /\.s?css$/,
			options: {
				output: {
					path: config.paths.dist,
				},
				context: config.paths.dev,
			},
		}),
		new webpack.LoaderOptionsPlugin({
			test: /\.js$/,
			options: {
				eslint: {
					failOnWarning: false,
					failOnError: true,
				},
			},
		}),
		/*new webpack.ProvidePlugin({
			$: 'jquery',
			jQuery: 'jquery',
			'window.jQuery': 'jquery',
			Popper: 'popper.js/dist/umd/popper.js',
		}),*/
		new StyleLintPlugin({
			failOnError: ! config.enabled.watcher,
			syntax: 'scss',
		}),
	],
};

/* eslint-disable global-require */ /** Let's only load dependencies as needed */

if (config.enabled.optimize) {
	webpackConfig = merge(webpackConfig, require('./webpack.config.optimize'));
}

if (config.env.production) {
	webpackConfig.plugins.push(new webpack.NoEmitOnErrorsPlugin());
}

if (config.enabled.watcher) {
	webpackConfig.entry = require('./util/addHotMiddleware')(webpackConfig.entry);
	webpackConfig = merge(webpackConfig, require('./webpack.config.watch'));
}

module.exports = webpackConfig;
