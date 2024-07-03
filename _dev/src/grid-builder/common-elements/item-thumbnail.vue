<template>
	<component :is="thumbnailComponent"
			   :style="thumbnailStyle" />
</template>

<script>
export default {
	props: {
		link: {
			type: Boolean,
			default: false
		}
	},

	computed: {
		thumbnailComponent() {
			return this.link ? 'link-thumbnail' : 'default-thumbnail';
		},
		thumbnailStyle() {
			let styles = {
				backgroundImage: 'url(' + this.thumbnailData.file + ')'
			};

			if (['masonry', 'justified'].includes(this.layout))
				styles.paddingBottom = Math.round((this.thumbnailData.height / this.thumbnailData.width) * 100 * 10) / 10 + '%';

			return styles;
		},
	},

	data() {
		return {
			defaultThumbnailComponent: null,
			linkThumbnailComponent: null,
			layout: this.$parent.layout,
			thumbnailData: this.$parent.itemData.thumbnail_data,
		};
	},

	created() {
		this.defaultThumbnailComponent = Vue.component('default-thumbnail', {
			template: '<div class="jgb_item-thumb"></div>'
		});

		this.linkThumbnailComponent = Vue.component('link-thumbnail', {
			template: '<a href="#" class="jgb_item-thumb"></a>'
		});
	}
};
</script>