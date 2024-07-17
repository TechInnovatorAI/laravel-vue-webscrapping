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
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row" style="align-items: center;">
                                    <div class="col-6">
                                        <h5>
                                            Tournament Types
                                        </h5>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button class="btn btn-warning" @click="isEditing=true" v-if="!isEditing" style="float:right">Add New Tournament Type</button>
                                        <button class="btn btn-danger" @click="cancelEdit" v-if="isEditing" style="float:right">Cancel</button>
                                    </div>
                                </div>
                                <div v-if="isEditing" class="row mt-4">
                                    <div class="col-md-12 form-group mb-3">
                                        <label>Tournament Name</label>
                                        <input type="text" placeholder="Tournament Type" v-model="tournament.tournament_name" class="form-control">
                                        <small class="text-danger">{{ errors.tournament_name ? errors.tournament_name[0] : '' }}</small>
                                    </div>
                                    <div class="col-md-12 form-group mb-3">
                                        <button class="btn btn-success" @click="saveTournament" :disabled="isLoading">{{isLoading ? 'Saving...' : 'Save Tournament Type'}}</button>
                                    </div>
                                </div>
                                <div v-if="!isEditing" class="row mt-4">
                                    <div class="table-responsive rounded-2 mb-4">
                                        <table class="table border text-nowrap customize-table mb-0 align-middle">
                                            <thead>
                                                <tr>
                                                    <th>Sr. #</th>
                                                    <th>Name</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(tour, index) in tournaments" :key="tour.id">
                                                    <td>{{ index + 1 }}</td>
                                                    <td>{{ tour.tournament_name }}</td>
                                                    <td>
                                                        <a href="javascript:void(0)" @click="edit(tour)" class="link text-warning ms-2">
                                                            <i class="ti ti-pencil fs-4"></i>
                                                        </a>
                                                        <!-- <a href="javascript:void(0)" @click="deleteTournament(tour.id)" class="link text-danger ms-2">
                                                            <i class="ti ti-trash fs-4"></i>
                                                        </a> -->
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
            isEditing:false,
            tournaments:[],
            isLoading:false,
        }
    },
    methods: {
        getTournaments(){
            this.axios.get(`${this.$apiUrl}tournament/all`).then(response => {
                this.tournaments = response.data;
            });
        },
        saveTournament(){
            this.isLoading = true;
            this.errors = {};
            this.axios.post(`${this.$apiUrl}tournament/save`, this.tournament).then(response => {
                this.tournaments = response.data;
                this.tournament = {};
                this.isEditing = false;
                this.isLoading = false;
                this.noti("success", "Tournament saved sucessfully");
            }).catch(error => {
                this.errors = error.response.data.errors || {};
                this.noti("error", error.response.data.message);
                this.isLoading = false;
            });
        },
        deleteTournament(id){
            this.axios.get(`${this.$apiUrl}tournament/delete/${id}`).then(response => {
                this.tournaments = response.data;
                this.noti("success", "Tournament deleted sucessfully");
            });
        },
        edit(tournament){
            this.tournament = tournament;
            this.isEditing = true;
        },
        cancelEdit(){
            this.tournament = {};
            this.errors = {};
            this.isEditing = false;
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
        this.getTournaments();
    },
}
</script>
<style lang="">

</style>
