<template>
	<div class="jgb_grid-builder jgb_grid-builder-terms"
		 :class="{ 'jgb_loading': !loaded }">
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
import request from '@/includes/request-actions';

// main mixin
import gridBuilderFront from '@/grid-builder/mixins/grid-builder-front.js';

export default {
	mixins: [gridBuilderFront],

	methods: {
		loadContent() {
			let termsIDs = this.getSettingValue('terms');

			if (!termsIDs) {
				this.loaded = true;
				this.removePreloader();

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
		}
	}
}

</script>