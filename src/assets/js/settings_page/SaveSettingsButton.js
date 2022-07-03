import apiFetch from "@wordpress/api-fetch";
import { Button } from "@wordpress/components";
import { useSnapshot } from "valtio";
import { store } from "../utilities";

export default function SaveSettingsButton() {
	const { settings } = useSnapshot(store);

	return (
		<Button isPrimary isLarge onClick={() => apiFetch({ path: pluginApiPath, method: "POST", parse: false, data: settings })}>
			{__("Save Settings", "vnh_textdomain")}
		</Button>
	);
}
