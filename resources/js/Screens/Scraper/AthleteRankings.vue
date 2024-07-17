<template>
  <div :class="`page-wrapper ${$isMobileWeb && mobileSideBar ? 'show-sidebar' : 'mini-sidebar'
    }`" id="main-wrapper" data-theme="blue_theme" data-layout="vertical" :data-sidebartype="`${$isMobileWeb && mobileSideBar ? 'full' : !$isMobileWeb ? 'full' : 'mini-sidebar'
      }`" data-sidebar-position="fixed" data-header-position="fixed">
    <Sidebar @onClose="closeSideBar" />
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
            <img :src="`${$images}logo.png`" class="dark-logo" style="height: 40px" />
          </a>
        </nav>
      </header>
      <div class="container-fluid mt-0">
        <div class="row">
          <div class="col-md-12 mx-auto">
            <div class="card shadow-sm border-0">
              <div class="card-body">
                <h5 class="text-center text-warning mb-4">Athlete Ranking Results</h5>
                <div class="row">
                  <div class="col-md-3 form-group">
                    <label>Year</label>
                    <select v-model="selectedYear" class="form-control rounded-0" @change="addYear">
                      <option disabled value="null">Please select year</option>
                      <option v-for="year in years" :key="year">
                        {{ year }}
                      </option>
                    </select>
                    <div class="mt-2">
                      <span class="badge bg-warning m-1 align-items-center" v-for="(year, index) in filters.year"
                        :key="index">
                        {{ year }}
                        <span class="ms-2 text-white cursor-pointer" @click="removeYear(index)">x</span>
                      </span>
                    </div>
                  </div>
                  <div class="col-md-3 form-group">
                    <label>Tournament Type</label>
                    <select v-model="selectedTournamentType" class="form-control rounded-0" @change="addTournamentType">
                      <option disabled value="">Please select one</option>
                      <option v-for="(type, index) in tournamentTypes" :key="index">
                        {{ type }}
                      </option>
                    </select>
                    <div class="mt-2">
                      <span class="badge bg-warning m-1 align-items-center"
                        v-for="(type, index) in filters.tournamentType" :key="type">
                        {{ type }}
                        <span class="ms-2 text-white cursor-pointer" @click="removeTournamentType(index)">x</span>
                      </span>
                    </div>
                  </div>
                  <div class="col-md-3 form-group">
                    <label>Category</label>
                    <select v-model="selectedCategory" class="form-control rounded-0" @change="handleCategoryChange">
                      <option value="null">Please select one</option>
                      <option v-for="category in categories" :key="category" :value="category">
                        {{ category }}
                      </option>
                    </select>
                    <div class="mt-2">
                      <span class="badge bg-warning m-1 align-items-center"
                        v-for="(category, index) in filters.category" :key="category">
                        {{ category }}
                        <span class="ms-2 text-white cursor-pointer" @click="removeCategory(index)">x</span>
                      </span>
                    </div>
                  </div>
                  <div class="col-md-3 form-group">
                    <label>Weight</label>
                    <select v-model="selectedWeight" class="form-control rounded-0" @change="addWeight">
                      <option disabled value="null">Please select one</option>
                      <option v-for="weight in weights" :key="weight">
                        {{ weight }}
                      </option>
                    </select>
                    <div class="mt-2">
                      <span class="badge bg-warning m-1 align-items-center" v-for="(weight, index) in filters.weight"
                        :key="index">
                        {{ weight }}
                        <span class="ms-2 text-white cursor-pointer" @click="removeWeight(index)">x</span>
                      </span>
                    </div>
                  </div>
                  <div class="col-md-3 form-group">
                    <label>Weight Group</label>
                    <select v-model="selectedWeightGroups" class="form-control rounded-0" @change="addWeightGroups">
                      <option disabled value="null">Please select one</option>
                      <option v-for="weightGroup in weightGroups" :key="weightGroup">
                        {{ weightGroup }}
                      </option>
                    </select>
                    <div class="mt-2">
                      <span class="badge bg-warning m-1 align-items-center"
                        v-for="(weight_group, index) in filters.weightGroups" :key="index">
                        {{ weight_group }}
                        <span class="ms-2 text-white cursor-pointer" @click="removeWeightGroup(index)">x</span>
                      </span>
                    </div>
                  </div>
                  <div class="col-md-3 form-group">
                    <label>Gender</label>
                    <select v-model="selectedGender" class="form-control rounded-0" @change="addGender">
                      <option value="null">Please select one</option>
                      <option value="M">M (Male)</option>
                      <option value="F">F (Female)</option>
                    </select>
                    <div class="mt-2">
                      <span class="badge bg-warning m-1 align-items-center" v-for="(gender, index) in filters.gender"
                        :key="gender">
                        {{ gender }}
                        <span class="ms-2 text-white cursor-pointer" @click="removeGender(index)">x</span>
                      </span>
                    </div>
                  </div>
                  <div class="col-md-3 form-group">
                    <label>Country</label>
                    <select v-model="selectedCountry" class="form-control rounded-0" @change="addCountry">
                      <option value="null">Please select one</option>
                      <!-- <option value="ITA">ITA</option> -->
                      <option v-for="(country, index) in countries" :key="index">
                        {{ country }}
                      </option>
                    </select>
                    <div class="mt-2">
                      <span class="badge bg-warning m-1 align-items-center" v-for="(cnt, index) in filters.country"
                        :key="index">
                        {{ cnt }}
                        <span class="ms-2 text-white cursor-pointer" @click="removeCountry(index)">x</span>
                      </span>
                    </div>
                  </div>
                  <div class="col-md-3 form-group">
                    <button class="btn btn-warning w-100 rounded-0" style="margin-top: 22px" @click="applyFilters">
                      {{ isLoading ? "Filtering..." : "Apply Filters" }}
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-2" ref="resultsSection">
          <div class="col-12">
            <div class="card shadow-sm border-0">
              <div class="card-body">
                <h5 class="card-title text-warning">Athlete Ranking Results</h5>
                <div class="row justify-content-end m-3">
                  <div class="col-md-3">
                    <label>Input Selection</label>

                    <div>
                      <VueMultiselect v-model="topOpentounaments" :options="maxOptions" :multiple="false"
                        placeholder="Input Selection" label="name" track-by="code" @select="selected" />
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label>Sorting:</label>

                    <div>
                      <VueMultiselect v-model="selectedSortings" :options="sortingOptions" :multiple="true" :max="3"
                        placeholder="Select Options" label="name" track-by="code" @select="sorted" />
                    </div>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Official R</th>
                        <!-- <th scope="col">R1</th>
                                                <th scope="col">R2</th> -->
                        <th scope="col">Wins</th>
                        <th scope="col">Loses</th>
                        <th scope="col">Wins-Loses Diff</th>
                        <th scope="col">Points Scored</th>
                        <th scope="col">Points Suffered</th>
                        <th scope="col">Points Diff</th>
                        <th scope="col">Matches</th>
                        <th scope="col">Weight</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Display a message if there are no tournaments -->
                      <tr v-if="tournaments && !tournaments.length">
                        <td colspan="14" class="text-center">No record found</td>
                      </tr>
                      <!-- Iterate through tournaments and display data -->
                      <template v-for="(tournament, index) in tournaments" :key="tournament.id">
                        <tr>
                          <th scope="row">
                            {{ index + 1 }}
                          </th>
                          <td :title="tournament.club">
                            {{ tournament.name }}
                          </td>
                          <td>
                            {{ tournament.official_ranking }}
                          </td>
                          <!-- <td>
                                                        {{
                                                            tournament.ranking1
                                                        }}
                                                    </td>
                                                    <td>
                                                        {{
                                                            tournament.ranking2
                                                        }}
                                                    </td> -->
                          <td>
                            {{ `${tournament.win}` }}
                          </td>
                          <td>
                            {{ `${tournament.lose}` }}
                          </td>
                          <td>
                            {{ `${tournament.difference}` }}
                          </td>
                          <td>
                            {{ `${tournament.point_scored} ` }}
                          </td>
                          <td>
                            {{ `${tournament.point_suffered} ` }}
                          </td>
                          <td>
                            {{ ` ${tournament.point_diff}` }}
                          </td>
                          <td>
                            <p>
                              {{ tournament.total_matches }}
                            </p>
                          </td>
                          <td>
                            {{ tournament.weight_group }}
                          </td>
                          <!-- Button to view details -->
                          <td>
                            <button class="btn btn-info btn-sm" @click="openModal(index, $event)">
                              View
                            </button>
                          </td>
                        </tr>
                        <tr v-if="isModalOpen && actionIndex === index">
                          <td colspan="14">
                            <table size="small" aria-label="purchase" class="table table-bordered">
                              <thead>
                                <tr>
                                  <th>Tournament Name</th>
                                  <th>Official Ranking</th>
                                  <!-- <th>
                                                                        Ranking
                                                                        1
                                                                    </th>
                                                                    <th>
                                                                        Ranking
                                                                        2
                                                                    </th> -->
                                  <th>Win</th>
                                  <th>Lose</th>
                                  <th>Win Lose Diff</th>
                                  <th>Point Scored</th>
                                  <th>Point Suffered</th>
                                  <th>Point Diff</th>
                                  <th>Matches</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="(
                                    detail, detailIndex
                                  ) in tournamentData.athleteRankings" :key="detailIndex">
                                  <td>
                                    {{ detail.t_name }}
                                  </td>
                                  <td>
                                    {{ detail.official_ranking }}
                                  </td>
                                  <!-- <td>
                                                                        {{
                                                                            detail.ranking1
                                                                        }}
                                                                    </td>
                                                                    <td>
                                                                        {{
                                                                            detail.ranking2
                                                                        }}
                                                                    </td> -->
                                  <td>
                                    {{ detail.win }}
                                  </td>
                                  <td>
                                    {{ detail.lose }}
                                  </td>
                                  <td>
                                    {{ detail.difference }}
                                  </td>
                                  <td>
                                    {{ detail.point_scored }}
                                  </td>
                                  <td>
                                    {{ detail.point_suffered }}
                                  </td>
                                  <td>
                                    {{ detail.point_diff }}
                                  </td>
                                  <td>
                                    <div v-if="detail.matches && detail.matches.length">
                                      <div v-for="(match, matchIndex) in JSON.parse(
                                        detail.matches
                                      )" :key="matchIndex">
                                        <p>
                                          <strong>{{ match.opposition }}</strong>
                                          ({{ match.scores }}
                                          -
                                          {{ match.opposition_scores }})
                                        </p>
                                      </div>
                                    </div>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </template>
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
  <div v-if="show" class="subscription wrapper">
    <div class="card-content">
      <div class="container">
        <div class="image">
          <i class="fas fa-search"></i>
        </div>
        <h5>free for a week</h5>
        <p>Explore this site for free.</p>
      </div>
      <div class="form-input" id="paypal-button-container">
        <button class="subscribe-btn" id="" @click="setPermission('one week')">
          Try trial
        </button>
      </div>
    </div>
    <div class="card-content">
      <img :src="`${$images}backgrounds/silver.png`" alt="" class="card-brand">
      <div class="container">
        <div class="image">
          <i class="fas fa-search"></i>
        </div>
        <h5>Avalible for a month</h5>
        <p>Explore this site for free.</p>
      </div>
      <div class="form-input">
        <div id="oneMonth" ref="oneMonth" class="pay-btn"></div>
        <div class="subscribe-btn" @click="requestPay('oneMonth', 2, $event)">
          $2
        </div>
      </div>
    </div>
    <div class="card-content">
      <img :src="`${$images}backgrounds/bronze.png`" alt="" class="card-brand">
      <div class="container">
        <div class="image">
          <i class="fas fa-search"></i>
        </div>
        <h5>Avalible for six months</h5>
        <p>Explore this site.</p>
      </div>
      <div class="form-input">
        <div id="sixMonths" ref="sixMonths" class="pay-btn"></div>
        <div class="subscribe-btn" @click="requestPay('sixMonths', 10, $event)">
          $10
        </div>
      </div>
    </div>
    <div class="card-content">
      <img :src="`${$images}backgrounds/gold.png`" alt="" class="card-brand">
      <div class="container">
        <div class="image">
          <i class="fas fa-search"></i>
        </div>
        <h5>Avalible for a year</h5>
        <p>Explore this site.</p>
      </div>
      <div class="form-input">
        <div id="oneYear" ref="oneYear" class="pay-btn"></div>
        <div class="subscribe-btn" @click="requestPay('oneYear', 16, $event)">
          $16
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import VueMultiselect from "vue-multiselect";
import Sidebar from "../../Components/Sidebar.vue";
import { ref } from "vue";
import { loadScript } from "@paypal/paypal-js";

const AthleteRankings = {
  components: {
    Sidebar,
    VueMultiselect,
  },
  computed: {
    alternatingRows(currentIndex) {
      const rows = [];
      for (let i = 0; i < currentIndex; i++) {
        // Add a data row
        rows.push({ type: "data", data: this.tournaments[i] });

        // Add a details row
      }
      rows.push({
        type: "details",
        data: this.tournaments[currentIndex],
      });
      for (let i = currentIndex + 1; i < this.tournaments.length; i++) {
        // Add a data row
        rows.push({ type: "data", data: this.tournaments[i] });
      }
      return rows;
    },
  },
  data() {
    return {
      show: false,
      years: [],
      weights: [],
      weightGroups: [],
      categories: ["ESO", "CADET", "JUNIOR", "U21", "SENIOR", "MASTER"],
      countries: [],
      tournaments: [],
      filters: {
        year: [],
        tournamentType: [],
        category: [],
        weight: [],
        weightGroups: [],
        gender: [],
        country: [],
      },
      selectedYear: null,
      selectedTournamentType: "",
      selectedCategory: null,
      selectedWeight: null,
      selectedWeightGroups: null,
      selectedGender: null,
      selectedCountry: null,
      tournamentTypes: null,
      isLoading: false,
      selectedSorting: "asc",

      selectedSortings: [{ name: "Default Sorting", code: "asc" }], //{ name: "Default Inputs", code: "all", value: 7 }

      sortingOptions: [
        { name: "Official Ranking Ascending", code: "ra" },
        { name: "Official Ranking Descending", code: "rd" },
        { name: "Wins Ascending", code: "wa" },
        { name: "Wins Descending", code: "wd" },
        { name: "Loses Ascending", code: "la" },
        { name: "Loses Descending", code: "ld" },
        { name: "Points Scored Ascending", code: "pa" },
        { name: "Points Scored Descending", code: "pd" },
        { name: "Points Suffered Ascending", code: "sa" },
        { name: "Points Suffered Descending", code: "sd" },
        { name: "Points Diff Ascending", code: "pda" },
        { name: "Points Diff Descending", code: "pdd" },
        { name: "Total Matches Ascending", code: "tma" },
        { name: "Total Matches Descending", code: "tmd" },
      ],
      maxOptions: [
        { name: "Three", code: "three", value: 3 },
        { name: "Five", code: "five", value: 5 },
        { name: "All", code: "all", value: 7 },
      ],

      isModalOpen: false,
      selectedTournament: null,
      tournamentName: null,
      playerName: null,
      tournamentData: {
        athleteRankings: [],
      },

      topOpentounaments: { name: "three", code: "three", value: 3 },

      actionIndex: ref(-1),
    };
  },
  created() {
    this.isModalOpen = true
    // this.checkLog();
    this.applyFilters();
    this.getFilters();

  },
  mounted() {

    var ended_at = new Date(localStorage.getItem("ended_at"));
    var updated_at = new Date(localStorage.getItem("updated_at"));

    if (isNaN(ended_at) || updated_at > ended_at) this.show = true;

  },
  methods: {
    requestPay(id, amount, e) {
      e.target.style.display = "none";
      const self = this; 
      loadScript({
        "client-id": this.$paypal_client_id
      }).then((paypal) => {
        paypal.Buttons({
          env: this.$paypal_mode /* sandbox | production */,
          style: {
            layout: "horizontal", // horizontal | vertical
            size: "responsive" /* medium | large | responsive*/,
            shape: "pill" /* pill | rect*/,
            color: "gold" /* gold | blue | silver | black*/,
            fundingicons: false /* true | false */,
            tagline: false /* true | false */,
            label: "pay",
          },
          createOrder: function (data, actions) {
            return actions.order.create({
              purchase_units: [
                {
                  amount: {
                    value: amount,
                  },
                },
              ],
            });
          },

          onApprove: function (data, actions) {
            self.axios.post(`${self.$apiUrl}auth/updateEnddate`, {
              email: localStorage.getItem("email"),
              period: id
            }).
              then((res) => {
                self.show = false;
                self.noti("success","purchase premium successfully")
              });

          },
        }).render(`#${id}`);
      });

    },
    openModal(index, event) {
      event.preventDefault();
      // this.actionIndex = index;
      if (this.actionIndex === index) {
        this.actionIndex = -1;
        this.isModalOpen = false;
      } else {
        this.actionIndex = index;
        const playerName = this.tournaments[this.actionIndex].name;
        const playerId = this.tournaments[this.actionIndex].id;
        this.playerName = playerName;
        let data = {
          name: playerName,
          filters: this.filters,
        };
        this.axios
          .post(`${this.$apiUrl}fetch-tournament-details`, data)
          .then((response) => {
            // Assuming the response data structure matches what the Laravel method returns
            this.tournamentData = {
              athleteRankings: response.data.athleteRankings,
              resultMatches: response.data.resultMatches,
            };
            this.isModalOpen = true;
          })
          .catch((error) => {
            console.error("Error fetching tournament details:", error);
            // Handle error appropriately, e.g., displaying an error message
          });
      }
    },

    getFilters() {
      this.axios.get(`${this.$apiUrl}tournaments/updateFilter`).then((response) => {
        this.years = response.data.years;
        this.weights = response.data.weights;
        this.weightGroups = response.data.weightGroups;
        this.tournamentTypes = response.data.tournamentTypes;
        this.countries = response.data.countries;
      });
    },

    applyFilters() {
      this.isLoading = true;
      let filtersCopy = JSON.parse(JSON.stringify(this.filters)); // create a copy to avoid modifying the original data
      filtersCopy.category = filtersCopy.category.map((category) =>
        category.toUpperCase()
      );
      this.axios
        .get(`${this.$apiUrl}tournaments/athlete-filter`, {
          params: { ...filtersCopy, topOpentounaments: this.topOpentounaments.value },
        })
        .then((response) => {
          this.tournaments = response.data;
          this.noti("success", "Data fetched successfully"); // Show notification on success
          this.$nextTick(() => {
            // Ensure DOM is updated
            this.$refs.resultsSection.scrollIntoView({
              behavior: "smooth",
            }); // Scroll to table
          });
          this.isLoading = false;
          // console.log('filtering..');
        })
        .catch((error) => {
          this.noti("error", "Failed to fetch data"); // Show notification on error
          this.isLoading = false;
        });
    },

    selected(val) {
      this.applyFilters();
    },

    addTournamentType() {
      if (
        this.selectedTournamentType &&
        !this.filters.tournamentType.includes(this.selectedTournamentType)
      ) {
        this.filters.tournamentType.push(this.selectedTournamentType);
      }
      this.selectedTournamentType = "";
    },
    removeTournamentType(index) {
      this.filters.tournamentType.splice(index, 1);
    },
    addYear() {
      if (this.selectedYear && !this.filters.year.includes(this.selectedYear)) {
        this.filters.year.push(this.selectedYear);
      }
      this.selectedYear = null;
    },
    removeYear(index) {
      this.filters.year.splice(index, 1);
    },
    addWeight() {
      if (this.selectedWeight && !this.filters.weight.includes(this.selectedWeight)) {
        this.filters.weight.push(this.selectedWeight);
      }
      this.selectedWeight = null;
    },
    removeWeight(index) {
      this.filters.weight.splice(index, 1);
    },
    addWeightGroups() {
      if (
        this.selectedWeightGroups &&
        !this.filters.weightGroups.includes(this.selectedWeightGroups)
      ) {
        this.filters.weightGroups.push(this.selectedWeightGroups);
      }
      this.selectedWeightGroups = null;
    },
    removeWeightGroup(index) {
      this.filters.weightGroups.splice(index, 1);
    },
    handleCategoryChange() {
      if (this.selectedCategory && this.selectedCategory !== "null") {
        this.addCategory();
      }
    },
    getWeightGroupByCategory(category) {
      const url = `${this.$apiUrl}getWeightGroupByCategory/${category}`;
      this.axios
        .get(url)
        .then((response) => {
          // Merge new weights with existing ones
          const newWeightGroups = new Set([
            ...this.weightGroups,
            ...response.data.weightGroups,
          ]);
          this.weightGroups = Array.from(newWeightGroups);
          // console.log('weight group',this.weightGroups);
        })
        .catch((error) => {
          console.error("Error fetching weightGroups:", error);
        });
    },
    getWeightByCategory(category) {
      const url = `${this.$apiUrl}getWeightByCategory/${category}`;
      this.axios
        .get(url)
        .then((response) => {
          // Merge new weights with existing ones
          const newWeights = new Set([...this.weights, ...response.data.weights]);
          this.weights = Array.from(newWeights);
          // console.log('weight',this.weights);
        })
        .catch((error) => {
          console.error("Error fetching weights:", error);
        });
    },

    addCategory() {
      if (
        this.selectedCategory &&
        !this.filters.category.includes(this.selectedCategory)
      ) {
        this.filters.category.push(this.selectedCategory);
        this.updateWeightsAndGroups();
      }
      this.selectedCategory = null;
    },

    removeCategory(index) {
      this.filters.category.splice(index, 1);

      if (this.filters.category.length === 0) {
        this.weights = [];
        this.weightGroups = [];
      } else {
        this.updateWeightsAndGroups();
      }
    },
    updateWeightsAndGroups() {
      this.weights = [];
      this.weightGroups = [];
      this.filters.category.forEach((category) => {
        this.getWeightByCategory(category);
        this.getWeightGroupByCategory(category);
      });
    },

    addGender() {
      if (this.selectedGender && !this.filters.gender.includes(this.selectedGender)) {
        this.filters.gender.push(this.selectedGender);
      }
      this.selectedGender = null;
    },
    addCountry() {
      if (this.selectedCountry && !this.filters.country.includes(this.selectedCountry)) {
        this.filters.country.push(this.selectedCountry);
      }
      this.selectedCountry = null;
    },
    removeGender(index) {
      this.filters.gender.splice(index, 1);
    },
    removeCountry(index) {
      this.filters.country.splice(index, 1);
    },
    sortByOfficialRankingAscending() {
      this.tournaments.sort((a, b) => a.official_ranking - b.official_ranking);
    },

    sortByOfficialRankingDescending() {
      this.tournaments.sort((a, b) => b.official_ranking - a.official_ranking);
    },
    sortByWinsAscending() {
      this.tournaments.sort((a, b) => a.win - b.win);
    },

    sortByWinsDescending() {
      this.tournaments.sort((a, b) => b.win - a.win);
    },
    sortByLosesAscending() {
      // console.log('lose asc');
      this.tournaments.sort((a, b) => a.lose - b.lose);
    },

    sortByTotalMatchesDes() {
      this.tournaments.sort((a, b) => b.matches.length - a.matches.length);
    },
    sortByTotalMatchesAsc() {
      this.tournaments.sort((a, b) => a.matches.length - b.matches.length);
    },

    sortByLosesDescending() {
      this.tournaments.sort((a, b) => b.lose - a.lose);
    },
    sortByDiffAscending() {
      this.tournaments.sort((a, b) => a.difference - b.difference);
    },

    sortByDiffDescending() {
      this.tournaments.sort((a, b) => b.difference - a.difference);
    },
    sortByPointsAscending() {
      this.tournaments.sort((a, b) => a.point_scored - b.point_scored);
    },

    sortByPointsDescending() {
      this.tournaments.sort((a, b) => b.point_scored - a.point_scored);
    },
    sortBySufferedAscending() {
      this.tournaments.sort((a, b) => a.point_suffered - b.point_suffered);
    },

    sortBySufferedDescending() {
      this.tournaments.sort((a, b) => b.point_suffered - a.point_suffered);
    },
    sortByPointsDiffAscending() {
      this.tournaments.sort((a, b) => a.point_diff - b.point_diff);
    },

    sortByPointsDiffDescending() {
      this.tournaments.sort((a, b) => b.point_diff - a.point_diff);
    },

    sorted() {
      // this.resetTournaments();
      this.selectedSortings.forEach((sorting) => {
        // console.log('start sorting of',sorting);
        this.applySorting(sorting);
      });
    },

    applySorting(sortingOption) {
      switch (sortingOption.code) {
        case "asc":
          this.sortByOfficialRankingDescending();
          break;
        case "ra":
          this.sortByOfficialRankingAscending();
          break;
        case "rd":
          this.sortByOfficialRankingDescending();
          break;
        case "wa":
          this.sortByWinsAscending();
          break;
        case "wd":
          this.sortByWinsDescending();
          break;
        case "la":
          this.sortByLosesAscending();
          break;
        case "ld":
          this.sortByLosesDescending();
          break;
        case "da":
          this.sortByDiffAscending();
          break;
        case "dd":
          this.sortByDiffDescending();
          break;
        case "pa":
          this.sortByPointsAscending();
          break;
        case "pd":
          this.sortByPointsDescending();
          break;
        case "sa":
          this.sortBySufferedAscending();
          break;
        case "sd":
          this.sortBySufferedDescending();
          break;
        case "pda":
          this.sortByPointsDiffAscending();
          break;
        case "pdd":
          this.sortByPointsDiffDescending();
          break;
        case "tma":
          this.sortByTotalMatchesAsc();
          break;
        case "tmd":
          this.sortByTotalMatchesDes();
          break;
        default:
          // Handle any other cases or errors
          break;
      }
    },

    resetTournaments() {
      if (this.selectedSorting === "ra") {
        this.sortByOfficialRankingAscending();
      }
    },
  }


}
export default AthleteRankings;
</script>

<style src="../../../../node_modules/vue-multiselect/dist/vue-multiselect.css"></style>
<style src="../../../css/app.css"></style>

<style scoped>
.modal {
  display: flex;
  align-items: center;
  justify-content: center;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 1000;
  overflow: auto;
  /* Enable modal content scrolling */
}

.modal-content {
  background-color: #fff;
  padding: 20px;
  max-width: 80%;
  max-height: 80%;
  overflow: auto;
  position: relative;
}

.close {
  color: #aaa;
  font-size: 28px;
  font-weight: bold;
  position: absolute;
  /* Position it absolutely within the modal content */
  top: 10px;
  right: 10px;
  cursor: pointer;
  z-index: 1001;
  /* Ensure it's above the modal content */
}

.right-sticky {
  position: absolute;
  /* Make it fixed when scrolling down */
  top: 10px;
  right: 10px;
  cursor: pointer;
}

.fixed-close {
  position: fixed;
  top: 10px;
  right: 10px;
}

.card {
  border-radius: 1rem;
}

.card-body {
  padding: 2rem;
}

.form-group {
  margin-bottom: 1.5rem;
}

h5 {
  margin-bottom: 1.5rem;
}

.text-white {
  color: #ffffff;
}

.cursor-pointer {
  cursor: pointer;
}

.card-body h5 {
  font-weight: bold;
}

.btn-primary {
  background-color: #0d6efd;
  border-color: #0d6efd;
}

.table {
  height: 50%;
}

td,
th {
  font-size: 10px;
}

.detail-section {
  position: absolute;
  background-color: white;
  border: 1px solid black;
  padding: 10px;
}
</style>
valueOfvalueOf
