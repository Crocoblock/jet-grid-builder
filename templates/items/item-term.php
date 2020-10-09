<?php
/**
 * Item content overlay template
 */
?>

<script type="text/x-template" class="jgb_item-template">
	<div class="jgb_item jgb_item-term"
		:class="{'jgb_no-thumbnail':!thumbnailEnabled}"
	>
		<a class="jgb_item-permalink" :href="itemData.permalink"></a>
		<item-thumbnail v-if="thumbnailEnabled" />
		<div class="jgb_item-type-wrap" v-if="[termTaxonomyEnabled, thumbnailEnabled].every(isTrue)">
			<div class="jgb_item-type">{{itemData.term_taxonomy}}</div>
		</div>
		<div class="jgb_item-body">
			<div class="jgb_item-type-wrap" v-if="[termTaxonomyEnabled, !thumbnailEnabled].every(isTrue)">
				<div class="jgb_item-type">{{itemData.term_taxonomy}}</div>
			</div>
			<div class="jgb_item-title" v-if="titleEnabled">{{itemData.term_title}}</div>
			<term-description v-if="descriptionEnabled"/>
			<div class="jgb_item-divider" v-if="dividerEnabled">
				<span class="jgb_item-divider-separator"></span>
			</div>
			<div class="jgb_item-posts-count" v-if="termPostsCountEnabled">
				<span class="jgb_item-posts-count-prefix">{{termPostsCountPrefix}}</span>
				<span class="jgb_item-posts-count-value">{{itemData.term_count}}</span>
			</div>
		</div>
	</div>
</script>