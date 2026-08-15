import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/css/login.css",
                "resources/css/news-form.css",
                "resources/css/otp-verify.css",
                "resources/css/layout.css",
                "resources/css/new.css",
                "resources/css/new-show.css",
                "resources/css/quote-form.css",
                "resources/css/quote.css",
                "resources/js/app.js",
                "resources/js/admins/news-form.js", // <-- Chemin corrigé !
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ["**/storage/framework/views/**"],
        },
    },
});
