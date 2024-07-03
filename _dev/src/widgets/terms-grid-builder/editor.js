import termsGridBuilderEditor from '@/grid-builder/terms-grid-builder/editor/terms-grid-builder-editor.vue';
import widgetPreloaderChangeStyle from '@/includes/widget-preloader-change-style.js';

(function ($) {

	"use strict";

	const termsGridBuilderEditorInit = () => {
		elementorFrontend.hooks.addAction('frontend/element_ready/terms-grid-builder.default', $scope => {

			const elementId = $scope.data('model-cid'),
				elementSettingsModel = elementorFrontend.config.elements.data[elementId],
				$container = $scope.find('.terms-grid-builder'),
				settings = elementorFrontend.config.elements.data[elementId].attributes;

			const termsGridBuilder = new Vue({
				el: $container.get(0),
				data: {
					elementId,
					settings: settings
				},
				created() {
					widgetPreloaderChangeStyle($scope);
				},
				methods: {
					updateOption: (key, value) => {
						elementSettingsModel.set(key, value);
						elementor.saver.setFlagEditorChange(true);
					},
				},
				render: h => h(termsGridBuilderEditor)
			});

			elementor.channels.editor.on('jgb:term:add', controlView => {
				if (controlView.elementSettingsModel.cid === elementSettingsModel.cid) {
					termsGridBuilder.addItems();
				}
			});

			window.parent.jgb.initTermsSelector();
		});
	};

	$(window).on('elementor/frontend/init', termsGridBuilderEditorInit);

}(jQuery));