const state={
    user:null,
    userStatus:true,
};
const getters={
   
    authUser: state => {
        return state.user;
    },
    userStatus:state=>{
        return state.userStatus;
    }
};
const actions={
    fetchAuthUser({commit,state}){
        axios.get('/api/auth-user')
        .then(res => {
            this.commit('setAuthUser',res.data)
        })
        .catch(err => {
            console.error(err); 
        }).finally(()=>{
            state.userStatus=false;
        })
    }
};
const mutations={
    setAuthUser(state,user){
        state.user=user;
    }
};

export default {
    state, getters, actions, mutations,
}