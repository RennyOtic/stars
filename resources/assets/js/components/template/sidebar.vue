<template>
	<section class="full-box cover dashboard-sideBar"> <!-- SideBar -->
		<div class="full-box dashboard-sideBar-bg btn-menu-dashboard"></div>
		<div class="full-box dashboard-sideBar-ct">
			<div class="full-box text-uppercase text-center text-titles dashboard-sideBar-title"> <!--SideBar Title -->
				<router-link :to="{ path: '/'}" style="text-decoration: none" v-html="all.L.Lg"></router-link>
				<i class="zmdi zmdi-close btn-menu-dashboard visible-xs"></i>
			</div>
			<div class="full-box dashboard-sideBar-UserInfo"> <!-- SideBar User info -->
				<figure class="full-box">
					<img :src="all.user.logoPath" alt="UserIcon">
					<figcaption class="text-center text-titles"><b>{{ all.user.fullName }}</b></figcaption>
				</figure>
				<ul class="full-box list-unstyled text-center">
					<li>
						<router-link :to="{ name: 'profile'}" data-tooltip="tooltip" title="Ajustes">
							<i class="zmdi zmdi-settings"></i>
						</router-link>
					</li>
					<li>
						<a href="#" :to="{ path: '/'}" data-tooltip="tooltip" title="Salir" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
							<i class="zmdi zmdi-power"></i>
							<form id="logout-form" action="/logout" method="POST" style="display:none;">
								<input type="hidden" name="_token" :value="token">
							</form>
						</a>
					</li>
				</ul>
			</div>

			<rs-menu></rs-menu>

		</div>
	</section>
</template>

<script>
	import menu from './sidebar-menu.vue';

	export default {
		name: 'v-sidebar',
		props: ['all'],
		components: {
			'rs-menu': menu
		},
		data() {
			return {
				token: window.token.content
			}
		}
	}
</script>
