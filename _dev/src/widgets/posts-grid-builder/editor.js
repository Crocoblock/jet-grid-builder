import postsGridBuilderEditor from 'grid-builder/posts-grid-builder/editor/posts-grid-builder-editor.vue';
import widgetPreloaderChangeStyle from 'includes/widget-preloader-change-style.js';

(function ($) {

	"use strict";

	const postsGridBuilderEditorInit = () => {
		elementorFrontend.hooks.addAction('frontend/element_ready/posts-grid-builder.default', $scope => {

			const elementId = $scope.data('model-cid'),
				elementSettingsModel = elementorFrontend.config.elements.data[elementId],
				$container = $scope.find('.posts-grid-builder'),
				settings = elementorFrontend.config.elements.data[elementId].attributes;

			const postsGridBuilder = new Vue({
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
						window.elementorCommon.api.internal('document/save/set-is-modified', { status: true });
					},
				},
				render: h => h(postsGridBuilderEditor)
			});

			elementor.channels.editor.on('jgb:post:add', controlView => {
				if (controlView.elementSettingsModel.cid === elementSettingsModel.cid) {
					if (postsGridBuilder.addItems)
						postsGridBuilder.addItems();
				}
			});

			window.parent.jgb.initPostsSelector();
		});
	}

	$(window).on('elementor/frontend/init', postsGridBuilderEditorInit);

}(jQuery));