import termsGridBuilderFront from '@/grid-builder/terms-grid-builder/front/terms-grid-builder-front.vue';

(function ($) {

	"use strict";

	$(document).ready(function () {
		const $termsGridBuilderContainers = $('.jgb_terms-grid-builder-container');

		$termsGridBuilderContainers.each(index => {
			const $termsGridBuilder = $termsGridBuilderContainers.eq(index).find('.terms-grid-builder');

			if (!$termsGridBuilder.length)
				return;

			const settings = $termsGridBuilder.data('settings');

			new Vue({
				el: $termsGridBuilder.get(0),
				data: {
					settings
				},
				render: h => h(termsGridBuilderFront)
			});
		});
	});

}(jQuery));