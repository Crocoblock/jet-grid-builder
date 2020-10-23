export default {
	data() {
		return {
			isRTL: document.body.classList.contains('rtl'),
			layoutData: {
				desktop: []
			}
		}
	},

	computed: {
		// layout computed properties
		layout() {
			return this.layoutData[this.availableBreakpoint] || [];
		},

		layoutMap() {
			const map = new Map()
			this.layout.forEach(boxLayout => {
				map.set(boxLayout.id, boxLayout)
			})
			return map
		},

		availableBreakpoint() {
			let availableBreakpoint = this.breakpointsNames.slice(-1)[0],
				currentBreakpointIndex = this.breakpointsNames.indexOf(this.currentBreakpoint);

			this.breakpointsNames.slice(0, currentBreakpointIndex + 1).forEach(breakpointName => {
				if (this.layoutData[breakpointName]) {
					availableBreakpoint = breakpointName;
					return;
				}
			});

			return availableBreakpoint;
		},

		layoutBreakpointEnabled() {
			return this.layoutData[this.currentBreakpoint] ? true : false;
		},

		// settings computed properties
		colNum() {
			return this.getSettingValue('colNum');
		},

		gutter() {
			return this.getResponsiveSettingValue('gutter');
		},

		cellSize() {
			let wSize = (this.clientWidth - this.gutter * (this.colNum - 1)) / this.colNum;

			return {
				w: wSize,
				h: wSize
			}
		}
	},

	mounted() {
		this.initLayout();
	},

	methods: {
		initLayout() {
			let layoutData = {
				desktop: []
			};

			this.eachResponsiveSetting('layout_data', (value, breakpoint) => {
				let breakpointLayout = JSON.parse(value);

				layoutData[breakpoint] = breakpointLayout;
			});

			this.layoutData = layoutData;
		},

		getRequestArgs(args = {}) {
			const requestArgs = { ...args },
				date_format = this.getSettingValue('item_post_date_format'),
				thumbnail_size = this.getSettingValue('item_thumbnail_size'),
				items_type = this.getSettingValue('items_type'),
				woo_items_type = this.getSettingValue('woo_items_type'),
				jetengine_listing_id = this.getSettingValue('jetengine_listing_id'),
				jet_woo_builder_archive_id = this.getSettingValue('jet_woo_builder_archive_id');

			if (date_format) requestArgs.date_format = date_format;
			if (thumbnail_size) requestArgs.thumbnail_size = thumbnail_size;
			if (items_type) requestArgs.items_type = items_type;
			if (woo_items_type) requestArgs.woo_items_type = woo_items_type;
			if (jetengine_listing_id) requestArgs.jetengine_listing_id = jetengine_listing_id;
			if (jet_woo_builder_archive_id) requestArgs.jet_woo_builder_archive_id = jet_woo_builder_archive_id;

			return requestArgs;
		},

		applyСustomMethods() {
			if (this.getSettingValue('items_type') === 'jetengine_listing') {
				if (!window.JetEngine)
					return;

				window.JetEngine.widgetDynamicField(jQuery(this.$el));
			}
		}
	}
};