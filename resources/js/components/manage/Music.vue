<template>
    <div class="container flex flex-col grow overflow-hidden">
        <PerfectScrollbar class="new-release flex flex-col grow pr-4">
            <div class="mb-4 text-2xl border-bottom pb-4">Добавление релиза</div>
            <div class="flex grow mb-4">
                <div class="flex flex-col mr-4 w-1/2 area p-4">
                    <div class="pb-4 text-xl">Основное</div>
                    <input type="text" class="input mb-4" placeholder="Название" v-model="release.name">
                    <textarea class="input mb-4" placeholder="Описание" v-model="release.description"></textarea>
                    <input type="number" class="input mb-4" placeholder="Год" v-model="release.year">
                    <input ref="logo" type="file" accept="image/*">
                </div>
                <div class="grow flex flex-col w-1/2 area p-4">
                    <div class="flex mb-4">
                        <div class="pb-4 text-xl self-center">Треки</div>
                        <div class="grow"></div>
                        <button class="button" @click="addTrack">Добавить</button>
                    </div>
                    <div class="flex flex-col">
                        <div v-for="(track, index) in release.tracks" class="flex flex-col mb-4">
                            <input type="text" class="input grow mb-4" placeholder="Название" v-model="track.name">
                            <textarea class="input mb-4" placeholder="Описание" v-model="track.description"></textarea>
                            <div class="flex">
                                <input ref="files" type="file" class="grow" accept="audio/mp3">
                                <button @click="removeTrack(index)">Удалить</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex mb-4">
                <div class="grow"></div>
                <button class="button green p-2 font-bold uppercase" @click="create">Создать</button>
            </div>
        </PerfectScrollbar>
    </div>

</template>

<script setup>

    import {onMounted, ref} from "vue";
    import axios from "axios";
    import {useStore} from "vuex";

    const store = useStore();
    const logo = ref(null);
    const track = {
        name: '',
        description: '',
        file: null
    };
    let files = ref([]);
    let release = ref({
        name: '',
        description: '',
        year: '',
        logo: '',
        tracks: [],
    })

    onMounted(()=>{
        axios.post('/collection', {}).then(function (response){
            //store.state.music.collection = response.data;
        }).catch(function (error){
            console.error(error);
        });
    });

    function addTrack(){
        release.value.tracks.push(Object.assign({}, track));
    }

    function removeTrack(index){
        release.value.tracks.splice(index, 1);
    }

    function create(){

        if(!validation()){
            return;
        }

        let form_data = new FormData();
        form_data.append('name', release.value.name);
        form_data.append('description', release.value.description);
        form_data.append('logo', logo.value.files[0]);
        form_data.append('year', logo.value.year);
        form_data.append('tracks', release.value.tracks.length);
        for (let i in release.value.tracks){
            let track = release.value.tracks[i];
            form_data.append('track_name' + i, track.name);
            form_data.append('track_desc' + i, track.description);
            form_data.append('track_file' + i, files.value[i].files[0]);
        }
        axios.post('/release', form_data, {}).then(function (response){
            if(response.data.result){
                location.reload()
            }
        })
    }

    function validation(){
        let text = '';
        if(!release.value.name){
            text += 'Не заполнено наименование релиза\n';
        }
        if(!release.value.tracks.length){
            text += 'Не добавлены треки\n';
        }
        if(!logo.value.files.length){
            text += 'Не добавлено лого релиза\n';
        }
        for (let i in release.value.tracks){
            let t = release.value.tracks[i];
            if(!t.name){
                text += 'Не заполнено наименование трека\n';
            }
            if(!files.value[i].files.length){
                text += 'Не добавлен файл трека\n';
            }
        }
        store.state.error = text;
        return text.length == 0;
    }

</script>

<style scoped>



</style>
