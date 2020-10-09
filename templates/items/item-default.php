<?php
/**
 * Item default template
 */
?>

<script type="text/x-template" class="jgb_item-template">
	<div class="jgb_item jgb_item-default"
		:class="{'jgb_no-thumbnail':!thumbnailEnabled}"
	>
		<a class="jgb_item-permalink" :href="itemData.permalink"></a>
		<item-thumbnail v-if="thumbnailEnabled" />
		<div class="jgb_item-type-wrap" v-if="[postTypeEnabled, thumbnailEnabled].every(isTrue)">
			<div class="jgb_item-type">{{itemData.post_type}}</div>
		</div>
		<div class="jgb_item-body">
			<div class="jgb_item-type-wrap" v-if="[postTypeEnabled, !thumbnailEnabled].every(isTrue)">
				<div class="jgb_item-type">{{itemData.post_type}}</div>
			</div>
			<div class="jgb_item-title" v-if="titleEnabled">{{itemData.post_title}}</div>
			<item-description v-if="descriptionEnabled"/>
			<div class="jgb_item-divider" v-if="dividerEnabled">
				<span class="jgb_item-divider-separator"></span>
			</div>
			<div class="jgb_item-meta" v-if="[authorEnabled, dateEnabled].some(isTrue)">
				<div class="jgb_item-date" v-if="dateEnabled">
					<span class="jgb_item-date-prefix">{{datePrefix}}</span>
					<span class="jgb_item-date-value">{{itemData.post_date}}</span>
				</div>
				<div class="jgb_item-author" v-if="authorEnabled">
					<span class="jgb_item-author-prefix">{{authorPrefix}}</span>
					<span class="jgb_item-author-name">{{itemData.post_author}}</span>
				</div>
			</div>
		</div>
	</div>
</script>