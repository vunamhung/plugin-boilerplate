import { useEffect, useState } from "@wordpress/element";
import apiFetch from "@wordpress/api-fetch";
import useObjectState from "./useObjectState";

export default function useSettings() {
	const [settings, setSettings] = useObjectState();
	const [loading, setLoading] = useState(true);

	useEffect(() => {
		setLoading(true);
		apiFetch({ path: pluginApiPath }).then((settings) => {
			setLoading(false);
			setSettings(settings);
		});
	}, []);

	return [{ loading, settings }, setSettings];
}
