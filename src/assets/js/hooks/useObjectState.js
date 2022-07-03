import { useState } from '@wordpress/element';

const objCheck = (thing) => {
  if (Object.prototype.toString.call(thing) !== '[object Object]') {
    throw new Error('`useObjectState` only accepts objects.');
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
