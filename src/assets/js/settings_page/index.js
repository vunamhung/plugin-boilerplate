import { BaseControl, Button, ExternalLink, PanelBody, PanelRow, Placeholder, Spinner, ToggleControl } from "@wordpress/components";
import { render } from "@wordpress/element";

import "../../scss/settings_page.scss";

class App extends Component {
	state = {
		isAPILoaded: false,
		isAPISaving: false,
		analytics_key: "",
		analytics_status: false,
	};

	componentDidMount() {
		apiFetch({ path: plugin.apiPath }).then((res) => {
			this.setState({
				analytics_key: res.analytics_key,
				analytics_status: res.analytics_status,
				isAPILoaded: true,
			});
		});
	}

	saveSettings() {
		this.setState({ isAPISaving: true });
		const data = {
			analytics_key: this.state.analytics_key,
			analytics_status: this.state.analytics_status,
		};
		apiFetch({ path: plugin.apiPath, method: "POST", parse: false, data }).then((res) => {
			this.setState({ isAPISaving: false });
		});
	}

	render() {
		if (!this.state.isAPILoaded) {
			return (
				<Placeholder>
					<Spinner />
				</Placeholder>
			);
		}

		return (
			<>
				<div className="header">
					<div className="container">
						<div className="logo">
							<h1>
								{plugin.name} - v{plugin.version}
							</h1>
						</div>
					</div>
				</div>

				<div className="main">
					<PanelBody title={__("Settings", "vnh_textdomain")}>
						<PanelRow>
							<BaseControl
								label={__("Google Analytics Key", "vnh_textdomain")}
								help={"In order to use Google Analytics, you need to use an API key."}
								id="options-google-analytics-api"
								className="text-field"
							>
								<input
									type="text"
									id="options-google-analytics-api"
									value={this.state.analytics_key}
									placeholder={__("Google Analytics API Key", "vnh_textdomain")}
									disabled={this.state.isAPISaving}
									onChange={(e) => this.setState({ analytics_key: e.target.value })}
								/>
							</BaseControl>
						</PanelRow>
						<PanelRow>
							<ToggleControl
								label={__("Track Admin Users?", "vnh_textdomain")}
								help={"Would you like to track views of logged-in admin accounts?."}
								checked={this.state.analytics_status}
								onChange={() => this.setState({ analytics_status: !this.state.analytics_status })}
							/>
						</PanelRow>
					</PanelBody>
					<Button isPrimary isLarge disabled={this.state.isAPISaving} onClick={() => this.saveSettings()}>
						{__("Save Settings", "vnh_textdomain")}
					</Button>
				</div>
			</>
		);
	}
}

render(<App />, document.getElementById("plugin"));
