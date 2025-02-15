<template>
    <div class="container flex flex-col grow overflow-hidden">
        <div class="flex mb-4">
            <input type="text" class="input grow mr-4" v-model="name" placeholder="Имя события, если чтобы связать фото с событием">
            <button class="button green mr-4" @click="show">Добавить фото</button>
            <input ref="element_input" type="file" class="hidden" multiple accept="image/*" @change="count">
            <button class="button green" @click="upload">Загрузить</button>
        </div>
        <div class="flex mb-4">
            <div class="mr-2">Фотографий добавлено: </div>
            <div class="font-bold">{{ len }}</div>
        </div>
        <perfect-scrollbar>
            <div v-for="(photo, i) in photos" class="mb-4">
                <div class="mr-4">
                    <div class="mb-4 bottom-line pb-2">{{ photo.name }}</div>
                    <div class="flex justify-center flex-wrap">
                        <div v-for="(file, c) in photo.files" class="flex image_min relative select-none">
                            <div class="photo_wrap"  @click="showImage(file, i, c)"></div>
                            <div class="photo_close" @click="remove(i, file)"></div>
                            <img class="photo" :src="'/storage' + file">
                        </div>
                    </div>
                </div>
            </div>
        </perfect-scrollbar>
    </div>
    <ImageShow></ImageShow>
</template>

<script setup>

    import {onMounted, ref} from 'vue';
    import axios from "axios";
    import ImageShow from "../templates/ImageShow.vue";
    import {useStore} from "vuex";

    const element_input = ref([]);
    const store = useStore();

    let photos = ref([]);
    let name = ref('');
    let len = ref(0);

    onMounted(()=>{
        list();
    });

    function count(){
        len.value = element_input.value.files.length;
    }

    function show(){
        element_input.value.click();
    }

    function upload(){
        if(element_input.value.files.length === 0){
            store.state.error = 'Фотографии не добавлены';
            return;
        }
        let form_data = new FormData();
        form_data.append('name', name.value);
        for (let i in element_input.value.files){
            let photo = element_input.value.files[i];
            form_data.append('image_file' + i, photo);
        }
        axios.post('/photos_upload', form_data, {}).then(function (response){
            photos.value = response.data;
        });
    }

    function list(){
        axios.post('/photos').then(function (response){
            photos.value = response.data;
        })
    }

    function remove(i, file){
        axios.post('/photos_remove', {i: i, file: file}).then(function (response){
            photos.value = response.data;
        });
    }

    function showImage(file, i, c){
        store.state.photo.item = i;
        store.state.photo.current = c;
        store.commit('photo/files', photos.value);
        setTimeout(function (){
            store.state.photo.visible = true;
        }, 50);
    }

</script>

<style scoped>



</style>
