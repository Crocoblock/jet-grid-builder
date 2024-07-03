<template>
	<div class="jgb_product-stars-rating"
		 v-if="ratingCount">
		<div class="jgb_product-stars-rating-star"
			 v-for="star in getStarsData()"
			 :class="`jgb_star-${star}`">
		</div>
	</div>
</template>

<script>
export default {
	data() {
		return {
			starsCount: 5,
			ratingCount: parseInt(this.$parent.itemData.woocommerce_rating_count),
			averageRating: parseFloat(this.$parent.itemData.woocommerce_average_rating)
		};
	},

	methods: {
		getStarsData() {
			let starsData = [];

			for (let index = 0; index < this.starsCount; index++) {
				let star = 'empty',
					starVal = Math.round((this.averageRating - index) * 100) / 100;

				if (starVal > 0.7) {
					star = 'full';
				} else if (starVal >= 0.3) {
					star = 'half';
				}

				starsData.push(star);
			}

			return starsData;
		}
	}
};
</script>