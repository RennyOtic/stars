<template>
	<div>
		<rs-sidebar :all="all"></rs-sidebar>

		<section class="full-box dashboard-contentPage"> <!-- Content page-->

			<rs-nav :all="all"></rs-nav>

			<div class="container-fluid"> <!-- Content page -->
				<div class="page-header">
					<h1 id="breadcrumb" class="text-titles"> <small>Tiles</small></h1>
				</div>
			</div>
			<div class="container-fluid">
				<div class="full-box rs">
					<router-view></router-view>
				</div>
			</div>

			<!-- <rs-footer :all="all.foot"></rs-footer> -->

		</section>

		<!-- <rs-notifications></rs-notifications> -->

	</div>
</template>

<style>
.container-fluid .page-header {margin: 15px;}
div.full-box.rs {margin-top: -35px;}
</style>

<script>
	import Header from './template/header.vue';
	import Sidebar from './template/sidebar.vue';
	// import Footer from './template/footer.vue';
	// import Notification from './template/notifications.vue';

	export default {
		components: {
			'rs-nav': Header,
			'rs-sidebar': Sidebar,
			// 'rs-footer': Footer,
			// 'rs-notifications': Notification
		},
		data() {
			return {
				title: '',
				all: {
					L: {Lg: '', Lm: ''},
					user: {fullName: '', logoPath: ''},
					foot: {y: '', credits: '', version: ''}
				}
			}
		},
		created() {
			axios.post('/app', {rs: 'ras'})
			.then(response => {
				this.all = response.data;
			});
		}
	}
</script>
