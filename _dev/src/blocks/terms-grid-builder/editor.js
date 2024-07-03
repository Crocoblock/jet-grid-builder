import options from '@/blocks/editor/options';
import termsGridBuilderEditor from '@/grid-builder/terms-grid-builder/editor/terms-grid-builder-editor.vue';
import TemplateRender from '@/blocks/editor/controls/templateRender';

const { __ } = wp.i18n;

const {
	registerBlockType
} = wp.blocks;

const {
	InspectorControls
} = wp.editor;

const {
	PanelBody,
	Button,
	ToggleControl,
	TextControl,
	SelectControl
} = wp.components;

window.jgb.initTermsSelector();

registerBlockType('jet-grid-builder/terms-grid-builder', {
	title: __('Terms Grid Builder'),
	icon: 'layout',
	category: 'design',
	supports: {
		html: false
	},
	attributes: {
		terms: {
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
			type: 'boolean',
			default: true,
		},
		item_description_words_count: {
			type: 'number',
			default: 15,
		},
		item_post_count: {
			type: 'boolean',
			default: true,
		},
		item_posts_count_prefix: {
			type: 'string',
			default: __('Posts Count:'),
		},
		item_divider: {
			type: 'boolean',
			default: true,
		},
		item_term_taxonomy: {
			type: 'boolean',
			default: true,
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
			if (!this.termsGridBuilder)
				return;

			this.termsGridBuilder.settings = this.props.attributes;
		}

		layoutUpdate() {
			this.el = document.getElementById(`block-${this.props.clientId}`).getElementsByClassName('terms-grid-builder')[0];

			if (!this.el)
				return;

			this.termsGridBuilder = new Vue({
				el: this.el,
				data: {
					elementId: this.props.clientId,
					settings: this.props.attributes,
					breakpointsDisabled: true
				},
				methods: {
					updateOption: this.updateAttribute.bind(this),
				},
				render: h => h(termsGridBuilderEditor)
			});
		}

		addTermsBtnClick() {
			this.termsGridBuilder.addItems();
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
									this.addTermsBtnClick();
								}}
							>{__('Add Terms')}</Button>
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
							{options.pluginsExist.jetengine && (
								<SelectControl
									label={__('Items Type')}
									value={attributes.items_type}
									options={options.termsItemsType}
									onChange={newValue => {
										this.updateAttribute('items_type', newValue);
									}}
								/>
							)}
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
								<ToggleControl
									label={__('Description')}
									checked={attributes.item_description}
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
									label={__('Posts Count')}
									checked={attributes.item_post_count}
									onChange={newValue => {
										this.updateAttribute('item_post_count', newValue);
									}}
								/>
								{attributes.item_post_count && (
									<TextControl
										type="text"
										label={__('Posts Count Prefix')}
										value={attributes.item_posts_count_prefix}
										onChange={newValue => {
											this.updateAttribute('item_posts_count_prefix', newValue);
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
									label={__('Term Taxonomy')}
									checked={attributes.item_term_taxonomy}
									onChange={newValue => {
										this.updateAttribute('item_term_taxonomy', newValue);
									}}
								/>
							</PanelBody>
						)}
					</InspectorControls>
				),
				<TemplateRender
					block="jet-grid-builder/terms-grid-builder"
					attributes={attributes}
					exceptions={[
						'terms',
						'layout_data',
						'colNum',
						'gutter',
						'vertical_compact',
						'loading_spinner_media',
						'item_thumbnail',
						'item_title',
						'item_description',
						'item_description_words_count',
						'item_post_count',
						'item_posts_count_prefix',
						'item_divider',
						'item_term_taxonomy'
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