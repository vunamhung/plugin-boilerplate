module.exports = {
	purge: {
		content: ["./src/**/*.js", "./src/**/*.css"],
		options: {
			whitelist: ["bg-red-500", "px-4"],
		},
	},
	theme: {},
	variants: {},
	plugins: [require("@vunamhung/tailwind-config"), require("@tailwindcss/custom-forms")],
};
