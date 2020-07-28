import { useEffect, useState } from "@wordpress/element";
import { Button } from "@wordpress/components";
import isEmpty from "lodash/isEmpty";
import { saveSettings, useSettings } from "./helpers";
import General from "./General";

export default function App() {
	const { loading, settings, setSettings } = useSettings();
	const [saving, setSaving] = useState(false);

	useEffect(() => {
		!isEmpty(settings) && saveSettings(settings);
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
