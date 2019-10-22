const paths = {
	plugin: {
		sass: {
			watch: ["src/plugin/assets/scss/**/*.scss"],
			generate: "src/plugin/assets/scss/*.scss",
		},
		files: ["src/plugin/assets/css/*.css", "src/plugin/assets/js/*.js", "src/plugin/**/*.php"],
		build: [
			"src/plugin/**",
			"!src/plugin/**/*.scss",
			"!src/plugin/assets/js/src/**",
			"!src/plugin/assets/libs/fontawesome-pro/webfonts/*.svg",
			"!src/plugin/assets/libs/fontawesome-pro/webfonts/fa-regular-400*",
			"!src/plugin/assets/js/font/**/*.js",
			"!src/plugin/src/composer.json",
			"!src/plugin/src/composer.lock",
			"!src/plugin/vendor/cmb2/cmb2/languages/*",
			"!src/plugin/vendor/cmb2/cmb2/CHANGELOG.md",
			"!src/plugin/vendor/cmb2/cmb2/CONTRIBUTING.md",
			"!src/plugin/vendor/cmb2/cmb2/example-functions.php",
			"!src/plugin/vendor/cmb2/cmb2/package-lock.json",
			"!**/apigen/**",
			"!**/apigen.neon",
		],
	},
};

export default paths;
