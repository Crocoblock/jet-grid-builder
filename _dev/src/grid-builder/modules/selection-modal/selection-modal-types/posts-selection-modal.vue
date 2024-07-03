<template>
	<selection-modal class="jgb-modal-posts-selection"
					 :menu="postsMenu"
					 :data="postsData"
					 :paged="paged"
					 :totalPage="totalPage"
					 :orderby="orderby"
					 :order="order"
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
			currentPostType: 'post'
		};
	},

	computed: {
		postsMenu() {
			return this.$store.getters.postTypeList.map(item => {
				return Object.assign({
					active: item.slug === this.currentPostType ? true : false
				}, item);
			});
		},

		postsData() {
			return this.$store.getters.postsSelectionData(this.cid).posts;
		},

		paged() {
			return this.$store.getters.postsSelectionData(this.cid).currentPage;
		},

		totalPage() {
			return this.$store.getters.postsSelectionData(this.cid).totalPages;
		},

		orderby() {
			return this.$store.getters.postsSelectionData(this.cid).orderby;
		},

		order() {
			return this.$store.getters.postsSelectionData(this.cid).order;
		}
	},

	methods: {
		open(props = {}) {
			return this.$refs.modal.open(props);
		},

		updateData(params) {
			if (params.post_type)
				this.currentPostType = params.post_type;

			this.$store.dispatch('getPostsSelectionData', { cid: this.cid, postsSelectionParams: params });
		}
	}
};
</script>