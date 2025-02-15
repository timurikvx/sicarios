<template>
    <div v-if="store.state.photo.visible" class="image_show relative">
        <div class="prev_image image_move absolute" @click="prev"></div>
        <img :src="'/storage' + store.state.photo.photo">
        <div class="name">{{ store.state.photo.name }}</div>
        <div class="next_image image_move absolute" @click="next"></div>
    </div>
</template>

<script setup>

    import { onMounted, ref} from 'vue'
    import {useStore} from 'vuex';

    const store = useStore();

    onMounted(()=>{
        document.addEventListener('click', documentCLick);
    });

    function next(){
        store.commit('photo/next');
    }

    function prev(){
        store.commit('photo/prev');
    }

    function documentCLick(e){
        let element = e.target;
        if(!element.closest('.image_show') && store.state.photo.visible){
            store.state.photo.visible = false;
        }
    }

</script>

<style scoped>



</style>
