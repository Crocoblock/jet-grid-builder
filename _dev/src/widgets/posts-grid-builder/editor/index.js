import postsGridBuilderEditor from './posts-grid-builder-editor.vue';
import widgetPreloaderChangeStyle from 'includes/widget-preloader-change-style.js';

(function ($) {

	"use strict";

	const postsGridBuilderEditorInit = () => {
		elementorFrontend.hooks.addAction('frontend/element_ready/posts-grid-builder.default', $scope => {

			const elementId = $scope.data('model-cid'),
				elementSettingsModel = elementorFrontend.config.elements.data[elementId],
				$container = $scope.find('.posts-grid-builder'),
				settings = elementorFrontend.config.elements.data[elementId].attributes;

			new Vue({
				el: $container.get(0),
				data: {
					elementId,
					elementSettingsModel,
					settings: settings
				},
				created() {
					widgetPreloaderChangeStyle($scope);
				},
				render: h => h(postsGridBuilderEditor)
			});

			window.parent.jgb.initPostsSelector();
		});
	}

	$(window).on('elementor/frontend/init', postsGridBuilderEditorInit);

}(jQuery));