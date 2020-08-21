<?php
/**
 * HTML item template
 */
?>

<script type="text/x-template" class="jgb_item-template">
	<div class="jgb_item jgb_item-jet-listing"
		 :class="`jet-listing-dynamic-post-${itemData.id}`"
		 v-html="itemData.content"
	></div>
</script>