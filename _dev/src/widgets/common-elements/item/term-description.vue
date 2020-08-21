<template>
	<div class="jgb_item-description"
	     v-if="wordsCount > 0 && description"
	     v-html="$options.filters.limitation(description, wordsCount)">
	</div>
</template>

<script>
	import filters from 'modules/filters/limitation.js'

	export default {
		filters: filters,

		computed: {
			wordsCount() {
				return this.$parent.getResponsiveSetting('item_description_words_count');
			},
			description() {
				return this.$parent.itemData.term_description;
			}
		}
	};
</script>