export function useUpdateSettings(settings, setSettings) {
	return (data) => setSettings({ ...settings, ...data });
}
