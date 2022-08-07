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
		counter: './src/counter.ts',
		converter: './src/converter.ts',
	},
	output: {
		filename: '[name].js',
		path: path.resolve(__dirname, '..', 'server', 'public', 'js'),
	},
};
