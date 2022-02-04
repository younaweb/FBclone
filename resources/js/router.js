import Vue from "vue";
import VueRouter from "vue-router";
import FeedPosts from './views/FeedPosts'
import UserShow from './views/users/Show'
Vue.use(VueRouter);

export default new VueRouter({
    mode:'history',
    routes:[
        {
            path:'/',
            name:'home',
            component:FeedPosts,
            meta:{
                title:'News Feed'
            }
        },
        {
            path:'/users/:userId',
            name:'user.show',
            component:UserShow,
            meta:{
                title:'Profile'
            }
        }
    ]
});