import { BaseControl, PanelBody, PanelRow, ToggleControl } from "@wordpress/components";

export default function General({ settings, setSettings }) {
	const { analytics_key, analytics_status } = settings;

	const updateSettings = (data) => setSettings({ ...settings, ...data });

	return (
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
						onChange={(e) => updateSettings({ analytics_key: e.target.value })}
						placeholder={__("Google Analytics API Key", "vnh_textdomain")}
					/>
				</BaseControl>
			</PanelRow>
			<PanelRow>
				<ToggleControl
					label={__("Track Admin Users?", "vnh_textdomain")}
					help={__("Would you like to track views of logged-in admin accounts?.", "vnh_textdomain")}
					checked={analytics_status}
					onChange={() => updateSettings({ analytics_status: !analytics_status })}
				/>
			</PanelRow>
		</PanelBody>
	);
}
