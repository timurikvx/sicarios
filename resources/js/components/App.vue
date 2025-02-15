<template>
  <RouterView />
    <div v-if="store.state.error.length > 0" style="z-index: 10000" class="error flex grow">
        <div class="my-auto w-full">
            <div class="flex head select-none">
                <div>Ошибка</div>
                <div class="grow"></div>
                <div class="close" @click="close"></div>
            </div>
            <p class="content text-center">{{ store.state.error }}</p>
        </div>
    </div>
</template>

<script setup>

    import {RouterView} from "vue-router";
    import {useStore} from "vuex";

    const store = useStore();

    function close(){
        store.state.error = '';
    }

</script>

<style scoped>

</style>
