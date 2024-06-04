export default defineNuxtConfig({
  devtools: { enabled: true },
  ssr: false,
  components: [
    {
      path: "@/components/",
      pathPrefix: false,
    },
  ],
  modules: [
    "@nuxtjs/tailwindcss",
    "nuxt-primevue",
    "@vee-validate/nuxt",
    "nuxt-auth-sanctum"
  ],
  primevue: {
    cssLayerOrder: "tailwind-base, primevue, tailwind-utilities",
  },
  imports: {
    dirs: [
      "composables",
      "composables/*/index.{ts,js,mjs,mts}",
      "composables/**",
    ],
  },
  css: ["primevue/resources/themes/aura-light-noir/theme.css"],
  sanctum: {
    baseUrl: "http://localhost:50085",
    userStateKey: "sanctum.user.identity",
    redirectIfAuthenticated: false,
    endpoints: {
      csrf: "/sanctum/csrf-cookie",
      login: "/login",
      logout: "/logout",
      user: "/api/user",
    },
    client: {
      retry: false,
    },
    csrf: {
      cookie: "XSRF-TOKEN",
      header: "X-XSRF-TOKEN",
    },
    redirect: {
      keepRequestedRoute: false,
      onLogin: false,
      onLogout: false,
      onAuthOnly: false,
      onGuestOnly: "/login",
    },
    globalMiddleware: {
      enabled: false,
      allow404WithoutAuth: false,
    },
    logLevel: 3,
  },
});