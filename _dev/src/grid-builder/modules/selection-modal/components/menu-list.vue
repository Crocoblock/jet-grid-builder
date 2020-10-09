<template>
	<ul class="psm_menu">
		<li class="psm_menu-item"
		    v-for="item in itemsData"
		    :key="item.id">
			<div class="psm_menu-btn"
			     :class="{active: item.active}"
			     :disabled="item.active"
			     @click="!item.active ? itemClick(item) : ''">{{item.title}}</div>
		</li>
	</ul>
</template>

<script>
	export default {
		props: {
			itemsData: {
				type: Array,
				required: true
			}
		},

		methods: {
			itemClick(item) {
				this.activeSlug = item.slug
				this.$emit('change', item);
			}
		},
	}
</script>