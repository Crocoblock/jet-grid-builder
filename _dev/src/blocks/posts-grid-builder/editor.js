import options from '@/blocks/editor/options';
import postsGridBuilderEditor from '@/grid-builder/posts-grid-builder/editor/posts-grid-builder-editor.vue';
import TemplateRender from '@/blocks/editor/controls/templateRender';

const { __ } = wp.i18n;

const {
	registerBlockType
} = wp.blocks;

const {
	InspectorControls
} = wp.blockEditor;

const {
	PanelBody,
	Button,
	ToggleControl,
	TextControl,
	SelectControl
} = wp.components;

window.jgb.initPostsSelector();

registerBlockType('jet-grid-builder/posts-grid-builder', {
	title: __('Posts Grid Builder'),
	icon: 'layout',
	category: 'design',
	supports: {
		html: false
	},
	attributes: {
		posts: {
			type: 'string',
			default: '',
		},
		layout_data: {
			type: 'string',
			default: '',
		},
		colNum: {
			type: 'number',
			default: 18,
		},
		gutter: {
			type: 'number',
			default: 10,
		},
		vertical_compact: {
			type: 'boolean',
			default: false,
		},
		// item type
		items_type: {
			type: 'string',
			default: 'default',
		},
		item_style: {
			type: 'string',
			default: 'default',
		},
		jetengine_listing_id: {
			type: 'string',
			default: '',
		},
		// item 'default' settings
		item_title: {
			type: 'boolean',
			default: true,
		},
		item_thumbnail: {
			type: 'boolean',
			default: true,
		},
		item_thumbnail_size: {
			type: 'string',
			default: 'large',
		},
		item_description: {
			type: 'string',
			default: 'auto',
		},
		item_description_words_count: {
			type: 'number',
			default: 15,
		},
		item_post_author: {
			type: 'boolean',
			default: true,
		},
		item_post_author_prefix: {
			type: 'string',
			default: __('By'),
		},
		item_post_date: {
			type: 'boolean',
			default: true,
		},
		item_post_date_prefix: {
			type: 'string',
			default: __('Posted'),
		},
		item_post_date_format: {
			type: 'string',
			default: 'F, j',
		},
		item_divider: {
			type: 'boolean',
			default: true,
		},
		item_post_type: {
			type: 'boolean',
			default: true,
		},
		// Woocommerce
		woo_items_type: {
			type: 'string',
			default: 'default',
		},
		woo_item_style: {
			type: 'string',
			default: 'default',
		},
		jet_woo_builder_archive_id: {
			type: 'string',
			default: '',
		},
		// Woocommerce settings
		woocommerce_item_clickable: {
			type: 'boolean',
			default: false,
		},
		woocommerce_item_stars_rating: {
			type: 'boolean',
			default: true,
		},
		woocommerce_item_categories: {
			type: 'boolean',
			default: true,
		},
		woocommerce_item_price: {
			type: 'boolean',
			default: true,
		},
		woocommerce_item_add_to_cart: {
			type: 'boolean',
			default: true,
		},
		woocommerce_item_add_to_cart_text: {
			type: 'string',
			default: __('Add to cart'),
		},
		// loading spinner settings
		loading_spinner: {
			type: 'boolean',
			default: true,
		},
		loading_spinner_media: {
			type: 'boolean',
			default: false,
		},
		loading_spinner_type: {
			type: 'string',
			default: 'circle-clip-growing',
		}
	},

	edit: class extends wp.element.Component {
		componentDidUpdate() {
			if (!this.postsGridBuilder)
				return;

			this.postsGridBuilder.settings = this.props.attributes;
		}

		layoutUpdate() {
			this.el = document.getElementById(`block-${this.props.clientId}`).getElementsByClassName('posts-grid-builder')[0];

			if (!this.el)
				return;

			this.postsGridBuilder = new Vue({
				el: this.el,
				data: {
					elementId: this.props.clientId,
					settings: this.props.attributes,
					breakpointsDisabled: true
				},
				methods: {
					updateOption: this.updateAttribute.bind(this),
				},
				render: h => h(postsGridBuilderEditor)
			});
		}

		addPostsBtnClick() {
			this.postsGridBuilder.addItems();
		}

		updateAttribute(key, value) {
			this.props.setAttributes({ [key]: value });
		}

		render() {
			const {
				attributes,
				isSelected
			} = this.props;

			return [
				isSelected && (
					<InspectorControls
						key={'inspector'}
					>
						<PanelBody title={__('General')}>
							<Button
								className='jgb_button'
								onClick={() => {
									this.addPostsBtnClick();
								}}
							>{__('Add Posts')}</Button>
							<ToggleControl
								label={__('Vertical Compact')}
								checked={attributes.vertical_compact}
								onChange={newValue => {
									this.updateAttribute('vertical_compact', newValue);
								}}
							/>
							<TextControl
								type="number"
								label={__('Gutter')}
								min={`0`}
								max={`50`}
								value={attributes.gutter}
								onChange={newValue => {
									this.updateAttribute('gutter', Number(newValue));
								}}
							/>
							<TextControl
								type="number"
								label={__('Number of columns')}
								min={`3`}
								max={`50`}
								value={attributes.colNum}
								onChange={newValue => {
									this.updateAttribute('colNum', Number(newValue));
								}}
							/>
							<SelectControl
								label={__('Items Type')}
								value={attributes.items_type}
								options={options.itemsType}
								onChange={newValue => {
									this.updateAttribute('items_type', newValue);
								}}
							/>
							{attributes.items_type === 'jetengine_listing' && (
								<SelectControl
									label={__('Listing')}
									value={attributes.jetengine_listing_id}
									options={[{
										value: '',
										disabled: true,
										label: __('Select JetEngine Template...')
									}, ...options.jetengineListings]}
									onChange={newValue => {
										this.updateAttribute('jetengine_listing_id', newValue);
									}}
								/>
							)}
							{attributes.items_type === 'default' && (
								<SelectControl
									label={__('Item Style')}
									value={attributes.item_style}
									options={options.itemStyles}
									onChange={newValue => {
										this.updateAttribute('item_style', newValue);
									}}
								/>
							)}
							{options.pluginsExist.woocommerce && (
								<SelectControl
									label={__('Woo Items Type')}
									value={attributes.woo_items_type}
									options={options.wooItemsTypes}
									onChange={newValue => {
										this.updateAttribute('woo_items_type', newValue);
									}}
								/>
							)}
							{options.pluginsExist.woocommerce && attributes.woo_items_type === 'jet_woo_builder_archive' && (
								<SelectControl
									label={__('JetWooBuilder Template')}
									value={attributes.jet_woo_builder_archive_id}
									options={[{
										value: '',
										disabled: true,
										label: __('Select JetWoo Template...')
									}, ...options.jetwoobuilderListings]}
									onChange={newValue => {
										this.updateAttribute('jet_woo_builder_archive_id', newValue);
									}}
								/>
							)}
							{options.pluginsExist.woocommerce && attributes.woo_items_type === 'default' && (
								<SelectControl
									label={__('Woo Item Style')}
									value={attributes.woo_item_style}
									options={options.wooItemStyles}
									onChange={newValue => {
										this.updateAttribute('woo_item_style', newValue);
									}}
								/>
							)}
							<ToggleControl
								label={__('Loading Spinner')}
								checked={attributes.loading_spinner}
								onChange={newValue => {
									this.updateAttribute('loading_spinner', newValue);
								}}
							/>
							{attributes.loading_spinner && (
								<ToggleControl
									label={__('Show spinner until media loads')}
									checked={attributes.loading_spinner_media}
									help={__('Only for default items type')}
									onChange={newValue => {
										this.updateAttribute('loading_spinner_media', newValue);
									}}
								/>
							)}
							{attributes.loading_spinner && (
								<SelectControl
									label={__('Spinner Type')}
									value={attributes.loading_spinner_type}
									options={options.loadingSpinnerTypes}
									onChange={newValue => {
										this.updateAttribute('loading_spinner_type', newValue);
									}}
								/>
							)}
						</PanelBody>
						{attributes.items_type === 'default' && (
							<PanelBody title={__('Post Item')} initialOpen={false}>
								<ToggleControl
									label={__('Thumbnail')}
									checked={attributes.item_thumbnail}
									onChange={newValue => {
										this.updateAttribute('item_thumbnail', newValue);
									}}
								/>
								<SelectControl
									label={__('Thumbnail Size')}
									value={attributes.item_thumbnail_size}
									options={options.thumbnailSizes}
									onChange={newValue => {
										this.updateAttribute('item_thumbnail_size', newValue);
									}}
								/>
								<ToggleControl
									label={__('Title')}
									checked={attributes.item_title}
									onChange={newValue => {
										this.updateAttribute('item_title', newValue);
									}}
								/>
								<SelectControl
									label={__('Description')}
									value={attributes.item_description}
									options={options.descriptionTypes}
									onChange={newValue => {
										this.updateAttribute('item_description', newValue);
									}}
								/>
								<TextControl
									type="number"
									label={__('Words count')}
									min={`0`}
									max={`100`}
									value={attributes.item_description_words_count}
									onChange={newValue => {
										this.updateAttribute('item_description_words_count', Number(newValue));
									}}
								/>
								<ToggleControl
									label={__('Author')}
									checked={attributes.item_post_author}
									onChange={newValue => {
										this.updateAttribute('item_post_author', newValue);
									}}
								/>
								{attributes.item_post_author && (
									<TextControl
										type="text"
										label={__('Author Prefix')}
										value={attributes.item_post_author_prefix}
										onChange={newValue => {
											this.updateAttribute('item_post_author_prefix', newValue);
										}}
									/>
								)}
								<ToggleControl
									label={__('Date')}
									checked={attributes.item_post_date}
									onChange={newValue => {
										this.updateAttribute('item_post_date', newValue);
									}}
								/>
								{attributes.item_post_date && (
									<TextControl
										type="text"
										label={__('Date Prefix')}
										value={attributes.item_post_date_prefix}
										onChange={newValue => {
											this.updateAttribute('item_post_date_prefix', newValue);
										}}
									/>
								)}
								{attributes.item_post_date && (
									<TextControl
										type="text"
										label={__('Date Format')}
										value={attributes.item_post_date_format}
										help={<a href="https://wordpress.org/support/article/formatting-date-and-time/" target="_blank">{__('Date Format Documentation')}</a>}
										onChange={newValue => {
											this.updateAttribute('item_post_date_format', newValue);
										}}
									/>

								)}
								<ToggleControl
									label={__('Divider')}
									checked={attributes.item_divider}
									onChange={newValue => {
										this.updateAttribute('item_divider', newValue);
									}}
								/>
								<ToggleControl
									label={__('Post Type')}
									checked={attributes.item_post_type}
									onChange={newValue => {
										this.updateAttribute('item_post_type', newValue);
									}}
								/>
							</PanelBody>
						)}
						{attributes.items_type === 'post_content' && (
							<PanelBody title={__('Post Item')} initialOpen={false}>
								<ToggleControl
									label={__('Thumbnail')}
									checked={attributes.item_thumbnail}
									onChange={newValue => {
										this.updateAttribute('item_thumbnail', newValue);
									}}
								/>
								<SelectControl
									label={__('Thumbnail Size')}
									value={attributes.item_thumbnail_size}
									options={options.thumbnailSizes}
									onChange={newValue => {
										this.updateAttribute('item_thumbnail_size', newValue);
									}}
								/>
							</PanelBody>
						)}
						{options.pluginsExist.woocommerce && attributes.woo_items_type === 'default' && (
							<PanelBody title={__('Woocommerce Product')} initialOpen={false}>
								<ToggleControl
									label={__('Make Item Clickable')}
									checked={attributes.woocommerce_item_clickable}
									onChange={newValue => {
										this.updateAttribute('woocommerce_item_clickable', newValue);
									}}
								/>
								<ToggleControl
									label={__('Stars Rating')}
									checked={attributes.woocommerce_item_stars_rating}
									onChange={newValue => {
										this.updateAttribute('woocommerce_item_stars_rating', newValue);
									}}
								/>
								<ToggleControl
									label={__('Categories')}
									checked={attributes.woocommerce_item_categories}
									onChange={newValue => {
										this.updateAttribute('woocommerce_item_categories', newValue);
									}}
								/>
								<ToggleControl
									label={__('Price')}
									checked={attributes.woocommerce_item_price}
									onChange={newValue => {
										this.updateAttribute('woocommerce_item_price', newValue);
									}}
								/>
								<ToggleControl
									label={__('Add To Cart')}
									checked={attributes.woocommerce_item_add_to_cart}
									onChange={newValue => {
										this.updateAttribute('woocommerce_item_add_to_cart', newValue);
									}}
								/>
								{attributes.woocommerce_item_add_to_cart && (
									<TextControl
										type="text"
										label={__('Add To Cart Text')}
										value={attributes.woocommerce_item_add_to_cart_text}
										onChange={newValue => {
											this.updateAttribute('woocommerce_item_add_to_cart_text', newValue);
										}}
									/>
								)}
							</PanelBody>
						)}
					</InspectorControls>
				),
				<TemplateRender
					block="jet-grid-builder/posts-grid-builder"
					attributes={attributes}
					exceptions={[
						'posts',
						'layout_data',
						'colNum',
						'gutter',
						'vertical_compact',
						'loading_spinner_media',
						'item_thumbnail',
						'item_title',
						'item_description',
						'item_description_words_count',
						'item_post_author',
						'item_post_author_prefix',
						'item_post_date',
						'item_post_date_prefix',
						'item_divider',
						'item_post_type',
						'woocommerce_item_clickable',
						'woocommerce_item_stars_rating',
						'woocommerce_item_categories',
						'woocommerce_item_price',
						'woocommerce_item_add_to_cart',
						'woocommerce_item_add_to_cart_text',
					]}
					onSuccess={() => { this.layoutUpdate(); }}
				/>
			];
		}
	},
	save: () => {
		return null;
	}
});