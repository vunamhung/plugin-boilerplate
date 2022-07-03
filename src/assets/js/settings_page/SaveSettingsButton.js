import apiFetch from "@wordpress/api-fetch";
import { Button } from "@wordpress/components";
import { useSnapshot } from "valtio";
import { toast } from "react-hot-toast";
import { store } from "./utilities";

export default function SaveSettingsButton() {
	const { settings } = useSnapshot(store);

	const onClick = () => apiFetch({ path: pluginApiPath, method: "POST", parse: false, data: settings }).then(() => toast.success("Setting saved"));

	return (
		<Button isPrimary isLarge onClick={onClick}>
			{__("Save Settings", "vnh_textdomain")}
		</Button>
	);
}
