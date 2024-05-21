const MiniCssExtractPlugin = require("mini-css-extract-plugin");

const path = require('path');

module.exports = {
    entry: './src/js/main.js',
    output: {
        path: path.resolve(__dirname, 'dist'),
        filename: './js/bundle.js'
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env']
                    }
                }
            },
            {
              test: /\.s[ac]ss$/i,
              exclude: /node_modules/,
              use: [
                  MiniCssExtractPlugin.loader,
                  "css-loader",
                  "sass-loader"
              ]
            },
            {
              test: /\.(woff|woff2|eot|ttf|otf|svg)$/,
              exclude: /node_modules/,
              // use: ['url-loader','file-loader'],
              type: 'asset/resource',
            }
        ]
    },
    plugins: [
      new MiniCssExtractPlugin({
        filename: './styles/styles.css',
      }),
    ],
};
