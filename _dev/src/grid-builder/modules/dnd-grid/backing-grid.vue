<template>
	<div class="backing-grid">
		<div class="backing-grid-row"
		     v-for="row in tableData">
			<div class="backing-grid-item"
			     v-for="column in row"
			     :style="itemStyle"></div>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'BackingGrid',
		props: {
			cellSize: {
				type: Object,
				required: true
			},
			rows: {
				type: Number,
				required: true
			},
			columns: {
				type: Number,
				required: true
			},
		},

		computed: {
			tableData() {
				const data = [];
				let index = 1;

				for (let i = 1; i <= this.rows; i++) {
					const row = [];

					for (let j = 1; j <= this.columns; j++) {
						row.push({
							id: index,
							position: {
								x: j,
								y: i
							}
						});

						index++;
					}

					data.push(row);
				}


				return data;
			},

			itemStyle() {
				const size = this.cellSize.w > 1 ? this.cellSize.w : 1;

				return {
					width: size + 'px',
					height: size + 'px'
				}
			},
		},

		mounted() {

		},

		methods: {

		}
	}
</script>