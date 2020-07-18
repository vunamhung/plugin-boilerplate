declare class Component extends React.Component {} //wp.element.Component

declare function __(text: string, domain: "vnh_textdomain"): string; //wp.i18n.__
declare function sprintf(format: string, ...args): string; //wp.i18n.sprintf

declare var plugin: {
	name: "";
	version: "";
	apiPath: "";
};

declare var apiUrl: string;
declare var wcStoreApiNonce: string;
