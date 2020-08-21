const path = require('path')
const webpack = require('webpack')

module.exports = {
	name: 'js_bundle',
	entry: {
		'js/admin.js': './src/includes/admin.js',
		'js/polyfills.js': './src/includes/polyfills.js',
		'js/editor.js': './src/editor/index.js',
		'js/posts-grid-builder-front.js': './src/widgets/posts-grid-builder/front/index.js',
		'js/posts-grid-builder-editor.js': './src/widgets/posts-grid-builder/editor/index.js',
		'js/terms-grid-builder-front.js': './src/widgets/terms-grid-builder/front/index.js',
		'js/terms-grid-builder-editor.js': './src/widgets/terms-grid-builder/editor/index.js'
	},
	output: {
		path: path.resolve(__dirname, '../assets'),
		filename: '[name]'
	},
	module: {
		rules: [{
			test: /\.css$/,
			use: [
				'vue-style-loader',
				'css-loader?url=false'
			],
		},
		{
			test: /\.scss$/,
			use: [
				'vue-style-loader',
				'css-loader',
				'sass-loader'
			],
		},
		{
			test: /\.vue$/,
			loader: 'vue-loader',
			options: {
				loaders: {
					'scss': [
						'vue-style-loader',
						'css-loader',
						'sass-loader',
						{
							loader: 'sass-resources-loader',
							options: {
								resources: [
									path.resolve(__dirname, '../assets/scss/_mixins.scss'),
									path.resolve(__dirname, '../assets/scss/_variables.scss'),
								]
							}
						}
					]
				}
			}
		},
		{
			test: /\.js$/,
			loader: 'babel-loader',
			exclude: /node_modules/
		},
		{
			test: /\.js$/,
			include: [
				path.resolve(__dirname, "./src/vendors")
			],
			use: ['script-loader']
		},
		{
			test: /\.(png|jpg|gif|svg)$/,
			loader: 'url-loader?limit=10000'
		}
		]
	},

	resolve: {
		modules: [
			path.resolve(__dirname, 'src'),
			'node_modules'
		],
		alias: {
			'vue$': 'vue/dist/vue.esm.js',
		},
		extensions: ['*', '.js', '.vue', '.json']
	},

	performance: {
		hints: false
	},

	devtool: '#eval-source-map'
}

if (process.env.NODE_ENV === 'production') {
	module.exports.devtool = '#source-map'
	module.exports.plugins = (module.exports.plugins || []).concat([
		new webpack.DefinePlugin({
			'process.env': {
				NODE_ENV: '"production"'
			}
		}),
		new webpack.optimize.UglifyJsPlugin({
			//sourceMap: true,
			compress: {
				warnings: false
			}
		}),
		new webpack.LoaderOptionsPlugin({
			minimize: true
		}),
	])
}