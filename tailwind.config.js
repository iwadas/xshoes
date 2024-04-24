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
      },
      zIndex: {
        '-1': '-1',
      },
    },
  },
  plugins: [],
}

