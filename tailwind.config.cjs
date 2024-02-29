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
      animation: {
        fade: 'fadeOut 3s ease-in-out',
      },
      keyframes: theme => ({
        fadeOut: {
          '0%': { backgroundColor: theme('colors.slate.700') },
          '100%': { backgroundColor: theme('colors.transparent') },
        },
      }),
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
