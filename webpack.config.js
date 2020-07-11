const { resolve } = require("path");
const webpack = require("webpack");
const argv = require("yargs").argv;

const BundleAnalyzer = require("webpack-bundle-analyzer").BundleAnalyzerPlugin;
const MiniCssExtract = require("mini-css-extract-plugin");
const ErrorNotification = require("webpack-error-notification");
const DuplicatePackageChecker = require("duplicate-package-checker-webpack-plugin");

const webpackModules = {
	rules: [
		{
			test: /\.js$/,
			use: ["babel-loader"],
			exclude: /node_modules/,
		},
		{
			test: /\.css$/,
			use: [MiniCssExtract.loader, "css-loader"],
		},
		{
			test: /\.scss$/,
			use: [MiniCssExtract.loader, "css-loader", "sass-loader"],
		},
		{
			test: /\.(png|gif|jpg|jpeg|woff|woff2|eot|ttf|svg)$/,
			use: ["url-loader"],
		},
	],
};

const pluginConfig = {
	mode: "development",
	entry: {
		settings_page: "./src/assets/js/settings_page/index.js",
		frontend: "./src/assets/js/frontend/index.js",
	},
	output: {
		path: resolve("./src/assets/js/dist"),
		filename: "[name].js",
	},
	module: webpackModules,
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
			filename: "../../css/[name].css",
		}),
		new ErrorNotification(),
		new DuplicatePackageChecker(),
	],
	devtool: "cheap-module-source-map",
};

if (argv.mode === "production") {
	delete pluginConfig.devtool;
}

if (argv.analytic) {
	pluginConfig.plugins.push(new BundleAnalyzer());
	delete pluginConfig.devtool;
}

module.exports = pluginConfig;
