<template>
  <!-- MAIN CONTENT -->
  <div class="w-full lg:w-2/3 xl:w-2/5 pt-32 lg:pt-16 px-2">
  <div v-if="getUserStatus=='loading'">
             <scale-loader  ></scale-loader>
  </div>
   <div v-else class="card border w-full hover:shadow-none relative flex flex-col mx-auto shadow-lg m-5">
    <img class="max-h-20 w-full opacity-80 absolute top-0" style="z-index:-1" src="https://unsplash.com/photos/iFPBRwZ4I-M/download?force=true&w=640" alt="" />
    <div class="profile w-full flex m-3 ml-4 text-white">
      <img class="w-28 h-28 p-1 bg-white rounded-full" src="https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg?crop=faces&fit=crop&h=200&w=200&auto=compress&cs=tinysrgb" alt=""/>
      <div class="title mt-11 ml-3 font-bold flex flex-col">
        <div class="name break-words">{{getUser.data.attributes.name}} </div>
        <!--  add [dark] class for bright background -->
        <div class="add font-semibold text-sm italic dark">Laravel developer</div>
      </div>
    </div>
    <div class="buttons flex absolute bottom-0 font-bold right-0 text-xs text-gray-500 space-x-0 my-3.5 mr-3">
      <button v-if="getFriendButtonText && getFriendButtonText!='Accept'" @click="$store.dispatch('makeFriendRequest',getUser.data.user_id)" class="add border rounded-l-2xl rounded-r-sm border-gray-300 p-1 px-4 cursor-pointer hover:bg-gray-700 hover:text-white">{{getFriendButtonText}} </button>
      <!-- <div class="add border rounded-r-2xl rounded-l-sm border-gray-300 p-1 px-4 cursor-pointer hover:bg-gray-700 hover:text-white">Bio</div> -->
    </div>
    <div class="buttons flex absolute bottom-0 font-bold right-8 text-xs text-gray-500 space-x-0 my-3.5 mr-3">
      <button v-if="getFriendButtonText==='Accept'" @click="$store.dispatch('acceptFriendRequest',$route.params.userId)" class="add border rounded-l-2xl rounded-r-sm border-green-300 bg-green-400 p-1 px-4 cursor-pointer hover:bg-green-700 text-white">Accept </button>
      <!-- <div class="add border rounded-r-2xl rounded-l-sm border-gray-300 p-1 px-4 cursor-pointer hover:bg-gray-700 hover:text-white">Bio</div> -->
      <button v-if="getFriendButtonText==='Accept'" @click="$store.dispatch('ignoreFriendRequest',$route.params.userId)" class="add border rounded-r-2xl rounded-l-sm border-gray-300 p-1 px-4 cursor-pointer hover:bg-red-700 hover:text-white">Ignore </button>
    </div>
   
  </div>

  <div v-if="! postsLoading && posts.data.length==0">No posts yet ...get started</div>
  <!-- show posts -->
  <!-- LIST POST -->

            <div>

           <div v-if="postsLoading">
                      <scale-loader  ></scale-loader>
           </div>
          <post v-else v-for="post in posts.data" :key="post.data.post_id" :post="post"/>
             

            </div>

            <!-- END LIST POST -->
  <!-- end show posts -->
  
  </div>
  <!-- END MAIN CONTENT -->

</template>

<script>
import Post from '../../components/Post.vue'
import ScaleLoader from 'vue-spinner/src/ScaleLoader.vue'
import {mapGetters} from 'vuex'
export default {
    components:{
        Post,
        ScaleLoader
    },
  data() {
    return {
      postsLoading: true,
      posts: null,
    };
  },
  mounted() {
   this.$store.dispatch('fetchUser',this.$route.params.userId );
    axios
      .get("/api/users/"+this.$route.params.userId +'/posts')
      .then((res) => {
        this.posts = res.data;
      })
      .catch((err) => {
        console.error(err);
      })
      .finally(() => {
        this.postsLoading = false;
      });
  },
  computed:{
    ...mapGetters(['getUser','getUserStatus','getFriendButtonText'])
  }
};
</script>

<style>
  .dark{color:rgba(55, 65, 81,1);}

</style>