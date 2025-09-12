// postcss.config.js
module.exports = {
  plugins: {
    'tailwindcss/nesting': {},
    tailwindcss: {
      config: {
        // O array 'content' do antigo config viria aqui dentro
        content: [
          './*.html',
          './*.php',
          './**/*.php',
          './**/**/*.js',
          './src/**/*.{js,ts}'
        ]
      }
    },
    '@tailwindcss/postcss': {},
    autoprefixer: {},
  },
}