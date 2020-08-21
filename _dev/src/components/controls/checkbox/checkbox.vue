<template>
	<div class="jgb_checkbox">
		<label class="jgb_checkbox-label">
			<input class="jgb_checkbox-input"
			       type="checkbox"
			       :checked="checked"
			       @change="handleChange">
			<div class="jgb_checkbox-checkmark"></div>
			<div class="jgb_checkbox-text">{{label}}</div>
		</label>
	</div>
</template>

<script>
	export default {
		props: {
			checked: {
				type: Boolean,
				default: false
			},
			label: {
				type: String,
				default: 'Label'
			}
		},

		methods: {
			handleChange(evt) {
				this.$emit('change', evt.target.checked);
			}
		}
	}
</script>