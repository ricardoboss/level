const path = require('path');

module.exports = {
	mode: 'development',
	devtool: 'inline-source-map',
	module: {
		rules: [
			{
				test: /\.tsx?$/,
				use: 'ts-loader',
				exclude: /node_modules/,
			},
		],
	},
	resolve: {
		extensions: ['.tsx', '.ts', '.js'],
	},
	entry: {
		framework: './src/framework.ts',
	},
	output: {
		filename: '[name].js',
		path: path.resolve(__dirname, '..', 'server', 'public', 'js'),
	},
};
