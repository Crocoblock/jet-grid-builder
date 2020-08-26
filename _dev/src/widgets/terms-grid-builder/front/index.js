require('editor/index.js');

import termsGridBuilderFront from './terms-grid-builder-front.vue';

(function ($) {

	"use strict";

	const termsGridBuilderFrontInit = () => {
		elementorFrontend.hooks.addAction('frontend/element_ready/terms-grid-builder-preview.default', $scope => {
			const elementId = $scope.data('model-cid'),
				$container = $scope.find('.terms-grid-builder'),
				elementSettingsModel = {
					on() {
						return;
					},
					set() {
						return;
					},
					cid: false
				},
				settings = $container.data('settings');

			new Vue({
				el: $container.get(0),
				data: {
					elementId,
					elementSettingsModel,
					settings: settings
				},
				render: h => h(termsGridBuilderFront)
			});

			window.parent.jgb.initTermsSelector();
		});
	}

	$(window).on('elementor/frontend/init', termsGridBuilderFrontInit);

}(jQuery));