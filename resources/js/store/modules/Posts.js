const state={
    newsPosts:null,
    newsStatus:null,
    postMessage:'',
};
const getters={
   
    newsPosts: state => {
        return state.newsPosts
    },
    newsStatus:state=>{
        return {

            newsPostsStatus:state.newsStatus
        }
            
    },
    postMessage:state=>{
        return state.postMessage
    }
};
const actions={
    fetchNewsPosts({commit,state}){
        this.commit('setNewsStatus','Loading')
        axios.get('/api/posts')
        .then(res => {
            this.commit('setNewsPosts',res.data)
            this.commit('setNewsStatus','Success')
        })
        .catch(err => {
             this.commit('setNewsStatus','Error')
        })
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

};
const mutations={
    setNewsStatus(state,status){
        state.newsStatus=status;
    },
    setNewsPosts(state,posts){
        state.newsPosts=posts;
    },
    updateMessage(state,message){
        state.postMessage=message
    },
    pushMessage(state,message){
        state.newsPosts.data.unshift(message)
    },
    pushLike(state,data){
        state.newsPosts.data[data.key].data.attributes.likes=data.like

    }
};

export default {
    state, getters, actions, mutations,
}