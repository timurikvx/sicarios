<template>
    <Header></Header>
    <PerfectScrollbar class="">
        <div class="gallery down">
            <div class="grow flex flex-wrap justify-center pl-2">
                <div v-for="(item, key) in store.state.music.collection" class="item">
                    <div class="track-logo relative mb-4">
                        <img :src="item['folder'] + item['logo']" width="250" height="250" class="mx-auto">
                        <div class="wrap justify-center flex">
                            <div class="m-auto cursor-pointer p-2 play" :class="{pause: (status.album === key && status.play)}" @click="play(item['folder'], item['data']['tracks'], 0, key)"></div>
                        </div>
                    </div>
                    <div class="border-top py-4 flex flex-col md:flex-row">
                        <div class="font-bold text-xl">{{ item['data']['name'] }}</div>
                        <div class="grow"></div>
                        <div class="self-center year">{{ item['data']['year'] }}</div>
                    </div>
                    <div v-for="(track, i) in item['data']['tracks']" class="mb-2 mr-4 flex">
                        <div class="pr-4 cursor-pointer play min mr-2" :class="{pause: (status.track?.name === track['name'] && status.play)}" @click="play(item['folder'], item['data']['tracks'], i, key)"></div>
                        <div class="grow truncate">{{ track['name'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </PerfectScrollbar>
    <Player ref="player" @status="playerStatus"></Player>
</template>

<script setup>

    import Header from "./templates/Header.vue";
    import axios from "axios";
    import {onMounted, ref} from "vue";
    import {useStore} from "vuex";
    import Player from "./templates/Player.vue";

    const store = useStore();
    const player = ref(null);
    let status = ref({});

    onMounted(()=>{
        axios.post('/collection', {}).then(function (response){
            store.state.music.collection = response.data;
            status.value = store.state.player.status;
        }).catch(function (error){
            console.error(error);
        });
    });

    function play(folder, data, current, album){
        let tracks = data.map(function (item){
            item['src'] = folder + item.file;
            return item;
        });
        current = current || 0;
        let track = tracks[current];
        if(status.value.album === album && track.name === status.value.track?.name){
            if(status.value.play) {
                player.value.pause();
            }else{
                player.value.play();
            }
        }else{
            store.commit('player/tracks', tracks);
            store.commit('player/album', album);
            store.commit('player/current', current);
            player.value.setTrack();
        }
    }

    function playerStatus(data){
        status.value = data;
    }

</script>

<style scoped>



</style>
