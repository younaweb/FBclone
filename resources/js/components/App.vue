<template>
  <div>
  <Nav></Nav>
  <div class="flex justify-center h-screen">
  <left-sidebar></left-sidebar>
  <router-view></router-view>
  <right-sidebar></right-sidebar>
  </div>
  </div>
</template>

<script>
import Nav from "./Nav.vue"
import LeftSidebar from './LeftSidebar.vue'
import RightSidebar from './RightSidebar.vue'
export default {
  components:{
    Nav,
    LeftSidebar,
    RightSidebar
  }

}
</script>

<style>

</style>