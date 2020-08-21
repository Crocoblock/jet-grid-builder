<?php
/**
 * HTML item template
 */
?>

<script type="text/x-template" class="jgb_item-template">
	<div class="jgb_item jgb_item-post-content">
		<item-thumbnail
			v-if="thumbnailEnabled" />
		<div class="jgb_item-body"
			v-html="itemData.content"
		></div>
	</div>
</script>