<template>
    <Header></Header>
    <div v-if="!auth" class="grow flex">
        <div class="m-auto auth">
            <div class="mb-4 font-bold text-center text-2xl">Авторизация</div>
            <div>
                <div class="grid mb-4">
                    <div class="self-center">Логин</div>
                    <input type="text" class="input" v-model="form.login">
                </div>
                <div class="grid mb-4">
                    <div class="self-center">Пароль</div>
                    <input type="password" class="input" v-model="form.pass">
                </div>
                <div class="flex">
                    <button class="button grow" @click="authentication">Войти</button>
                </div>
                <div v-if="error" class="alert p-2 mt-4 flex">
                    <div class="m-auto font-bold">{{ error }}</div>
                </div>
            </div>
        </div>
    </div>
    <div v-else class="flex flex-col grow overflow-hidden">
        <div class="flex">
            <div class="p-4 my-4 tab text-center grow cursor-pointer select-none" :class="{current: tab === 'music'}" @click="tab='music'">Добавление релиза</div>
            <div class="p-4 my-4 tab text-center grow cursor-pointer select-none" :class="{current: tab === 'gallery'}" @click="tab='gallery'">Управление релизами</div>
            <div class="p-4 my-4 tab text-center grow cursor-pointer select-none" :class="{current: tab === 'about'}" @click="tab='about'">Описание участников</div>
            <div class="p-4 my-4 tab text-center grow cursor-pointer select-none" :class="{current: tab === 'events'}" @click="tab='events'">События</div>
            <div class="p-4 my-4 tab text-center grow cursor-pointer select-none" :class="{current: tab === 'photo'}" @click="tab='photo'">Фотогалерея</div>
        </div>
        <div v-if="tab === 'music'" class="grow flex overflow-hidden">
            <Music></Music>
        </div>
        <div v-if="tab === 'gallery'" class="grow flex overflow-hidden">
            <ManageMusic></ManageMusic>
        </div>
        <div v-if="tab === 'events'" class="grow flex overflow-hidden">
            <Events></Events>
        </div>
        <div v-if="tab === 'photo'" class="grow flex overflow-hidden">
            <Photo></Photo>
        </div>
        <div v-if="tab === 'about'" class="grow flex overflow-hidden">
            <Members></Members>
        </div>
    </div>
</template>

<script setup>

    import Header from "./templates/Header.vue";
    import Music from "./manage/Music.vue";
    import ManageMusic from "./manage/ManageMusic.vue";
    import Events from "./manage/Events.vue";
    import Photo from "./manage/Photo.vue";
    import Members from "./manage/Members.vue";
    import {ref} from 'vue';
    import axios from "axios";

    let auth = ref(false);
    let error = ref('');
    let form = ref({
        login: '',
        pass: ''
    });
    let tab = ref('music');

    function authentication(){
        axios.post('/auth', form.value).then(function (response){
            if(response.data.auth){
                auth.value = response.data.auth;
            }else{
                error.value = 'Неверный логин или пароль';
            }
        }).catch(function (error){
            console.error(error);
        })
    }

</script>

<style scoped>

</style>
