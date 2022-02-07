<template>
  <div v-if="authUser">
    <Nav></Nav>
    <div class="flex justify-center h-screen">
      <left-sidebar></left-sidebar>
      <router-view :key="$route.fullPath"></router-view>
      <right-sidebar></right-sidebar>
    </div>
  </div>
</template>

<script>
import Nav from "./Nav.vue";
import LeftSidebar from "./LeftSidebar.vue";
import RightSidebar from "./RightSidebar.vue";
import { mapGetters } from "vuex";
export default {
  name: "App",

  components: {
    Nav,
    LeftSidebar,
    RightSidebar,
  },
  mounted() {
    this.$store.dispatch("fetchAuthUser");
  },
  computed: {
    ...mapGetters(["authUser"]),
  },
  created() {
    this.$store.dispatch("fetchPageTitle", this.$route.meta.title);
  },
  watch: {
    $route(to, from) {
      this.$store.commit("setTitle", to.meta.title);
    },
  },
};
</script>

<style>
</style>