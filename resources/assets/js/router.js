import VueRouter from 'vue-router';
import App from './components/App.vue';
import Dashboard from './components/views/DashboardComponent.vue';
import Profile from './components/views/profileComponent.vue';
import Users from './components/views/UsersComponent.vue';
import Roles from './components/views/RolesComponent.vue';
import Permission from './components/views/PermissionsComponent.vue';
import courseManagement from './components/views/courseManagementsComponent.vue';
import NotFound from './components/views/NotFoundComponent.vue';

const router = new VueRouter({
	mode: 'history',
	hashbang: false,
	routes: [
	{
		path: '/',
		name: 'dashboard',
		component: Dashboard,
	},
	{
		path: '/perfil',
		name: 'profile',
		component: Profile,
	},
	{
		path: '/administracion/',
		component: {template: `<router-view></router-view>`},
		children: [
		{
			path: 'usuarios',
			name: 'user.index',
			component: Users,
		},
		{
			path: 'roles',
			name: 'rol.index',
			component: Roles,
		},
		{
			path: 'permisos',
			name: 'permission.index',
			component: Permission,
		},
		{
			path: '*',
			component: NotFound,
		}
		]
	},
	{
		path: '/gestion-de-cursos',
		name: 'courseManagement.index',
		component: courseManagement,
	},
	{ 
		path: '*', 
		name: 'error',
		component: NotFound
	}
	],
});

router.beforeEach((to, from, next) => {
	let permission = to.name;
	if (to.path == '/') {next(); return;}

	if (location.href.indexOf('/login') > 0) return;
	if (location.href.indexOf('/registro') > 0) return;

	if (permission == undefined) permission = 'error';
	axios.post('/admin/app', {p: permission})
	.then(response => {
		if (response.data) {next(); return;}
		next(false);
	});
});
router.afterEach((to, from, next) => {
	setTimeout(function () {
		$('[data-tool="tooltip"]').tooltip();
	}, 1000);
});

export default router;