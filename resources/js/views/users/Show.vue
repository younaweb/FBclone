<template>
  <!-- MAIN CONTENT -->
  <div class="w-full lg:w-2/3 xl:w-2/5 pt-32 lg:pt-16 px-2">
    <div v-if="getStatus.user == 'loading'">
      <scale-loader></scale-loader>
    </div>
    
    <div
      v-else-if="getUser.data && getStatus.user == 'success'"
      class="
        card
        border
        w-full
        hover:shadow-none
        relative
        flex flex-col
        mx-auto
        shadow-lg
        m-5
      "
    >
      <user-image
        image-width="1500"
        image-height="700"
        image-location="cover"
        :user-im='getUser.data.attributes.cover_image'
        :classes="'max-h-20 w-full opacity-80 absolute top-0'"
        :alt="'Cover Image not displayed'"
      />
      <div class="profile w-full flex m-3 ml-4 text-white">
        <user-image
        image-width="750"
        image-height="750"
        image-location="profile"
        :user-im='getUser.data.attributes.profile_image'
        class="z-10"
        :classes="'w-28 h-28 p-1 bg-white rounded-full '"
        :alt="'profile image'"
      />
       
        <div class="title mt-11 ml-3 font-bold flex flex-col">
          <div class="name break-words">{{ getUser.data.attributes.name }}</div>
          <!--  add [dark] class for bright background -->
          <div class="add font-semibold text-sm italic dark">
            Laravel developer
          </div>
        </div>
      </div>
      <div
        class="
          buttons
          flex
          absolute
          bottom-0
          font-bold
          right-0
          text-xs text-gray-500
          space-x-0
          my-3.5
          mr-3
        "
      >
        <button
          v-if="getFriendButtonText && getFriendButtonText != 'Accept'"
          @click="$store.dispatch('makeFriendRequest', getUser.data.user_id)"
          class="
            add
            border
            rounded-l-2xl rounded-r-sm
            border-gray-300
            p-1
            px-4
            cursor-pointer
            hover:bg-gray-700 hover:text-white
          "
        >
          {{ getFriendButtonText }}
        </button>
        <!-- <div class="add border rounded-r-2xl rounded-l-sm border-gray-300 p-1 px-4 cursor-pointer hover:bg-gray-700 hover:text-white">Bio</div> -->
      </div>
      <div
        class="
          buttons
          flex
          absolute
          bottom-0
          font-bold
          right-8
          text-xs text-gray-500
          space-x-0
          my-3.5
          mr-3
        "
      >
        <button
          v-if="getFriendButtonText === 'Accept'"
          @click="$store.dispatch('acceptFriendRequest', $route.params.userId)"
          class="
            add
            border
            rounded-l-2xl rounded-r-sm
            border-green-300
            bg-green-400
            p-1
            px-4
            cursor-pointer
            hover:bg-green-700
            text-white
          "
        >
          Accept
        </button>
        <!-- <div class="add border rounded-r-2xl rounded-l-sm border-gray-300 p-1 px-4 cursor-pointer hover:bg-gray-700 hover:text-white">Bio</div> -->
        <button
          v-if="getFriendButtonText === 'Accept'"
          @click="$store.dispatch('ignoreFriendRequest', $route.params.userId)"
          class="
            add
            border
            rounded-r-2xl rounded-l-sm
            border-gray-300
            p-1
            px-4
            cursor-pointer
            hover:bg-red-700 hover:text-white
          "
        >
          Ignore
        </button>
      </div>
    </div>

    <!-- show posts -->
    <!-- LIST POST -->

    <div>
 
      <div v-if="getStatus.posts == 'loading'">
        <scale-loader></scale-loader>
      </div>
      <div v-else-if="posts.data.length < 1">No posts yet ...get started</div>
      <post
        v-else
        v-for="(post, postKey) in posts.data"
        :key="postKey"
        :post="post"
      />
    </div>

    <!-- END LIST POST -->
    <!-- end show posts -->
  </div>
  <!-- END MAIN CONTENT -->
</template>

<script>
import Post from "../../components/Post.vue";
import ScaleLoader from "vue-spinner/src/ScaleLoader.vue";
import { mapGetters } from "vuex";
import UserImage from "../../components/UserImage.vue";
export default {
  components: {
    Post,
    ScaleLoader,
    UserImage,
  },
  data() {
    return {
      x: true,
    };
  },
  mounted() {
    this.$store.dispatch("fetchUser", this.$route.params.userId);
    this.$store.dispatch("fetchUserPosts", this.$route.params.userId);
  },
  computed: {
    ...mapGetters(["getUser", "getStatus", "getFriendButtonText", "posts"]),
  },
};
</script>

<style>
.dark {
  color: rgba(55, 65, 81, 1);
}
</style>