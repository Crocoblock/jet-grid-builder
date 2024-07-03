<template>
	<div class="jgb_product-categories"
		 v-if="categoriesData">
		<a class="jgb_product-category"
		   v-for="category in categoriesData"
		   :key="category.term_id"
		   :href="category.permalink">
			{{ category.name }}
		</a>
	</div>
</template>

<script>
export default {
	data() {
		return {
			categoriesData: this.$parent.itemData.woocommerce_product_cat,
		};
	}
};
</script>