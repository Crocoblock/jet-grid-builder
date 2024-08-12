module.exports = {
	presets: [
		'@vue/cli-plugin-babel/preset'
	],
	plugins: [
		[
			"@babel/plugin-transform-react-jsx",
			{
				pragma: "wp.element.createElement"
			}
		]
	]
};
