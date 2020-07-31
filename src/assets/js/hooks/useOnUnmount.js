import { useEffect } from "@wordpress/element";

export default function useOnUnmount(onUnmount) {
	useEffect(() => {
		return () => onUnmount && onUnmount();
	}, []);
}
