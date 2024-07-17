import { createRouter, createWebHistory } from 'vue-router'

function guard(to, from, next, check) {
  let isAuthenticated = localStorage.getItem("token") && localStorage.getItem("user") ? true : false;
  if (check) {
    if (isAuthenticated) {
      next();
    } else {
      window.location.href = "/";
    }
  } else {
    if ((to.name === "register" || to.name === "login" || to.name === "VerifyEmail") && isAuthenticated)
      next({ name: "dashboard" });
    else next();
  }
}

const routes = [
  // Auth Routes
  {
    path: '/',
    name: 'login',
    component: () => import('./Screens/Auth/Login.vue'),
    beforeEnter: (to, from, next) => {
      guard(to, from, next, false);
    },
  },
  {
    path: '/forgot',
    name: 'forgot',
    component: () => import('./Screens/Auth/Forgot.vue'),
    beforeEnter: (to, from, next) => {
      guard(to, from, next, false);
    },
  },
  {
    path: '/register',
    name: 'register',
    component: () => import('./Screens/Auth/Signup.vue'),
    beforeEnter: (to, from, next) => {
      guard(to, from, next, false);
    },
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: () => import('./Screens/Scraper/Home.vue'),
    // beforeEnter: (to, from, next) => {
    //   guard(to, from, next, true);
    // },
  },
  {
    path: '/tournament-type',
    name: 'tournament-type',
    component: () => import('./Screens/Scraper/TournamentType.vue'),
    // beforeEnter: (to, from, next) => {
    //   guard(to, from, next, true);
    // },
  },
  {
    path: '/tournament-archive',
    name: 'tournament-archive',
    component: () => import('./Screens/Scraper/TournamentArchive.vue'),
    // beforeEnter: (to, from, next) => {
    //   guard(to, from, next, true);
    // },
  },
  {
    path: '/athlete-rankings',
    name: 'athlete-rankings',
    component: () => import('./Screens/Scraper/AthleteRankings.vue'),
    // beforeEnter: (to, from, next) => {
    //   guard(to, from, next, true);
    // },
  },
  {
    path: '/settings',
    name: 'settings',
    component: () => import('./Screens/Scraper/Settings.vue'),
    // beforeEnter: (to, from, next) => {
    //   guard(to, from, next, true);
    // },
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  linkActiveClass: "active-link"
})

export default router
