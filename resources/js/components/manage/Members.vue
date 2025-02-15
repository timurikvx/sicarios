<template>
    <div class="container flex flex-col grow overflow-hidden">
        <div class="flex flex-col mb-4 border p-4 area">
            <div class="mb-2 text-xl mb-4">Добавление нового участника</div>
            <input type="text" class="input mb-2" v-model="member.name" placeholder="ФИО">
            <input type="text" class="input mb-2" v-model="member.role" placeholder="Специализация">
            <input type="text" class="input mb-2" v-model="member.description" placeholder="Доп описание участника">
            <input type="text" class="input mb-2" v-model="member.vk" placeholder="Ссылка VK">
            <div class="flex mb-4">
                <div class="grow self-center">Индекс в списке (для нужной сортировки участников)</div>
                <input type="number" class="input" v-model="member.number" min="0" max="100">
            </div>
            <input ref="photo" type="file" class="mb-2 text-cyan-50" accept="image/*">
            <div class="flex">
                <div class="grow"></div>
                <button class="button green" @click="add">Добавить</button>
            </div>
        </div>
        <perfect-scrollbar>
            <div class="mb-6 flex" v-for="item in members" :index="item.number">
                <div class="mr-4">
                    <img class="member_photo" :src="'/storage/' + item.photo">
                </div>
                <div class="grow flex flex-col">
                    <div class="mb-2 text-xl">{{ item.name }}</div>
                    <div class="mb-2 text-cyan-500">{{ item.role }}</div>
                    <div class="mb-2 text-sm text-gray-500">{{ item.description }}</div>
                    <a target="_blank" :href="item.vk" class="vk_ref mb-2"></a>
                    <div class="grow"></div>
                    <div class="flex">
                        <div class="grow"></div>
                        <button class="button red" @click="remove(item)">Удалить</button>
                    </div>
                </div>
            </div>
        </perfect-scrollbar>
    </div>
</template>

<script setup>

    import {onMounted, ref} from "vue";
    import axios from "axios";
    import {useStore} from "vuex";

    const store = useStore();

    const photo = ref(null);

    let members = ref([]);

    let member = ref({
        name: '',
        role: '',
        vk: '',
        description: '',
        number: 0,
        photo: ''
    })

    onMounted(()=>{
        getMembers();
    });

    function getMembers(){
        axios.post('/members').then(function (response){
            members.value = response.data;
        });
    }

    function add(){
        if(!member.value.name){
            store.state.error = 'Не указано ФИО';
            return;
        }
        if(!member.value.role){
            store.state.error = 'Не указана специализация';
            return;
        }
        if(!photo.value.files.length){
            store.state.error = 'Не добавлено фото';
            return;
        }

        let form_data = new FormData();
        form_data.append('name', member.value.name);
        form_data.append('role', member.value.role);
        form_data.append('vk', member.value.vk);
        form_data.append('number', member.value.number);
        form_data.append('description', member.value.description);
        form_data.append('photo', photo.value.files[0]);

        axios.post('/members/add', form_data).then(function (response){
            members.value = response.data;
            member.value.name = '';
            member.value.role = '';
            member.value.vk = '';
            member.value.number = 0;
            member.value.description = '';
            member.value.photo = '';
            photo.value = null;
        });
    }

    function remove(item){
        axios.post('/members/remove', item).then(function (response){
            console.log(response.data);
            members.value = response.data;
        });
    }

</script>

<style scoped>

</style>
