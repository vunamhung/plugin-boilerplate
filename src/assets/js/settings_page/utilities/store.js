import { proxy } from "valtio";
import { devtools } from "valtio/utils";

export const store = proxy({
	settings: {},
});

export const actions = {
	setSettings: (payload) => (store.settings = payload),
};

const unsub = devtools(store, { name: "state name", enabled: true });
