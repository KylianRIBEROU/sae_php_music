/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./app/**/*.{html,php}"],
  theme: {
    colors : {
      'black':'#000101',
      'black-light':'#080909',
      'white':'#FEFFFE',
      'gray-dark':'#121313',
      'gray':'#222223',
      'gray-hover':'#1A1B1B',
      'gray-dark-hover':'#3E3E3E',
      'gray-light':'#A6A7A6',
      'purple':'#F61353',
      'purple2':'#F71352'
    },
    keyframes: {
      fadeIn: {
        '0%': { opacity: '0' },
        '100%': { opacity: '1' },
      },
      fadeOut: {
        '0%': { opacity: '1' },
        '100%': { opacity: '0' },
      },
      zoomIn: {
        '0%': { transform: 'scale(0)' },
        '100%': { transform: 'scale(1)' },
      },
      zoomOut: {
        '0%': { transform: 'scale(1)' },
        '100%': { transform: 'scale(0)' },
      },
    },
    animation: {
      'fade-in': 'fadeIn 150ms ease',
      'fade-out': 'fadeOut 150ms ease',
      'zoom-in': 'zoomIn 150ms ease',
      'zoom-out': 'zoomOut 150ms ease',
    },
    extend: {},
  },
  plugins: [],
}

