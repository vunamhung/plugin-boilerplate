declare class Component extends React.Component {} //wp.element.Component

declare function __(text: string, domain: "vnh_textdomain"): string; //wp.i18n.__
declare function sprintf(format: string, ...args): string; //wp.i18n.sprintf
declare function apiFetch(path: object, ...args): object; //wp.apiFetch

declare function _merge(object: object, ...source): object; //_.merge
declare function _map(collection: Array<any> | object, iteratee: Function): any; //_.map
declare function _times(n: number, iteratee: Function): any; //_.times
declare function _each(collection: Array<any> | object, iteratee: Function): any; //_.each
declare function _isNumber(value: any): boolean; //_.isNumber

declare var plugin: {
	name: "";
	version: "";
	apiPath: "";
};
