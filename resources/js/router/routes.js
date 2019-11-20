function page (path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [{
  path: '/',
  name: 'home',
  component: page('home.vue')
},
{
  path: '/login',
  name: 'login',
  component: page('auth/login.vue')
},
{
  path: '/register',
  name: 'register',
  component: page('auth/register.vue')
},
{
  path: '/password/reset',
  name: 'password.request',
  component: page('auth/password/email.vue')
},
{
  path: '/password/reset/:token',
  name: 'password.reset',
  component: page('auth/password/reset.vue')
},
{
  path: '/email/verify/:id',
  name: 'verification.verify',
  component: page('auth/verification/verify.vue')
},
{
  path: '/email/resend',
  name: 'verification.resend',
  component: page('auth/verification/resend.vue')
},
{
  path: '/account',
  component: page('account/index.vue'),
  children: [{
    path: '',
    redirect: {
      name: 'account.profile'
    }
  },
  {
    path: 'profile',
    name: 'account.profile',
    component: page('account/profile.vue')
  },
  {
    path: 'password',
    name: 'account.password',
    component: page('account/password.vue')
  },
  {
    path: 'email-settings',
    name: 'account.emailSettings',
    component: page('account/email-settings.vue')
  },
  {
    path: 'favourite-shops',
    name: 'account.favouriteShops',
    component: page('account/favourite-shops.vue')
  },
  {
    path: 'submit-a-code',
    name: 'account.submitACode',
    component: page('account/submit-a-code.vue')
  }
  ]
},
{
  path: '/admin',
  component: page('admin/index.vue'),
  children: [{
    path: '',
    redirect: {
      name: 'admin.dashboard'
    }
  },
  {
    path: 'dashboard',
    name: 'admin.dashboard',
    component: page('admin/dashboard.vue')
  },
  {
    path: 'retailers',
    name: 'admin.retailers',
    component: page('admin/retailers.vue')
  },
  {
    path: 'pages',
    name: 'admin.pages',
    component: page('admin/pages.vue')
  },
  {
    path: 'users',
    name: 'admin.users',
    component: page('admin/users.vue')
  },
  {
    path: 'feeds',
    name: 'admin.feeds',
    component: page('admin/feeds.vue')
  },
  {
    path: 'submissions',
    name: 'admin.submissions',
    component: page('admin/submissions.vue')
  },
  {
    path: 'categories',
    name: 'admin.categories',
    component: page('admin/categories.vue')
  },
  {
    path: 'messages',
    name: 'admin.messages',
    component: page('admin/messages.vue')
  },
  {
    path: 'password',
    name: 'admin.password',
    component: page('admin/password.vue')
  },
  {
    path: 'vouchers',
    name: 'admin.vouchers',
    component: page('admin/vouchers.vue')
  }
  ]
},
{
  path: '/contact',
  name: 'contact',
  component: page('contact.vue')
},
{
  path: '/students',
  name: 'students',
  component: page('students.vue')
},
{
  path: '/nhs-voucher-codes',
  name: 'nhs',
  component: page('nhs.vue')
},
{
  path: '/exclusive-deals',
  name: 'exclusive',
  component: page('exclusive.vue')
},
{
  path: '/faqs',
  name: 'faqs',
  component: page('faqs.vue')
},
{
  path: '/support',
  name: 'support',
  component: page('support.vue')
},
{
  path: '/top-20-voucher-codes',
  name: 'top-20',
  component: page('top-20.vue')
},
{
  path: '/retailers',
  name: 'retailers',
  component: page('retailers.vue')
},
{
  path: '/restaurants',
  name: 'restaurants',
  component: page('restaurants.vue')
},
{
  path: '/categories',
  name: 'categories',
  component: page('categories.vue')
},
{
  path: '/page',
  component: page('page/index.vue'),
  children: [{
    path: '',
    redirect: {
      name: 'page.main'
    }
  },
  {
    path: 'terms',
    name: 'page.terms',
    component: page('page/terms.vue')
  },
  {
    path: 'privacy',
    name: 'page.privacy',
    component: page('page/privacy.vue')
  },
  {
    path: 'cookies',
    name: 'page.cookies',
    component: page('page/cookies.vue')
  },
  {
    path: 'about',
    name: 'page.about',
    component: page('page/about.vue')
  }
  ]
},
{
  path: '/:slug',
  component: page('retailers/show.vue')
},
{
  path: '/cat/:slug',
  component: page('category.vue')
},
{
  path: '/retailers/:char',
  component: page('retailers.vue')
},
{
  path: '*',
  component: page('errors/404.vue')
}
]
