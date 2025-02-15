<template>
    <Header></Header>
    <div class="grow flex flex-col overflow-hidden">
        <div class="container flex flex-col overflow-hidden mb-10">
            <perfect-scrollbar>
                <div v-for="(photo, i) in photos" class="mb-4">
                    <div class="mr-4">
                        <div class="mb-4 bottom-line pb-2">{{ photo.name }}</div>
                        <div class="flex justify-center flex-wrap">
                            <div v-for="(file, c) in photo.files" class="flex image_min relative">
                                <div class="photo_wrap"  @click="showImage(file, i, c)"></div>
                                <img class="photo" :src="'/storage' + file">
                            </div>
                        </div>
                    </div>
                </div>
            </perfect-scrollbar>
        </div>
    </div>
    <Player></Player>
    <ImageShow></ImageShow>
</template>

<script setup>

    import Header from "./templates/Header.vue";
    import Player from "./templates/Player.vue";
    import axios from "axios";
    import {onMounted, ref} from 'vue'
    import {useStore} from "vuex";
    import ImageShow from "./templates/ImageShow.vue";

    const store = useStore();
    let photos = ref([]);

    onMounted(()=>{
        list();
    })

    function showImage(file, i, c){
        store.state.photo.item = i;
        store.state.photo.current = c;
        store.commit('photo/files', photos.value);
        setTimeout(function (){
            store.state.photo.visible = true;
        }, 50);
    }

    function list(){
        axios.post('/photos').then(function (response){
            photos.value = response.data;
        })
    }


</script>

<style scoped>

</style>
