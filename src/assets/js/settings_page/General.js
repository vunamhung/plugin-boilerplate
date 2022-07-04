import { PanelBody, PanelRow, TextControl, ToggleControl } from "@wordpress/components";
import { useSnapshot } from "valtio";
import { actions, store } from "./utilities";

export default function General() {
	const { settings } = useSnapshot(store);
	const { analytics_key, analytics_status } = settings;

	return (
		<PanelBody title={__("Settings", "vnh_textdomain")} className="bg-white mb-4">
			<PanelRow>
				<TextControl
					label={__("Google Analytics Key", "vnh_textdomain")}
					help={__("In order to use Google Analytics, you need to use an API key.", "vnh_textdomain")}
					value={analytics_key}
					onChange={(value) => actions.setSettings({ ...settings, analytics_key: value })}
					placeholder={__("Google Analytics API Key", "vnh_textdomain")}
				/>
			</PanelRow>
			<PanelRow>
				<ToggleControl
					label={__("Track Admin Users?", "vnh_textdomain")}
					help={__("Would you like to track views of logged-in admin accounts?.", "vnh_textdomain")}
					checked={analytics_status}
					onChange={() => actions.setSettings({ ...settings, analytics_status: !analytics_status })}
				/>
			</PanelRow>
		</PanelBody>
	);
}
