<?php
/**
 * Woocommerce item default template
 */
?>

<script type="text/x-template" class="jgb_woocommerce-item-template">
	<div class="jgb_woocommerce-item jgb_item jgb_item-default"
		:class="{'jgb_no-thumbnail':!thumbnailEnabled}"
	>
		<item-thumbnail v-if="thumbnailEnabled" :link="true" />
		<div class="jgb_item-type-wrap" v-if="[postTypeEnabled, thumbnailEnabled].every(isTrue)">
			<div class="jgb_item-type">{{itemData.post_type}}</div>
		</div>
		<div class="jgb_item-body">
			<div class="jgb_item-type-wrap" v-if="[postTypeEnabled, !thumbnailEnabled].every(isTrue)">
				<div class="jgb_item-type">{{itemData.post_type}}</div>
			</div>
			<productStarsRating v-if="productStarsRatingEnabled" />
			<productCategories v-if="productCategoriesEnabled" />
			<div class="jgb_item-title" v-if="titleEnabled">
				<a :href="itemData.permalink">{{itemData.post_title}}</a>
			</div>
			<item-description v-if="descriptionEnabled"/>
			<productPrice v-if="productPriceEnabled" />
			<productAddToCart v-if="productAddToCartEnabled" />
		</div>
	</div>
</script>