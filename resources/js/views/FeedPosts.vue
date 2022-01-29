<template>
    <!-- MAIN CONTENT -->
        <div class="w-full lg:w-2/3 xl:w-2/5 pt-32 lg:pt-16 px-2">
           

           <new-post></new-post>

       

            <!-- LIST POST -->

            <div>

           <div v-if="loading">
           <scale-loader  ></scale-loader>
           </div>
          <post v-else v-for="post in posts.data" :key="post.data.post_id" :post="post"/>
             

            </div>

            <!-- END LIST POST -->
        </div>
        <!-- END MAIN CONTENT -->
</template>

<script>
import NewPost from "../components/NewPost.vue"
import Post from "../components/Post.vue"
import ScaleLoader from 'vue-spinner/src/ScaleLoader.vue'
export default {
  components:{
    NewPost,
    Post,
    ScaleLoader,
  },
  data(){
    return{
      posts:null,
      loading:true,
    }
  },
  mounted(){
    axios.get('api/posts')
    .then(res => {
      this.posts=res.data;
      this.loading=false;
    })
    .catch(err => {
      console.error(err); 
      this.loading=false;
    })
  }

}
</script>

<style>

</style>