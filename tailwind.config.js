module.exports = {
  content: [
    './templates/**/*.twig',
    './assets/**/*.js',
    './src/**/*.php',
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('tailwindcss'),
    require('autoprefixer'),
  ],
};
