<template>
	<div class="psm_sortby">
		<span class="psm_sortby-label"
			  v-if="label.length">{{ label }}</span>
		<div class="psm_sortby-dropdown"
			 :class="{ open: dropdownShow }">
			<div class="psm_sortby-dropdown-button"
				 @click="dropdownToggle($event)">{{ value }}</div>
			<div class="psm_sortby-dropdown-panel"
				 v-show="dropdownShow">
				<ul class="psm_sortby-dropdown-items-list">
					<li class="psm_sortby-dropdown-item"
						v-for="item in items"
						:class="item"
						@click="itemClick(item)">
						{{ item }}
					</li>
				</ul>
			</div>
		</div>
		<div class="psm_sortby-arrow-switch"
			 v-if="orderSwitch"
			 :class="'psm_sortby-arrow-switch-' + order"
			 @click="orderToggle"></div>
	</div>
</template>

<script>
export default {
	props: {
		items: {
			type: Array,
			required: true
		},
		value: {
			type: String,
			required: true
		},
		label: {
			type: String,
			default: ''
		},
		orderSwitch: {
			type: Boolean,
			default: true
		},
		order: {
			type: String,
			default: 'asc'
		}
	},

	data() {
		return {
			displayValue: this.value,
			dropdownShow: false
		};
	},

	created() {
		document.addEventListener('click', this.documentClick);
	},

	destroyed() {
		document.removeEventListener('click', this.documentClick);
	},

	methods: {
		documentClick(e) {
			if ((this.$el !== e.target) && !this.$el.contains(e.target)) {
				this.dropdownShow = false;
			}
		},
		dropdownToggle(e) {
			this.dropdownShow = !this.dropdownShow;
		},
		orderToggle() {
			this.$emit('orderChange', this.order === 'asc' ? 'desc' : 'asc');
		},
		itemClick(value) {
			this.$emit('orderbyChange', value);
			this.displayValue = value;
			this.dropdownShow = false;
		},
	}
};
</script>