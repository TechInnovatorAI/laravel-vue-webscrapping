<template lang="">
    <div
        class="page-wrapper"
        id="main-wrapper"
        data-layout="vertical"
        data-sidebartype="full"
        data-sidebar-position="fixed"
        data-header-position="fixed"
    >
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100"
        >
            <div class="position-relative z-index-5">
                <div class="row">
                    <div class="col-xl-7 col-xxl-8">
                        <a
                            href="/"
                            class="text-nowrap logo-img d-block px-4 py-9 w-100"
                        >
                            <!-- <img :src="`${$appDir}logo.gif`" width="180" alt=""> -->
                        </a>
                        <div
                            class="d-none d-xl-flex align-items-center justify-content-center"
                            style="height: calc(100vh - 80px)"
                        >
                            <img
                                :src="`${$appDir}auth/artificial-intelligence.svg`"
                                alt=""
                                class="img-fluid"
                                width="500"
                            />
                        </div>
                    </div>
                    <div class="col-xl-5 col-xxl-4">
                        <div
                            class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4"
                        >
                            <div class="col-sm-8 col-md-6 col-xl-9">
                                <h2 class="mb-3 fs-7 fw-bolder">
                                    Welcome to Scraper
                                </h2>
                                <p class="mb-9">Continue Your Journey</p>
                                <div class="position-relative text-center my-4">
                                    <p
                                        class="mb-0 fs-4 px-3 d-inline-block bg-white text-dark z-index-5 position-relative"
                                    >
                                        Login
                                    </p>
                                    <span
                                        class="border-top w-100 position-absolute top-50 start-50 translate-middle"
                                    ></span>
                                </div>
                                <form @submit="login">
                                    <div class="mb-3">
                                        <label class="form-label"
                                            >Username</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="user.email"
                                        />
                                        <Error :message="errors.email" />
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label"
                                            >Password</label
                                        >
                                        <input
                                            type="password"
                                            class="form-control"
                                            v-model="user.password"
                                        />
                                        <Error :message="errors.password" />
                                    </div>

                                    <button
                                        class="btn btn-warning w-100 py-8 mb-4 rounded-2"
                                        @click="login"
                                        :disabled="isLoading"
                                    >
                                        {{
                                            isLoading
                                                ? "Please wait..."
                                                : "Sign In"
                                        }}
                                    </button>
                                    <div style="display: flex;justify-content: space-between;">
                                    <router-link to="/register"
                                        >Go to Register</router-link
                                    >
                                    <router-link to="/forgot"
                                        >forgot password?</router-link
                                    >
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
import Error from "../../Components/Error.vue";
import { getAuth, signInWithEmailAndPassword } from "firebase/auth";
import { ref } from "vue";
import * as firebase from "../../initFirebase";

const errMsg = ref();

export default {
    components: {
        Error,
    },
    data() {
        return {
            errors: {},
            user: {
                email: "",
                password: "",
                user_type: "",
            },
            isLoading: false,
        };
    },
    methods: {

        login(e) {
            e.preventDefault();
            signInWithEmailAndPassword(
                firebase.auth,
                this.user.email,
                this.user.password
            )
                .then((data) => {
                    this.noti("success", "Successfully logged in");
                    localStorage.setItem("accessToken", data.user.accessToken);
                    const currentTime = new Date().toISOString();
                    localStorage.setItem("logTime", currentTime);
                    this.axios.post(`${this.$apiUrl}auth/login`, { email: this.user.email }).then(response => {
                        if (this.user.email == "maurocomendulli@gmail.com" || "keysven0@gmail.com") {
                            this.user.user_type = "admin";
                            this.$router.push("/dashboard");
                        } else {
                            this.user.user_type = "user";
                            this.$router.push("/athlete-rankings");
                        }
                        localStorage.setItem("email", this.user.email)
                        localStorage.setItem("User_Type", this.user.user_type)
                        localStorage.setItem("updated_at", response.data.res.updated_at)
                        localStorage.setItem("ended_at", response.data.res.ended_at)
                    })
                })
                .catch(({ error }) => {
                    errMsg.value = "Email or Password was incorrect";
                    this.noti("error", errMsg.value);
                    switch (error.code) {
                        case "auth/invalid-email":
                            errMsg.value = "Invalid email";
                            this.noti("error", errMsg.value);

                            break;
                        case "auth/invalid-credential":
                            errMsg.value =
                                "no account with that email was found";
                            this.noti("error", errMsg.value);
                            break;
                        case "auth/wrong-password":
                            errMsg.value = "Incorrect password";
                            this.noti("error", errMsg.value);
                            break;
                        default:
                            errMsg.value = "Email or Password was incorrect";
                            this.noti("error", errMsg.value);
                            break;
                    }
                });
        },
    },
};
</script>
<style lang=""></style>
