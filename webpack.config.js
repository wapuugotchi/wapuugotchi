const path = require('path')

module.exports = {
    mode: "development",
    entry: "/src/index.js", // main js
    output: {
        path: __dirname,
        filename: "./dist/bundle.js"
    },
    devServer: {
        static: __dirname + "/src",
        //contentBase: path.resolve(__dirname, 'dist'),
        open: true,
        port: 9001
    },
    module: {
        rules: [
            {
                test: /\.(jsx|js)$/,
                include: path.resolve(__dirname, 'src'),
                exclude: /node_modules/,
                use: [{
                    loader: 'babel-loader',
                    options: {
                        presets: [
                            ['@babel/preset-env', {
                                "targets": "defaults"
                            }],
                            '@babel/preset-react'
                        ]
                    }
                }]
            }, {
                test: /\.css$/,
                use: [
                    'style-loader',
                    'css-loader'
                ]
            }
        ]
    }
}