import termsGridBuilderEditor from './terms-grid-builder-editor.vue';
import widgetPreloaderChangeStyle from 'includes/widget-preloader-change-style.js';

(function ($) {

	"use strict";

	const termsGridBuilderEditorInit = () => {
		elementorFrontend.hooks.addAction('frontend/element_ready/terms-grid-builder-preview.default', $scope => {

			const elementId = $scope.data('model-cid'),
				elementSettingsModel = elementorFrontend.config.elements.data[elementId],
				$container = $scope.find('.terms-grid-builder'),
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
				render: h => h(termsGridBuilderEditor)
			});

			window.parent.jgb.initTermsSelector();
		});
	}

	$(window).on('elementor/frontend/init', termsGridBuilderEditorInit);

}(jQuery));