<?php
/**
 * HTML item template
 */
?>

<script type="text/x-template" class="jgb_woocommerce-item-template">
	<div class="jgb_item jgb_item-jet-woo-builder"
		 :class="`jet_woo-builder-dynamic-post-${itemData.id}`"
		 v-html="itemData.content"
	></div>
</script>