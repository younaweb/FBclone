<template>
  <!-- LEFT MENU -->
  <div class="w-1/5 pt-16 h-full hidden xl:flex flex-col fixed top-0 left-0">
    <ul class="p-4">
      <li>
        <a
          href="#"
          class="
            flex
            items-center
            space-x-2
            p-2
            hover:bg-gray-200
            rounded-lg
            transition-all
            dark:text-dark-txt dark:hover:bg-dark-third
          "
        >
          <img
          :src="authUser.data.attributes.profile_image.data.attributes.path" 
            alt="Profile picture"
            class="w-10 h-10 rounded-full"
          />
          <span class="font-semibold">Tran Anh Tuat</span>
        </a>
      </li>
      <li>
        <a
          href="#"
          class="
            flex
            items-center
            space-x-2
            p-2
            hover:bg-gray-200
            rounded-lg
            transition-all
            dark:text-dark-txt dark:hover:bg-dark-third
          "
        >
          <img
            :src="'/images/friends.png'"
            alt="Profile picture"
            class="w-10 h-10 rounded-full"
          />
          <span class="font-semibold">Friends</span>
        </a>
      </li>
      <li>
        <a
          href="#"
          class="
            flex
            items-center
            space-x-2
            p-2
            hover:bg-gray-200
            rounded-lg
            transition-all
            dark:text-dark-txt dark:hover:bg-dark-third
          "
        >
          <img
            :src="'/images/page.png'"
            alt="Profile picture"
            class="w-10 h-10 rounded-full"
          />
          <span class="font-semibold">Pages</span>
        </a>
      </li>
      <li>
        <a
          href="#"
          class="
            flex
            items-center
            space-x-2
            p-2
            hover:bg-gray-200
            rounded-lg
            transition-all
            dark:text-dark-txt dark:hover:bg-dark-third
          "
        >
          <img
            :src="'/images/memory.png'"
            alt="Profile picture"
            class="w-10 h-10 rounded-full"
          />
          <span class="font-semibold">Memories</span>
        </a>
      </li>
      <li>
        <a
          href="#"
          class="
            flex
            items-center
            space-x-2
            p-2
            hover:bg-gray-200
            rounded-lg
            transition-all
            dark:text-dark-txt dark:hover:bg-dark-third
          "
        >
          <img
            :src="'/images/group.png'"
            alt="Profile picture"
            class="w-10 h-10 rounded-full"
          />
          <span class="font-semibold">Groups</span>
        </a>
      </li>
      <li>
        <a
          href="#"
          class="
            flex
            items-center
            space-x-2
            p-2
            hover:bg-gray-200
            rounded-lg
            transition-all
            dark:text-dark-txt dark:hover:bg-dark-third
          "
        >
          <span
            class="
              w-10
              h-10
              rounded-full
              grid
              place-items-center
              bg-gray-300
              dark:bg-dark-second
            "
          >
            <i class="bx bx-chevron-down"></i>
          </span>
          <span class="font-semibold">See more</span>
        </a>
      </li>
      <li class="border-b border-gray-200 dark:border-dark-third mt-6"></li>
    </ul>
 
    <div class="mt-auto p-6 text-sm text-gray-500 dark:text-dark-txt">
      <a href="#">Privacy</a>
      <span>.</span>
      <a href="#">Terms</a>
      <span>.</span>
      <a href="#">Advertising</a>
      <span>.</span>
      <a href="#">Cookies</a>
      <span>.</span>
      <a href="#">Ad choices</a>
      <span>.</span>
      <a href="#">More</a>
      <span>.</span>
      <span>Facebook © 2021</span>
    </div>
  </div>
  <!-- END LEFT MENU -->
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  computed:{
    ...mapGetters(['authUser']),
  }
};
</script>

<style>
</style>