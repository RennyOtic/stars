<template>
    <ul class="list-unstyled full-box dashboard-sideBar-Menu"> <!-- SideBar Menu -->
        <li class="header text-center">Menú de Navegación</li>
        <li v-show="can(['user.index','rol.index','permission.index','company.index'])">
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
                        <i class="zmdi zmdi-shield-security zmdi-hc-fw"></i> Perfiles
                    </router-link>
                </li>
                <li v-if="can('permission.index')">
                    <router-link :to="{ name: 'permission.index' }">
                        <i class="zmdi-hc-fw glyphicon glyphicon-th"></i> Permisos
                    </router-link>
                </li>
                <li v-if="can('company.index')">
                    <router-link :to="{ name: 'company.index' }">
                        <i class="zmdi-hc-fw glyphicon glyphicon-home"></i> Empresas
                    </router-link>
                </li>
            </ul>
        </li>
        <li v-if="can('courseManagement.index')">
            <router-link :to="{ name: 'courseManagement.index' }">
                <i class="glyphicon glyphicon-blackboard zmdi-hc-fw"></i> Gestión de Cursos
            </router-link>
        </li>
        <li v-if="can('assistanceControl.index')">
            <router-link :to="{ name: 'assistanceControl.index' }">
                <i class="glyphicon glyphicon-list zmdi-hc-fw"></i> Control de Asistencia
            </router-link>
        </li>
        <li v-if="can('notify_s.index')">
            <router-link :to="{ name: 'notify_s.index' }">
                <i class="glyphicon glyphicon-exclamation-sign zmdi-hc-fw"></i> Solicitudes de Suspención
            </router-link>
        </li>
        <li v-show="can(['report.pay_teacher'])">
            <a href="#!" class="btn-sideBar-SubMenu">
                <i class="fa fa-laptop zmdi zmdi-hc-fw"></i> Reportes <i class="zmdi zmdi-caret-down pull-right"></i>
            </a>
            <ul class="list-unstyled full-box">
                <li v-if="can('report.pay_teacher')">
                    <router-link :to="{ name: 'report.pay_teacher' }">
                        <i class="fa fa-users zmdi zmdi-hc-fw"></i> Pago de profesor
                    </router-link>
                </li>
            </ul>
        </li>
    </ul>
</template>

<script>
    export default {}
</script>