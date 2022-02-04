const state={
    user:null,
    userStatus:null,
    friendButtonText:null,
};
const getters={
   
    getUser: state => {
        return state.user;
    },
    getUserStatus:state=>{
        return state.userStatus;
    },
    getFriendShip:state=>{
        return state.user.data.attributes.friendship;
    },
    getFriendButtonText:state=>{
        return state.friendButtonText;
    }

};
const actions={
    fetchUser({commit,actions},userId){
        this.commit('setUserStatus','loading')
        axios
        .get("/api/users/" + userId)
        .then((res) => {
          this.commit('setUser', res.data);
          this.commit('setUserStatus','success')
        this.dispatch('fetchFriendButtonText')
        })
        .catch((err) => {
            this.commit('setUserStatus','error')

        });
        
    },
    makeFriendRequest({commit,getters},friendId){
        if(getters.getFriendButtonText=='Add Friend'){
            this.commit('setFriendButtonText','loading')
        axios.post('/api/friend-request',{'friend_id':friendId})
        .then(res => {
            this.commit('setFriendButtonText','Pending Friend Request')
        })
        .catch(err => {
            this.commit('setFriendButtonText','Add Friend')
        })
        }
        
    },
    fetchFriendButtonText({commit,getters}){
        if(getters.getFriendShip==null){
            this.commit('setFriendButtonText','Add Friend')
        }else if(getters.getFriendShip.data.attributes.confirmed_at==null){
            this.commit('setFriendButtonText','Pending Friend Request')

        }
    }

};
const mutations={
    setUser(state,user){
        state.user=user;
    },
    setUserStatus(state,userStatus){
        state.userStatus=userStatus
    },
    setFriendButtonText(state,text){
        state.friendButtonText=text;
    }
};

export default {
    state, getters, actions, mutations,
}