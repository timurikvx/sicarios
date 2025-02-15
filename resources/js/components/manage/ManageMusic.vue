<template>
    <div class="container flex flex-col grow overflow-hidden">
        <PerfectScrollbar class="">
            <div class="gallery">
                <div class="grow flex flex-wrap justify-center">
                    <div v-for="(item, key) in store.state.music.collection" class="item flex flex-col">
                        <div class="track-logo relative mb-4">
                            <img :src="item['folder'] + item['logo']" width="250" height="250" class="mx-auto">
                        </div>
                        <div class="border-top py-4 flex">
                            <div class="font-bold text-xl">{{ item['data']['name'] }}</div>
                            <div class="grow"></div>
                            <div class="self-center year">{{ item['data']['year'] }}</div>
                        </div>
                        <div v-for="(track, i) in item['data']['tracks']" class="mb-2 mr-4 flex">
                            <div class="grow">{{ track['name'] }}</div>
                        </div>
                        <div class="grow"></div>
                        <div class="flex">
                            <div class="grow"></div>
                            <button class="button red" @click="remove(item)">Удалить</button>
                        </div>
                    </div>
                </div>
            </div>
        </PerfectScrollbar>
    </div>
</template>

<script setup>

    import {onMounted, ref} from "vue";
    import {useStore} from "vuex";
    import axios from "axios";

    const store = useStore();

    onMounted(()=>{
        axios.post('/collection', {}).then(function (response){
            store.state.music.collection = response.data;
        }).catch(function (error){
            console.error(error);
        });
    });


    function remove(item){
        console.log(item);
        axios.post('/release/remove', {name: item.data.name}).then(function (response){
            store.state.music.collection = response.data;
        }).catch(function (error){
            console.error(error);
        });
    }

</script>

<style scoped>

</style>
