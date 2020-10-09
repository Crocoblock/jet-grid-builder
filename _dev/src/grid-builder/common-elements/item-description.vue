<template>
	<div class="jgb_item-description"
	     v-if="wordsCount > 0 && description"
	     v-html="$options.filters.limitation(description, wordsCount)">
	</div>
</template>

<script>
	import filters from 'grid-builder/modules/filters/limitation.js'

	export default {
		filters: filters,

		computed: {
			wordsCount() {
				return this.$parent.getResponsiveSetting('item_description_words_count');
			},
			description() {
				let description = '',
					descriptionType = this.$parent.getSetting('item_description');

				switch (descriptionType) {
					case 'auto':
						description = this.$parent.itemData.post_excerpt ? this.$parent.itemData.post_excerpt : this.$parent.itemData.post_content;
						break;

					case 'content':
						description = this.$parent.itemData.post_content;
						break;

					case 'excerpt':
						description = this.$parent.itemData.post_excerpt;
						break;
				}

				return description;
			}
		}
	};
</script>