import { createRouter, createWebHistory } from "vue-router";

/* Guest Component */
import NotFound from "./components/NotFound.vue";
import Transaction from "./components/modules/transactions/index.vue";
import Description from "./components/modules/transactions/description.vue";
import Dashboard from "./components/modules/dashboard/index.vue";
import Domain from "./components/modules/domain/index.vue";
import Users from "./components/modules/users/index.vue";
import UserForm from "./components/modules/users/form.vue";
import Profile from "./components/modules/users/profile.vue";
import Roles from "./components/modules/roles/index.vue";
import RoleForm from "./components/modules/roles/form.vue";
import Dni from "./components/modules/dni/index.vue";
import Ip from "./components/modules/ip/index.vue";
import Logs from "./components/modules/logs/index.vue";
import Login from "./components/modules/auth/login.vue";
import Session from "./components/Session.vue";


function verifyAcces(to, from, next) {
    let authUser = JSON.parse(localStorage.getItem("authUser"));

    if (authUser) {
        let permissions = JSON.parse(localStorage.getItem("permissions"));
        if (permissions.includes(to.name)) {
            next();
        } else {
            let accessiblePermission = permissions.find((permission) =>
                routes.some((route) => route.name === permission)
            );
            if (accessiblePermission) {
                let accessibleRoute = routes.find(
                    (route) => route.name === accessiblePermission
                );
                next(accessibleRoute.path);
            } else {
                next("/error");
            }
        }
    } else {
        next("/login");
    }
}

const routes = [
    {
        path: "/",
        component: Dashboard,
        name: "dashboard.index",
        beforeEnter: (to, from, next) => {
            verifyAcces(to, from, next);
        },
    },
    {
        path: "/transactions",
        component: Transaction,
        name: "transactions.index",
        beforeEnter: (to, from, next) => {
            verifyAcces(to, from, next);
        },
    },
    {
        path: "/yape/business",
        component: Description,
        name: "yape.business",
        props: { description: 'Business', apiUrl: '/api/transactions/list?description=business' },
        beforeEnter: (to, from, next) => {
            verifyAcces(to, from, next);
        },
    },
    {
        path: "/yape/mulfood",
        component: Description,
        name: "yape.mulfood",
        props: { description: 'Mulfood', apiUrl: '/api/transactions/list?description=mulfood' },
        beforeEnter: (to, from, next) => {
            verifyAcces(to, from, next);
        },
    },
    {
        path: "/yape/teleservicios",
        component: Description,
        name: "yape.teleservicios",
        props: { description: 'Teleservicios', apiUrl: '/api/transactions/list?description=teleservicios' },
        beforeEnter: (to, from, next) => {
            verifyAcces(to, from, next);
        },
    },
    {
        path: "/yape/televentas",
        component: Description,
        name: "yape.televentas",
        props: { description: 'Televentas', apiUrl: '/api/transactions/list?description=televentas' },
        beforeEnter: (to, from, next) => {
            verifyAcces(to, from, next);
        },
    },
    {
        path: "/dni",
        component: Dni,
        name: "dni.index",
        beforeEnter: (to, from, next) => {
            verifyAcces(to, from, next);
        },
    },
    {
        path: "/domain",
        component: Domain,
        name: "domain.index",
        beforeEnter: (to, from, next) => {
            verifyAcces(to, from, next);
        },
    },
    {
        path: "/ip",
        component: Ip,
        name: "ip.index",
        beforeEnter: (to, from, next) => {
            verifyAcces(to, from, next);
        },
    },
    {
        path: "/logs",
        component: Logs,
        name: "logs.index",
        beforeEnter: (to, from, next) => {
            verifyAcces(to, from, next);
        },
    },
    {
        path: "/roles",
        component: Roles,
        name: "roles.index",
        beforeEnter: (to, from, next) => {
            verifyAcces(to, from, next);
        },
    },
    {
        path: "/roles/create",
        component: RoleForm,
        name: "roles.create",
        beforeEnter: (to, from, next) => {
            verifyAcces(to, from, next);
        },
    },
    {
        path: "/roles/edit/:roleId",
        component: RoleForm,
        name: "roles.edit",
        props: true,
        beforeEnter: (to, from, next) => {
            verifyAcces(to, from, next);
        },
    },
    {
        path: "/users",
        component: Users,
        name: "users.index",
        beforeEnter: (to, from, next) => {
            verifyAcces(to, from, next);
        },
    },
    {
        path: "/users/create",
        component: UserForm,
        name: "users.create",
        beforeEnter: (to, from, next) => {
            verifyAcces(to, from, next);
        },
    },
    {
        path: "/users/edit/:userId",
        component: UserForm,
        name: "users.edit",
        props: true,
        beforeEnter: (to, from, next) => {
            verifyAcces(to, from, next);
        },
    },
    {
        path: "/users/profile",
        component: Profile,
        name: "users.profile",
        beforeEnter: (to, from, next) => {
            verifyAcces(to, from, next);
        },
    },
    {
        path: "/login",
        component: Login,
        beforeEnter: (to, from, next) => {
            let authUser = JSON.parse(localStorage.getItem("authUser"));
            if (authUser) {
                next("/");
            } else {
                next();
            }
        },
    },
    {
        path: "/sessions",
        component: Session,
        name: "session.index"
    },
    { path: "/:pathMatch(.*)*", component: NotFound },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
