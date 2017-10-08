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
				enforce: 'pre',
				test: /style\.scss$/,
				include: config.paths.dev,
				loader: StringReplacePlugin.replace({
					replacements: [
						{
							pattern: /^\/\*! \-\-\- Theme header will be inserted here automatically\. \-\-\- \*\//,
							replacement: function () {
								let header =	'Theme Name: ' + config.themeData.themeName + '\n' +
												'Theme URI: ' + config.themeData.themeURI + '\n' +
												'Author: ' + config.themeData.author + '\n' +
												'Author URI: ' + config.themeData.authorURI + '\n' +
												'Description: ' + config.themeData.description + '\n' +
												'Version: ' + config.themeData.version + '\n' +
												'License: ' + config.themeData.license + '\n' +
												'License URI: ' + config.themeData.licenseURI + '\n' +
												'Text Domain: ' + config.themeData.textDomain + '\n' +
												( config.themeData.domainPath ? 'Domain Path: ' + config.themeData.domainPath + '\n' : '' ) +
												'Tags: ' + config.themeData.tags;

								let gplNote =	'This program is free software: you can redistribute it and/or modify\n' +
												'it under the terms of the GNU General Public License as published by\n' +
												'the Free Software Foundation, either version 3 of the License, or\n' +
												'(at your option) any later version.\n\n' +
												'This program is distributed in the hope that it will be useful,\n' +
												'but WITHOUT ANY WARRANTY; without even the implied warranty of\n' +
												'MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the\n' +
												'GNU General Public License for more details.';

								return '/*!\n' + header + '\n\n' + config.themeData.themeName + ' WordPress Theme, Copyright (C) ' + (new Date()).getFullYear() + ' ' + config.themeData.author + '\n\n' + gplNote + '\n*/';
							},
						},
					],
				}),
			},
			// TODO: The following replacement does not work.
			{
				enforce: 'pre',
				test: /readme\.txt/,
				include: config.paths.root,
				loader: StringReplacePlugin.replace({
					replacements: [
						{
							pattern: /^\=\=\= (.+) \=\=\=([\s\S]+)\=\= Description \=\=/m,
							replacement: function () {
								let header =	'Contributors: ' + config.themeData.contributors + '\n' +
												'Stable tag: ' + config.themeData.version + '\n' +
												'Version: ' + config.themeData.version + '\n' +
												'Requires at least: ' + config.themeData.minRequired + '\n' +
												'Tested up to: ' + config.themeData.testedUpTo + '\n' +
												'License: ' + config.themeData.license + '\n' +
												'License URI: ' + config.themeData.licenseURI + '\n' +
												'Tags: ' + config.themeData.tags;
								return '=== ' + config.themeData.themeName + ' ===\n\n' + header + '\n\n== Description ==';
							},
						},
					],
				}),
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
			{
				test: /\.css$/,
				include: config.paths.dev,
				use: ExtractTextPlugin.extract({
					fallback: 'style',
					use: [
						{
							loader: 'cache'
						},
						{
							loader: 'css',
							options: {
								minimize: false,
								sourceMap: config.enabled.sourceMaps,
								url: false,
							},
						},
						{
							loader: 'postcss', options: {
								config: {
									path: __dirname,
									ctx: config,
								},
								sourceMap: config.enabled.sourceMaps,
							},
						},
					],
				}),
			},
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
								minimize: false,
								sourceMap: config.enabled.sourceMaps,
								url: false,
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
		new CleanPlugin([config.paths.dist], {
			root: config.paths.root,
			verbose: false,
		}),
		new CopyWebpackPlugin( copy ),
		new ExtractTextPlugin({
			filename: '../../style.css',
			allChunks: true,
			disable: config.enabled.watcher,
		}),
		new FriendlyErrorsWebpackPlugin(),
		new webpack.LoaderOptionsPlugin({
			minimize: false,
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
		new webpack.ProvidePlugin({
			$: 'jquery',
			jQuery: 'jquery',
			'window.jQuery': 'jquery',
		}),
		new StyleLintPlugin({
			failOnError: ! config.enabled.watcher,
			syntax: 'scss',
		}),
		new UglifyJSPlugin({
			uglifyOptions: {
				warnings: false,
			},
		}),
		new UnminifiedWebpackPlugin({
			exclude: /\.css$/,
		}),
		new WebpackRTLPlugin({
			filename: '../../style-rtl.css',
			minify: false,
		}),
		new StringReplacePlugin(),
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
				removeUnknownsAndDefaults: false,
				cleanupIDs: false,
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
