
let plugins = [];

if (process.env.APP_ENV === 'production') {
  plugins.push([
    require('@fullhuman/postcss-purgecss')({
      content: [
        './**/*.php',
        './**/*.js',
      ],
      defaultExtractor: content => content.match(/[A-Za-z0-9-_:/]+/g) || []
    })
  ]);
}

module.exports = {
  plugins: plugins,
}
