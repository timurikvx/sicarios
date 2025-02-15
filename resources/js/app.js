import './bootstrap';


import { createApp } from 'vue';
import { createStore } from 'vuex'
import router from "./router.js";
import { PerfectScrollbarPlugin } from 'vue3-perfect-scrollbar'
import 'vue3-perfect-scrollbar/style.css';
import App from './components/App.vue';


//store modules
import music from './components/store/music.js'
import player from "./components/store/player.js";
import photo from "./components/store/photo.js";

const store = createStore({
    state: {
        test: 'Sicarios',
        error: '',
        windows:{
            image: false,
        }
    },
    getters: {

    },
    mutations: {

    },
    modules: {
        music,
        player,
        photo
    }
})

const app = createApp(App);
app.use(router);
app.use(store);
//app.use(VueAxios, axios);
app.use(PerfectScrollbarPlugin);
app.mount('#app')
