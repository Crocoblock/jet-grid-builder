export default {
	methods: {
		getSettingValue(setting, property = false) {
			let settingValue = this.$root.settings[setting];

			if (property && typeof settingValue === 'object') {
				settingValue = settingValue[property];
			}

			return settingValue;
		},

		getResponsiveSettingValue(setting, property = false) {
			let settingValue = false,
				currentBreakpointIndex = this.breakpointsNames.indexOf(this.currentBreakpoint);

			if (~currentBreakpointIndex) {
				this.breakpointsNames.slice(0, currentBreakpointIndex + 1).forEach(breakpointName => {
					let tempSettingValue = this.getSettingValue(setting + this.getBreakpointPostfix(breakpointName), property);

					if (tempSettingValue || tempSettingValue === 0) {
						settingValue = tempSettingValue;
						return;
					}
				});
			}

			return settingValue
		},

		eachResponsiveSetting(setting, callback) {
			this.breakpointsNames.forEach(breakpointName => {
				let breakpointSetting = this.getSettingValue(setting + this.getBreakpointPostfix(breakpointName));

				if (breakpointSetting) {
					callback(breakpointSetting, breakpointName);
				}
			});
		},

		showSpinnerUntilMediaLoads() {
			return this.getSettingValue('items_type') === 'default'
				&& this.getSettingValue('loading_spinner') === 'true'
				&& this.getSettingValue('loading_spinner_media') === 'true'
				? true
				: false;
		}
	}
};