routes = [
  {
    path: '/',
    url: 'index.php',
    master: true,
    // detail routes
    detailRoutes: [
      {
        path: '/detail/:id',
        url: 'detail.php',
      }
    ]
  },
  // Default route (404 page). MUST BE THE LAST
  {
    path: '(.*)',
    url: 'pages/404.html',
  },
];
