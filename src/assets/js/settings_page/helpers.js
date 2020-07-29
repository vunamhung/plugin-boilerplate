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
			console.warn("Settings loaded");
		});
	}, []);

	return { loading, setLoading, settings, setSettings };
}

export async function saveSettings(data, setLoading) {
	await apiFetch({ path: pluginApiPath, method: "POST", parse: false, data });
	setLoading(false);
	console.warn("Settings saved");
}
