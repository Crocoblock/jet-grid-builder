// utils
import * as localStorage from 'includes/local-storage.js';
import { preloadMedia, getIntermediateImageSizesUrl, stringToBoolean } from 'includes/utility.js';

// components
import { dndGridContainer, dndGridBox, dndGridUtils } from 'grid-builder/modules/dnd-grid';
import item from 'grid-builder/common-elements/item.vue';
import checkbox from 'grid-builder/components/controls/checkbox/checkbox.vue';

// mixins
import breakpointsMixin from 'grid-builder/mixins/breakpoints.js';
import settingsMixin from 'grid-builder/mixins/settings.js';

// main mixin
import gridBuilderLayout from 'grid-builder/mixins/layout.js';

export default {
	mixins: [breakpointsMixin, settingsMixin, gridBuilderLayout],

	components: {
		dndGridContainer,
		dndGridBox,
		item,
		checkbox
	},

	data() {
		return {
			elementId: this.$root.elementId,
			items: [],
			mainEl: null,
			loaded: false,
			backingGrid: false
		}
	},

	computed: {
		noContent() {
			return !this.layout.length || !this.items.length ? true : false;
		},

		itemsIDs() {
			return this.items.map(item => {
				return item.id
			});
		},

		verticalCompact() {
			return stringToBoolean(this.getSettingValue('vertical_compact'));
		},
	},

	watch: {
		'verticalCompact': function (newVal) {
			if (newVal) {
				this.layoutUpdated(dndGridUtils.layoutBubbleUp(this.layout));
			}
		},
		'colNum': function () {
			this.checkOutOfBounds();
		}
	},

	mounted() {
		this.backingGrid = stringToBoolean(localStorage.getLocalStorageItem(this.elementId + '_backingGrid', true));
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

			this.$nextTick(this.applyСustomMethods);
		},

		/*------------------------------
		 # Element Model Methods
		-------------------------------*/
		setLayoutData() {
			for (let layoutKey in this.layoutData) {
				this.updateOption('layout_data' + this.getBreakpointPostfix(layoutKey), JSON.stringify(this.layoutData[layoutKey]));
			};
		},

		setItems(action, newItem, prevItem = false) {
			let oldItemIDs = this.getSettingValue(this.itemsKey),
				newItemIDs;

			switch (action) {
				case 'add':
					newItemIDs = (oldItemIDs ? oldItemIDs + ',' : '') + newItem.map(item => item.id).join();
					break;

				case 'change':
					newItemIDs = oldItemIDs.replace(prevItem, newItem.id);
					break;

				case 'remove':
					newItemIDs = oldItemIDs.replace(new RegExp('\\b' + newItem + ',?|,?' + newItem + '$'), '');
					break;
			}

			if (newItemIDs || newItemIDs === '') {
				this.updateOption(this.itemsKey, newItemIDs);
			}
		},

		/*------------------------------
		 # Events Methods
		-------------------------------*/
		mouseDownEvent(e) {
			e.stopPropagation();
		},

		changeBackingGrid(checked) {
			this.backingGrid = checked;
			localStorage.setLocalStorageItem(this.elementId + '_backingGrid', checked);
		},

		layoutUpdated(newLayout) {
			if (!this.layoutBreakpointEnabled) {
				this.createLayoutBreakpoint(newLayout);
			} else {
				this.layoutData[this.availableBreakpoint] = newLayout;
			}

			this.setLayoutData();
		},

		addNewItems(newItems) {
			// add to layoutData
			for (let breakpoint in this.layoutData) {
				let newBreakpointLayout = [...this.layoutData[breakpoint]],
					layoutHeight = newBreakpointLayout.reduce((height, boxLayout) => {
						return boxLayout.hidden
							? height
							: Math.max(height, boxLayout.position.y + boxLayout.position.h)
					}, 0),
					column = 0,
					itemY = layoutHeight,
					itemWidth = this.colNum,
					itemHeight = Math.ceil(itemWidth * 1.3);

				switch (breakpoint) {
					case 'desktop':
						itemWidth = Math.floor(this.colNum / 3);
						itemHeight = Math.ceil(itemWidth * 1.5);
						break;

					case 'tablet':
						itemWidth = Math.floor(this.colNum / 2);
						itemHeight = Math.ceil(itemWidth * 1.25);
						break;
				}

				newItems.forEach(item => {
					this.setThumbnailUrlByImageSize(item);
					newBreakpointLayout.push(
						{
							id: item.id,
							hidden: false,
							pinned: false,
							position: {
								x: itemWidth * column,
								y: itemY,
								w: itemWidth,
								h: itemHeight
							}
						}
					)

					switch (breakpoint) {
						case 'desktop':
							column = column >= 2 ? 0 : column + 1;
							break;

						case 'tablet':
							column = column >= 1 ? 0 : column + 1;
							break;
					}

					if (column === 0)
						itemY = itemY + itemHeight;

				})

				this.layoutData[breakpoint] = newBreakpointLayout
			}

			// add to items
			this.items = this.items.concat(newItems);

			this.setItems('add', newItems);
			this.setLayoutData();

			// update items content if custom type
			this.updateItems(newItems);
		},

		removeItem(removeItemID) {
			let removedItemIndex;

			// remove from layoutData
			for (let layoutKey in this.layoutData) {

				removedItemIndex = this.layoutData[layoutKey].findIndex(item => {
					return item.id === removeItemID;
				});

				if (removedItemIndex > -1) {
					this.layoutData[layoutKey].splice(removedItemIndex, 1);
				}
			}

			// remove from items
			removedItemIndex = this.items.findIndex(item => {
				return item.id === removeItemID;
			});
			if (removedItemIndex > -1) {
				this.items.splice(removedItemIndex, 1);
			}

			this.setItems('remove', removeItemID);
			this.setLayoutData();
			
			if (this.verticalCompact) {
				this.layoutUpdated(dndGridUtils.layoutBubbleUp(this.layout));
			}
		},

		changeItem(editableItemId, newItem) {
			let editableItemIndex;

			this.setThumbnailUrlByImageSize(newItem);

			// change in layoutData
			for (let layoutKey in this.layoutData) {
				editableItemIndex = this.layoutData[layoutKey].findIndex(item => {
					return item.id === editableItemId;
				});

				if (editableItemIndex > -1) {
					this.layoutData[layoutKey][editableItemIndex].id = newItem.id;
				}
			}

			// change in items
			this.items = this.items.map(item => {
				return item.id === editableItemId ? newItem : item;
			});

			this.setItems('change', newItem, editableItemId);
			this.setLayoutData();

			// update item content if custom type
			this.updateItems([newItem]);
		},

		updateItems(items) {
			items.forEach(item => {
				if (item.is_woocommerce) {
					if (this.getSettingValue('woo_items_type') !== 'default') {
						this.updateItem(item);
					}
				} else {
					if (this.getSettingValue('items_type') !== 'default') {
						this.updateItem(item);
					}
				}
			});
		},

		/*------------------------------
		 # Auxiliary Methods
		-------------------------------*/
		updateOption(key, value) {
			if (typeof this.$root.updateOption !== 'function')
				return;

			this.$root.updateOption(key, value);
		},

		setThumbnailUrlByImageSize(item) {
			if (typeof item.thumbnail_data === 'object' && !item.thumbnail_data.file) {
				item.thumbnail_data = getIntermediateImageSizesUrl(item.thumbnail_data, this.getSettingValue('item_thumbnail_size'));
			}
		},

		checkOutOfBounds() {
			for (let breakpoint in this.layoutData) {
				let newBreakpointLayout = [...this.layoutData[breakpoint]],
					needUpdate = false;

				newBreakpointLayout.forEach(item => {
					if (item.position.w > this.colNum) {
						item.position.w = this.colNum;
					}
					if (item.position.w + item.position.x > this.colNum) {
						item.position.x = 0;
						item.position.y++;

						needUpdate = true;
					}
				});

				if (needUpdate) {
					this.layoutData[breakpoint] = newBreakpointLayout;
				}
			}
		}
	}
}