module.exports = {
	purge: {
		content: ["src/assets/js/**"],
		options: {
			whitelist: ["bg-red-500", "px-4"],
		},
	},
	theme: {
		extend: {
			container: {
				center: true,
				padding: "var(--spacing-4)",
			},
		},
	},
	variants: {},
	plugins: [require("@vunamhung/tailwind-config"), require("@tailwindcss/custom-forms")],
};
