/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'selector',
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './resources/css/**/*.css',
    './src/**/*.php',
  ],
  theme: {
    extend: {},
  },
  plugins: [],
};
