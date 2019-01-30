import VueRouter from 'vue-router';
import App from './components/App.vue';
import Dashboard from './components/views/DashboardComponent.vue';
import Profile from './components/views/profileComponent.vue';
import Users from './components/views/UsersComponent.vue';
import Roles from './components/views/RolesComponent.vue';
import Permission from './components/views/PermissionsComponent.vue';
import course from './components/views/CourseComponent.vue';
import AssistanceControl from './components/views/AssistanceControlComponent.vue';
import AssistanceControlForm from './components/forms/Form-assistance.vue';
import Company from './components/views/CompanyComponent.vue';
import Inscription from './components/forms/Form-course-students.vue';
import Notify from './components/views/NotificationComponent.vue';
import PayTeacher from './components/forms/Form-PayTeacher.vue';
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
			path: 'perfiles',
			name: 'rol.index',
			component: Roles,
		},
		{
			path: 'permisos',
			name: 'permission.index',
			component: Permission,
		},
		{
			path: 'empresas',
			name: 'company.index',
			component: Company,
		},
		{
			path: '*',
			component: NotFound,
		}
		]
	},
	{
		path: '/reportes/',
		component: {template: `<router-view></router-view>`},
		children: [
		{
			path: 'pago-de-profesores',
			name: 'report.pay_teacher',
			component: PayTeacher,
		}
		]
	},
	{
		path: '/gestion-de-cursos',
		name: 'courseManagement.index',
		component: course,
	},
	{
		path: '/inscripcion-a-cursos/:id',
		name: 'inscription.index',
		component: Inscription,
	},
	{
		path: '/control-de-asistencias',
		name: 'assistanceControl.index',
		component: AssistanceControl,
	},
	{
		path: '/control-de-asistencias/:id',
		name: 'assistanceControl.store',
		component: AssistanceControlForm,
	},
	{
		path: '/notificaciones',
		name: 'notify_s.index',
		component: Notify,
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
	if (location.href.indexOf('/login') > 0) return;
	if (location.href.indexOf('/registro') > 0) return;
	if (location.href.indexOf('/password') > 0) return;
	if (permission == undefined) {next('error'); return;}
	if (to.path.split('/')[1] == 'js' || to.path.split('/')[1] == 'css') {next('/'); return;}

	setTimeout(() => {
		if (to.path == '/') {
			if (this.a.app.can('courseManagement.index')) {
				next('/gestion-de-cursos');
			} else {
				next('/control-de-asistencias');
			}
			return;
		}
		if (this.a.app.can(permission)) {
			next(); return;
		} else if (permission.indexOf('-') != -1) {
			let split = permission.split('-');
			for(let i in split) {
				if (split[i].indexOf('.index') != -1) {
					if (this.a.app.can(split[i])) {next(); return; }
				} else {
					if (this.a.app.can(split[i] + '.index')) {next(); return; }
				}
			}
		}
		axios.post('/admin/app', { p: permission })
		.then(response => {
			if (response.data) {next(); return;}
			next(false);
		});
	}, 10);
});

router.afterEach((to, from, next) => {
	let breadcrumb = to.path.split('/').join(' > ');
	do {breadcrumb = breadcrumb.replace('-', ' ');} while(breadcrumb.indexOf('-') != -1);
	$('#breadcrumb').text(breadcrumb.toUpperCase());
	if (to.path == '/') $('#breadcrumb').text(' > Dashboard');
	setTimeout(function () {
		$('[data-tooltip="tooltip"]').tooltip();
	}, 1000);
});

export default router;