import { useEffect } from "@wordpress/element";

export default function useOnMount(onMount) {
	useEffect(() => {
		onMount && onMount();
	}, []);
}
