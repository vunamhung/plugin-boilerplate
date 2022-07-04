import { proxy } from "valtio";
import { devtools } from "valtio/utils";

export const state = proxy({
	settings: {
		analyticsKey: "",
		analyticsStatus: true,
	},
});

const unsub = devtools(state, { name: "state name", enabled: true });
