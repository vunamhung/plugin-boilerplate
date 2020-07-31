import { useEffect, useState } from "@wordpress/element";
import apiFetch from "@wordpress/api-fetch";

export function useOutsideClick(ref, callback) {
	const handleClick = (e) => {
		if (ref.current && !ref.current.contains(e.target)) {
			callback();
		}
	};

	useEffect(() => {
		document.addEventListener("click", handleClick);

		return () => {
			document.removeEventListener("click", handleClick);
		};
	});
}

export function useSettings() {
	const [settings, setSettings] = useState([]);
	const [loading, setLoading] = useState(true);

	useEffect(() => {
		setLoading(true);
		apiFetch({ path: pluginApiPath })
			.then((settings) => {
				setSettings(settings);
			})
			.finally(() => {
				setLoading(false);
				console.warn("Settings loaded");
			});
	}, []);

	return [{ loading, settings }, setSettings];
}

export function useUpdateSettings(settings, setSettings) {
	return (data) => setSettings({ ...settings, ...data });
}
