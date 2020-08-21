import postsGridBuilderFront from './posts-grid-builder-front.vue';

(function ($) {

	"use strict";

	const postsGridBuilderFrontInit = () => {
		elementorFrontend.hooks.addAction('frontend/element_ready/posts-grid-builder.default', $scope => {
			const $container = $scope.find('.posts-grid-builder'),
				settings = $container.data('settings');

			new Vue({
				el: $container.get(0),
				data: {
					settings: settings
				},
				render: h => h(postsGridBuilderFront)
			});
		});
	}

	$(window).on('elementor/frontend/init', postsGridBuilderFrontInit);

}(jQuery));