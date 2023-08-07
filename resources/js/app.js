import './bootstrap';

import { createApp, h } from 'vue';
import { createInertiaApp, Link, Head } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import Layout from "./Shared/Layout.vue";


createInertiaApp({
    progress: {
        enabled: true,
        delay: 250,
        color: '#29d',
        includeCSS: true,
        showSpinner: false,
    },

    resolve: async (name) => {
        const { default: page } = await resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue'));
        page.layout = page.layout || Layout;
        return page;
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });
        app.use(plugin);
        app.component('Link', Link);
        app.component('Head', Head),
        app.mount(el);
    },

    title: (title) => `My App - ${title}`,
});
