module.exports = {
  content: [
    './src/**/*.js',
    './app/**/*.latte'
  ],
  theme: {
    container: {
      center: true,
    },
    screens: {
      sm: '480px',
      md: '768px',
      lg: '976px',
      xl: '1440px',
    },
    extend: {
      container: {
        center: true,
        screens: {
          lg: '800px',
          xl: '800px',
        },
      },
    },
  },
  plugins: [],
}
