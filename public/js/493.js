"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[493],{6599:(e,s,a)=>{a.d(s,{Z:()=>r});var t=a(821),i={class:"text-danger"};const o={props:{message:String}};const r=(0,a(3744).Z)(o,[["render",function(e,s,a,o,r,l){return(0,t.wg)(),(0,t.iD)("small",i,(0,t.zw)(a.message?a.message[0]:""),1)}]])},493:(e,s,a)=>{a.r(s),a.d(s,{default:()=>y});var t=a(821),i={class:"page-wrapper",id:"main-wrapper","data-layout":"vertical","data-sidebartype":"full","data-sidebar-position":"fixed","data-header-position":"fixed"},o={class:"position-relative overflow-hidden radial-gradient min-vh-100"},r={class:"position-relative z-index-5"},l={class:"row"},n={class:"col-xl-7 col-xxl-8"},c=(0,t._)("a",{href:"/",class:"text-nowrap logo-img d-block px-4 py-9 w-100"},null,-1),d={class:"d-none d-xl-flex align-items-center justify-content-center",style:{height:"calc(100vh - 80px)"}},u=["src"],p={class:"col-xl-5 col-xxl-4"},m={class:"authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4"},g={class:"col-sm-8 col-md-6 col-xl-9"},f=(0,t.uE)('<h2 class="mb-3 fs-7 fw-bolder">Welcome to Scraper</h2><p class="mb-9">Continue Your Journey</p><div class="position-relative text-center my-4"><p class="mb-0 fs-4 px-3 d-inline-block bg-white text-dark z-index-5 position-relative">Login</p><span class="border-top w-100 position-absolute top-50 start-50 translate-middle"></span></div>',3),w={class:"mb-3"},b=(0,t._)("label",{class:"form-label"},"Email",-1),h={class:"mb-4"},v=(0,t._)("label",{class:"form-label"},"Password",-1),x=["disabled"];const _={components:{Error:a(6599).Z},data:function(){return{errors:{},user:{},isLoading:!1}},methods:{login:function(e){var s=this;e.preventDefault(),this.errors={},this.isLoading=!0,this.axios.post("".concat(this.$apiUrl,"auth/login"),this.user).then((function(e){s.noti("success",e.data.message),localStorage.clear(),localStorage.setItem("user_id",e.data.user.id);var a=(new Date).getTime();localStorage.setItem("log",a),localStorage.setItem("user",JSON.stringify(e.data.user)),localStorage.setItem("token",e.data.token),window.location.href="/dashboard"})).catch((function(e){s.noti("error",e.response.data.message),s.errors=e.response.data.errors||{},s.isLoading=!1}))}}};const y=(0,a(3744).Z)(_,[["render",function(e,s,a,_,y,k){var S=(0,t.up)("Error");return(0,t.wg)(),(0,t.iD)("div",i,[(0,t._)("div",o,[(0,t._)("div",r,[(0,t._)("div",l,[(0,t._)("div",n,[c,(0,t._)("div",d,[(0,t._)("img",{src:"".concat(e.$appDir,"auth/artificial-intelligence.svg"),alt:"",class:"img-fluid",width:"500"},null,8,u)])]),(0,t._)("div",p,[(0,t._)("div",m,[(0,t._)("div",g,[f,(0,t._)("form",{onSubmit:s[3]||(s[3]=function(){return k.login&&k.login.apply(k,arguments)})},[(0,t._)("div",w,[b,(0,t.wy)((0,t._)("input",{type:"email",class:"form-control","onUpdate:modelValue":s[0]||(s[0]=function(e){return y.user.email=e})},null,512),[[t.nr,y.user.email]]),(0,t.Wm)(S,{message:y.errors.email},null,8,["message"])]),(0,t._)("div",h,[v,(0,t.wy)((0,t._)("input",{type:"password",class:"form-control","onUpdate:modelValue":s[1]||(s[1]=function(e){return y.user.password=e})},null,512),[[t.nr,y.user.password]]),(0,t.Wm)(S,{message:y.errors.password},null,8,["message"])]),(0,t._)("button",{class:"btn btn-warning w-100 py-8 mb-4 rounded-2",onClick:s[2]||(s[2]=function(){return k.login&&k.login.apply(k,arguments)}),disabled:y.isLoading},(0,t.zw)(y.isLoading?"Please wait...":"Sign In"),9,x)],32)])])])])])])])}]])}}]);