import { useEffect, useState } from "@wordpress/element";
import { Button } from "@wordpress/components";
import { isEmpty } from "ramda";
import apiFetch from "@wordpress/api-fetch";
import { useSettings } from "./helpers";
import General from "./general";

export default function App() {
	const [{ settings }, setSettings] = useSettings();
	const [saving, setSaving] = useState(false);
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

	return (
		<>
			<div className="bg-white py-6 mb-4">
				<div className="container w-9/12 lg:w-7/12">
					<div className="flex items-center">
						<h1>{pluginName}</h1>
						<div className="ml-3 text-xs rounded font-light bg-neutral-200 px-1 border-neutral-300">v{pluginVersion}</div>
					</div>
				</div>
			</div>

			<div className="container w-9/12 lg:w-7/12">
				<General settings={settings} setSettings={setSettings} />
				<Button isPrimary isLarge disabled={loading} onClick={() => setSaving(true)}>
					{__("Save Settings", "vnh_textdomain")}
				</Button>
			</div>
		</>
	);
}
