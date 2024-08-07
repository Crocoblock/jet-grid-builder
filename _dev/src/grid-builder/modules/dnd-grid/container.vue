<template>
	<div class="jgb_grid-container"
		 :style="style">
		<div class="backing-grid"
			 v-if="backingGrid"
			 :style="backingStyle"></div>
		<slot></slot>
		<box class="placeholder"
			 boxId="::placeholder::"></box>
	</div>
</template>

<script>
import Box from './box';
import * as utils from './utils';
export const List = new Set();
export default {
	name: 'DndGridContainer',
	components: {
		Box
	},
	props: {
		layout: {
			type: Array,
			required: true
		},
		cellSize: {
			type: Object,
			default() {
				return {
					w: 100,
					h: 100
				};
			}
		},
		maxColumnCount: {
			type: Number,
			default: Infinity
		},
		maxRowCount: {
			type: Number,
			default: Infinity
		},
		margin: {
			type: Number,
			default: 5
		},
		outerMargin: {
			type: Number,
			default: 0
		},
		bubbleUp: {
			type: Boolean,
			default: false
		},
		autoAddLayoutForNewBox: {
			type: Boolean,
			required: false,
			default: true
		},
		defaultSize: {
			type: Object,
			required: false,
			default() {
				return {
					w: 1,
					h: 1
				};
			}
		},
		backingGrid: {
			type: Boolean,
			default: true
		},
		fixLayoutOnLoad: {
			type: Boolean,
			required: false,
			default: true
		},
		isRTL: {
			type: Boolean,
			required: false,
			default: false
		}
	},
	watch: {
		layout(newLayout) {
			if (this.fixLayoutOnLoad) {
				if (utils.layoutHasCollisions(newLayout)) {
					this.updateLayout(utils.fixLayout(newLayout, this.bubbleUp));
				}
			}
		}
	},
	data() {
		return {
			placeholder: {
				hidden: true,
				position: {
					x: 0,
					y: 0,
					w: 1,
					h: 1
				}
			},
			dragging: {
				boxLayout: null,
				offset: {
					x: 0,
					y: 0
				}
			},
			resizing: {
				boxLayout: null,
				offset: {
					x: 0,
					y: 0
				}
			},
			isMounted: false
		};
	},
	computed: {
		style() {
			let layoutSize = utils.getLayoutSize(this.layout);
			return {
				minHeight: (
					(layoutSize.h * this.cellSize.h) +
					((layoutSize.h - 1) * this.margin) +
					(2 * this.outerMargin)
				) + 'px',
				//backgroundImage: this.backingGrid ? `url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='${this.cellSize.w + this.margin}' height='${this.cellSize.h + this.margin}'><defs><filter id='inner-glow'><feFlood flood-color='rgb(113,215,247)'/><feComposite in2='SourceAlpha' operator='out'/><feGaussianBlur stdDeviation='1' result='blur'/><feComposite operator='atop' in2='SourceGraphic'/></filter></defs><rect x='0' y='0' width='${this.cellSize.w}' height='${this.cellSize.h}' stroke='black' stroke-width='0' fill='rgb(234,249,254)' filter='url(%23inner-glow)' /></svg>")` : 'none'
			};
		},
		backingStyle() {
			return {
				right: -(this.margin / 2) + 'px',
				bottom: -(this.margin / 2) + 'px',
				top: -(this.margin / 2) + 'px',
				left: -(this.margin / 2) + 'px',
				backgroundImage: this.backingGrid ? `url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='${this.cellSize.w + this.margin}' height='${this.cellSize.h + this.margin}'%3E%3Crect width='${this.cellSize.w}' height='${this.cellSize.h}' x='${this.margin / 2}' y='${this.margin / 2}' style='fill: rgb(234,249,254); outline-color: rgb(207,239,252); outline-style: solid; outline-width: 1px; outline-offset: -1px;' /%3E%3C/svg%3E")` : 'none'
			};
		},
		pinnedLayout() {
			return this.layout.filter((boxLayout) => {
				return boxLayout.pinned;
			});
		},
		layoutMap() {
			let map = new Map();
			this.layout.forEach(boxLayout => {
				map.set(boxLayout.id, boxLayout);
			});
			return map;
		}
	},
	methods: {
		getBoxLayoutById(id) {
			if (id === '::placeholder::') {
				return this.placeholder;
			}
			return this.layoutMap.get(id);
		},
		getPixelPositionById(id) {
			if (this.dragging.boxLayout && this.dragging.boxLayout.id === id) {
				let pixels = utils.positionToPixels(this.dragging.boxLayout.position, this.cellSize, this.margin, this.outerMargin);
				// RTL fix
				pixels.x = this.invertForRTL(pixels.x) + this.dragging.offset.x;
				pixels.y += this.dragging.offset.y;
				return pixels;
			}
			if (this.resizing.boxLayout && this.resizing.boxLayout.id === id) {
				let pixels = utils.positionToPixels(this.resizing.boxLayout.position, this.cellSize, this.margin, this.outerMargin);
				// RTL fix
				pixels.x = this.invertForRTL(pixels.x);
				pixels.w = pixels.w + this.invertForRTL(this.resizing.offset.x);
				pixels.h += this.resizing.offset.y;
				return pixels;
			}
			var boxLayout = this.getBoxLayoutById(id);
			let pixels = utils.positionToPixels(boxLayout.position, this.cellSize, this.margin, this.outerMargin);
			pixels.x = this.invertForRTL(pixels.x);
			return pixels;
		},
		isBoxVisible(id) {
			var boxLayout = this.getBoxLayoutById(id);
			return boxLayout && !boxLayout.hidden;
		},
		getPositionByPixel(x, y) {
			return {
				x: this.invertForRTL(Math.round(x / (this.cellSize.w + this.margin))),
				y: Math.round(y / (this.cellSize.h + this.margin))
			};
		},
		updateLayout(layout) {
			this.$emit('update:layout', layout);
		},
		registerBox(box) {
			this.enableResizing(box);
			this.enableDragging(box);
			if (this.isMounted && this.autoAddLayoutForNewBox) {
				this.createBoxLayout(box.$props.boxId);
			}
		},
		unregisterBox(box) {
		},

		invertForRTL(value) {
			return this.isRTL ? (value * -1) : value;
		},

		enableDragging(box) {
			var initialLayout;
			var isDragging = false;
			let validateTargetPosition = (targetX, targetY) => {
				if (targetX + this.dragging.boxLayout.position.w > this.maxColumnCount) {
					targetX = this.maxColumnCount - this.dragging.boxLayout.position.w;
				} else {
					if (targetX < 0) {
						targetX = 0;
					}
				}
				if (targetY + this.dragging.boxLayout.position.h > this.maxRowCount) {
					targetY = this.maxRowCount - this.dragging.boxLayout.position.h;
				} else {
					if (targetY < 0) {
						targetY = 0;
					}
				}
				return {
					targetX,
					targetY
				};
			};
			box.$on('dragStart', evt => {
				var boxLayout = this.getBoxLayoutById(box.boxId);
				if (boxLayout.pinned) {
					return;
				}
				isDragging = true;
				// find box
				this.dragging.boxLayout = boxLayout;
				this.placeholder = {
					...this.dragging.boxLayout
				};
				// clone layout
				initialLayout = utils.sortLayout(this.layout);
				this.$emit('drag:start', initialLayout);
			});
			box.$on('dragUpdate', evt => {
				if (!isDragging) {
					return;
				}
				this.dragging.offset.x = evt.offset.x;
				this.dragging.offset.y = evt.offset.y;
				var moveBy = this.getPositionByPixel(evt.offset.x, evt.offset.y);
				if (!utils.isFree(this.pinnedLayout, {
					...this.dragging.boxLayout.position,
					x: this.dragging.boxLayout.position.x + moveBy.x,
					y: this.dragging.boxLayout.position.y + moveBy.y
				})) {
					return;
				}
				let { targetX, targetY } = validateTargetPosition(
					this.dragging.boxLayout.position.x + moveBy.x,
					this.dragging.boxLayout.position.y + moveBy.y
				);
				// check if box has moved
				if (this.placeholder.position.x === targetX && this.placeholder.position.y === targetY) {
					return;
				}
				this.placeholder = utils.updateBoxPosition(this.placeholder, {
					x: targetX,
					y: targetY
				});
				var newLayout = [this.placeholder];
				initialLayout.forEach((boxLayout) => {
					if (boxLayout.id === this.dragging.boxLayout.id) {
						return;
					}
					newLayout.push(utils.moveBoxToFreePlace(newLayout, boxLayout, this.bubbleUp));
				});
				if (this.bubbleUp) {
					newLayout = utils.layoutBubbleUp(newLayout);
					this.placeholder = newLayout.find((boxLayout) => {
						return boxLayout.id === this.dragging.boxLayout.id;
					});
				}
				this.updateLayout(newLayout);
				this.$emit('drag:update', newLayout);
			});
			box.$on('dragEnd', evt => {
				if (!isDragging) {
					return;
				}
				var moveBy = this.getPositionByPixel(evt.offset.x, evt.offset.y);
				if (utils.isFree(this.pinnedLayout, {
					...this.dragging.boxLayout.position,
					x: this.dragging.boxLayout.position.x + moveBy.x,
					y: this.dragging.boxLayout.position.y + moveBy.y
				})) {
					let { targetX, targetY } = validateTargetPosition(
						this.dragging.boxLayout.position.x + moveBy.x,
						this.dragging.boxLayout.position.y + moveBy.y
					);
					this.placeholder = utils.updateBoxPosition(this.placeholder, {
						x: targetX,
						y: targetY
					});
				}
				this.dragging.boxLayout = utils.updateBoxPosition(this.dragging.boxLayout, {
					x: this.placeholder.position.x,
					y: this.placeholder.position.y
				});
				var newLayout = [this.dragging.boxLayout];
				initialLayout.forEach((boxPosition) => {
					if (boxPosition.id === this.dragging.boxLayout.id) {
						return;
					}
					newLayout.push(utils.moveBoxToFreePlace(newLayout, boxPosition, this.bubbleUp));
				});
				if (this.bubbleUp) {
					newLayout = utils.layoutBubbleUp(newLayout);
				}
				this.updateLayout(newLayout);
				this.dragging.boxLayout = null;
				this.dragging.offset.x = 0;
				this.dragging.offset.y = 0;
				this.placeholder.hidden = true;
				isDragging = false;
				this.$emit('drag:end', newLayout);
			});
		},
		enableResizing(box) {
			var initialLayout;
			var isResizing = false;
			let validateTargetSize = (targetW, targetH) => {
				if (this.resizing.boxLayout.position.x + targetW > this.maxColumnCount) {
					targetW = this.maxColumnCount - this.resizing.boxLayout.position.x;
				} else {
					if (targetW < 1) {
						targetW = 1;
					}
				}
				if (this.resizing.boxLayout.position.y + targetH > this.maxRowCount) {
					targetH = this.maxRowCount - this.resizing.boxLayout.position.y;
				} else {
					if (targetH < 1) {
						targetH = 1;
					}
				}
				return {
					targetW,
					targetH
				};
			};
			box.$on('resizeStart', evt => {
				var boxLayout = this.getBoxLayoutById(box.boxId);
				if (boxLayout.pinned) {
					return;
				}
				isResizing = true;
				// find box
				this.resizing.boxLayout = boxLayout;
				this.placeholder = {
					...this.resizing.boxLayout
				};
				// clone layout
				initialLayout = utils.sortLayout(this.layout);
				this.$emit('resize:start', initialLayout);
			});
			box.$on('resizeUpdate', evt => {
				if (!isResizing) {
					return;
				}
				this.resizing.offset.x = evt.offset.x;
				this.resizing.offset.y = evt.offset.y;
				var resizeBy = this.getPositionByPixel(evt.offset.x, evt.offset.y);
				if (!utils.isFree(this.pinnedLayout, {
					...this.resizing.boxLayout.position,
					w: this.resizing.boxLayout.position.w + resizeBy.x,
					h: this.resizing.boxLayout.position.h + resizeBy.y
				})) {
					return;
				}
				let { targetW, targetH } = validateTargetSize(
					this.resizing.boxLayout.position.w + resizeBy.x,
					this.resizing.boxLayout.position.h + resizeBy.y
				);
				// check if box size has changed
				if (this.placeholder.position.w === targetW && this.placeholder.position.h === targetH) {
					return;
				}
				this.placeholder = utils.updateBoxPosition(this.placeholder, {
					w: targetW,
					h: targetH
				});
				var newLayout = [this.placeholder];
				initialLayout.forEach((boxLayout) => {
					if (boxLayout.id === this.resizing.boxLayout.id) {
						return;
					}
					newLayout.push(utils.moveBoxToFreePlace(newLayout, boxLayout, this.bubbleUp));
				});
				if (this.bubbleUp) {
					newLayout = utils.layoutBubbleUp(newLayout);
					this.placeholder = newLayout.find((boxLayout) => {
						return boxLayout.id === this.resizing.boxLayout.id;
					});
				}
				this.updateLayout(newLayout);
				this.$emit('resize:update', newLayout);
			});
			box.$on('resizeEnd', evt => {
				if (!isResizing) {
					return;
				}
				var resizeBy = this.getPositionByPixel(evt.offset.x, evt.offset.y);
				if (utils.isFree(this.pinnedLayout, {
					...this.resizing.boxLayout.position,
					w: this.resizing.boxLayout.position.w + resizeBy.x,
					h: this.resizing.boxLayout.position.h + resizeBy.y
				})) {
					let { targetW, targetH } = validateTargetSize(
						this.resizing.boxLayout.position.w + resizeBy.x,
						this.resizing.boxLayout.position.h + resizeBy.y
					);
					this.placeholder = utils.updateBoxPosition(this.placeholder, {
						w: targetW,
						h: targetH
					});
				}
				this.resizing.boxLayout = utils.updateBoxPosition(this.resizing.boxLayout, {
					w: this.placeholder.position.w,
					h: this.placeholder.position.h
				});
				var newLayout = [this.resizing.boxLayout];
				initialLayout.forEach((boxPosition) => {
					if (boxPosition.id === this.resizing.boxLayout.id) {
						return;
					}
					newLayout.push(utils.moveBoxToFreePlace(newLayout, boxPosition, this.bubbleUp));
				});
				if (this.bubbleUp) {
					newLayout = utils.layoutBubbleUp(newLayout);
				}
				this.updateLayout(newLayout);
				this.resizing.boxLayout = null;
				this.resizing.offset.x = 0;
				this.resizing.offset.y = 0;
				this.placeholder.hidden = true;
				this.$emit('resize:end', newLayout);
			});
		},
		createBoxLayout(...boxIds) {
			boxIds = boxIds.filter(boxId => !this.getBoxLayoutById(boxId));
			if (boxIds.length) {
				let newLayout = [
					...this.layout
				];
				boxIds.forEach(boxId => {
					newLayout.push(utils.moveBoxToFreePlace(newLayout, {
						id: boxId,
						hidden: false,
						position: {
							x: 0,
							y: 0,
							...this.defaultSize
						}
					}, this.bubbleUp));
				});
				this.updateLayout(newLayout);
			}
		}
	},
	created() {
		List.add(this);
	},
	mounted() {
		this.isMounted = true;
		let boxIds = this.$children.map(box => box.$props.boxId);
		this.createBoxLayout(...boxIds);
	},
	beforeDestroy() {
		List.delete(this);
	}
};
</script>