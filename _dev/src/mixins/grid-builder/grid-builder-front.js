// utils
import { getLayoutSize, positionToPixels } from 'modules/dnd-grid/utils';
import { preloadMedia } from 'includes/utility.js';

// components
import item from "widgets/common-elements/item/item.vue";

// mixins
import breakpointsMixin from 'mixins/breakpoints.js';
import settingsMixin from 'mixins/settings.js';

// main mixin
import gridBuilderLayout from 'mixins/grid-builder/layout.js';

const box = {};

export default {
	mixins: [breakpointsMixin, settingsMixin, gridBuilderLayout],

	components: {
		item,
		box
	},

	data() {
		return {
			loaded: false,
			items: []
		}
	},

	computed: {
		containerStyle() {
			var layoutSize = getLayoutSize(this.layout);

			return {
				minHeight: (
					(layoutSize.h * this.cellSize.h) +
					((layoutSize.h - 1) * this.gutter)
				) + 'px'
			}
		}
	},

	mounted() {
		this.loadContent();
	},

	methods: {
		contentLoaded(items) {
			if (this.showSpinnerUntilMediaLoads()) {
				preloadMedia(items, (items) => {
					this.initItems(items);
				});
			} else {
				this.initItems(items);
			}
		},

		initItems(items) {
			this.items = items;

			this.loaded = true;
			// remove preloader
			const preloaderEl = this.$el.parentElement.querySelector('.jgb_spinner');

			if (preloaderEl) {
				preloaderEl.remove();
			}
		},

		getPixelPositionById(id) {
			const boxLayout = this.layoutMap.get(id);

			return positionToPixels(boxLayout.position, this.cellSize, this.gutter);
		}
	}
}

//box component
box.template = `<div :style="style"><slot></slot></div>`;
box.props = {
	boxId: {
		required: true
	}
};
box.computed = {
	style() {
		const pixelPosition = this.$parent.getPixelPositionById(this.boxId);

		return {
			width: pixelPosition.w + 'px',
			height: pixelPosition.h + 'px',
			transform: `translate(${pixelPosition.x}px, ${pixelPosition.y}px)`
		}
	}
}