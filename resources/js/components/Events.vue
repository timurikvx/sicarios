<template>
    <Header></Header>
    <perfect-scrollbar class="grow">
        <div class="container">
            <div v-for="event in events" class="event_item">
                <a class="mb-4 text-xl underline" target="_blank" :href="event.url">{{ event.title }}</a>
                <div class="flex" v-if="event.width <= event.height">
                    <img :src="event.image" class="image_event_h mr-4">
                    <div class="text-justify">{{ event.description }}</div>
                </div>
                <div class="" v-else>
                    <img :src="event.image" class="image_event mb-4">
                    <div class="text-justify">{{ event.description }}</div>
                </div>
            </div>
            <div class="py-10"></div>
        </div>
    </perfect-scrollbar>
    <Player></Player>
</template>

<script setup>

    import Header from "./templates/Header.vue";
    import Player from "./templates/Player.vue";
    import axios from "axios";
    import {onMounted, ref} from "vue";

    let events = ref([]);

    onMounted(()=>{
        events_list();
    });

    function events_list(){
        axios.post('/events').then(function (response){
            events.value = response.data;
        }).catch(function (error){
            console.error(error);
        })
    }

</script>

<style scoped>

</style>