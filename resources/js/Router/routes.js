

const routes = [
    {
        name: "register",
        path: "/register",
        component: require("../components/Auth/Register.vue").default,
    },
    {
        name: "login",
        path: "/login",
        component: require("../components/Auth/Login.vue").default,
    },

    {
        name: "shop",
        path: "/shop",
        component: require("../components/Shop/TestShop.vue").default,
    },
    
];

export default routes;
