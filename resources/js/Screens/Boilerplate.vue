<template lang="">
    <div :class="`page-wrapper ${$isMobileWeb && mobileSideBar ? 'show-sidebar' : 'mini-sidebar'}`" id="main-wrapper" data-theme="blue_theme"  data-layout="vertical" :data-sidebartype="`${$isMobileWeb && mobileSideBar ? 'full' : !$isMobileWeb ? 'full' : 'mini-sidebar'}`" data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <Sidebar @onClose="closeSideBar" />
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <header class="app-header" v-if="$isMobileWeb"> 
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                        <a class="nav-link nav-icon-hover ms-n3" @click="showSideBar" href="javascript:void(0)">
                            <i class="ti ti-menu-2"></i>
                        </a>
                        </li>
                    </ul>
                    <a href="/" class="text-nowrap logo-img">
                        <img :src="`${$appDir}logo.png`" class="dark-logo" style="height:40px" />
                    </a>
                </nav>
            </header>
            <div class="container-fluid">
                
            </div>
        </div>
    </div>
</template>
<script>
import Sidebar from '../../Components/Sidebar.vue';
export default {
    components:{
      Sidebar
    },
    data() {
        return {
            mobileSideBar: false,
        }
    },
    methods: {
        showSideBar(){
            this.mobileSideBar = true;
        },
        closeSideBar(){
            this.mobileSideBar = false;
        }
    },
}
</script>
<style lang="">

</style>