import { getNesting } from 'includes/utility.js';

export default {
	data() {
		return {
			breakpoints: {
				desktop: Infinity,
				tablet: getNesting(window, 'elementorFrontend', 'config', 'breakpoints', 'lg') || 1025,
				mobile: getNesting(window, 'elementorFrontend', 'config', 'breakpoints', 'md') || 768
			},

			currentBreakpoint: '',
			breakpointsNames: ['desktop', 'tablet', 'mobile'],

			clientWidth: 0
		}
	},

	mounted() {
		this.breakpointsNames = Object.keys(this.breakpoints).sort((a, b) => { return this.breakpoints[a] + this.breakpoints[b] });

		//add resize event
		window.addEventListener('resize', this.resizeFrame);
		this.resizeUpdate();
	},

	methods: {
		getBreakpointPostfix(breakpointName = false) {
			let breakpoint = breakpointName ? breakpointName : this.currentBreakpoint;

			return breakpoint !== 'desktop' ? '_' + breakpoint : '';
		},

		createLayoutBreakpoint(breakpointLayout) {
			this.layoutData = Object.assign({
				[this.currentBreakpoint]: breakpointLayout
			},
				this.layoutData
			);
		},

		removeLayoutBreakpoint() {
			this.layoutData = Object.keys(this.layoutData).reduce((accumulator, key) => {
				if (key !== this.currentBreakpoint) {
					return {
						...accumulator,
						[key]: this.layoutData[key]
					}
				}
				return accumulator;
			}, {});

			this.updateOption('layout_data' + this.getBreakpointPostfix(this.currentBreakpoint), '');
		},

		// responsive
		setCurrentBreakpoint() {
			if (this.$root.breakpointsDisabled) {
				this.currentBreakpoint = 'desktop';

				return;
			}

			let currentBreakpoint;

			this.breakpointsNames.forEach(breakpoint => {
				if (window.innerWidth < this.breakpoints[breakpoint])
					currentBreakpoint = breakpoint
			});
			this.currentBreakpoint = currentBreakpoint
		},

		// resize event
		resizeFrame() {
			window.requestAnimationFrame(this.resizeUpdate);
		},
		resizeUpdate() {
			this.clientWidth = this.$el.clientWidth;
			this.setCurrentBreakpoint();

			// trigger resize event
			if (typeof this.onResize === 'function') this.onResize();
		}
	}
};