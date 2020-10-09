<template lang="html">
	<transition name="pagination">
		<div class="jgb_pagination"
		     v-if="show">
			<ul class="jgb_pagination-items">
				<li class="jgb_pagination-item"
				    v-if="withNextPrev">
					<div class="jgb_pagination-prev"
					     :class="{'jgb_disabled': disablePrev}"
					     @click="!disablePrev ? prevPage() : ''">
						<span class="jgb_pagination-prev-text"
						      v-if="prevText">{{ prevText }}</span>
					</div>
				</li>
				<li class="jgb_pagination-item"
				    v-for="n in pages"
				    :class="{active: n.active}">
					<div :class="{'jgb_pagination-page-link': !n.disable, 'jgb_pagination-gap': n.disable}"
					     @click="!n.disable && !n.active ? pageClick(n) : ''">{{ n.value }}</div>
				</li>
				<li class="jgb_pagination-item"
				    v-if="withNextPrev">
					<div class="jgb_pagination-next"
					     :class="{'jgb_disabled': disableNext}"
					     @click="!disableNext ? nextPage() : ''">
						<span class="jgb_pagination-next-text"
						      v-if="nextText">{{ nextText }}</span>
					</div>
				</li>
				<li class="jgb_pagination-item"
				    v-if="loadMoreText">
					<div class="jgb_pagination-more"
					     :class="{'jgb_disabled': disableNext}"
					     @click="!disableNext ? moreClick() : ''">{{ loadMoreText }}</div>
				</li>
			</ul>
		</div>
	</transition>
</template>

<script>
	export default {
		props: {
			totalPage: {
				type: Number,
				required: true
			},
			startPage: {
				type: Number,
				default: 1,
			},
			pageRange: {
				type: Number,
				default: 2,
			},
			withNextPrev: {
				type: Boolean,
				default: false
			},
			nextText: {
				type: String,
				default: '',
			},
			prevText: {
				type: String,
				default: '',
			},
			loadMoreText: {
				type: String,
				default: '',
			},
		},

		data() {
			return {
				show: true,
				currentPage: this.startPage,
				selectedPages: [],
				disableNext: false,
				disablePrev: false,
			}
		},

		computed: {
			pages() {
				let pages = [];

				if (!this.pageRange) {
					this.fillInterval(pages, 1, this.totalPage);
				}

				if (this.pageRange) {
					if (this.totalPage <= (this.pageRange * 2 + 2)) {
						this.fillInterval(pages, 1, this.totalPage);
					} else {
						if (this.currentPage < this.pageRange + 2) {
							this.fillInterval(pages, 1, this.pageRange * 2 + 1);
							this.addItem(pages, '...', true);
							this.addItem(pages, this.totalPage);
						} else if (this.currentPage > (this.totalPage - (this.pageRange + 1))) {
							this.addItem(pages, 1);
							this.addItem(pages, '...', true);
							this.fillInterval(pages, (this.totalPage - (this.pageRange * 2)), this.totalPage);
						} else {
							this.addItem(pages, 1);
							if (this.currentPage > this.pageRange + 2) {
								this.addItem(pages, '...', true);
							}
							this.fillInterval(pages, this.currentPage - this.pageRange, this.currentPage + this.pageRange);
							if (this.currentPage < (this.totalPage - (this.pageRange + 1))) {
								this.addItem(pages, '...', true);
							}
							this.addItem(pages, this.totalPage);
						}
					}
				}

				return pages;
			}
		},

		watch: {
			totalPage: {
				handler: function (val) {
					if (this.totalPage <= 1) {
						this.show = false;
					} else {
						this.show = true;
						this.prevNextCheck();
					}
				},
				immediate: true
			},
			startPage: function (val) {
				this.currentPage = val;
				this.prevNextCheck();
			}
		},

		methods: {
			pageClick(n) {
				this.currentPage = n.value;
				this.emitChanges();
			},
			nextPage() {
				this.currentPage++;
				this.emitChanges();
			},
			prevPage() {
				if (!this.selectedPages.length) {
					this.currentPage--;
				} else {
					this.currentPage = this.selectedPages[0] - 1;
				}
				this.emitChanges();
			},
			moreClick() {
				this.selectedPages.push(this.currentPage);
				this.currentPage++;
				this.$emit('more', this.currentPage);
				this.prevNextCheck();
			},
			emitChanges() {
				this.$emit('change', this.currentPage);
				this.clearSelected();
			},
			prevNextCheck() {
				this.disablePrev = this.currentPage === 1 || this.selectedPages[0] === 1 ? true : false;
				this.disableNext = this.currentPage === this.totalPage ? true : false;
			},
			clearSelected() {
				this.selectedPages = [];
				this.prevNextCheck();
			},
			fillInterval(array, start, end) {
				for (let index = start; index <= end; index++) {
					this.addItem(array, index);
				}
			},
			addItem(array, index, disable = false) {
				array.push({
					value: index,
					active: this.ifItemActive(index),
					disable: disable,
				});
			},
			ifItemActive(index) {
				let active = false;

				if (this.currentPage === index) {
					active = true;
				} else {
					if (this.selectedPages.length)
						active = this.selectedPages.includes(index);
				}

				return active;
			}
		}
	}
</script>