<template>
	<div class="jgb_grid-builder jgb_grid-builder-terms"
	     :class="{'jgb_no-content': noContent, 'jgb_loading': !loaded}"
	     @mousedown="mouseDownEvent">
		<div class="jgb_add-items-btn-holder">
			<button v-if="loaded && !noContent"
					type="button"
					class="jgb_add-items-btn elementor-button"
					@click="addTermsBtnClick()"
			>
				<i class="eicon-plus"></i> Add Terms
			</button>
		</div>
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
			<div class="jgb_no-items-title">No Terms</div>
			<button type="button"
			        class="jgb_no-items-add-btn elementor-button"
			        @click="addTermsBtnClick()"><i class="eicon-plus"></i> Add Terms</button>
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
						    @click="changeTermClick(item.id)">
							<i class="eicon-edit"
							   aria-hidden="true"></i></li>
						<li class="jgb_overlay-toolset-remove"
						    @click="removeTermClick(item.id)">
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
				itemsKey: 'terms'
			}
		},

		mounted() {
			this.loadTerms();
		},

		methods: {
			loadTerms() {
				let termsIDs = this.getSettingValue(this.itemsKey);

				if (!termsIDs) {
					this.loaded = true;
					return;
				}

				const requestArgs = this.getRequestArgs({
					taxonomy: 'any',
					include: termsIDs,
				});

				request.getTerms(requestArgs,
					response => {
						this.contentLoaded(response.terms);
					}
				);
			},

			updateItem(item) {
				if (!item.id)
					return;

				const requestArgs = this.getRequestArgs({
					taxonomy: 'any',
					include: item.id,
				});

				item.class = 'jgb_item-loading';

				request.getTerms(requestArgs,
					response => {
						response.terms.forEach(term => {
							this.items = this.items.map(item => {
								return item.id === term.id ? term : item;
							})
						});
					}
				);
			},

			// Events Methods
			addTermsBtnClick() {
				window.parent.jgb.termsSelector.open({
					disabled: this.itemsIDs,
				})
					.then(newTerms => {
						this.addNewItems(newTerms);
					})
					.catch(() => { });
			},

			changeTermClick(termId) {
				window.parent.jgb.termsSelector.open({
					title: 'Select Term',
					singleSelection: true,
					selected: [termId],
					disabled: removeFromArray([...this.itemsIDs], termId)
				})
					.then(newTerm => {
						this.changeItem(termId, newTerm.shift());
					})
					.catch(() => { });
			},

			removeTermClick(termId) {
				this.removeItem(termId);
			}
		},
	}
</script>