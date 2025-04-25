const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', component: () => import('pages/IndexPage.vue'), },
      { path: '/profile', component: () => import('pages/ProfilePage.vue'), },
      { path: '/post-product', component: () => import('pages/AddProductPage.vue'), },
      { path: '/product/:id', component: () => import('pages/ProductDetail.vue'), },
      { path: '/paid/:id', component: () => import('pages/PayPage.vue'), },
      { path: '/history/:type', component: () => import('pages/HistoryPage.vue') },
      { path: '/posted-products', component: () => import('pages/ProductHistoryPage.vue'), },
    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
]

export default routes
