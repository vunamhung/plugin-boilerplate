import { useState } from "@wordpress/element";
import { is } from "ramda";

const objCheck = (thing) => {
	if (!is(Object, thing)) {
		throw "`useObjectState` only accepts objects.";
	}

	return thing;
};

export default function useObjectState(initialState = {}) {
	const [state, setState] = useState(() => objCheck(initialState));

	const mergeState = (objOrFxn) => {
		setState((prevState) => {
			const newState = objCheck(objOrFxn instanceof Function ? objOrFxn(prevState) : objOrFxn);
			return { ...prevState, ...newState };
		});
	};

	return [state, mergeState];
}
