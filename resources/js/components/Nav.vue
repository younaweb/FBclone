<template>
   <!-- NAV -->
    <nav  class="bg-white dark:bg-dark-second h-max md:h-14 w-full shadow flex flex-col md:flex-row items-center justify-center md:justify-between fixed top-0 z-50 border-b dark:border-dark-third">

        <!-- LEFT NAV -->
        <div class="flex items-center justify-between w-full md:w-max px-4 py-2">
            <a href="#" class="mr-2 hidden md:inline-block">
                <img :src="'/images/fb-logo.png'" alt="Facebook logo" class="w-24 sm:w-20 lg:w-10 h-auto">
            </a>
            <a href="#" class="inline-block md:hidden">
                <img :src="'/images/fb-logo-mb.png'" alt="" class="w-32 h-auto">
            </a>
            <div class="flex items-center justify-between space-x-1">
                <div class="relative bg-gray-100 dark:bg-dark-third px-2 py-2 w-10 h-10 sm:w-11 sm:h-11 lg:h-10 lg:w-10 xl:w-max xl:pl-3 xl:pr-8 rounded-full flex items-center justify-center cursor-pointer">
                    <i class='bx bx-search-alt-2 text-xl xl:mr-2 dark:text-dark-txt'></i>
                    <input type="text" placeholder="Search Facebook" class="outline-none bg-transparent hidden xl:inline-block">
                </div>
                <div class="text-2xl grid place-items-center md:hidden bg-gray-200 dark:bg-dark-third rounded-full w-10 h-10 cursor-pointer hover:bg-gray-300 dark:text-dark-txt">
                    <i class='bx bxl-messenger'></i>
                </div>
                <div class="text-2xl grid place-items-center md:hidden bg-gray-200 dark:bg-dark-third rounded-full w-10 h-10 cursor-pointer hover:bg-gray-300 dark:text-dark-txt" id="dark-mode-toggle-mb">
                    <i class='bx bxs-moon'></i>
                </div>
            </div>
        </div>
        <!-- END LEFT NAV -->

        <!-- MAIN NAV -->
        <ul class="flex w-full lg:w-max items-center justify-center">
            <li class="w-1/5 md:w-max text-center">
                <router-link :to="'/'" class="w-full text-3xl py-2 px-3 xl:px-12 cursor-pointer text-center inline-block text-blue-500 border-b-4 border-blue-500">
                    <i class='bx bxs-home'></i>
                </router-link>
            </li>
            <li class="w-1/5 md:w-max text-center">
                <a href="#" class="w-full text-3xl py-2 px-3 xl:px-12 cursor-pointer text-center inline-block rounded text-gray-600 hover:bg-gray-100 dark:hover:bg-dark-third dark:text-dark-txt relative">
                    <i class='bx bx-movie-play'></i>
                    <span class="text-xs absolute top-0 right-1/4 bg-red-500 text-white font-semibold rounded-full px-1 text-center">9+</span>
                </a>
            </li>
            <li class="w-1/5 md:w-max text-center">
                <a href="#" class="w-full text-3xl py-2 px-3 xl:px-12 cursor-pointer text-center inline-block rounded text-gray-600 hover:bg-gray-100 dark:hover:bg-dark-third dark:text-dark-txt relative">
                    <i class='bx bx-store'></i>
                </a>
            </li>
            <li class="w-1/5 md:w-max text-center">
                <a href="#" class="w-full text-3xl py-2 px-3 xl:px-12 cursor-pointer text-center inline-block rounded text-gray-600 hover:bg-gray-100 dark:hover:bg-dark-third dark:text-dark-txt relative">
                    <i class='bx bx-group'></i>
                </a>
            </li>
            <li class="w-1/5 md:w-max text-center hidden md:inline-block">
                <a href="#" class="w-full text-3xl py-2 px-3 xl:px-12 cursor-pointer text-center inline-block rounded text-gray-600 hover:bg-gray-100 dark:hover:bg-dark-third dark:text-dark-txt relative">
                    <i class='bx bx-layout'></i>
                    <span class="text-xs absolute top-0 right-1/4 bg-red-500 text-white font-semibold rounded-full px-1 text-center">9+</span>
                </a>
            </li>
            <li class="w-1/5 md:w-max text-center inline-block md:hidden">
                <a href="#" class="w-full text-3xl py-2 px-3 xl:px-12 cursor-pointer text-center inline-block rounded text-gray-600 hover:bg-gray-100 dark:hover:bg-dark-third dark:text-dark-txt relative">
                    <i class='bx bx-menu'></i>
                </a>
            </li>
        </ul>
        <!-- END MAIN NAV -->

        <!-- RIGHT NAV -->
        <ul class="hidden md:flex mx-4 items-center justify-center">
            <li v-if="userStatus=='Loading'">loading...</li>
            <li class="h-full hidden xl:flex" v-else-if="userStatus=='success'">
                <router-link :to="'/users/'+authUser.data.user_id" class="inline-flex items-center justify-center p-1 rounded-full hover:bg-gray-200 dark:hover:bg-dark-third mx-1">
                    <img           :src="authUser.data.attributes.profile_image.data.attributes.path" 
 alt="Profile picture" class="rounded-full h-7 w-7">
                    <span class="mx-2 font-semibold dark:text-dark-txt">{{authUser.data.attributes.name}}</span>
                </router-link>
            </li>
          
            <li>
                <div class="text-xl grid place-items-center bg-gray-200 dark:bg-dark-third dark:text-dark-txt rounded-full mx-1 p-3 cursor-pointer hover:bg-gray-300 relative">
                    <i class='bx bxs-bell'></i>
                    <span class="text-xs absolute top-0 right-0 bg-red-500 text-white font-semibold rounded-full px-1 text-center">9</span>
                </div>
            </li>
            <li>
                <div class="text-xl grid place-items-center bg-gray-200 dark:bg-dark-third dark:text-dark-txt rounded-full mx-1 p-3 cursor-pointer hover:bg-gray-300 relative" id="dark-mode-toggle">
                    <i class='bx bxs-moon'></i>
                </div>
            </li>
        </ul>
        <!-- END RIGHT NAV -->
    </nav>
    <!-- END NAV -->
</template>

<script>

import { mapGetters } from 'vuex';
export default {
    computed:{
        ...mapGetters([

            'authUser','userStatus'
        ]
        )
    },
  
    mounted(){
      
    }


}
</script>

<style>

</style>