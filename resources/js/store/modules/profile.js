const state = {
    user: null,
    userStatus: null,
   
};
const getters = {
    getUser: (state) => {
        return state.user;
    },
   
    getStatus: (state) => {
        return {
            user:state.userStatus,
            posts:state.postStatus,
        };
    },
    getFriendShip: (state) => {
        return state.user.data.attributes.friendship;
    },
    getFriendButtonText: (state, getters, rootState) => {
        if (rootState.User.user.data.user_id == getters.getUser.data.user_id) {
            return "";
        }
        if (getters.getFriendShip == null) {
            return "Add Friend";
        } else if (
            getters.getFriendShip.data.attributes.confirmed_at == null &&
            getters.getFriendShip.data.attributes.friend_id !=
                rootState.User.user.data.user_id
        ) {
            return "Pending Friend Request";
        } else if (getters.getFriendShip.data.attributes.confirmed_at != null) {
            return "";
        }
        return "Accept";
    },
};
const actions = {
    fetchUser({ commit, actions }, userId) {
        this.commit("setUserStatus", "loading");
        axios
            .get("/api/users/" + userId)
            .then((res) => {
                this.commit("setUser", res.data);
                this.commit("setUserStatus", "success");
            })
            .catch((err) => {
                this.commit("setUserStatus", "error");
            });
    },
    
    makeFriendRequest({ commit, getters }, friendId) {
        if (getters.getFriendButtonText == "Add Friend") {
            axios
                .post("/api/friend-request", { friend_id: friendId })
                .then((res) => {
                    this.commit("setFriendShip", res.data);
                })
                .catch((err) => {});
        }
    },
    acceptFriendRequest({ commit, getters }, userId) {
        axios
            .post("/api/friend-request-response", { user_id: userId })
            .then((res) => {
                this.commit("setFriendShip", res.data);
            })
            .catch((err) => {});
    },
    ignoreFriendRequest({ commit, getters }, userId) {
        axios
            .delete("/api/friend-request-response/delete", {
                data: { user_id: userId },
            })
            .then((res) => {
                this.commit("setFriendShip", null);
            })
            .catch((err) => {});
    },
};
const mutations = {
    setUser(state, user) {
        state.user = user;
    },
  
    setUserStatus(state, userStatus) {
        state.userStatus = userStatus;
    },
 
    setFriendShip(state, text) {
        state.user.data.attributes.friendship = text;
    },
};

export default {
    state,
    getters,
    actions,
    mutations,
};
