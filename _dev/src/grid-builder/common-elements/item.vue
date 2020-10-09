<template>
	<div class="jgb_item-container"
	     :class="itemData.class">
		<component :is="component"
		           :itemData="itemData"
		           v-if="component" />
	</div>
</template>

<script>
	import { stringToBoolean, decodeHtmlSpecialChars } from 'includes/utility.js';
	import itemThumbnail from './item-thumbnail.vue';
	import itemDescription from './item-description.vue';
	import productCategories from './product-categories.vue';
	import productStarsRating from './product-stars-rating.vue';
	import productPrice from './product-price.vue';
	import productAddToCart from './product-add-to-cart.vue';
	import termDescription from './term-description.vue';

	export default {
		props: {
			itemData: {
				type: Object,
				required: true
			}
		},

		data() {
			return {
				component: null,
			}
		},

		created() {
			this.component = Vue.component('item-comp', {
				template: this.getTemplate(),

				components: {
					itemThumbnail,
					itemDescription,
					productCategories,
					productStarsRating,
					productPrice,
					productAddToCart,
					termDescription
				},

				props: ['itemData'],

				computed: {
					layout() {
						return this.getSetting('layout');
					},
					thumbnailEnabled() {
						return this.getSetting('item_thumbnail')
							? (this.itemData.thumbnail_data.file ? true : false)
							: false;
					},
					postTypeEnabled() {
						return this.getSetting('item_post_type');
					},
					titleEnabled() {
						return this.getSetting('item_title');
					},
					descriptionEnabled() {
						return this.getSetting('item_description');
					},
					authorEnabled() {
						return this.getSetting('item_post_author');
					},
					authorPrefix() {
						return decodeHtmlSpecialChars(this.getSetting('item_post_author_prefix'));
					},
					dateEnabled() {
						return this.getSetting('item_post_date');
					},
					datePrefix() {
						return decodeHtmlSpecialChars(this.getSetting('item_post_date_prefix'));
					},
					dividerEnabled() {
						return this.getSetting('item_divider');
					},
					productStarsRatingEnabled() {
						return this.getSetting('woocommerce_item_stars_rating');
					},
					productCategoriesEnabled() {
						return this.getSetting('woocommerce_item_categories');
					},
					productAddToCartEnabled() {
						return this.getSetting('woocommerce_item_add_to_cart');
					},
					productPriceEnabled() {
						return this.getSetting('woocommerce_item_price');
					},
					termTaxonomyEnabled() {
						return this.getSetting('item_term_taxonomy');
					},
					termPostsCountEnabled() {
						return this.getSetting('item_post_count');
					},
					termPostsCountPrefix() {
						return this.getSetting('item_posts_count_prefix');
					},
				},

				methods: {
					getSetting(setting) {
						return this.$root.$children[0].getSettingValue(setting);
					},
					getResponsiveSetting(setting) {
						return this.$root.$children[0].getResponsiveSettingValue(setting);
					},
					isTrue(val) {
						return stringToBoolean(val);
					}
				}
			});
		},

		methods: {
			getTemplate() {
				if (this.itemData.is_woocommerce) {
					return jQuery(this.$root.$el).siblings('.jgb_woocommerce-item-template').get(0);
				} else {
					return jQuery(this.$root.$el).siblings('.jgb_item-template').get(0);
				}
			}
		}
	}
</script>