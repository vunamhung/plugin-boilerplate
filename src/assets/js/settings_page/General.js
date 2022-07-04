import { PanelBody, TextControl, ToggleControl } from "@wordpress/components";
import { useSnapshot } from "valtio";
import { state } from "./utilities";

export default function General() {
	const { settings } = useSnapshot(state);
	const { analyticsKey, analyticsStatus } = settings;

	return (
		<PanelBody title={__("Settings", "vnh_textdomain")} className="bg-white mb-4">
			<TextControl
				label={__("Google Analytics Key", "vnh_textdomain")}
				help={__("In order to use Google Analytics, you need to use an API key.", "vnh_textdomain")}
				placeholder={__("Google Analytics API Key", "vnh_textdomain")}
				value={analyticsKey}
				onChange={(value) => (state.settings.analyticsKey = value)}
			/>
			<ToggleControl
				label={__("Track Admin Users?", "vnh_textdomain")}
				help={__("Would you like to track views of logged-in admin accounts?", "vnh_textdomain")}
				checked={analyticsStatus}
				onChange={() => (state.settings.analyticsStatus = !analyticsStatus)}
			/>
		</PanelBody>
	);
}
