const { defineConfig } = require('@vue/cli-service');

module.exports = defineConfig({
	outputDir: '../assets',
	publicPath: './assets',
	filenameHashing: false,
	productionSourceMap: false,
	runtimeCompiler: true,
	css: {
		extract: false,
	},
	configureWebpack: {
		entry: {
			'admin': './src/includes/admin.js',
			'polyfills': './src/includes/polyfills.js',
			'editor': './src/grid-builder/editor/index.js',
			'widgets-grid-builder-editor': './src/widgets/index-editor.js',
			'widgets-grid-builder-front': './src/widgets/index-front.js',
			'blocks-grid-builder-editor': './src/blocks/index-editor.js',
			'blocks-grid-builder-front': './src/blocks/index-front.js'
		}
	},
	chainWebpack: config => {
		// Remove the standard entry point
		config.entryPoints.delete('app');

		config.performance
			.maxEntrypointSize(1000000)
			.maxAssetSize(1000000);
		config.optimization.delete('splitChunks');
		config.plugins.delete('html');
		config.plugins.delete('preload');
		config.plugins.delete('prefetch');
	}
});