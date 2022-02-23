<template>
  <!-- POST FORM -->
  <div class="px-4 mt-4 shadow rounded-lg bg-white dark:bg-dark-second">
    <div
      class="p-2 border-b border-gray-300 dark:border-dark-third flex space-x-4"
    >
      <img
        :src="authUser.data.attributes.profile_image.data.attributes.path"
        alt="Profile picture"
        class="w-10 h-10 rounded-full"
      />

      <input
        class="
          flex-1
          bg-gray-100
          rounded-full
          flex
          items-center
          justify-start
          pl-4
          cursor-pointer
          dark:bg-dark-third
          text-gray-500 text-lg
          dark:text-dark-txt
        "
        placeholder="What's new ?"
        v-model="postMessage"
        debounce="500"
      />
      <transition name="fade">
        <button
          v-if="postMessage"
          @click="postHandler"
          class="
            w-1/3
            bg-gray-100
            flex
            space-x-2
            justify-center
            items-center
            hover:bg-gray-300
            dark:hover:bg-dark-third
            text-xl
            sm:text-3xl
            py-2
            rounded-lg
            cursor-pointer
            text-blue-500
          "
        >
          <i class="bx bx-message-add"></i>
        </button>
      </transition>
    </div>
    <div class="p-2 flex">
      <div
        ref="postImg"
        class="
          dz-clicable
          w-1/3
          flex
          space-x-2
          justify-center
          items-center
          hover:bg-gray-100
          dark:hover:bg-dark-third
          text-xl
          sm:text-3xl
          py-2
          rounded-lg
          cursor-pointer
          text-green-500
        "
      >
        <i class="bx bx-images dz-clicable"></i>
        <span
          class="
            text-xs
            dz-clicable
            sm:text-sm
            font-semibold
            text-gray-500
            dark:text-dark-txt
          "
          >Add Image</span
        >
      </div>
      <div class="dropzone-previews">
        <div id="dz-template" class="hidden">
          <div class="dz-preview dz-file-preview mt-4">
            <div class="dz-details">
              <img data-dz-thumbnail class="w-32 h-32" />

              <button data-dz-remove class="text-xs">REMOVE</button>
            </div>
            <div class="dz-progress">
              <span class="dz-upload" data-dz-upload></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END POST FORM -->
</template>

<script>
import dropZone from "dropzone";
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      postImage: null,
    };
  },
  mounted() {
    this.postImage = new dropZone(this.$refs.postImg, this.settings);
  },
  computed: {
    ...mapGetters(["authUser"]),
    settings() {
      return {
        paramName: "image",
        url: "/api/posts",
        acceptedFiles: "image/*",
        clickable: ".dz-clicable",
        autoProcessQueue: false,
        maxFiles: 1,
        previewsContainer: ".dropzone-previews",
        previewTemplate: document.querySelector("#dz-template").innerHTML,
        params: {
          width: 1200,
          height: 500,
        },
        sending: (file, xhr, formData) => {
          formData.append("body", this.$store.getters.postMessage);
        },
        headers: {
          "X-CSRF-TOKEN": document.head.querySelector("meta[name=csrf-token]")
            .content,
        },
        success: (e, res) => {
          this.postImage.removeAllFiles();

          this.$store.commit("pushMessage", res);
        },
        maxfilesexceeded: (file) => {
          this.postImage.removeAllFiles();
          this.postImage.addFile(file);
        },
      };
    },
    postMessage: {
      get() {
        return this.$store.getters.postMessage;
      },
      set(postMessage) {
        this.$store.commit("updateMessage", postMessage);
      },
    },
  },
  methods: {
    postHandler() {
      if (this.postImage.getAcceptedFiles().length) {
        this.postImage.processQueue();
      } else {
        this.$store.dispatch("storeNewMessage");
      }

      this.$store.commit("updateMessage", "");
    },
  },
};
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>