import postsGridBuilderFront from '@/grid-builder/posts-grid-builder/front/posts-grid-builder-front.vue';

(function ($) {

	"use strict";

	$(document).ready(function () {
		const $postsGridBuilderContainers = $('.jgb_posts-grid-builder-container');

		$postsGridBuilderContainers.each(index => {
			const $postsGridBuilder = $postsGridBuilderContainers.eq(index).find('.posts-grid-builder');

			if (!$postsGridBuilder.length)
				return;

			const settings = $postsGridBuilder.data('settings');

			new Vue({
				el: $postsGridBuilder.get(0),
				data: {
					settings
				},
				render: h => h(postsGridBuilderFront)
			});
		});
	});

}(jQuery));