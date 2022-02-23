<template>
<div>
   <img
        :class="classes"
       
        ref="userImg"
        :src="userIm.data.attributes.path"
        :alt="alt"
      />
    
</div>
</template>

<script>
import dropZone from 'dropzone';
import { mapGetters } from "vuex";
export default {
    name:'UserImage',
    data(){
        return{
            zoneImage:null,
            
        }
    },
    mounted(){
       if(this.authUser.data.user_id== this.$route.params.userId){
            this.zoneImage= new dropZone(this.$refs.userImg,this.settings) 
       }

    },
    props:['imageHeight','imageWidth','imageLocation','userIm','classes','alt'],
    computed:{
        ...mapGetters(['authUser']),
        settings(){
            return{

                paramName:'image',
                url:'/api/user-image',
                acceptedFiles:'image/*',
                params:{
                    'width':this.imageWidth,
                    'height':this.imageHeight,
                    'location':this.imageLocation,
                },
                    headers: {
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content,
                    },
                success:(e,res) =>{
                    // console.log('data =====>',res);
                   
                        this.$store.dispatch('fetchPosts');
                        this.$store.dispatch('fetchAuthUser');
                    this.$store.dispatch("fetchUser", this.$route.params.userId);

                }
            }
        }
        
    }



}
</script>

<style>

</style>