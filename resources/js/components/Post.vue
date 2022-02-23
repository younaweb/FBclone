<template>
    <!-- POST -->
    <div
        class="shadow bg-white dark:bg-dark-second dark:text-dark-txt mt-4 rounded-lg"
    >
        <!-- POST AUTHOR -->
        <div class="flex items-center justify-between px-4 py-2">
            <div class="flex space-x-2 items-center">
                <div class="relative">
                    <img
                    :src="post.data.attributes.posted_by.data.attributes.profile_image.data.attributes.path"
                        alt="Profile picture"
                        class="w-10 h-10 rounded-full"
                    />
                    <span
                        class="bg-green-500 w-3 h-3 rounded-full absolute right-0 top-3/4 border-white border-2"
                    ></span>
                </div>
                <div>
                    <div class="font-semibold">
                        {{
                            post.data.attributes.posted_by.data.attributes.name
                        }}
                    </div>
                    <span class="text-sm text-gray-500">
                        {{ post.data.attributes.posted_at }}
                    </span>
                </div>
            </div>
            <div
                class="w-8 h-8 grid place-items-center text-xl text-gray-500 hover:bg-gray-200 dark:text-dark-txt dark:hover:bg-dark-third rounded-full cursor-pointer"
            >
                <i class="bx bx-dots-horizontal-rounded"></i>
            </div>
        </div>
        <!-- END POST AUTHOR -->

        <!-- POST CONTENT -->
        <div class="text-justify px-4 py-2">
            {{ post.data.attributes.body }}
        </div>
        <!-- END POST CONTENT -->

        <!-- POST IMAGE -->
        <div class="py-2" v-if="post.data.attributes.image!='http://fbclone.test/storage'">
            <img :src="post.data.attributes.image" alt="Post image" />
        </div>
        <!-- END POST IMAGE -->

        <!-- POST REACT -->
        <div class="px-4 py-2">
            <div class="flex items-center justify-between">
                <div class="flex flex-row-reverse items-center">
                    <span class="ml-2 text-gray-500 dark:text-dark-txt"
                        >{{ post.data.attributes.likes.like_count }} likes</span
                    >
                    <span
                        class="rounded-full grid place-items-center text-2xl -ml-1 text-red-800"
                    >
                        <i class="bx bxs-angry"></i>
                    </span>
                    <span
                        class="rounded-full grid place-items-center text-2xl -ml-1 text-red-500"
                    >
                        <i class="bx bxs-heart-circle"></i>
                    </span>
                    <span
                        class="rounded-full grid place-items-center text-2xl -ml-1 text-yellow-500"
                    >
                        <i class="bx bx-happy-alt"></i>
                    </span>
                </div>
                <div class="text-gray-500 dark:text-dark-txt">
                    <span>{{post.data.attributes.comments.comment_count}} comments</span>
                    
                </div>
            </div>
        </div>
        <!-- END POST REACT -->

        <!-- POST ACTION -->
        <div class="py-2 px-4">
            <div
                class="border border-gray-200 dark:border-dark-third border-l-0 border-r-0 py-1"
            >
                <div class="flex space-x-2">
                    <div
                        class="w-1/3 flex space-x-2 justify-center items-center hover:bg-gray-100 dark:hover:bg-dark-third text-xl py-2 rounded-lg cursor-pointer text-gray-500 dark:text-dark-txt"
                        @click="
                            $store.dispatch('makeLike', {
                                postId: post.data.post_id,
                                postKey: $vnode.key,
                            })
                        "
                        :class="[
                            post.data.attributes.likes.user_like_post
                                ? 'bg-blue-600 text-white hover:bg-blue-400'
                                : '',
                        ]"
                    >
                        <i class="bx bx-like"></i>
                        <span class="text-sm font-semibold">Like</span>
                    </div>
                    <div
                        class="w-1/3 flex space-x-2 justify-center items-center hover:bg-gray-100 dark:hover:bg-dark-third text-xl py-2 rounded-lg cursor-pointer text-gray-500 dark:text-dark-txt"
                    >
                        <i class="bx bx-comment"></i>
                        <span class="text-sm font-semibold" @click="xcomment=!xcomment">Comment</span>
                    </div>
                 
                </div>
            </div>
        </div>
        <!-- END POST ACTION -->

        <!-- LIST COMMENT -->
        <div class="py-2 px-4" v-if="xcomment">
            <!-- COMMENT -->
            <div class="flex space-x-2" v-for="comment in post.data.attributes.comments.data" :key="comment.comment_id">
                <img
                    :src="comment.data.attributes.commented_by.data.attributes.profile_image.data.attributes.path"
                    alt="Profile picture"
                    class="w-9 h-9 rounded-full"
                />
                <div>
                    <div
                        class="bg-gray-100 dark:bg-dark-third p-2 rounded-2xl text-sm"
                    >
                        <span class="font-semibold block">{{comment.data.attributes.commented_by.data.attributes.name}}</span>
                        <span
                            >{{comment.data.attributes.body}}</span
                        >
                    </div>
                    <div class="p-2 text-xs text-gray-500 dark:text-dark-txt">
                        <span class="font-semibold">{{comment.data.attributes.commented_at}}</span>
                      
                    </div>
                   
                    <!-- END COMMENT -->
                </div>
            </div>
            <!-- END COMMENT -->
          
        </div>
        <!-- END LIST COMMENT -->

        <!-- COMMENT FORM -->
        <div class="py-2 px-4">
            <div class="flex space-x-2">
                    <img :src="authUser.data.attributes.profile_image.data.attributes.path" alt="Profile picture" class="w-10 h-10 rounded-full">

                <div
                    class="flex-1 flex bg-gray-100 dark:bg-dark-third rounded-full items-center justify-between px-3"
                >
                    <input
                        type="text"
                        placeholder="Write a comment..."
                        class="outline-none bg-transparent flex-1"
                        v-model="commentContent"
                    />
                    <div class="flex space-x-0 items-center justify-center" v-if="commentContent" @click="$store.dispatch('storePostComment',{postId: post.data.post_id,body:commentContent,postKey:$vnode.key});xcomment=true">
                        <span
                            class="w-7 h-7 grid place-items-center rounded-full hover:bg-gray-200 cursor-pointer text-blue-500 dark:text-dark-txt dark:hover:bg-dark-second text-xl"
                            ><i class="bx bx-send"></i
                        ></span>
                      
                    </div>
                </div>
            </div>
        </div>
        <!-- END COMMENT FORM -->
    </div>
    <!-- END POST -->
</template>
<script>
import {mapGetters} from 'vuex'
export default {
    data(){
        return {

            xcomment:false,
        
        }

      
    },
    props: ["post"],
    
    computed:{
        ...mapGetters(['authUser']),
         commentContent:{
            get(){
                return this.$store.getters.commentContent
            },
            set(commentContent){
                this.$store.commit('setCommentContent',commentContent)
            }

        },
     
    },
 
};
</script>

<style></style>
