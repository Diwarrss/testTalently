import Vue from "vue";
import VueRouter from "vue-router";
import store from "../store";

Vue.use(VueRouter);

/* Guest Component */
const Login = () =>
  import(
    "../pages/Login" /* webpackChunkName: "resource/js/components/login" */
  );
const Register = () =>
  import(
    "../pages/Register" /* webpackChunkName: "resource/js/components/register" */
  );
/* Guest Component */

/* Layouts */
const KanbanBoardLayout = () =>
  import(
    "../Layouts/KanbanBoard" /* webpackChunkName: "resource/js/components/Layouts/dashboard" */
  );
/* Layouts */

/* Authenticated Component */
const KanbanBoard = () =>
  import(
    "../pages/KanbanBoard" /* webpackChunkName: "resource/js/components/dashboard" */
  );
/* Authenticated Component */

const Routes = [
  {
    name: "login",
    path: "/login",
    component: Login,
    meta: {
      middleware: "guest",
      title: `Login`,
    },
  },
  {
    name: "register",
    path: "/register",
    component: Register,
    meta: {
      middleware: "guest",
      title: `Register`,
    },
  },
  {
    path: "/",
    component: KanbanBoardLayout,
    meta: {
      middleware: "auth",
    },
    children: [
      {
        name: "kanbanboard",
        path: "/",
        component: KanbanBoard,
        meta: {
          title: `Kanban Board`,
        },
      },
    ],
  },
];

let router = new VueRouter({
  mode: "history",
  routes: Routes,
});

router.beforeEach((to, from, next) => {
  document.title = `${to.meta.title} - ${process.env.MIX_APP_NAME}`;
  if (to.meta.middleware === "guest") {
    if (store.state.auth.authenticated) {
      next({ name: "dashboard" });
    }
    next();
  } else {
    if (store.state.auth.authenticated) {
      next();
    } else {
      next({ name: "login" });
    }
  }
});

export default router;
