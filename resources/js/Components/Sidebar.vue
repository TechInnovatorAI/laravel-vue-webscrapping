<template lang="">
    <div>
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
                <div
                    class="brand-logo d-flex align-items-center justify-content-between"
                >
                    <a href="/" class="text-nowrap logo-img">
                        <img
                            :src="`${$appDir}logo.gif`"
                            class="dark-logo"
                            width="180"
                            alt=""
                        />
                    </a>
                    <div
                        class="close-btn d-lg-none d-block cursor-pointer"
                        @click="onClose"
                    >
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav scroll-sidebar" data-simplebar>
                    <ul id="sidebarnav">
                        <!-- ============================= -->
                        <!-- Home -->
                        <!-- ============================= -->
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Menu</span>
                        </li>
                        <!-- =================== -->
                        <!-- Dashboard -->
                        <!-- =================== -->
                        <div v-if="isVisible">
                            <li class="sidebar-item">
                                <router-link
                                    class="sidebar-link"
                                    to="/dashboard"
                                    aria-expanded="false"
                                    @click="onClose"
                                >
                                    <span>
                                        <img
                                            :src="`${$appDir}menu/dashboard.png`"
                                            style="height: 20px"
                                        />
                                    </span>
                                    <span class="hide-menu">Tournament</span>
                                </router-link>
                            </li>
                            <li class="sidebar-item">
                                <router-link
                                    class="sidebar-link"
                                    to="/tournament-archive"
                                    aria-expanded="false"
                                    @click="onClose"
                                >
                                    <span>
                                        <img
                                            :src="`${$appDir}menu/books.png`"
                                            style="height: 20px"
                                        />
                                    </span>
                                    <span class="hide-menu"
                                        >Tournament Archive</span
                                    >
                                </router-link>
                            </li>
                            <li class="sidebar-item">
                                <router-link
                                    class="sidebar-link"
                                    to="/tournament-type"
                                    aria-expanded="false"
                                    @click="onClose"
                                >
                                    <span>
                                        <img
                                            :src="`${$appDir}menu/types.png`"
                                            style="height: 20px"
                                        />
                                    </span>
                                    <span class="hide-menu"
                                        >Tournament Types</span
                                    >
                                </router-link>
                            </li>
                            <li class="sidebar-item">
                                <router-link
                                    class="sidebar-link"
                                    to="/athlete-rankings"
                                    aria-expanded="false"
                                    @click="onClose"
                                >
                                    <span>
                                        <img
                                            :src="`${$appDir}menu/athletes.png`"
                                            style="height: 20px"
                                        />
                                    </span>
                                    <span class="hide-menu"
                                        >Athlete Ranking</span
                                    >
                                </router-link>
                            </li>
                            <!-- <li class="sidebar-item">
                            <router-link class="sidebar-link" to="/tournament-filter" aria-expanded="false" @click="onClose">
                                <span>
                                    <img :src="`${$appDir}menu/ranking.png`" style="height:20px" />
                                </span>
                                <span class="hide-menu">Ranking</span>
                            </router-link>
                            </li> -->
                            <li class="sidebar-item">
                                <router-link
                                    class="sidebar-link"
                                    to="/settings"
                                    aria-expanded="false"
                                    @click="onClose"
                                >
                                    <span>
                                        <img
                                            :src="`${$appDir}menu/gear.png`"
                                            style="height: 20px"
                                        />
                                    </span>
                                    <span class="hide-menu">Settings</span>
                                </router-link>
                            </li>
                        </div>
                        <div v-else>
                            <li class="sidebar-item">
                                <router-link
                                    class="sidebar-link"
                                    to="/athlete-rankings"
                                    aria-expanded="false"
                                    @click="onClose"
                                >
                                    <span>
                                        <img
                                            :src="`${$appDir}menu/athletes.png`"
                                            style="height: 20px"
                                        />
                                    </span>
                                    <span class="hide-menu"
                                        >Athlete Ranking</span
                                    >
                                </router-link>
                            </li>
                        </div>
                        <li class="sidebar-item">
                            <a
                                class="sidebar-link"
                                href="javascript:void(0)"
                                @click="logout"
                                aria-expanded="false"
                            >
                                <span>
                                    <img
                                        :src="`${$appDir}menu/signout.png`"
                                        style="height: 20px"
                                    />
                                </span>
                                <span class="hide-menu">Sign Out</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
    </div>
</template>
<script>
import { auth } from '../initFirebase';
export default {
    data() {
        return {
            isVisible: true
        };
    },
    methods: {
        logout() {
            localStorage.clear();
            this.noti("success", "Logged out successfully");
            window.location.href = "/";
        },
    },
    created() {
        const user = auth.currentUser;
        if (!user) {
            window.location.href = "/";
        } else {
            const email = user.email;
            if ( email == "keysven0@gmail.com" || email == "maurocomendulli@gmail.com" ) {
                localStorage.setItem('User_Type', "admin");
            } else {
                localStorage.setItem('User_Type', "user");
            }
        }
        let user_type = localStorage.getItem('User_Type');
        if (user_type == "admin") {
            this.isVisible = true;
        } else { this.isVisible = false;
        }
    },
};
</script>
<style>
.active-link {
    background-color: #d08d12;
    color: #fff !important;
}
</style>
