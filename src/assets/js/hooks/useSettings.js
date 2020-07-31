import { useState } from "@wordpress/element";
import apiFetch from "@wordpress/api-fetch";
import useOnMount from "./useOnMount";

export default function useSettings() {
	const [settings, setSettings] = useState([]);
	const [loading, setLoading] = useState(true);

	useOnMount(() => {
		setLoading(true);
		apiFetch({ path: pluginApiPath })
			.then((settings) => {
				setSettings(settings);
			})
			.finally(() => {
				setLoading(false);
				console.warn("Settings loaded");
			});
	});

	return [{ loading, settings }, setSettings];
}
