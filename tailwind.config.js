module.exports = {
	purge: ["./src/assets/js/settings_page/**/*.js", "./src/assets/js/frontend/**/*.js"],
	theme: {
		extend: {
			screens: {
				xxl: "1440px",
			},
			spacing: {
				"72": "18rem",
				"84": "21rem",
				"96": "24rem",
			},
		},
	},
	variants: {},
	plugins: [],
};
