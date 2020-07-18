const { resolve } = require("path");
const webpack = require("webpack");
const argv = require("yargs").argv;

const BundleAnalyzer = require("webpack-bundle-analyzer").BundleAnalyzerPlugin;
const MiniCssExtract = require("mini-css-extract-plugin");
const ErrorNotification = require("webpack-error-notification");
const DuplicatePackageChecker = require("duplicate-package-checker-webpack-plugin");

const loaders = {
	css: {
		loader: "css-loader",
		options: {
			sourceMap: true,
		},
	},
	postCSS: {
		loader: "postcss-loader",
		options: require("./postcss.config"),
	},
	file: {
		loader: "file-loader",
		options: {
			name: "[name].[ext]",
			outputPath: "assets/fonts/",
		},
	},
};

const config = {
	mode: "development",
	entry: {
		settings_page: ["./src/assets/js/settings_page/index.js", "./src/assets/css/settings_page.css"],
		frontend: ["./src/assets/js/frontend/index.js"],
	},
	output: {
		path: resolve("./src/build"),
		filename: "[name].js",
	},
	module: {
		rules: [
			{
				enforce: "pre",
				test: /\.js|.jsx/,
				loader: "import-glob",
				exclude: /node_modules/,
			},
			{
				test: /\.js|.jsx/,
				loader: "babel-loader",
				exclude: /node_modules/,
			},
			{
				test: /\.html$/,
				loader: "raw-loader",
				exclude: /node_modules/,
			},
			{
				test: /\.css$/,
				use: [MiniCssExtract.loader, loaders.css, loaders.postCSS],
				exclude: /node_modules/,
			},
			{
				test: /\.(ttf|eot|svg|woff2?)(\?v=[0-9]\.[0-9]\.[0-9])?$/,
				use: [loaders.file],
				exclude: /assets/,
			},
		],
	},
	externals: {
		"@wordpress/api-fetch": "wp.apiFetch",
		"@wordpress/element": "wp.element",
		"@wordpress/i18n": "wp.i18n",
		"@wordpress/components": "wp.components",
		"@wordpress/compose": "wp.compose",
		react: "React",
		"react-dom": "ReactDOM",
		jquery: "jQuery",
	},
	stats: {
		colors: true,
	},
	plugins: [
		new webpack.ProvidePlugin({
			$: "jquery",
			jQuery: "jquery",
			apiFetch: "@wordpress/api-fetch",
			Component: ["@wordpress/element", "Component"],
			__: ["@wordpress/i18n", "__"],
			sprintf: ["@wordpress/i18n", "sprintf"],
		}),
		new MiniCssExtract({
			filename: "../build/[name].css",
		}),
		new ErrorNotification(),
		new DuplicatePackageChecker(),
	],
	devtool: "cheap-module-source-map",
};

if (argv.mode === "production") {
	delete config.devtool;
}

if (argv.analytic) {
	config.plugins.push(new BundleAnalyzer());
	delete config.devtool;
}

module.exports = config;
