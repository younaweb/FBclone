<template>
    <!-- MAIN CONTENT -->
        <div class="w-full lg:w-2/3 xl:w-2/5 pt-32 lg:pt-16 px-2">
           

           <new-post></new-post>

       

            <!-- LIST POST -->

            <div>

           <div v-if="postStatus.postStatus=='Loading'">
           <scale-loader  ></scale-loader>
           </div>
          <post v-else v-for="(post,postKey) in posts.data" :key="postKey" :post="post"/>
             

            </div>

            <!-- END LIST POST -->
        </div>
        <!-- END MAIN CONTENT -->
</template>

<script>
import NewPost from "../components/NewPost.vue"
import Post from "../components/Post.vue"
import ScaleLoader from 'vue-spinner/src/ScaleLoader.vue'
import {mapGetters} from 'vuex'
export default {
  components:{
    NewPost,
    Post,
    ScaleLoader,
  },
 
  mounted(){
    this.$store.dispatch('fetchPosts');
  },
  computed:{
    ...mapGetters([
      'posts',
      'postStatus'


    ])
  }

}
</script>

<style>

</style>