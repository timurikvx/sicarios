<template>
    <Header></Header>
    <div class="container flex flex-col grow overflow-hidden">
        <perfect-scrollbar class="flex flex-wrap">
            <div class="mb-6 flex flex-col grow md:flex-row lg:w-1/2" v-for="item in members" :index="item.number">
                <div class="md:mr-4 mb-4">
                    <img class="member_photo mx-auto" :src="'/storage/' + item.photo">
                </div>
                <div class="grow">
                    <div class="mb-2 text-xl">{{ item.name }}</div>
                    <div class="mb-2">{{ item.role }}</div>
                    <div class="mb-2 text-sm text-gray-500">{{ item.description }}</div>
                    <a target="_blank" :href="item.vk" class="vk_ref mb-2"></a>
                </div>
            </div>
        </perfect-scrollbar>
        <div class="py-6"></div>
        <div class="py-6"></div>
    </div>
    <Player></Player>
</template>

<script setup>

    import Header from "./templates/Header.vue";
    import {onMounted, ref} from "vue";
    import Player from "./templates/Player.vue";
    import axios from "axios";

    let members = ref([]);

    onMounted(()=>{
        getMembers();
    });

    function getMembers(){
        axios.post('/members').then(function (response){
            members.value = response.data;
        });
    }

</script>


<style scoped>

</style>
