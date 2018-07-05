<template>
	<div>
		<v-header :all="all"></v-header>
		<v-sidebar :all="all"></v-sidebar>

		<div class="content-wrapper">
			<!-- <section class="content-header"> -->
				<!-- <h1> -->
					<!-- @yield('page-title') -->
					<!-- <small>@yield('page-subtitle')</small> -->
				<!-- </h1> -->
				<!-- @yield('breadcrumbs') -->
			<!-- </section> -->

			<section class="content">
				<router-view></router-view>
			</section>
		</div>

		<v-footer :all="all.foot"></v-footer>

	</div>
</template>

<script>
	import Header from './template/header.vue';
	import Sidebar from './template/sidebar.vue';
	import Footer from './template/footer.vue';

	export default {
		components: {
			'v-header': Header,
			'v-sidebar': Sidebar,
			'v-footer': Footer,
		},
		data() {
			return {
				all: {
					L: {Lg: '', Lm: ''},
					user: {fullName: '', logoPath: ''},
					foot: {y: '', credits: '', version: ''}
				}
			}
		},
		updated: function () {
			$('ul.sidebar-menu.tree > li').unbind('click');
			$('ul.sidebar-menu.tree > li').click(function () {
				$('ul.sidebar-menu.tree > li').removeClass('active');
				$(this).addClass('active');
			});
		},
		methods: {},
		created() {
			axios.post('/app', {rs: 'ras'})
			.then(response => {
				this.all = response.data;
			});
		}
	}
</script>
