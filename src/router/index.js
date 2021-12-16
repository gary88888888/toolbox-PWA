import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import myTools from '../views/myTools.vue'
Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
    meta: {
      requiresAuth: true,
      index: 1,
      title: '彈性工具櫃智慧管理系統v1.0'

    }
  }, {
    path: '/login',
    name: 'Login',
    component: () => import('../views/login.vue'),
    meta: {
      index: 0,
      title: '彈性工具櫃智慧管理系統v1.0'
    }
  },

  {
    path: '/borrow',
    name: 'Borrow',
    component: () => import("../views/borrow.vue"),
    meta: {
      requiresAuth: true,
      index: 2,
      title: '借用登記'


    }
  },

  {
    path: '/myTools',
    name: 'myTools',
    component: myTools,
    meta: {
      requiresAuth: true,
      index: 2,
      title: '我的工具'


    }
  },
  {
    path: '/allTools',
    name: 'allTools',
    component: () => import("../views/allTools.vue"),
    meta: {
      requiresAuth: true,
      index: 2,
      title: '工具一覽'


    }
  },
  {
    path: '/report',
    name: 'report',
    component: () => import("../views/problemReport.vue"),
    meta: {
      requiresAuth: true,
      index: 2,
      title: '問題回報'


    }
  }, {
    path: '/history',
    name: 'history',
    component: () => import("../views/history.vue"),
    meta: {
      requiresAuth: true,
      index: 2,
      title: '紀錄查詢'


    }
  },


]

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});

router.beforeEach((to, from, next) => {
  router.from = from
  window.document.title = to.meta.title;
  if (to.matched.some(record => record.meta.requiresAuth)) {

    if (!localStorage.islogin) {
      next({
        name: "Login"
      });

    } else {
      next()

    }

  }
  else {
    next()
  }
})
export default router;
