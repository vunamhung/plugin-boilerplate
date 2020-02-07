const paths = {
	plugin: {
		sass: {
			watch: ["src/plugin/assets/scss/**/*.scss"],
			generate: "src/plugin/assets/scss/*.scss",
		},
		files: ["src/plugin/assets/css/*.css", "src/plugin/assets/js/*.js", "src/plugin/**/*.php"],
		build: [
			"src/plugin/**",
			"!src/plugin/**/.*",
			"!src/plugin/**/phpcs.xml",
			"!src/plugin/**/package*.json",
			"!src/plugin/**/example-functions.php",
			"!src/plugin/**/*.scss",
			"!src/plugin/assets/js/src/**",
			"!src/plugin/**/*.md",
		],
	},
};

export default paths;
