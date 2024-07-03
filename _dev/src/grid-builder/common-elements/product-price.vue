<template>
	<div class="jgb_product-price"
		 v-if="priceHTML"
		 v-html="priceHTML">
	</div>
</template>

<script>
export default {
	data() {
		return {
			priceHTML: this.$parent.itemData.woocommerce_price,
		};
	}
};
</script>