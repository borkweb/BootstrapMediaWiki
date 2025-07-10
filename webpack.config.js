const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');

module.exports = {
	entry: {
		// Main stylesheet entry point
		style: './resources/main.scss'
	},
	output: {
		path: path.resolve(__dirname),
		filename: '[name].js', // We'll delete the JS files since we only need CSS
	},
	module: {
		rules: [
			{
				test: /\.s[ac]ss$/i,
				use: [
					MiniCssExtractPlugin.loader,
					'css-loader',
					{
						loader: 'sass-loader',
						options: {
							sassOptions: {
								includePaths: [path.resolve(__dirname, 'resources')],
							},
						},
					},
				],
			},
			{
				test: /\.css$/i,
				use: [MiniCssExtractPlugin.loader, 'css-loader'],
			},
		],
	},
	plugins: [
		new MiniCssExtractPlugin({
			filename: 'style.css',
		}),
	],
	optimization: {
		minimizer: [
			`...`, // Keep default minimizers
			new CssMinimizerPlugin(),
		],
	},
	// Since we're only building CSS, we can ignore the JS output
	externals: {
		// Prevent webpack from bundling these
		jquery: 'jQuery',
	},
};