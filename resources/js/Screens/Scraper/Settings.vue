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
                                            {{show_ranking === 1 ? 'Official Rankings' : show_ranking == 2 ? 'Rankings 1' : 'Rankings 2'}}
                                            <button v-if="true || show_ranking > 1" @click="updateRankings" class="btn btn-warning btn-sm ml-5">Update {{show_ranking == 1 ? 'Official Rankings' : show_ranking == 2 ? 'Rankings 1' : 'Rankings 2'}}</button>
                                        </h5>
                                    </div>
                                    <div class="col-6 text-right">
                                        <div class="">
                                            <button @click="show_ranking = 1" :class="`btn btn-${ show_ranking == 1 ? 'warning' : 'primary' } btn-sm`">Official Rankings</button>
                                            <button @click="show_ranking = 2" :class="`btn btn-${ show_ranking == 2 ? 'warning' : 'primary' } btn-sm ml-5`">Rankings 1</button>
                                            <button @click="show_ranking = 3" :class="`btn btn-${ show_ranking == 3 ? 'warning' : 'primary' } btn-sm ml-5`">Rankings 2</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4" v-if="show_ranking === 1">
                                    <div class="table-responsive rounded-2 mb-4">
                                        <table class="table border text-nowrap customize-table mb-0 align-middle" style="font-size:10px">
                                            <thead>
                                                <tr>
                                                    <th>Tournament</th>
                                                    <th>Fattore</th>
                                                    <th>1 Posto</th>
                                                    <th>2 Posto</th>
                                                    <th>3 Posto</th>
                                                    <th>5 Posto</th>
                                                    <th>7 Posto</th>
                                                    <th>9 Posto</th>
                                                    <th>11 Posto</th>
                                                    <th>Finalisti Quarti</th>
                                                    <th>Non Ripescati</th>
                                                    <th>Incontri Vinti</th>
                                                    <th>Partecipazione</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(ranking, index) in rankings" :key="ranking.id">
                                                    <td>{{ ranking.tournament?.tournament_name }}</td>
                                                    <td>
                                                        <input v-if="true" class="w50" type="number" v-model="ranking.fattore" />
                                                        <span v-else>{{ ranking.fattore }}</span>
                                                    </td>
                                                    <td>
                                                        <input class="w50" v-if="true" type="number" v-model="ranking.posto_1" />
                                                        <span v-else>{{ ranking.posto_1 }}</span>
                                                    </td>
                                                    <td>
                                                        <input class="w50" v-if="true" type="number" v-model="ranking.posto_2" />
                                                        <span v-else>{{ ranking.posto_2 }}</span>
                                                    </td>
                                                    <td>
                                                        <input class="w50" v-if="true" type="number" v-model="ranking.posto_3" />
                                                        <span v-else>{{ ranking.posto_3 }}</span>
                                                    </td>
                                                    <td>
                                                        <input class="w50" v-if="true" type="number" v-model="ranking.posto_5" />
                                                        <span v-else>{{ ranking.posto_5 }}</span>
                                                    </td>
                                                    <td>
                                                        <input class="w50" v-if="true" type="number" v-model="ranking.posto_7" />
                                                        <span v-else>{{ ranking.posto_7 }}</span>
                                                    </td>
                                                    <td>
                                                        <input class="w50" v-if="true" type="number" v-model="ranking.posto_9" />
                                                        <span v-else>{{ ranking.posto_9 }}</span>
                                                    </td>
                                                    <td>
                                                        <input class="w50" v-if="true" type="number" v-model="ranking.posto_11" />
                                                        <span v-else>{{ ranking.posto_11 }}</span>
                                                    </td>
                                                    <td>
                                                        <input class="w50" v-if="true" type="number" v-model="ranking.finalist_quarti" />
                                                        <span v-else>{{ ranking.finalist_quarti }}</span>
                                                    </td>
                                                    <td>
                                                        <input class="w50" v-if="true" type="number" v-model="ranking.non_ripescati" />
                                                        <span v-else>{{ ranking.non_ripescati }}</span>
                                                    </td>
                                                    <td>
                                                        <input class="w50" v-if="true" type="number" v-model="ranking.incontri_vinti" />
                                                        <span v-else>{{ ranking.incontri_vinti }}</span>
                                                    </td>
                                                    <td>
                                                        <input class="w50" v-if="true" type="number" v-model="ranking.partecipazione" />
                                                        <span v-else>{{ ranking.partecipazione }}</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row mt-4" v-if="show_ranking === 2">
                                    <div class="table-responsive rounded-2 mb-4">
                                        <table class="table border text-nowrap customize-table mb-0 align-middle" style="font-size:10px">
                                            <thead>
                                                <tr>
                                                    <th>Tournament</th>
                                                    <th>Fattore</th>
                                                    <th>1 Posto</th>
                                                    <th>2 Posto</th>
                                                    <th>3 Posto</th>
                                                    <th>5 Posto</th>
                                                    <th>7 Posto</th>
                                                    <th>9 Posto</th>
                                                    <th>11 Posto</th>
                                                    <th>Finalisti Quarti</th>
                                                    <th>Non Ripescati</th>
                                                    <th>Incontri Vinti</th>
                                                    <th>Partecipazione</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(ranking, index) in rankings1" :key="ranking.id">
                                                    <td>{{ ranking.tournament?.tournament_name }}</td>
                                                    <td>
                                                        <input class="w50" type="number" v-model="ranking.fattore" />
                                                    </td>
                                                    <td>
                                                        <input class="w50" type="number" v-model="ranking.posto_1" />
                                                    </td>
                                                    <td>
                                                        <input class="w50" type="number" v-model="ranking.posto_2" />
                                                    </td>
                                                    <td>
                                                        <input class="w50" type="number" v-model="ranking.posto_3" />
                                                    </td>
                                                    <td>
                                                        <input class="w50" type="number" v-model="ranking.posto_5" />
                                                    </td>
                                                    <td>
                                                        <input class="w50" type="number" v-model="ranking.posto_7" />
                                                    </td>
                                                    <td>
                                                        <input class="w50" type="number" v-model="ranking.posto_9" />
                                                    </td>
                                                    <td>
                                                        <input class="w50" type="number" v-model="ranking.posto_11" />
                                                    </td>
                                                    <td>
                                                        <input class="w50" type="number" v-model="ranking.finalist_quarti" />
                                                    </td>
                                                    <td>
                                                        <input class="w50" type="number" v-model="ranking.non_ripescati" />
                                                    </td>
                                                    <td>
                                                        <input class="w50" type="number" v-model="ranking.incontri_vinti" />
                                                    </td>
                                                    <td>
                                                        <input class="w50" type="number" v-model="ranking.partecipazione" />
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row mt-4" v-if="show_ranking === 3">
                                    <div class="table-responsive rounded-2 mb-4">
                                        <table class="table border text-nowrap customize-table mb-0 align-middle" style="font-size:10px">
                                            <thead>
                                                <tr>
                                                    <th>Tournament</th>
                                                    <th>Fattore</th>
                                                    <th>1 Posto</th>
                                                    <th>2 Posto</th>
                                                    <th>3 Posto</th>
                                                    <th>5 Posto</th>
                                                    <th>7 Posto</th>
                                                    <th>9 Posto</th>
                                                    <th>11 Posto</th>
                                                    <th>Finalisti Quarti</th>
                                                    <th>Non Ripescati</th>
                                                    <th>Incontri Vinti</th>
                                                    <th>Partecipazione</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(ranking, index) in rankings2" :key="ranking.id">
                                                    <td>{{ ranking.tournament?.tournament_name }}</td>
                                                    <td>
                                                        <input class="w50" type="number" v-model="ranking.fattore" />
                                                    </td>
                                                    <td>
                                                        <input class="w50" type="number" v-model="ranking.posto_1" />
                                                    </td>
                                                    <td>
                                                        <input class="w50" type="number" v-model="ranking.posto_2" />
                                                    </td>
                                                    <td>
                                                        <input class="w50" type="number" v-model="ranking.posto_3" />
                                                    </td>
                                                    <td>
                                                        <input class="w50" type="number" v-model="ranking.posto_5" />
                                                    </td>
                                                    <td>
                                                        <input class="w50" type="number" v-model="ranking.posto_7" />
                                                    </td>
                                                    <td>
                                                        <input class="w50" type="number" v-model="ranking.posto_9" />
                                                    </td>
                                                    <td>
                                                        <input class="w50" type="number" v-model="ranking.posto_11" />
                                                    </td>
                                                    <td>
                                                        <input class="w50" type="number" v-model="ranking.finalist_quarti" />
                                                    </td>
                                                    <td>
                                                        <input class="w50" type="number" v-model="ranking.non_ripescati" />
                                                    </td>
                                                    <td>
                                                        <input class="w50" type="number" v-model="ranking.incontri_vinti" />
                                                    </td>
                                                    <td>
                                                        <input class="w50" type="number" v-model="ranking.partecipazione" />
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
            rankings:[],
            rankings1:[],
            rankings2:[],
            show_ranking:1,
            isLoading:false,
        }
    },
    methods: {
        getRankings(){
            this.axios.get(`${this.$apiUrl}official-rankings`).then(response => {
                this.rankings = response.data.rankings;
                this.rankings1 = response.data.rankings1;
                this.rankings2 = response.data.rankings2;
            })
        },
        updateRankings(){
            this.isLoading = true;
            let ranks = [];
            if(this.show_ranking == 1){
                ranks = this.rankings;
            }else if(this.show_ranking == 2){
                ranks = this.rankings1;
            }else if(this.show_ranking == 3){
                ranks = this.rankings2;
            }
            let toUpdate = this.show_ranking;
            let data = {
                "rankings": ranks,
                "update": toUpdate,
            }
            this.axios.post(`${this.$apiUrl}rankings/update`, data).then(response => {
                this.getRankings();
                this.noti("success", response.data.message);
                console.log("msg", response.data.message);
                this.isLoading = false;
            }).catch(error => {
                this.noti("error", error.response.data.message);
                this.isLoading = false;
            });
        },
        showSideBar(){
            this.mobileSideBar = true;
        },
        closeSideBar(){
            this.mobileSideBar = false;
        }
    },
    created() {
        // this.checkLog();
        this.getRankings();

    },
}
</script>
<style>
    .w50{
        width: 40px;
    }
    .ml-5{
        margin-left: 5px;
    }
    .text-right{
        text-align: right;
    }
</style>
