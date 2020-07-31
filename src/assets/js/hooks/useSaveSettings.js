import { useEffect, useState } from "@wordpress/element";
import apiFetch from "@wordpress/api-fetch";
import { isEmpty } from "ramda";

export default function useSaveSettings(settings, saving, setSaving) {
	const [loading, setLoading] = useState(false);

	useEffect(() => {
		// early exit
		if (isEmpty(settings) || saving === false) return;

		setLoading(true);
		apiFetch({ path: pluginApiPath, method: "POST", parse: false, data: settings }).finally(() => {
			setSaving(false);
			setLoading(false);
			console.warn("Settings saved");
		});
	}, [saving]);

	return loading;
}
