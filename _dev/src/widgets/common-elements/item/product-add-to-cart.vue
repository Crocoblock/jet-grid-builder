<template>
	<div class="jgb_product-add-to-cart">
		<a class="add_to_cart_button ajax_add_to_cart"
		   data-quantity="1"
		   :data-product_id="productId"
		   :href="addToCartUrl">
			<span class="add_to_cart_button_text">{{addToCartText}}</span>
		</a>
	</div>
</template>

<script>
	export default {
		computed: {
			addToCartText() {
				return this.$parent.getSetting('woocommerce_item_add_to_cart_text');
			}
		},

		data() {
			return {
				productId: this.$parent.itemData.id,
				addToCartUrl: this.$parent.itemData.woocommerce_add_to_cart_url,
			}
		}
	};
</script>