/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {},
  },
  plugins: [require("daisyui")],
  daisyui: {
    themes: [
      {
        'dark': {
          "primary": "#50fe87",
          "primary-focus": "#3DC367",
          "primary-content": "#ffffff",
          "secondary": "#73DDDD",
          "secondary-focus": "#51A7A7",
          "secondary-content": "#212121",
          "accent": "#eafe19",
          "accent-focus": "#B8C71B",
          "accent-content": "#212121",
          "neutral": "#2a2e37",
          "neutral-focus": "#16181d",
          "neutral-content": "#ffffff",
          "base": "#16181d",
          "base-100": "#212121",
          "base-200": "#2D2D2D",
          "base-300": "#353535",
          "base-content": "#ebecf0",
          "info": "#66c6ff",
          "success": "#87d039",
          "warning": "#e2d562",
          "error": "#ff6f6f"
        },
      },
      {
        'light': {
          "primary": "#212121",
          "primary-focus": "#000000",
          "primary-content": "#ffffff",
          "secondary": "#73DDDD",
          "secondary-focus": "#51A7A7",
          "secondary-content": "#212121",
          "accent": "#D0E017",
          "accent-focus": "#A7B41A",
          "accent-content": "#212121",
          "neutral": "#3d4451",
          "neutral-focus": "#2a2e37",
          "neutral-content": "#ffffff",
          "base-100": "#FFFFFF",
          "base-200": "#EEEEEE",
          "base-300": "#EAEAEA",
          "base-content": "#1f2937",
          "info": "#66c6ff",
          "success": "#87d039",
          "warning": "#e2d562",
          "error": "#ff6f6f"
        }
      }
    ]
}
}

