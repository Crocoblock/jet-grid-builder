<template>
	<div class="psm-post-item"
		 :class="{ 'psm-selected': is_selected, 'psm-disabled': is_disabled, 'psm-no-thumbnail': !thumbnail }"
		 @click="itemClick()">
		<div class="psm-post-item-icon"></div>
		<div class="psm-post-item-wrapper">
			<div class="psm-post-item-thumb"
				 v-if="thumbnail">
				<img class="psm-image"
					 :src="thumbnail.file">
			</div>
			<div class="psm-post-item-bottom-grad"
				 v-if="thumbnail"></div>
			<div class="psm-post-item-content">
				<div class="psm-post-item-title">{{ title }}</div>
			</div>
		</div>
	</div>
</template>

<script>
import { getIntermediateImageSizesUrl } from '@/includes/utility.js';

export default {
	props: {
		data: {
			type: Object,
			required: true
		},
		titleKey: {
			type: String,
			default: 'title'
		}
	},

	computed: {
		is_disabled() {
			return this.$parent.$parent.disabled.some(id => id === this.data.id);
		},
		is_selected() {
			return this.$parent.$parent.selectedItems.some(item => item.id === this.data.id);
		}
	},

	data() {
		return {
			thumbnail: getIntermediateImageSizesUrl(this.data.thumbnail_data, 'medium'),
			title: this.data[this.titleKey],
		};
	},

	methods: {
		itemClick() {
			if (this.is_disabled)
				return;

			if (this.$parent.$parent.singleSelection) {
				this.$parent.$parent.clearSelected();
			}
			if (!this.is_selected) {
				this.$parent.$parent.addToSelected(this.data);
			} else {
				this.$parent.$parent.removeFromSelected(this.data);
			}
		}
	}
};
</script>