const config = {
  target: "web",
  entry: path.join(__dirname, "src/index.js"),
  output: {
    filename: "[name].[chunkhas:8].js",
    path: path.join(__dirname, "dist"),
  },
  module: {
    rules: [
      {
        test: /\.vue$/,
        loader: "vue-loader",
      },
    ],
  },
};
