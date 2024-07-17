<template>
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row" style="align-items: center;">
                                    <div class="col-6">
                                        <h5>
                                            Tournament Archives
                                        </h5>
                                    </div>

                                </div>

                                <div class="row mt-4">
                                    <div class="table-responsive rounded-2 mb-4">
                                        <table class="table border text-nowrap customize-table mb-0 align-middle">
                                            <thead>
                                                <tr>
                                                    <th>Sr. #</th>
                                                    <th>Tournament id</th>
                                                    <th>Tournament Name</th>
                                                    <th>Tournament Type</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(archive, index) in archives" :key="archive.id">
                                                    <td>{{ index + 1 }}</td>
                                                    <td>{{ archive.tournament_id }}</td>
                                                    <td>{{ archive.tournament_name }}</td>
                                                    <td>{{ archive.tournaments.tournament_name }}</td>
                                                    <td>
                                                        <a href="javascript:void(0)" @click="deleteArchive(archive.tournament_id)" class="link text-danger ms-2">
                                                            <i class="ti ti-trash fs-4"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
            tournament:{},
            errors:{},
            archives:[],
        }
    },
    methods: {
        getArchives(){
            this.axios.get(`${this.$apiUrl}tournament/archive`).then(response => {
                this.archives = response.data;
            });
        },

        deleteArchive(id){
            this.axios.get(`${this.$apiUrl}tournament/archive/delete/${id}`).then(response => {
                this.archives = response.data;
                this.noti("success", "Tournament deleted sucessfully");
                this.getArchives();
            });
                    // this.$router.push('/tournament/archive');
        },
        showSideBar(){
            this.mobileSideBar = true;
        },
        closeSideBar(){
            this.mobileSideBar = false;
        }
    },
    created() {
        this.checkLog();
        this.getArchives();
    },
}
</script>
