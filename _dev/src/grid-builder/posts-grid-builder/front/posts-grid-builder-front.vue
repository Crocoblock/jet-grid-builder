<template>
	<div class="jgb_grid-builder jgb_grid-builder-posts"
	     :class="{'jgb_loading': !loaded}">
		<div class="jgb_grid-container"
		     :style="containerStyle">
			<box class="jgb_grid-box"
			     v-for="item in items"
			     :key="item.id"
			     :boxId="item.id">
				<item :itemData="item" />
			</box>
		</div>
	</div>
</template>

<script>
	import request from 'includes/request-actions';

	// main mixin
	import gridBuilderFront from 'grid-builder/mixins/grid-builder-front.js';

	export default {
		mixins: [gridBuilderFront],

		methods: {
			loadContent() {
				let postsIDs = this.getSettingValue('posts');

				if (!postsIDs) {
					this.loaded = true;
					this.removePreloader();

					return;
				}

				const requestArgs = this.getRequestArgs({
					post_type: 'any',
					post__in: postsIDs,
				});

				request.getPosts(requestArgs,
					response => {
						this.contentLoaded(response.posts);
					}
				);
			}
		}
	}

</script>