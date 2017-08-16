var path = require('path');
module.exports = {
    entry: "./assets/entry.js",
    output: {
        path: path.resolve(__dirname, 'assets'),
        filename: "bundle.js"
    },
    module: {
        rules: [{
            test: /\.js$/, // Run the loader on all .js files
            exclude: /node_modules/, // ignore all files in the node_modules folder
            use: 'jshint-loader'
        }]
    }
};