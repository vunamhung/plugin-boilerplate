import { useState } from "@wordpress/element";
import { Button } from "@wordpress/components";
import General from "./General";
import useSettings from "../hooks/useSettings";
import useSaveSettings from "../hooks/useSaveSettings";

export default function App() {
	const [{ settings }, setSettings] = useSettings();
	const [saving, setSaving] = useState(false);
	const loading = useSaveSettings(settings, saving, setSaving);

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
