<template>
	<selection-modal class="jgb-modal-terms-selection"
					 :cid="cid"
					 :menu="taxonomiesMenu"
					 :data="termsData"
					 :paged="paged"
					 :totalPage="totalPage"
					 :orderby="orderby"
					 :order="order"
					 :keys="keys"
					 :defaultProps="defaultProps"
					 @getData="updateData"
					 ref="modal" />
</template>

<script>
import selectionModal from '../selection-modal.vue';

export default {
	components: {
		selectionModal
	},

	props: {
		cid: {
			type: String,
			default: ''
		}
	},

	data() {
		return {
			currentTaxonomy: 'category',
			keys: {
				type: 'taxonomy',
				title: 'term_title'
			},
			defaultProps: {
				title: 'Select Terms'
			}
		};
	},

	computed: {
		taxonomiesMenu() {
			return this.$store.getters.taxonomiesList.map(item => {
				return Object.assign({
					active: item.slug === this.currentTaxonomy ? true : false
				}, item);
			});
		},

		termsData() {
			return this.$store.getters.termsSelectionData(this.cid).terms;
		},

		paged() {
			return this.$store.getters.termsSelectionData(this.cid).currentPage;
		},

		totalPage() {
			return this.$store.getters.termsSelectionData(this.cid).totalPages;
		},

		orderby() {
			return this.$store.getters.termsSelectionData(this.cid).orderby;
		},

		order() {
			return this.$store.getters.termsSelectionData(this.cid).order;
		},
	},

	methods: {
		open(props = {}) {
			return this.$refs.modal.open(props);
		},

		updateData(params) {
			if (params.taxonomy)
				this.currentTaxonomy = params.taxonomy;

			this.$store.dispatch('getTermsSelectionData', { cid: this.cid, termsSelectionParams: params });
		}
	}
};
</script>