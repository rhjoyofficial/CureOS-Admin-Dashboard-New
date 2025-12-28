import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            screens: {
                "8xl": "88rem",
                "9xl": "96rem",
                "10xl": "104rem",
            },
            maxWidth: {
                "8xl": "88rem",
                "9xl": "96rem",
                "10xl": "104rem",
            },
            fontFamily: {
                inter: ["Inter", ...defaultTheme.fontFamily.sans],
                bengali: [
                    '"Noto Sans Bengali"',
                    ...defaultTheme.fontFamily.sans,
                ],
            },
            colors: {
                primary: "#3e60d5",
                secondary: "#6c757d",
                success: "#47ad77",
                info: "#16a7e9",
                warning: "#ffc35a",
                danger: "#f15776",
                light: "#f2f2f7",
                dark: "#212529",
                "brand-yellow": "#FACC15", // Amber 400 equivalent
                "brand-blue": "#3B82F6", // Blue 500 equivalent
                "brand-space": "#0c4c6a",
            },
        },
    },

    plugins: [
        forms,
        function ({ addUtilities }) {
            addUtilities({
                ".no-scrollbar::-webkit-scrollbar": {
                    display: "none",
                },
                ".no-scrollbar": {
                    "-ms-overflow-style": "none",
                    "scrollbar-width": "none",
                },
            });
        },
    ],
};
