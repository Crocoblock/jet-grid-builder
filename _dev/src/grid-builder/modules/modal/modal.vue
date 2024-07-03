<template>
	<transition name="jgb-modal-transition">
		<div class="jgb-modal"
			 :class="{ fullscreen: fullscreen }"
			 v-show="open">
			<div class="jgb-modal_wrapper">
				<div class="jgb-modal_container">
					<div class="jgb-modal_header">
						<h2 class="jgb-modal_header_title">{{ title }}</h2>
					</div>
					<div class="jgb-modal_body">
						<slot></slot>
					</div>
					<div class="jgb-modal_footer">
						<slot name="footer"></slot>
						<button class="jgb-modal_secondary"
								v-if="close"
								@click="$emit('close')">{{ close }}</button>
						<button class="jgb-modal_btn"
								v-if="apply"
								@click="$emit('apply')">{{ apply }}</button>
					</div>
				</div>
			</div>
		</div>
	</transition>
</template>

<script>
export default {
	props: {
		open: {
			type: Boolean,
			default: false
		},
		title: {
			type: String,
			required: true
		},
		hideBodyScroll: {
			type: Boolean,
			default: false
		},
		fullscreen: {
			type: Boolean,
			default: false
		},
		apply: {
			type: String
		},
		close: {
			type: String
		}
	},

	watch: {
		open: function () {
			if (this.hideBodyScroll) {
				this.open
					? this.body.classList.add(this.openClass)
					: this.body.classList.remove(this.openClass);
			}
		}
	},

	data() {
		return {
			body: document.body,
			openClass: 'jgb-modal-open'
		};
	},

	mounted() { },

	destroyed() { },
};
</script>