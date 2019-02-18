const mix = require('laravel-mix');
const MomentLocalesPlugin = require('moment-locales-webpack-plugin');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/main.js', 'public/js')
	.sass('resources/sass/app.scss', 'public/css')
	.extract([
		'jquery',
		'vue',
		'axios',
		'popper.js',
		'bootstrap',
		'toastr',
		'moment'
	])
	.options({
		processCssUrls: false
	});

if (mix.inProduction()) {
	mix
		.webpackConfig({
			plugins: [
				// new BundleAnalyzerPlugin(),
				new MomentLocalesPlugin(),
			],
			module: {
				rules: [{
					test: /\.js?$/,
					exclude: /(node_modules)/,
					use: [{
						loader: 'babel-loader',
						options: mix.config.babel()
					}]
				}]
			}
		})
		.babel('public/js/vendor.js', 'public/js/vendor.js')
		.babel('public/js/main.js', 'public/js/main.js')
		.version();
} else {
	mix
		.sourceMaps()
		.webpackConfig({
			plugins: [
				// new BundleAnalyzerPlugin(),
				new MomentLocalesPlugin(),
			]
		})
		.browserSync({
			proxy: 'jobs-notifier.local'
		})
}