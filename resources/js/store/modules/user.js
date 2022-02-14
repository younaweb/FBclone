const state={
    user:null,
    userStatus:null,
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
        this.commit('setUserStatus',"Loading")

        axios.get('/api/auth-user')
        .then(res => {
            this.commit('setAuthUser',res.data)
            this.commit('setUserStatus',"Success")
        })
        .catch(err => {
            this.commit('setUserStatus',"Error")
            ; 
        })
    }
};
const mutations={
    setAuthUser(state,user){
        state.user=user;
    },
    setUserStatus(state,user){
        state.userStatus=user;
    }
};

export default {
    state, getters, actions, mutations,
}