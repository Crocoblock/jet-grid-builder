<template>
	<div class="jgb_grid-builder jgb_grid-builder-posts"
	     :class="{'jgb_no-content': noContent, 'jgb_loading': !loaded}"
	     @mousedown="mouseDownEvent">
		<div class="jgb_toolbar">
			<button type="button"
			        class="jgb_toolbar-remove-breakpoint-btn elementor-button"
			        v-if="layoutBreakpointEnabled && 'desktop' !== currentBreakpoint"
			        @click="removeLayoutBreakpoint()">Remove {{currentBreakpoint}} Breakpoint</button>
			<div class="jgb_toolbar-current-breakpoint"
			     v-if="!layoutBreakpointEnabled && 'desktop' !== currentBreakpoint">Same as {{availableBreakpoint}} layout</div>
			<checkbox class="jgb_toolbar-backinggrid"
			          :checked="backingGrid"
			          :label="'Show backing grid'"
			          @change="changeBackingGrid" />
		</div>

		<div class="jgb_no-items"
		     v-if="loaded && noContent">
			<div class="jgb_no-items-title">No Posts</div>
			<button type="button"
			        class="jgb_no-items-add-btn elementor-button"
			        @click="addPostsBtnClick()"><i class="eicon-plus"></i> Add Posts</button>
		</div>

		<dnd-grid-container v-if="items.length"
		                    :layout="layout"
		                    :cellSize="cellSize"
		                    :maxColumnCount="colNum"
		                    :maxRowCount="Infinity"
		                    :margin="gutter"
		                    :bubbleUp="verticalCompact"
		                    :backingGrid="backingGrid"
		                    @update:layout="layoutUpdated">
			<dnd-grid-box v-for="item in items"
			              :key="item.id"
			              :boxId="item.id">
				<item :itemData="item" />
				<div class="jgb_overlay">
					<ul class="jgb_overlay-toolset">
						<li class="jgb_overlay-toolset-edit"
						    @click="changePostClick(item.id)">
							<i class="eicon-edit"
							   aria-hidden="true"></i></li>
						<li class="jgb_overlay-toolset-remove"
						    @click="removePostClick(item.id)">
							<i class="eicon-trash"></i>
						</li>
					</ul>
				</div>
			</dnd-grid-box>
		</dnd-grid-container>
	</div>
</template>

<script>
	import request from 'includes/request-actions';
	import { removeFromArray } from 'includes/utility.js';

	// main mixin
	import gridBuilderEditor from 'mixins/grid-builder/grid-builder-editor.js';

	export default {
		mixins: [gridBuilderEditor],

		data() {
			return {
				itemsKey: 'posts',
			}
		},

		mounted() {
			elementor.channels.editor.on('jgb:post:add', controlView => {
				if (controlView.elementSettingsModel.cid === this.elementSettingsModel.cid) {
					window.parent.jgb.postsSelector.open({
						disabled: this.itemsIDs,
					})
						.then(newPosts => {
							this.addNewItems(newPosts);
						})
						.catch(() => { });
				}
			});

			this.loadPosts();
		},

		methods: {
			loadPosts() {
				let postsIDs = this.getSettingValue(this.itemsKey);

				if (!postsIDs) {
					this.loaded = true;
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
			},

			updateItem(item) {
				if (!item.id)
					return;

				const requestArgs = this.getRequestArgs({
					post_type: 'any',
					post__in: item.id,
				});

				item.class = 'jgb_item-loading';

				request.getPosts(requestArgs,
					response => {
						response.posts.forEach(post => {
							this.items = this.items.map(item => {
								return item.id === post.id ? post : item;
							})
						});
					}
				);
			},

			// Events Methods
			addPostsBtnClick() {
				window.parent.jgb.postsSelector.open()
					.then(newPosts => {
						this.addNewItems(newPosts);
					})
					.catch(() => { });
			},

			changePostClick(postId) {
				window.parent.jgb.postsSelector.open({
					title: 'Select Post',
					singleSelection: true,
					selected: [postId],
					disabled: removeFromArray([...this.itemsIDs], postId)
				})
					.then(newPost => {
						this.changeItem(postId, newPost.shift());
					})
					.catch(() => { });
			},

			removePostClick(postId) {
				this.removeItem(postId);
			}
		},
	}
</script>