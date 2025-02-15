import IndexPage from "./components/Index.vue";
import AboutPage from "./components/About.vue";
import MediaPage from "./components/Media.vue";
import ManagePage from "./components/Manage.vue";
import EventsPage from "./components/Events.vue"
import PhotoPage from "./components/Photo.vue"

const routes = [
    { path: '/', component: IndexPage },
    { path: '/about', component: AboutPage },
    { path: '/media', component: MediaPage },
    { path: '/manage', component: ManagePage },
    { path: '/events', component: EventsPage },
    { path: '/photo', component: PhotoPage },
]

export default routes
