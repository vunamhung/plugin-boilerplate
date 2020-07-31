import { useState } from "@wordpress/element";
import apiFetch from "@wordpress/api-fetch";
import useOnMount from "./useOnMount";
import useObjectState from "./useObjectState";

export default function useSettings() {
	const [settings, setSettings] = useObjectState();
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
