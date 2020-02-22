const paths = {
	plugin: {
		sass: {
			watch: ["src/assets/scss/**/*.scss"],
			generate: "src/assets/scss/*.scss",
		},
		files: ["src/assets/css/*.css", "src/assets/js/*.js", "src/**/*.php"],
		build: [
			"src/**",
			"!src/**/.*",
			"!src/**/phpcs.xml",
			"!src/**/package*.json",
			"!src/**/example-functions.php",
			"!src/**/*.scss",
			"!src/assets/js/src/**",
			"!src/**/*.md",
		],
	},
};

export default paths;
