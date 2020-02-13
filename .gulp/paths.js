const paths = {
	plugin: {
		sass: {
			watch: ["plugin/assets/scss/**/*.scss"],
			generate: "plugin/assets/scss/*.scss",
		},
		files: ["plugin/assets/css/*.css", "plugin/assets/js/*.js", "plugin/**/*.php"],
		build: [
			"plugin/**",
			"!plugin/**/.*",
			"!plugin/**/phpcs.xml",
			"!plugin/**/package*.json",
			"!plugin/**/example-functions.php",
			"!plugin/**/*.scss",
			"!plugin/assets/js/src/**",
			"!plugin/**/*.md",
		],
	},
};

export default paths;
