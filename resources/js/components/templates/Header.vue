<template>
    <div class="header">
        <div class="grow"></div>
        <RouterLink to="/events" class="menu-item p-2 md:mx-4" :class="{current: (path === '/events')}">События</RouterLink>
        <RouterLink to="/media" class="menu-item p-2 md:mx-4" :class="{current: (path === '/media')}">Медиа</RouterLink>
        <RouterLink to="/" class="menu-item md:mx-4" :class="{current: (path === '/')}">
            <img src="/public/storage/sicarios.png" class="sicarios-img md:mx-4" alt="Официальный сайт группы Sicarios">
        </RouterLink>
        <RouterLink to="/photo" class="menu-item p-2 md:mx-4" :class="{current: (path === '/photo')}">Фото</RouterLink>
        <RouterLink to="/about" class="menu-item p-2 md:mx-4" :class="{current: (path === '/about')}">О нас</RouterLink>
        <div class="grow flex">
<!--            <div class="grow"></div>-->
<!--            <div class="flex my-auto justify-center grow">-->
<!--                <a class="vk_ref mr-2" target="_blank" href="https://vk.com/sicarios71" title="Группа Sicarios в контакте"></a>-->
<!--                <a class="ya_ref" target="_blank" href="https://music.yandex.ru/artist/7572335" title="Карточка на Яндекс музыке"></a>-->
<!--            </div>-->
        </div>
    </div>
</template>

<script setup>

    import {RouterLink} from "vue-router";
    const path = location.pathname;

</script>

<style scoped>

</style>
