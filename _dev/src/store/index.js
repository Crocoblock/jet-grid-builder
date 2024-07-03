import Vuex from 'vuex';
import request from '@/includes/request-actions';

Vue.use(Vuex);

let store = new Vuex.Store({
	state: {
		postsSelectionData: {
			default: {}
		},
		postTypeList: [],
		termsSelectionData: {
			default: {}
		},
		taxonomiesList: []
	},

	getters: {
		postsSelectionData: state => (id = false) => {
			return state.postsSelectionData[id] || state.postsSelectionData.default;
		},
		postTypeList(state) {
			return state.postTypeList;
		},
		termsSelectionData: state => (id = false) => {
			return state.termsSelectionData[id] || state.termsSelectionData.default;
		},
		taxonomiesList(state) {
			return state.taxonomiesList;
		}
	},

	mutations: {
		updateState(state, {
			type,
			newData
		}) {
			state[type] = newData;
		},
		updateStateObject(state, {
			type,
			newData,
			cid
		}) {
			let stateClone = Object.assign({}, state[type]),
				newObject = {};

			newObject[cid || 'default'] = newData;
			state[type] = Object.assign(stateClone, newObject);
		}
	},

	actions: {
		getPostsSelectionData({ commit }, { cid, postsSelectionParams } = { cid: false, postsSelectionParams: {} }) {
			let postType = postsSelectionParams.post_type || 'post',
				orderby = postsSelectionParams.orderby || 'date',
				order = postsSelectionParams.order || 'desc',
				search = postsSelectionParams.search || '';

			postsSelectionParams.posts_per_page = 60;

			return new Promise((resolve) => {
				request.getPosts(
					postsSelectionParams,
					response => {
						let data = {
							posts: response.posts,
							currentPage: parseInt(response.page),
							totalPages: parseInt(response.pages),
							postType,
							orderby,
							order,
							search
						};

						commit('updateStateObject', {
							type: 'postsSelectionData',
							newData: data,
							cid
						});

						resolve(response);
					}
				);
			});
		},
		getPostTypes({
			commit
		}) {
			request.getAllPostTypes(
				response => {
					let postTypesData = response.post_types,
						formattedPostTypesData = [];

					for (var key in postTypesData) {
						let postType = postTypesData[key];

						formattedPostTypesData.push({
							title: postType.label,
							slug: postType.slug
						});
					}

					commit('updateState', {
						type: 'postTypeList',
						newData: formattedPostTypesData
					});
				}
			);
		},
		getTermsSelectionData({ commit }, { cid, termsSelectionParams } = { cid: false, termsSelectionParams: {} }) {
			let taxonomy = termsSelectionParams.taxonomy || 'category',
				orderby = termsSelectionParams.orderby || 'date',
				order = termsSelectionParams.order || 'desc',
				search = termsSelectionParams.search || '';

			termsSelectionParams.number = 60;

			return new Promise((resolve) => {
				request.getTerms(
					termsSelectionParams,
					response => {
						let data = {
							terms: response.terms,
							currentPage: parseInt(response.page),
							totalPages: parseInt(response.pages),
							taxonomy,
							orderby,
							order,
							search
						};

						commit('updateStateObject', {
							type: 'termsSelectionData',
							newData: data,
							cid
						});

						resolve(response);
					}
				);
			});
		},
		getTaxonomies({
			commit
		}) {
			request.getTaxonomies(
				response => {
					let taxonomiesData = response.taxonomies,
						formattedTaxonomiesData = [];

					for (var key in taxonomiesData) {
						let taxonomy = taxonomiesData[key];

						formattedTaxonomiesData.push({
							title: taxonomy.label,
							slug: taxonomy.slug
						});
					}

					commit('updateState', {
						type: 'taxonomiesList',
						newData: formattedTaxonomiesData
					});
				}
			);
		}
	}
});

export default store;