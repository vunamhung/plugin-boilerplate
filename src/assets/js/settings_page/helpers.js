import { useEffect, useState } from "@wordpress/element";
import apiFetch from "@wordpress/api-fetch";

export function useSettings() {
	const [settings, setSettings] = useState([]);
	const [loading, setLoading] = useState(true);

	useEffect(() => {
		setLoading(true);
		apiFetch({ path: pluginApiPath }).then((settings) => {
			setSettings(settings);
			setLoading(false);
			console.log("Settings loaded");
		});
	}, []);

	return { loading, settings, setSettings };
}

export function saveSettings(data) {
	apiFetch({ path: pluginApiPath, method: "POST", parse: false, data }).then(() => {
		console.log("Settings saved");
	});
}
