<template>
	<modal :open="showSelectorModal"
	       :title="title"
	       :fullscreen="fullscreen"
	       :hideBodyScroll="hideBodyScroll"
	       :apply="applyText"
	       :close="closeText"
	       @apply="applyList()"
	       @close="cancelList()">
		<div class="psm-posts">
			<div class="psm-posts-sidebar">
				<menu-list :itemsData="menu"
				           @change="typeChange($event)" />
			</div>
			<div class="psm-posts-primary">
				<div class="psm-posts-top-panel">
					<div class="psm-posts-top-panel-left-side">
						<sortby :label="'Sort By:'"
						        :items="['Date','Title']"
						        :value="orderby"
						        :order="order"
						        @orderbyChange="orderbyChange($event.toLowerCase())"
						        @orderChange="orderChange($event)" />
					</div>
					<div class="psm-posts-top-panel-right-side">
						<div class="psm-search-form">
							<input class="psm-search-form-field"
							       :search="search"
							       @input="searchChange($event.target.value)" />
							<div class="psm-search-form-icon"></div>
						</div>
					</div>
				</div>
				<div class="psm-posts-list">
					<div class="psm-posts-list-item"
					     v-for="item in data"
					     :key="item.id">
						<item :data="item"
						      :titleKey="keys.title" />
					</div>
				</div>
			</div>
		</div>
		<pagination slot="footer"
		            :startPage="paged"
		            :totalPage="totalPage"
		            :withNextPrev="true"
		            @change="changePage($event)" />
	</modal>
</template>

<script>
	import { removeFromArray, clone } from 'includes/utility.js';

	import modal from 'modules/modal/modal.vue';
	import item from './components/list-item.vue';
	import menuList from './components/menu-list.vue';
	import sortby from './components/sortby.vue';
	import pagination from "modules/pagination/pagination.vue";

	let selectResolve,
		selectReject,
		smDefaultProps = {
			title: 'Select Posts',
			applyText: 'Select',
			closeText: 'Close',
			fullscreen: true,
			hideBodyScroll: true,
			singleSelection: false,
			disabled: [],
			selected: [],
			notIn: null
		};

	export default {
		components: {
			item,
			menuList,
			sortby,
			modal,
			pagination
		},

		props: {
			menu: {
				type: Array,
				required: true
			},
			data: {
				type: Array,
				required: true
			},
			paged: {
				type: Number,
				default: 1
			},
			totalPage: {
				type: Number,
				default: 1
			},
			orderby: {
				type: String,
				default: 'Date'
			},
			order: {
				type: String,
				default: 'desc'
			},
			search: {
				type: String,
				default: ''
			},
			keys: {
				type: Object,
				default: {
					type: 'post_type',
					title: 'post_title'
				}
			},
			defaultProps: {
				type: Object,
				required: false
			}
		},

		data() {
			return {
				//props data
				title: '',
				applyText: '',
				closeText: '',
				fullscreen: null,
				hideBodyScroll: null,
				singleSelection: null,
				disabled: [],
				selected: [],
				notIn: null,

				//modal data
				showSelectorModal: false,
				body: document.body,
				openClass: 'psm-open',

				// data
				requestParams: {},
				selectedItems: [],
			}
		},

		methods: {
			/*------------------------------
			 # Modal Methods
			-------------------------------*/
			open(props) {
				this.setProps(props);
				this.checkSelected();
				if (this.hideBodyScroll) this.body.classList.add(this.openClass);

				this.showSelectorModal = true;

				return new Promise(function (resolve, reject) {
					selectResolve = resolve;
					selectReject = reject;
				});
			},

			applyList() {
				selectResolve(clone(this.selectedItems));
				this.closeModal();
			},

			cancelList() {
				selectReject(clone(this.selectedItems));
				this.closeModal();
			},

			closeModal() {
				this.selectedItems = [];
				this.showSelectorModal = false;
			},

			/*------------------------------
			 # Data Methods
			-------------------------------*/
			getData() {
				this.$emit('getData', { ...this.requestParams });
			},

			typeChange(type) {
				this.requestParams[this.keys.type] = type.slug;
				this.requestParams.paged = 1;
				this.getData();
			},

			orderbyChange(orderby) {
				this.requestParams.orderby = orderby;
				this.requestParams.paged = 1;
				this.getData();
			},

			orderChange(order) {
				this.requestParams.order = order;
				this.requestParams.paged = 1;
				this.getData();
			},

			searchChange(search) {
				this.requestParams.search = search;
				this.requestParams.paged = 1;
				this.getData();
			},

			changePage(paged) {
				this.requestParams.paged = paged;
				this.getData();
			},

			addToSelected(item) {
				this.selectedItems.push(item);
			},

			removeFromSelected(item) {
				this.selectedItems.splice(
					this.selectedItems.findIndex(selectedItem => selectedItem.id === item.id),
					1
				);
			},

			clearSelected() {
				this.selectedItems.splice(
					0,
					this.selectedItems.length
				);
			},

			checkSelected() {
				[...this.selected].forEach(selectedId => {
					let selectedItem = this.data.find(item => {
						return item.id === selectedId;
					});

					if (selectedItem) {
						this.addToSelected(selectedItem);
						removeFromArray(this.selected, selectedItem.id)
					}
				});
			},

			setProps(newProps) {
				let smProps = Object.assign({}, smDefaultProps, this.defaultProps, newProps);

				for (var key in smProps)
					this[key] = smProps[key];
			}
		},
	}
</script>