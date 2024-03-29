import { useEffect } from "@wordpress/element";
import apiFetch from "@wordpress/api-fetch";
import { Toaster } from "react-hot-toast";
import { state } from "./utilities";
import General from "./General";
import SaveSettingsButton from "./SaveSettingsButton";

export default function App() {
	useEffect(() => {
		apiFetch({ path: pluginApiPath }).then((settings) => (state.settings = settings));
	}, []);

	return (
		<>
			<Toaster position="bottom-right" toastOptions={{ style: { borderRadius: "0", background: "#222", color: "#fff" } }} />
			<div className="bg-white py-6 mb-4">
				<div className="container w-9/12 lg:w-7/12">
					<div className="flex items-center">
						<h1>{pluginName}</h1>
						<div className="ml-3 text-xs rounded font-light bg-neutral-200 px-1 border-neutral-300">v{pluginVersion}</div>
					</div>
				</div>
			</div>

			<div className="container w-9/12 lg:w-7/12">
				<General />
				<SaveSettingsButton />
			</div>
		</>
	);
}
