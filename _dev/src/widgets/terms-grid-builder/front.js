import termsGridBuilderFront from '@/grid-builder/terms-grid-builder/front/terms-grid-builder-front.vue';

(function ($) {

	"use strict";

	const termsGridBuilderFrontInit = () => {
		elementorFrontend.hooks.addAction('frontend/element_ready/terms-grid-builder.default', $scope => {
			const $container = $scope.find('.terms-grid-builder'),
				settings = $container.data('settings');

			new Vue({
				el: $container.get(0),
				data: {
					settings: settings
				},
				render: h => h(termsGridBuilderFront)
			});
		});
	};

	$(window).on('elementor/frontend/init', termsGridBuilderFrontInit);

}(jQuery));