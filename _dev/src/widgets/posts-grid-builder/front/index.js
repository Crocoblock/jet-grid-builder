require('editor/index.js');

import postsGridBuilderFront from './posts-grid-builder-front.vue';

(function ($) {

	"use strict";

	const postsGridBuilderFrontInit = () => {
		elementorFrontend.hooks.addAction('frontend/element_ready/posts-grid-builder-preview.default', $scope => {
			const $container = $scope.find('.posts-grid-builder'),
				elementId = $scope.data('id'),
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
				render: h => h(postsGridBuilderFront)
			});

			window.parent.jgb.initPostsSelector();
		});
	}

	$(window).on('elementor/frontend/init', postsGridBuilderFrontInit);

}(jQuery));