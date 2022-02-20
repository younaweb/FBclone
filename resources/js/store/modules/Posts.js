const state={
    posts:null,
    postStatus:null,
    postMessage:'',
    commentContent:'',
};
const getters={
   
    posts: state => {
        return state.posts
    },
    postStatus:state=>{
        return {

            postStatus:state.postStatus
        }
            
    },
    postMessage:state=>{
        return state.postMessage
    },
    commentContent:state=>{
        return state.commentContent
    }
};
const actions={
    fetchPosts({commit,state}){
        this.commit('setPostStatus','Loading')
        axios.get('/api/posts')
        .then(res => {
            this.commit('setPosts',res.data)
            this.commit('setPostStatus','Success')
        })
        .catch(err => {
             this.commit('setPostStatus','Error')
        })
    },
    fetchUserPosts({ commit, actions }, userId) {
        this.commit("setPostStatus", "loading");

        axios
            .get("/api/users/" + userId + "/posts")
            .then((res) => {
                this.commit("setPosts", res.data);
                this.commit("setPostStatus", "success");
            })
            .catch((err) => {
                this.commit("setPostStatus", "error");
            });
    },
    storeNewMessage({commit,state}){
        axios.post('/api/posts',{ body: state.postMessage })
        .then(res => {
            this.commit('updateMessage','');
            this.commit('pushMessage',res.data);
        })
        .catch(err => {
        })
    },
    makeLike({commit,state},data){
        axios.post('/api/posts/'+data.postId+'/like')
        .then(res => {
            this.commit('pushLike',{like:res.data,key:data.postKey});
        })
        .catch(err => {
        })
    },
    storePostComment({commit,state},data){
        axios.post('/api/posts/'+data.postId+'/comment',{body:data.body})
        .then(res => {
            this.commit('pushComment',{comments:res.data,key:data.postKey});
            this.commit('setCommentContent','')

        })
        .catch(err => {
        })
    }

};
const mutations={
    setPostStatus(state,status){
        state.postStatus=status;
    },
    setPosts(state,posts){
        state.posts=posts;
    },
    setCommentContent(state,text){
        state.commentContent=text;
    },
    updateMessage(state,message){
        state.postMessage=message
    },
    pushMessage(state,message){
        state.posts.data.unshift(message)
    },
    pushLike(state,data){
        state.posts.data[data.key].data.attributes.likes=data.like

    },
    pushComment(state,data){
        state.posts.data[data.key].data.attributes.comments=data.comments

    }

};

export default {
    state, getters, actions, mutations,
}