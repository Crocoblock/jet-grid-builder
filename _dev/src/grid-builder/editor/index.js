import store from '@/store';
import { postsSelectionModal, termsSelectionModal } from '@/grid-builder/modules/selection-modal';

(function ($) {

	"use strict";

	let postsSelectorDataInited = false,
		termsSelectorDataInited = false;

	// Posts Selector Data Init
	function initPostsSelectorData() {
		if (postsSelectorDataInited) {
			return;
		}

		store.dispatch('getPostTypes');
		store.dispatch('getPostsSelectionData');
		postsSelectorDataInited = true;
	}

	// Terms Selector Data Init
	function initTermsSelectorData() {
		if (termsSelectorDataInited) {
			return;
		}

		store.dispatch('getTaxonomies');
		store.dispatch('getTermsSelectionData');
		termsSelectorDataInited = true;
	}

	window.jgb = {};

	// Posts Selector Init Function
	window.jgb.initPostsSelector = () => {
		if (window.jgb.postsSelector)
			return;

		initPostsSelectorData();

		$('body').append('<div id="jgb-posts-selelector-modal"></div>');

		window.jgb.postsSelector = new Vue({
			store,
			el: '#jgb-posts-selelector-modal',
			methods: {
				open(props = {}) {
					return this.$refs.modal.open(props);
				}
			},
			render: h => h(postsSelectionModal, {
				props: {
					cid: 'posts-selelector-modal'
				},
				ref: 'modal'
			})
		});
	};

	// Terms Selector Init Function
	window.jgb.initTermsSelector = () => {
		if (window.jgb.termsSelector)
			return;

		initTermsSelectorData();

		$('body').append('<div id="jgb-terms-selelector-modal"></div>');

		window.jgb.termsSelector = new Vue({
			store,
			el: '#jgb-terms-selelector-modal',
			methods: {
				open(props = {}) {
					return this.$refs.modal.open(props);
				}
			},
			render: h => h(termsSelectionModal, {
				props: {
					cid: 'terms-selelector-modal'
				},
				ref: 'modal'
			})
		});
	};

}(jQuery));