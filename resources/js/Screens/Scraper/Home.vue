<template lang="">
    <div
        :class="`page-wrapper ${
            $isMobileWeb && mobileSideBar ? 'show-sidebar' : 'mini-sidebar'
        }`"
        id="main-wrapper"
        data-theme="blue_theme"
        data-layout="vertical"
        :data-sidebartype="`${
            $isMobileWeb && mobileSideBar
                ? 'full'
                : !$isMobileWeb
                ? 'full'
                : 'mini-sidebar'
        }`"
        data-sidebar-position="fixed"
        data-header-position="fixed"
    >
        <!-- Sidebar Start -->
        <Sidebar @onClose="closeSideBar" />
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <header class="app-header" v-if="$isMobileWeb">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a
                                class="nav-link nav-icon-hover ms-n3"
                                @click="showSideBar"
                                href="javascript:void(0)"
                            >
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                    </ul>
                    <a href="/" class="text-nowrap logo-img">
                        <img
                            :src="`${$appDir}logo.png`"
                            class="dark-logo"
                            style="height: 40px"
                        />
                    </a>
                </nav>
            </header>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="mb-3">Scrape Tournament</h5>
                                <form>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model="formdata.t_id"
                                                    readonly

                                                />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    placeholder="Enter Name"
                                                    v-model="formdata.name"
                                                />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <select
                                                    class="form-control"
                                                    v-model="formdata.type"
                                                >
                                                    <option
                                                        value=""
                                                        selected
                                                        disabled
                                                    >
                                                        Select Tournament Type
                                                    </option>
                                                    <option
                                                        v-for="tour in tournaments"
                                                        :key="tour.id"
                                                        v-bind:value="tour.id"
                                                    >
                                                        {{
                                                            tour.tournament_name
                                                        }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div
                                            class="col-md-12"
                                            v-if="
                                                formdata.type === 11 || formdata.type === 8
                                            "
                                        >
                                            <div class="form-group mb-3">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    placeholder="Enter Fattore"
                                                    v-model="
                                                        formdata.fattore
                                                    "
                                                />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    placeholder="Enter URL"
                                                    v-model="formdata.url"
                                                />
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button
                                                class="btn btn-warning"
                                                @click.prevent="postData"
                                                :disabled="loading"
                                            >
                                                {{
                                                    loading
                                                        ? "Scraping data..."
                                                        : "Scrape Data"
                                                }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Sidebar from "../../Components/Sidebar.vue";
import Error from "../../Components/Error.vue";
export default {
    components: {
        Sidebar,
        Error,
    },

    data() {
        return {
            mobileSideBar: false,
            formdata: {
                t_id: "",
                type: "",
                url: "",
                name: "",
                fattore: "",
            },
            error: {},
            loading: false,
            tournaments: [],
        };
    },
    methods: {
        getTournaments() {
            console.log("project running test")
            this.axios.get(`${this.$apiUrl}tournament/all`).then((response) => {
                this.tournaments = response.data;
                // console.log("")
            });
        },
        showSideBar() {
            this.mobileSideBar = true;
        },
        closeSideBar() {
            this.mobileSideBar = false;
        },
        divideArrayIntoParts(array, noOfParts) {
            // Check if noOfParts is valid
            if (noOfParts < 1) {
                console.log("Number of parts must be at least 1.");
                return [];
            }

            // Calculate the size of each part
            const partSize = Math.ceil(array.length / noOfParts);
            const parts = Array.from({ length: noOfParts }, () => []); // Initialize arrays to hold the parts dynamically

            // Function to get first and last items of a part
            const getFirstAndLast = (arr) => {
                if (arr.length === 0) return [];
                if (arr.length === 1) return [arr[0]];
                return [arr[0], arr[arr.length - 1]];
            };

            // Distribute the objects into the parts
            for (let i = 0; i < array.length; i++) {
                const partIndex = Math.floor(i / partSize);
                if (partIndex < noOfParts) { // Ensure we don't exceed the bounds
                    parts[partIndex].push(array[i]);
                }
            }

            // Map each part to only contain the first and last item
            const result = parts.map(part => getFirstAndLast(part));

            return result;
        },
        async postData() {
            this.loading = true;
            try {
                const response = await this.axios.post(`${this.$apiUrl}scrape`, this.formdata);
                let links = response.data.links;

                let tourId = links[0].tourId;
                let t_id = links[0].t_id;
                for (const link of links) {
                    console.log("Links: ", link);
                    try {
                        const res = await this.axios.post(`${this.$apiUrl}scrape-draw`, link);
                        tourId = res.data.tourId;
                        t_id = res.data.t_id;
                        this.noti("success", `Data scraped for link ${ link.link }`);
                                       } catch (err) {
                        this.noti("error", `Error scraping for link ${ link.link }`);
                    }
                }
                this.noti("success", "Generating Athelete Rankings");
                // const res = await this.axios.get(`${this.$apiUrl}create-athlete-ranking/${t_id}/${tourId}`);
                await this.axios.get(`${this.$apiUrl}tournament-players/${t_id}/${tourId}`).then(async res => {
                    let players = res.data;
                    let parts = this.divideArrayIntoParts(players, 10);
                    let index = 1;
                    parts.forEach(async part => {
                        // setTimeout(() => {
                            let player_response = await this.axios.get(`${this.$apiUrl}athelete-player-ranking/${part[0].id}/${part[1].id}`);
                            index++;
                            if(index > 10){
                                this.noti("success", "All Done!");
                                this.formdata.url = "";
                                setTimeout(() => {
                                    window.location.reload();
                                }, 500);
                            }
                    });
                });


                // this.loading = false;

            } catch (error) {
                this.noti("error", error.response.data.message);
                this.loading = false;
            }
        },
    },
    created() {
        this.checkLog();
        this.getTournaments();
        const generateRandomId = () => {
            return Math.floor(Math.random() * 1000000) + 1;
        };

        this.formdata.t_id = generateRandomId();
    },
};
</script>
<style lang=""></style>
