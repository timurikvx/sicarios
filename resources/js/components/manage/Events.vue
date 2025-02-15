<template>
    <div class="container flex flex-col grow overflow-hidden">
        <div class="flex flex-col grow overflow-hidden">
            <div class="mb-4 text-2xl border-bottom pb-4">Добавление события</div>
            <div class="flex">
                <input type="text" class="input grow" placeholder="Ссылка на встречу VK" v-model="url">
                <button class="button green p-2 font-bold uppercase" @click="load">Добавить</button>
            </div>
            <div class="mt-4 flex flex-col grow overflow-hidden">
                <div v-if="event.image" class="mb-4 flex flex-col">
                    <input class="mb-4 text-xl underline input grow" v-model="event.title">
                    <div class="flex" v-if="event.width <= event.height">
                        <img :src="event.image" class="image_event_h mr-4">
                        <textarea class="grow input" v-model="event.description"></textarea>
                    </div>
                    <div v-else class="flex flex-col">
                        <img :src="event.image" class="image_event mb-4">
                        <textarea class="grow input" v-model="event.description"></textarea>
                    </div>
                    <div class="flex">
                        <div class="grow"></div>
                        <button class="button" @click="add">Добавить</button>
                    </div>
                </div>
                <perfect-scrollbar>
                    <div v-for="event in events" class="event_item mr-4">
                        <a class="mb-4 text-xl underline" target="_blank" :href="event.url">{{ event.title }}</a>
                        <div class="flex" v-if="event.width <= event.height">
                            <img :src="event.image" class="image_event_h mr-4">
                            <div class="text-justify">{{ event.description }}</div>
                        </div>
                        <div v-else>
                            <img :src="event.image" class="image_event mb-4">
                            <div class="text-justify">{{ event.description }}</div>
                        </div>
                        <div class="flex">
                            <div class="grow"></div>
                            <button class="button red" @click="remove(event.url)">Удалить</button>
                        </div>
                    </div>
                </perfect-scrollbar>
            </div>
        </div>
    </div>
</template>

<script setup>

    import {onMounted, ref} from 'vue';
    import {useStore} from "vuex";
    import axios from "axios";

    const store = useStore();

    let event = ref({});
    let events = ref([]);
    let url = ref('');

    onMounted(()=>{
        events_list();
    })
    function load(){
        //@change="load($event.target.value)"
        if(!url.value){
            return;
        }
        axios.post('/events/ref', {url: url.value}).then(function (response){
            event.value = response.data;
        })
    }

    function add(){
        axios.post('/events/add', event.value).then(function (response){
            if(response.data.result){
                event.value = {};
                url.value = '';
                events.value = response.data.list;
            }
            if(response.data.error){
                store.state.error = response.data.error;
            }
        })
    }

    function remove(url){
        axios.post('/events/remove', {url: url}).then(function (response){
            if(response.data.result){
                events.value = response.data.list;
            }
        })
    }

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
