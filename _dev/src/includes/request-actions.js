export default {
	getPosts(params, callbackResolve, callbackReject = false) {
		const actionGetPosts = window.jgbSettings.api.endpoints.Posts;

		jQuery.get(actionGetPosts, params)
			.done(response => {
				callbackResolve(response);
			})
			.fail(error => {
				console.error(error);
				if (typeof callbackReject === 'function')
					callbackReject(error);
			});
	},

	getAllPostTypes(callbackResolve, callbackReject = false) {
		const actionGetPostTypes = window.jgbSettings.api.endpoints.PostTypes;

		jQuery.get(actionGetPostTypes, {})
			.done(response => {
				callbackResolve(response);
			})
			.fail(error => {
				console.error(error);
				if (typeof callbackReject === 'function')
					callbackReject(error);
			});
	},

	getTerms(params, callbackResolve, callbackReject = false) {
		const actionGetTaxonomyTerms = window.jgbSettings.api.endpoints.TaxonomyTerms;

		jQuery.get(actionGetTaxonomyTerms, params)
			.done(response => {
				callbackResolve(response);
			})
			.fail(error => {
				console.error(error);
				if (typeof callbackReject === 'function')
					callbackReject(error);
			});
	},

	getTaxonomies(callbackResolve, callbackReject = false) {
		const actionGetTaxonomies = window.jgbSettings.api.endpoints.Taxonomies;

		jQuery.get(actionGetTaxonomies, {})
			.done(response => {
				callbackResolve(response);
			})
			.fail(error => {
				console.error(error);
				if (typeof callbackReject === 'function')
					callbackReject(error);
			});
	},
};