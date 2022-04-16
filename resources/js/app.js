require("./bootstrap");
import { createApp, } from "vue";

window.axios = require("axios");
axios.defaults.headers.common["Authorization"] =  "Bearer " + localStorage.getItem("test_token") || null;
axios.interceptors.request.use(
    (config) => {
        let token = localStorage.getItem("test_token") || null;
        if (token) config.headers["Authorization"] = `Bearer ${token}`;
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

import router from "./Router/index.js";

import App from "./App.vue";

const app = createApp({});

app.component("App", App).use(router).mount("#app");
