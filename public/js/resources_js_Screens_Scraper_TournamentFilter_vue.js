"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_Screens_Scraper_TournamentFilter_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Components/Sidebar.vue?vue&type=script&lang=js":
/*!*************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Components/Sidebar.vue?vue&type=script&lang=js ***!
  \*************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {};
  },
  methods: {
    logout: function logout() {
      localStorage.clear();
      this.noti("success", "Logged out successfully");
      window.location.href = '/';
    }
  },
  created: function created() {}
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Screens/Scraper/TournamentFilter.vue?vue&type=script&lang=js":
/*!***************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Screens/Scraper/TournamentFilter.vue?vue&type=script&lang=js ***!
  \***************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Components_Sidebar_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../Components/Sidebar.vue */ "./resources/js/Components/Sidebar.vue");

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    Sidebar: _Components_Sidebar_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  data: function data() {
    return {
      years: [],
      weights: [],
      categories: ['ESO', 'CADET', 'JUNIOR'],
      tournaments: [],
      filters: {
        year: [],
        tournamentType: [],
        category: [],
        weight: [],
        gender: []
      },
      selectedYear: null,
      selectedTournamentType: '',
      selectedCategory: null,
      selectedWeight: null,
      selectedGender: null,
      tournamentTypes: [],
      isLoading: false
    };
  },
  methods: {
    getFilters: function getFilters() {
      var _this = this;
      this.axios.get("".concat(this.$apiUrl, "tournaments/updateFilter")).then(function (response) {
        console.log(response.data);
        _this.years = response.data.years;
        _this.weights = response.data.weights;
        _this.tournamentTypes = response.data.tournamentTypes;
      });
    },
    applyFilters: function applyFilters() {
      var _this2 = this;
      this.isLoading = true;
      var filtersCopy = JSON.parse(JSON.stringify(this.filters)); // create a copy to avoid modifying the original data
      filtersCopy.category = filtersCopy.category.map(function (category) {
        return category.toUpperCase();
      });
      this.axios.get("".concat(this.$apiUrl, "tournaments/filter"), {
        params: filtersCopy
      }).then(function (response) {
        _this2.tournaments = response.data;
        _this2.noti("success", "Data fetched successfully"); // Show notification on success
        _this2.$nextTick(function () {
          // Ensure DOM is updated
          _this2.$refs.resultsSection.scrollIntoView({
            behavior: 'smooth'
          }); // Scroll to table
        });

        _this2.isLoading = false;
      })["catch"](function (error) {
        _this2.noti("error", "Failed to fetch data"); // Show notification on error
        _this2.isLoading = false;
      });
    },
    addTournamentType: function addTournamentType() {
      if (this.selectedTournamentType && !this.filters.tournamentType.includes(this.selectedTournamentType)) {
        this.filters.tournamentType.push(this.selectedTournamentType);
      }
      this.selectedTournamentType = '';
    },
    removeTournamentType: function removeTournamentType(index) {
      this.filters.tournamentType.splice(index, 1);
    },
    addYear: function addYear() {
      if (this.selectedYear && !this.filters.year.includes(this.selectedYear)) {
        this.filters.year.push(this.selectedYear);
      }
      this.selectedYear = null;
    },
    removeYear: function removeYear(index) {
      this.filters.year.splice(index, 1);
    },
    addWeight: function addWeight() {
      if (this.selectedWeight && !this.filters.weight.includes(this.selectedWeight)) {
        this.filters.weight.push(this.selectedWeight);
      }
      this.selectedWeight = null;
    },
    removeWeight: function removeWeight(index) {
      this.filters.weight.splice(index, 1);
    },
    addCategory: function addCategory() {
      if (this.selectedCategory && !this.filters.category.includes(this.selectedCategory)) {
        this.filters.category.push(this.selectedCategory);
      }
      this.selectedCategory = null;
    },
    removeCategory: function removeCategory(index) {
      this.filters.category.splice(index, 1);
    },
    addGender: function addGender() {
      if (this.selectedGender && !this.filters.gender.includes(this.selectedGender)) {
        this.filters.gender.push(this.selectedGender);
      }
      this.selectedGender = null;
    },
    removeGender: function removeGender(index) {
      this.filters.gender.splice(index, 1);
    }
  },
  created: function created() {
    this.checkLog();
    this.getFilters();
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Components/Sidebar.vue?vue&type=template&id=236a5a3e&lang=true":
/*!***************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Components/Sidebar.vue?vue&type=template&id=236a5a3e&lang=true ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "left-sidebar"
};
var _hoisted_2 = {
  "class": "brand-logo d-flex align-items-center justify-content-between"
};
var _hoisted_3 = {
  href: "/",
  "class": "text-nowrap logo-img"
};
var _hoisted_4 = ["src"];
var _hoisted_5 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
  "class": "ti ti-x fs-8"
}, null, -1 /* HOISTED */);
var _hoisted_6 = [_hoisted_5];
var _hoisted_7 = {
  "class": "sidebar-nav scroll-sidebar",
  "data-simplebar": ""
};
var _hoisted_8 = {
  id: "sidebarnav"
};
var _hoisted_9 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", {
  "class": "nav-small-cap"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
  "class": "ti ti-dots nav-small-cap-icon fs-4"
}), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "hide-menu"
}, "Menu")], -1 /* HOISTED */);
var _hoisted_10 = {
  "class": "sidebar-item"
};
var _hoisted_11 = ["src"];
var _hoisted_12 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "hide-menu"
}, "Tournament", -1 /* HOISTED */);
var _hoisted_13 = {
  "class": "sidebar-item"
};
var _hoisted_14 = ["src"];
var _hoisted_15 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "hide-menu"
}, "Tournament Archive", -1 /* HOISTED */);
var _hoisted_16 = {
  "class": "sidebar-item"
};
var _hoisted_17 = ["src"];
var _hoisted_18 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "hide-menu"
}, "Tournament Types", -1 /* HOISTED */);
var _hoisted_19 = {
  "class": "sidebar-item"
};
var _hoisted_20 = ["src"];
var _hoisted_21 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "hide-menu"
}, "Athlete Ranking", -1 /* HOISTED */);
var _hoisted_22 = {
  "class": "sidebar-item"
};
var _hoisted_23 = ["src"];
var _hoisted_24 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "hide-menu"
}, "Ranking", -1 /* HOISTED */);
var _hoisted_25 = {
  "class": "sidebar-item"
};
var _hoisted_26 = ["src"];
var _hoisted_27 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "hide-menu"
}, "Settings", -1 /* HOISTED */);
var _hoisted_28 = {
  "class": "sidebar-item"
};
var _hoisted_29 = ["src"];
var _hoisted_30 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "hide-menu"
}, "Sign Out", -1 /* HOISTED */);

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_router_link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("router-link");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("aside", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Sidebar scroll"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
    src: "".concat(_ctx.$appDir, "logo.gif"),
    "class": "dark-logo",
    width: "180",
    alt: ""
  }, null, 8 /* PROPS */, _hoisted_4)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": "close-btn d-lg-none d-block cursor-pointer",
    onClick: _cache[0] || (_cache[0] = function () {
      return _ctx.onClose && _ctx.onClose.apply(_ctx, arguments);
    })
  }, _hoisted_6)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Sidebar navigation"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("nav", _hoisted_7, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", _hoisted_8, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" ============================= "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Home "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" ============================= "), _hoisted_9, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" =================== "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Dashboard "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" =================== "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_10, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
    "class": "sidebar-link",
    to: "/dashboard",
    "aria-expanded": "false",
    onClick: _ctx.onClose
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
        src: "".concat(_ctx.$appDir, "menu/dashboard.png"),
        style: {
          "height": "20px"
        }
      }, null, 8 /* PROPS */, _hoisted_11)]), _hoisted_12];
    }),
    _: 1 /* STABLE */
  }, 8 /* PROPS */, ["onClick"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_13, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
    "class": "sidebar-link",
    to: "/tournament-archive",
    "aria-expanded": "false",
    onClick: _ctx.onClose
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
        src: "".concat(_ctx.$appDir, "menu/books.png"),
        style: {
          "height": "20px"
        }
      }, null, 8 /* PROPS */, _hoisted_14)]), _hoisted_15];
    }),
    _: 1 /* STABLE */
  }, 8 /* PROPS */, ["onClick"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_16, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
    "class": "sidebar-link",
    to: "/tournament-type",
    "aria-expanded": "false",
    onClick: _ctx.onClose
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
        src: "".concat(_ctx.$appDir, "menu/types.png"),
        style: {
          "height": "20px"
        }
      }, null, 8 /* PROPS */, _hoisted_17)]), _hoisted_18];
    }),
    _: 1 /* STABLE */
  }, 8 /* PROPS */, ["onClick"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_19, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
    "class": "sidebar-link",
    to: "/athlete-rankings",
    "aria-expanded": "false",
    onClick: _ctx.onClose
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
        src: "".concat(_ctx.$appDir, "menu/athletes.png"),
        style: {
          "height": "20px"
        }
      }, null, 8 /* PROPS */, _hoisted_20)]), _hoisted_21];
    }),
    _: 1 /* STABLE */
  }, 8 /* PROPS */, ["onClick"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_22, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
    "class": "sidebar-link",
    to: "/tournament-filter",
    "aria-expanded": "false",
    onClick: _ctx.onClose
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
        src: "".concat(_ctx.$appDir, "menu/ranking.png"),
        style: {
          "height": "20px"
        }
      }, null, 8 /* PROPS */, _hoisted_23)]), _hoisted_24];
    }),
    _: 1 /* STABLE */
  }, 8 /* PROPS */, ["onClick"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_25, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
    "class": "sidebar-link",
    to: "/settings",
    "aria-expanded": "false",
    onClick: _ctx.onClose
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
        src: "".concat(_ctx.$appDir, "menu/gear.png"),
        style: {
          "height": "20px"
        }
      }, null, 8 /* PROPS */, _hoisted_26)]), _hoisted_27];
    }),
    _: 1 /* STABLE */
  }, 8 /* PROPS */, ["onClick"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_28, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
    "class": "sidebar-link",
    href: "javascript:void(0)",
    onClick: _cache[1] || (_cache[1] = function () {
      return $options.logout && $options.logout.apply($options, arguments);
    }),
    "aria-expanded": "false"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
    src: "".concat(_ctx.$appDir, "menu/signout.png"),
    style: {
      "height": "20px"
    }
  }, null, 8 /* PROPS */, _hoisted_29)]), _hoisted_30])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" End Sidebar navigation ")]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" End Sidebar scroll")])]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Screens/Scraper/TournamentFilter.vue?vue&type=template&id=235783d8&scoped=true":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Screens/Scraper/TournamentFilter.vue?vue&type=template&id=235783d8&scoped=true ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _withScopeId = function _withScopeId(n) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.pushScopeId)("data-v-235783d8"), n = n(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.popScopeId)(), n;
};
var _hoisted_1 = ["data-sidebartype"];
var _hoisted_2 = {
  "class": "body-wrapper"
};
var _hoisted_3 = {
  key: 0,
  "class": "app-header"
};
var _hoisted_4 = {
  "class": "navbar navbar-expand-lg navbar-light"
};
var _hoisted_5 = {
  "class": "navbar-nav"
};
var _hoisted_6 = {
  "class": "nav-item"
};
var _hoisted_7 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
    "class": "ti ti-menu-2"
  }, null, -1 /* HOISTED */);
});
var _hoisted_8 = [_hoisted_7];
var _hoisted_9 = {
  href: "/",
  "class": "text-nowrap logo-img"
};
var _hoisted_10 = ["src"];
var _hoisted_11 = {
  "class": "container-fluid mt-5"
};
var _hoisted_12 = {
  "class": "row"
};
var _hoisted_13 = {
  "class": "col-md-6 mx-auto"
};
var _hoisted_14 = {
  "class": "card shadow-sm border-0"
};
var _hoisted_15 = {
  "class": "card-body"
};
var _hoisted_16 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h5", {
    "class": "text-center text-primary mb-4"
  }, "Ranking Results", -1 /* HOISTED */);
});
var _hoisted_17 = {
  "class": "form-group mt-4"
};
var _hoisted_18 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, "Year", -1 /* HOISTED */);
});
var _hoisted_19 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
    disabled: "",
    value: "null"
  }, "Please select year", -1 /* HOISTED */);
});
var _hoisted_20 = {
  "class": "mt-2"
};
var _hoisted_21 = ["onClick"];
var _hoisted_22 = {
  "class": "form-group"
};
var _hoisted_23 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, "Tournament Type", -1 /* HOISTED */);
});
var _hoisted_24 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
    disabled: "",
    value: ""
  }, "Please select one", -1 /* HOISTED */);
});
var _hoisted_25 = {
  "class": "mt-2"
};
var _hoisted_26 = ["onClick"];
var _hoisted_27 = {
  "class": "form-group"
};
var _hoisted_28 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, "Category", -1 /* HOISTED */);
});
var _hoisted_29 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
    value: "null"
  }, "Please select one", -1 /* HOISTED */);
});
var _hoisted_30 = {
  "class": "mt-2"
};
var _hoisted_31 = ["onClick"];
var _hoisted_32 = {
  "class": "form-group"
};
var _hoisted_33 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, "Weight", -1 /* HOISTED */);
});
var _hoisted_34 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
    disabled: "",
    value: "null"
  }, "Please select one", -1 /* HOISTED */);
});
var _hoisted_35 = {
  "class": "mt-2"
};
var _hoisted_36 = ["onClick"];
var _hoisted_37 = {
  "class": "form-group"
};
var _hoisted_38 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, "Gender", -1 /* HOISTED */);
});
var _hoisted_39 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
    value: "null"
  }, "Please select one", -1 /* HOISTED */);
});
var _hoisted_40 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
    value: "M"
  }, "M (Male)", -1 /* HOISTED */);
});
var _hoisted_41 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
    value: "F"
  }, "F (Female)", -1 /* HOISTED */);
});
var _hoisted_42 = [_hoisted_39, _hoisted_40, _hoisted_41];
var _hoisted_43 = {
  "class": "mt-2"
};
var _hoisted_44 = ["onClick"];
var _hoisted_45 = {
  "class": "form-group"
};
var _hoisted_46 = {
  "class": "row mt-5",
  ref: "resultsSection"
};
var _hoisted_47 = {
  "class": "col-12"
};
var _hoisted_48 = {
  "class": "card shadow-sm border-0"
};
var _hoisted_49 = {
  "class": "card-body"
};
var _hoisted_50 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h5", {
    "class": "card-title text-primary"
  }, "Ranking Results", -1 /* HOISTED */);
});
var _hoisted_51 = {
  "class": "table-responsive"
};
var _hoisted_52 = {
  "class": "table table-bordered"
};
var _hoisted_53 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("thead", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
    scope: "col"
  }, "#"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <th scope=\"col\">Rank</th> "), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
    scope: "col"
  }, "Name"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
    scope: "col"
  }, "Club"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
    scope: "col"
  }, "Scores"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
    scope: "col"
  }, "Class"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
    scope: "col"
  }, "Gender"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
    scope: "col"
  }, "Tournament"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
    scope: "col"
  }, "Weight"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
    scope: "col"
  }, "Year")])], -1 /* HOISTED */);
});
var _hoisted_54 = {
  key: 0
};
var _hoisted_55 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
    colspan: "10",
    "class": "text-center"
  }, "No record found", -1 /* HOISTED */);
});
var _hoisted_56 = [_hoisted_55];
var _hoisted_57 = {
  scope: "row"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Sidebar = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Sidebar");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)("page-wrapper ".concat(_ctx.$isMobileWeb && _ctx.mobileSideBar ? 'show-sidebar' : 'mini-sidebar')),
    id: "main-wrapper",
    "data-theme": "blue_theme",
    "data-layout": "vertical",
    "data-sidebartype": "".concat(_ctx.$isMobileWeb && _ctx.mobileSideBar ? 'full' : !_ctx.$isMobileWeb ? 'full' : 'mini-sidebar'),
    "data-sidebar-position": "fixed",
    "data-header-position": "fixed"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Sidebar, {
    onOnClose: _ctx.closeSideBar
  }, null, 8 /* PROPS */, ["onOnClose"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [_ctx.$isMobileWeb ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("header", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("nav", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
    "class": "nav-link nav-icon-hover ms-n3",
    onClick: _cache[0] || (_cache[0] = function () {
      return _ctx.showSideBar && _ctx.showSideBar.apply(_ctx, arguments);
    }),
    href: "javascript:void(0)"
  }, _hoisted_8)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", _hoisted_9, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
    src: "".concat(_ctx.$appDir, "logo.png"),
    "class": "dark-logo",
    style: {
      "height": "40px"
    }
  }, null, 8 /* PROPS */, _hoisted_10)])])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_11, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_12, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_13, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_14, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_15, [_hoisted_16, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_17, [_hoisted_18, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
      return $data.selectedYear = $event;
    }),
    "class": "form-control rounded-0",
    onChange: _cache[2] || (_cache[2] = function () {
      return $options.addYear && $options.addYear.apply($options, arguments);
    })
  }, [_hoisted_19, ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.years, function (year) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", {
      key: year
    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(year), 1 /* TEXT */);
  }), 128 /* KEYED_FRAGMENT */))], 544 /* HYDRATE_EVENTS, NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.selectedYear]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_20, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.filters.year, function (year, index) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", {
      "class": "badge bg-primary m-1 align-items-center",
      key: index
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(year) + " ", 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
      "class": "ms-2 text-white cursor-pointer",
      onClick: function onClick($event) {
        return $options.removeYear(index);
      }
    }, "x", 8 /* PROPS */, _hoisted_21)]);
  }), 128 /* KEYED_FRAGMENT */))])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_22, [_hoisted_23, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "onUpdate:modelValue": _cache[3] || (_cache[3] = function ($event) {
      return $data.selectedTournamentType = $event;
    }),
    "class": "form-control rounded-0",
    onChange: _cache[4] || (_cache[4] = function () {
      return $options.addTournamentType && $options.addTournamentType.apply($options, arguments);
    })
  }, [_hoisted_24, ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.tournamentTypes, function (type, index) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", {
      key: index
    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(type), 1 /* TEXT */);
  }), 128 /* KEYED_FRAGMENT */))], 544 /* HYDRATE_EVENTS, NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.selectedTournamentType]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_25, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.filters.tournamentType, function (type, index) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", {
      "class": "badge bg-primary m-1 align-items-center",
      key: type
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(type) + " ", 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
      "class": "ms-2 text-white cursor-pointer",
      onClick: function onClick($event) {
        return $options.removeTournamentType(index);
      }
    }, "x", 8 /* PROPS */, _hoisted_26)]);
  }), 128 /* KEYED_FRAGMENT */))])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_27, [_hoisted_28, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "onUpdate:modelValue": _cache[5] || (_cache[5] = function ($event) {
      return $data.selectedCategory = $event;
    }),
    "class": "form-control rounded-0",
    onChange: _cache[6] || (_cache[6] = function () {
      return $options.addCategory && $options.addCategory.apply($options, arguments);
    })
  }, [_hoisted_29, ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.categories, function (category) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", {
      key: category
    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(category), 1 /* TEXT */);
  }), 128 /* KEYED_FRAGMENT */))], 544 /* HYDRATE_EVENTS, NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.selectedCategory]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_30, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.filters.category, function (category, index) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", {
      "class": "badge bg-primary m-1 align-items-center",
      key: category
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(category) + " ", 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
      "class": "ms-2 text-white cursor-pointer",
      onClick: function onClick($event) {
        return $options.removeCategory(index);
      }
    }, "x", 8 /* PROPS */, _hoisted_31)]);
  }), 128 /* KEYED_FRAGMENT */))])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_32, [_hoisted_33, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "onUpdate:modelValue": _cache[7] || (_cache[7] = function ($event) {
      return $data.selectedWeight = $event;
    }),
    "class": "form-control rounded-0",
    onChange: _cache[8] || (_cache[8] = function () {
      return $options.addWeight && $options.addWeight.apply($options, arguments);
    })
  }, [_hoisted_34, ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.weights, function (weight) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", {
      key: weight
    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(weight), 1 /* TEXT */);
  }), 128 /* KEYED_FRAGMENT */))], 544 /* HYDRATE_EVENTS, NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.selectedWeight]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_35, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.filters.weight, function (weight, index) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", {
      "class": "badge bg-primary m-1 align-items-center",
      key: index
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(weight) + " ", 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
      "class": "ms-2 text-white cursor-pointer",
      onClick: function onClick($event) {
        return $options.removeWeight(index);
      }
    }, "x", 8 /* PROPS */, _hoisted_36)]);
  }), 128 /* KEYED_FRAGMENT */))])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_37, [_hoisted_38, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "onUpdate:modelValue": _cache[9] || (_cache[9] = function ($event) {
      return $data.selectedGender = $event;
    }),
    "class": "form-control rounded-0",
    onChange: _cache[10] || (_cache[10] = function () {
      return $options.addGender && $options.addGender.apply($options, arguments);
    })
  }, _hoisted_42, 544 /* HYDRATE_EVENTS, NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.selectedGender]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_43, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.filters.gender, function (gender, index) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", {
      "class": "badge bg-primary m-1 align-items-center",
      key: gender
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(gender) + " ", 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
      "class": "ms-2 text-white cursor-pointer",
      onClick: function onClick($event) {
        return $options.removeGender(index);
      }
    }, "x", 8 /* PROPS */, _hoisted_44)]);
  }), 128 /* KEYED_FRAGMENT */))])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_45, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    "class": "btn btn-primary w-100 rounded-0",
    onClick: _cache[11] || (_cache[11] = function () {
      return $options.applyFilters && $options.applyFilters.apply($options, arguments);
    })
  }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.isLoading ? 'Filtering...' : 'Apply Filters'), 1 /* TEXT */)])])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_46, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_47, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_48, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_49, [_hoisted_50, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_51, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_52, [_hoisted_53, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tbody", null, [$data.tournaments && !$data.tournaments.length ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", _hoisted_54, _hoisted_56)) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, {
    key: 1
  }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.tournaments, function (tournament, index) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", {
      key: tournament.id
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", _hoisted_57, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(index + 1), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <td>{{ tournament.rank }}</td> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(tournament.name), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(tournament.club), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(tournament.total_scores), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(tournament["class"]), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(tournament.male_female), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(tournament.tournament_name), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(tournament.weight), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(tournament.year), 1 /* TEXT */)]);
  }), 128 /* KEYED_FRAGMENT */))])])])])])])], 512 /* NEED_PATCH */)])])], 10 /* CLASS, PROPS */, _hoisted_1);
}

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Components/Sidebar.vue?vue&type=style&index=0&id=236a5a3e&lang=css":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Components/Sidebar.vue?vue&type=style&index=0&id=236a5a3e&lang=css ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n.active-link {\r\n    background-color: #d08d12;\r\n    color: #fff !important;\n}\r\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Screens/Scraper/TournamentFilter.vue?vue&type=style&index=0&id=235783d8&scoped=true&lang=css":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Screens/Scraper/TournamentFilter.vue?vue&type=style&index=0&id=235783d8&scoped=true&lang=css ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n.card[data-v-235783d8] {\r\n    border-radius: 1rem;\n}\n.card-body[data-v-235783d8] {\r\n    padding: 2rem;\n}\n.form-group[data-v-235783d8] {\r\n    margin-bottom: 1.5rem;\n}\nh5[data-v-235783d8] {\r\n    margin-bottom: 1.5rem;\n}\n.text-white[data-v-235783d8] {\r\n    color: #ffffff;\n}\n.cursor-pointer[data-v-235783d8] {\r\n    cursor: pointer;\n}\n.card-body h5[data-v-235783d8] {\r\n    font-weight: bold;\n}\n.btn-primary[data-v-235783d8] {\r\n    background-color: #0d6efd;\r\n    border-color: #0d6efd;\n}\r\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Components/Sidebar.vue?vue&type=style&index=0&id=236a5a3e&lang=css":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Components/Sidebar.vue?vue&type=style&index=0&id=236a5a3e&lang=css ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Sidebar_vue_vue_type_style_index_0_id_236a5a3e_lang_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Sidebar.vue?vue&type=style&index=0&id=236a5a3e&lang=css */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Components/Sidebar.vue?vue&type=style&index=0&id=236a5a3e&lang=css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Sidebar_vue_vue_type_style_index_0_id_236a5a3e_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Sidebar_vue_vue_type_style_index_0_id_236a5a3e_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Screens/Scraper/TournamentFilter.vue?vue&type=style&index=0&id=235783d8&scoped=true&lang=css":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Screens/Scraper/TournamentFilter.vue?vue&type=style&index=0&id=235783d8&scoped=true&lang=css ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TournamentFilter_vue_vue_type_style_index_0_id_235783d8_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./TournamentFilter.vue?vue&type=style&index=0&id=235783d8&scoped=true&lang=css */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Screens/Scraper/TournamentFilter.vue?vue&type=style&index=0&id=235783d8&scoped=true&lang=css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TournamentFilter_vue_vue_type_style_index_0_id_235783d8_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TournamentFilter_vue_vue_type_style_index_0_id_235783d8_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./resources/js/Components/Sidebar.vue":
/*!*********************************************!*\
  !*** ./resources/js/Components/Sidebar.vue ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Sidebar_vue_vue_type_template_id_236a5a3e_lang_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Sidebar.vue?vue&type=template&id=236a5a3e&lang=true */ "./resources/js/Components/Sidebar.vue?vue&type=template&id=236a5a3e&lang=true");
/* harmony import */ var _Sidebar_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Sidebar.vue?vue&type=script&lang=js */ "./resources/js/Components/Sidebar.vue?vue&type=script&lang=js");
/* harmony import */ var _Sidebar_vue_vue_type_style_index_0_id_236a5a3e_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Sidebar.vue?vue&type=style&index=0&id=236a5a3e&lang=css */ "./resources/js/Components/Sidebar.vue?vue&type=style&index=0&id=236a5a3e&lang=css");
/* harmony import */ var C_Users_Administrator_Documents_upwork_task_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;


const __exports__ = /*#__PURE__*/(0,C_Users_Administrator_Documents_upwork_task_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__["default"])(_Sidebar_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Sidebar_vue_vue_type_template_id_236a5a3e_lang_true__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Components/Sidebar.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/Screens/Scraper/TournamentFilter.vue":
/*!***********************************************************!*\
  !*** ./resources/js/Screens/Scraper/TournamentFilter.vue ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _TournamentFilter_vue_vue_type_template_id_235783d8_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TournamentFilter.vue?vue&type=template&id=235783d8&scoped=true */ "./resources/js/Screens/Scraper/TournamentFilter.vue?vue&type=template&id=235783d8&scoped=true");
/* harmony import */ var _TournamentFilter_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TournamentFilter.vue?vue&type=script&lang=js */ "./resources/js/Screens/Scraper/TournamentFilter.vue?vue&type=script&lang=js");
/* harmony import */ var _TournamentFilter_vue_vue_type_style_index_0_id_235783d8_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./TournamentFilter.vue?vue&type=style&index=0&id=235783d8&scoped=true&lang=css */ "./resources/js/Screens/Scraper/TournamentFilter.vue?vue&type=style&index=0&id=235783d8&scoped=true&lang=css");
/* harmony import */ var C_Users_Administrator_Documents_upwork_task_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;


const __exports__ = /*#__PURE__*/(0,C_Users_Administrator_Documents_upwork_task_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__["default"])(_TournamentFilter_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_TournamentFilter_vue_vue_type_template_id_235783d8_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render],['__scopeId',"data-v-235783d8"],['__file',"resources/js/Screens/Scraper/TournamentFilter.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/Components/Sidebar.vue?vue&type=script&lang=js":
/*!*********************************************************************!*\
  !*** ./resources/js/Components/Sidebar.vue?vue&type=script&lang=js ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Sidebar_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Sidebar_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Sidebar.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Components/Sidebar.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/Screens/Scraper/TournamentFilter.vue?vue&type=script&lang=js":
/*!***********************************************************************************!*\
  !*** ./resources/js/Screens/Scraper/TournamentFilter.vue?vue&type=script&lang=js ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TournamentFilter_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TournamentFilter_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./TournamentFilter.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Screens/Scraper/TournamentFilter.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/Components/Sidebar.vue?vue&type=template&id=236a5a3e&lang=true":
/*!*************************************************************************************!*\
  !*** ./resources/js/Components/Sidebar.vue?vue&type=template&id=236a5a3e&lang=true ***!
  \*************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Sidebar_vue_vue_type_template_id_236a5a3e_lang_true__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Sidebar_vue_vue_type_template_id_236a5a3e_lang_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Sidebar.vue?vue&type=template&id=236a5a3e&lang=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Components/Sidebar.vue?vue&type=template&id=236a5a3e&lang=true");


/***/ }),

/***/ "./resources/js/Screens/Scraper/TournamentFilter.vue?vue&type=template&id=235783d8&scoped=true":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/Screens/Scraper/TournamentFilter.vue?vue&type=template&id=235783d8&scoped=true ***!
  \*****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TournamentFilter_vue_vue_type_template_id_235783d8_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TournamentFilter_vue_vue_type_template_id_235783d8_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./TournamentFilter.vue?vue&type=template&id=235783d8&scoped=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Screens/Scraper/TournamentFilter.vue?vue&type=template&id=235783d8&scoped=true");


/***/ }),

/***/ "./resources/js/Components/Sidebar.vue?vue&type=style&index=0&id=236a5a3e&lang=css":
/*!*****************************************************************************************!*\
  !*** ./resources/js/Components/Sidebar.vue?vue&type=style&index=0&id=236a5a3e&lang=css ***!
  \*****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Sidebar_vue_vue_type_style_index_0_id_236a5a3e_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader/dist/cjs.js!../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Sidebar.vue?vue&type=style&index=0&id=236a5a3e&lang=css */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Components/Sidebar.vue?vue&type=style&index=0&id=236a5a3e&lang=css");


/***/ }),

/***/ "./resources/js/Screens/Scraper/TournamentFilter.vue?vue&type=style&index=0&id=235783d8&scoped=true&lang=css":
/*!*******************************************************************************************************************!*\
  !*** ./resources/js/Screens/Scraper/TournamentFilter.vue?vue&type=style&index=0&id=235783d8&scoped=true&lang=css ***!
  \*******************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TournamentFilter_vue_vue_type_style_index_0_id_235783d8_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader/dist/cjs.js!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./TournamentFilter.vue?vue&type=style&index=0&id=235783d8&scoped=true&lang=css */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Screens/Scraper/TournamentFilter.vue?vue&type=style&index=0&id=235783d8&scoped=true&lang=css");


/***/ })

}]);