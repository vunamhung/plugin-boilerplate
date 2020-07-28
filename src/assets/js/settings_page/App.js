import { useEffect, useState } from "@wordpress/element";
import { BaseControl, Button, PanelBody, PanelRow, ToggleControl } from "@wordpress/components";
import isEmpty from "lodash/isEmpty";
import { saveSettings, useSettings } from "./helpers";

export default function App() {
	const [loading, settings, setSettings] = useSettings();
	const { analytics_key, analytics_status } = settings;
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
				<PanelBody title={__("Settings", "vnh_textdomain")} className="bg-white mb-4">
					<PanelRow>
						<BaseControl
							label={__("Google Analytics Key", "vnh_textdomain")}
							help={__("In order to use Google Analytics, you need to use an API key.", "vnh_textdomain")}
							id="options-google-analytics-api"
						>
							<input
								type="text"
								id="options-google-analytics-api"
								value={analytics_key}
								onChange={(e) => setSettings({ ...settings, ...{ analytics_key: e.target.value } })}
								disabled={loading}
								placeholder={__("Google Analytics API Key", "vnh_textdomain")}
							/>
						</BaseControl>
					</PanelRow>
					<PanelRow>
						<ToggleControl
							label={__("Track Admin Users?", "vnh_textdomain")}
							help={__("Would you like to track views of logged-in admin accounts?.", "vnh_textdomain")}
							checked={analytics_status}
							onChange={() => setSettings({ ...settings, ...{ analytics_status: !analytics_status } })}
						/>
					</PanelRow>
				</PanelBody>
				<Button isPrimary isLarge disabled={loading} onClick={() => setSaving(true)}>
					{__("Save Settings", "vnh_textdomain")}
				</Button>
			</div>
		</>
	);
}
