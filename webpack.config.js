const path = require(`path`);

module.exports = {
    entry: `./assets/index.js`,
    mode: "development",
    output: {
        filename: `main.js`,
        path: path.resolve(__dirname, `build/webpack`),
    },
};