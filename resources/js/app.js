
require('./bootstrap');
import Vue from 'vue'
import router from './router';
import App from './components/App';

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);


const app = new Vue({
    el: '#app',
    router,
    components:{
        App,
    }
});
