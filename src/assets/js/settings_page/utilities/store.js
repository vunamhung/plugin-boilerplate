import { proxy } from "valtio";
import { devtools } from "valtio/utils";

export const store = proxy({
	settings: {
		analyticsKey: "",
		analyticsStatus: true,
	},
});

const unsub = devtools(store, { name: "state name", enabled: true });
