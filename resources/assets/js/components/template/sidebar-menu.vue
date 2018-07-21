<template>
    <ul class="list-unstyled full-box dashboard-sideBar-Menu"> <!-- SideBar Menu -->
        <li class="header text-center">Menú de Navegación</li>
        <li>
            <router-link :to="{ name: 'dashboard' }">
                <i class="zmdi zmdi-view-dashboard zmdi-hc-fw"></i> Dashboard
            </router-link>
        </li>
        <li v-show="can(['user.index','rol.index','permission.index'])">
            <a href="#!" class="btn-sideBar-SubMenu">
                <i class="fa fa-laptop zmdi zmdi-hc-fw"></i> Administración <i class="zmdi zmdi-caret-down pull-right"></i>
            </a>
            <ul class="list-unstyled full-box">
                <li v-if="can('user.index')">
                    <router-link :to="{ name: 'user.index' }">
                        <i class="fa fa-users zmdi zmdi-hc-fw"></i> Usuarios
                    </router-link>
                </li>
                <li v-if="can('rol.index')">
                    <router-link :to="{ name: 'rol.index' }">
                        <i class="zmdi zmdi-shield-security zmdi-hc-fw"></i> Roles
                    </router-link>
                </li>
                <li v-if="can('permission.index')">
                    <router-link :to="{ name: 'permission.index' }">
                        <i class="zmdi-hc-fw glyphicon glyphicon-th"></i> Permisos
                    </router-link>
                </li>
            </ul>
        </li>
        <li v-if="can('courseManagement.index')">
            <router-link :to="{ name: 'courseManagement.index' }">
                <i class="glyphicon glyphicon-blackboard zmdi zmdi-hc-fw"></i> Gestión de cursos
            </router-link>
        </li>
    </ul>
</template>

<script>
    export default {}
</script>