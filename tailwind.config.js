/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/js/**/*.vue',
    './resources/views/**/*.blade.php',
    // './storage/framework/views/*.php',
  ],
  theme: {
    extend: {
      scale:{
          '102': '1.02',
          '300': '3.00',
      },
      zIndex: {
        '-1': '-1',
      },
      backgroundColor: {
        'transparent-white': 'rgba(255,255,255,0.5)',
      },
    },
  },
  plugins: [],
}

