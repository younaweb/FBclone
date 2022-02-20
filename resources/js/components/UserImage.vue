<template>
<div>
   <img
        :class="classes"
       
        ref="userImg"
        :src="imageObject.data.attributes.path"
        :alt="alt"
      />
    
</div>
</template>

<script>
import dropZone from 'dropzone';
export default {
    name:'UserImage',
    data(){
        return{
            zoneImage:null,
            uploadedImage:null,
        }
    },
    mounted(){
        this.zoneImage= new dropZone(this.$refs.userImg,this.settings) 

    },
    props:['imageHeight','imageWidth','imageLocation','userIm','classes','alt'],
    computed:{
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
                    this.uploadedImage=res;
                }
            }
        },
        imageObject(){
            return this.uploadedImage || this.userIm;
        }
    }



}
</script>

<style>

</style>