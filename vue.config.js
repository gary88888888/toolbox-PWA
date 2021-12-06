module.exports = {
  publicPath: './',
  transpileDependencies: [
    'vuetify'
  ],
  devServer: {
    https: true
  },
  chainWebpack: config => {
    config.module.rules.delete('eslint');
}
}


