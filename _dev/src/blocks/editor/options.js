import {
	getNesting
} from '@/includes/utility';

const { __ } = wp.i18n;

export const itemStyles = [{
	label: __('Standard'),
	value: 'default'
},
{
	label: __('Content Overlay'),
	value: 'content-overlay'
}];

export const loadingSpinnerTypes = [{
	label: __('Circle clip growing'),
	value: 'circle-clip-growing'
},
{
	label: __('Circle clip'),
	value: 'circle-clip'
},
{
	label: __('Circle'),
	value: 'circle'
},
{
	label: __('Lines wave'),
	value: 'lines-wave'
},
{
	label: __('Lines pulse'),
	value: 'lines-pulse'
},
{
	label: __('Lines pulse rapid'),
	value: 'lines-pulse-rapid'
},
{
	label: __('Cube grid'),
	value: 'cube-grid'
},
{
	label: __('Cube folding'),
	value: 'cube-folding'
},
{
	label: __('Wordpress'),
	value: 'wordpress'
},
{
	label: __('Hash'),
	value: 'hash'
},
{
	label: __('Dots grid pulse'),
	value: 'dots-grid-pulse'
},
{
	label: __('Dots grid beat'),
	value: 'dots-grid-beat'
},
{
	label: __('Dots circle'),
	value: 'dots-circle'
},
{
	label: __('Dots pulse'),
	value: 'dots-pulse'
},
{
	label: __('Dots elastic'),
	value: 'dots-elastic'
},
{
	label: __('Dots carousel'),
	value: 'dots-carousel'
},
{
	label: __('Dots windmill'),
	value: 'dots-windmill'
},
{
	label: __('Dots triangle path'),
	value: 'dots-triangle-path'
},
{
	label: __('Dots bricks'),
	value: 'dots-bricks'
},
{
	label: __('Dots fire'),
	value: 'dots-fire'
},
{
	label: __('Dots rotate'),
	value: 'dots-rotate'
},
{
	label: __('Dots bouncing'),
	value: 'dots-bouncing'
},
{
	label: __('Dots chasing'),
	value: 'dots-chasing'
},
{
	label: __('Dots propagate'),
	value: 'dots-propagate'
},
{
	label: __('Dots spin scale'),
	value: 'dots-spin-scale'
}];

export const descriptionTypes = [{
	label: __('Auto'),
	value: 'auto'
},
{
	label: __('Content'),
	value: 'content'
},
{
	label: __('Excerpt'),
	value: 'excerpt'
}];

export const wooItemStyles = [{
	label: __('Standard'),
	value: 'default'
},
{
	label: __('Content Overlay'),
	value: 'content-overlay'
}];

export const termsItemsType = [{
	label: __('Default'),
	value: 'default'
},
{
	label: __('JetEngine Listing'),
	value: 'jetengine_listing'
}];

export const pluginsExist = getNesting(window.jgbSettings, 'plugins_exist');

function getOptions(type) {
	const data = getNesting(window.jgbSettings, 'blocks_options', type),
		options = [];

	for (const key in data) {
		options.push({
			value: key,
			label: data[key]
		});
	}

	return options;
};

export default {
	itemsType: getOptions('items_type'),
	itemStyles,
	loadingSpinnerTypes,
	descriptionTypes,
	thumbnailSizes: getOptions('thumbnail_sizes'),
	jetengineListings: getOptions('jetengine_listings'),
	wooItemsTypes: getOptions('woo_items_types'),
	jetwoobuilderListings: getOptions('jetwoobuilder_listings'),
	wooItemStyles,
	termsItemsType,
	pluginsExist
};