const loadingProps = [
	'loading_spinner_color',
	'loading_spinner_size',
	'loading_spinner_background',
	'loading_spinner_padding',
	'loading_spinner_border_border',
	'loading_spinner_border_width',
	'loading_spinner_border_color',
	'loading_spinner_border_radius',
	'loading_spinner_shadow_box_shadow',
	'loading_spinner_shadow_box_shadow_position'
];

let loadingTimeout;

export default function widgetPreloaderChangeStyle($scope) {
	if (!window.elementorFrontend.isEditMode())
		return;

	const elementId = $scope.data('model-cid'),
		container = $scope.find('.elementor-widget-container');

	elementorFrontend.config.elements.data[elementId].on('change', data => {
		if (Object.keys(data.changed).some(key => loadingProps.includes(key))) {
			clearTimeout(loadingTimeout);
			container.children().addClass('jgb_show-preloader');

			loadingTimeout = setTimeout(() => {
				container.children().removeClass('jgb_show-preloader');
			}, 5000);
		}
	});
};
