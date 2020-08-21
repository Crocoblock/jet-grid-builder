<template>
	<div :class="classes"
	     :style="style"
	     ref="dragHandle">
		<slot></slot>
		<div class="resize-handle"
		     ref="resizeHandle"></div>
	</div>
</template>

<script>
	import * as utils from './utils'
	import { List as ContainerList } from './Container'

	export default {
		name: 'DndGridBox',
		props: {
			boxId: {
				required: true
			},
			dragSelector: {
				type: String,
				default: '*'
			}
		},
		data() {
			return {
				container: null,
				dragging: false,
				resizing: false,
				startMouseEvt: null,
				mouseEvt: null,
				scrollOffset: null
			}
		},
		computed: {
			style() {
				if (this.container && this.container.isBoxVisible(this.boxId)) {
					var pixelPosition = this.container.getPixelPositionById(this.boxId)
					return {
						display: 'block',
						width: pixelPosition.w + 'px',
						height: pixelPosition.h + 'px',
						transform: `translate(${pixelPosition.x}px, ${pixelPosition.y}px)`
					}
				}

				return {
					display: 'none'
				}
			},
			classes() {
				return {
					'jgb_grid-box': true,
					'dragging': this.dragging,
					'resizing': this.resizing
				}
			}
		},
		methods: {
			findContainer() {
				let current = this
				while (current.$parent) {
					current = current.$parent
					if (ContainerList.has(current)) {
						return current
					}
				}
				return null
			},
			getOffset(evt) {
				if (evt) this.mouseEvt = evt
				return {
					x: this.mouseEvt.clientX - this.startMouseEvt.clientX,
					y: this.mouseEvt.clientY - this.startMouseEvt.clientY + (window.pageYOffset - this.scrollOffset)
				}
			}
		},
		mounted() {
			this.container = this.findContainer()
			if (!this.container) {
				throw new Error('Can not find container')
			}

			// register component on parent
			this.container.registerBox(this)

			// moving
			this.$dragHandle = this.$el || this.$refs.dragHandle
			this.$dragHandle.addEventListener('mousedown', evt => {
				if (!utils.matchesSelector(evt.target, this.dragSelector)) {
					return
				}

				evt.preventDefault()

				this.dragging = true
				this.startMouseEvt = evt
				this.mouseEvt = evt
				this.scrollOffset = window.pageYOffset
				this.$emit('dragStart')

				const handleMouseUp = evt => {
					window.removeEventListener('mouseup', handleMouseUp, true)
					window.removeEventListener('mousemove', handleMouseMove, true)
					window.removeEventListener('scroll', handleScroll, true)

					this.dragging = false

					let offset = this.getOffset(evt)
					this.$emit('dragEnd', { offset })
				}

				const handleMouseMove = evt => {
					let offset = this.getOffset(evt)
					this.$emit('dragUpdate', { offset })
				}

				const handleScroll = () => {
					let offset = this.getOffset()
					this.$emit('dragUpdate', { offset })
				}

				window.addEventListener('mouseup', handleMouseUp, true)
				window.addEventListener('mousemove', handleMouseMove, true)
				window.addEventListener('scroll', handleScroll, true)
			})

			// resizing
			this.$resizeHandle = this.$refs.resizeHandle
			if (this.$resizeHandle) {
				this.$resizeHandle.addEventListener('mousedown', evt => {
					evt.preventDefault()
					evt.stopPropagation()

					this.resizing = true
					this.startMouseEvt = evt
					this.mouseEvt = evt
					this.scrollOffset = window.pageYOffset
					this.$emit('resizeStart')

					const handleMouseUp = evt => {
						window.removeEventListener('mouseup', handleMouseUp, true)
						window.removeEventListener('mousemove', handleMouseMove, true)
						window.removeEventListener('scroll', handleScroll, true)

						this.resizing = false

						let offset = this.getOffset(evt)
						this.$emit('resizeEnd', { offset })
					}

					const handleMouseMove = evt => {
						let offset = this.getOffset(evt)
						this.$emit('resizeUpdate', { offset })
					}

					const handleScroll = () => {
						let offset = this.getOffset()
						this.$emit('resizeUpdate', { offset })
					}

					window.addEventListener('mouseup', handleMouseUp, true)
					window.addEventListener('mousemove', handleMouseMove, true)
					window.addEventListener('scroll', handleScroll, true)
				})
			}
		},
		beforeDestroy() {
			// register component on parent
			if (this.container) {
				this.container.unregisterBox(this)
			}
		}
	}
</script>