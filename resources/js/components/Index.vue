
<template>
  <Header></Header>
    <div class="grow flex flex-col overflow-hidden">
        <div class="container flex flex-col overflow-hidden">
            <perfect-scrollbar class="">
<!--                <div class="flex mb-8">-->
<!--                    <div class="grow"></div>-->
<!--                    <div>-->
<!--                        <iframe class="video" src="https://www.youtube.com/embed/eyiOEdXVcs4?si=imfAIBAaxuDRSNSM" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>-->
<!--                    </div>-->
<!--                    <div class="grow"></div>-->
<!--                </div>-->
                <div class="mb-8">Последние релизы</div>
                <div class="gallery">
                    <div class="grow flex flex-wrap justify-center">
                        <div v-for="(item, key) in store.state.music.collection" class="item">
                            <div class="track-logo relative mb-4">
                                <img :src="item['folder'] + item['logo']" width="250" height="250" class="mx-auto">
                                <div class="wrap justify-center flex">
                                    <div class="m-auto cursor-pointer p-2 play" :class="{pause: (status.album === key && status.play)}" @click="play(item['folder'], item['data']['tracks'], 0, key)"></div>
                                </div>
                            </div>
                            <div class="border-top py-4 flex flex-col md:flex-row">
                                <div class="font-bold text-xl mb-2 md:mb-0">{{ item['data']['name'] }}</div>
                                <div class="grow"></div>
                                <div class="md:self-center year">{{ item['data']['year'] }}</div>
                            </div>
                            <div v-for="(track, i) in item['data']['tracks']" class="mb-2 mr-4 flex">
                                <div class="pr-4 cursor-pointer play min mr-2" :class="{pause: (status.track?.name === track['name'] && status.play)}" @click="play(item['folder'], item['data']['tracks'], i, key)"></div>
                                <div class="grow truncate">{{ track['name'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-8">Фотогалерея</div>
                <div v-for="(photo, i) in photos" class="mb-4 p-bottom">
                    <div class="mr-4">
                        <div class="mb-4 md:mb-2">{{ photo.name }}</div>
                        <div class="flex flex-wrap justify-center">
                            <div v-for="(file, c) in photo.files" class="flex image_min relative">
                                <div class="photo_wrap"  @click="showImage(file, i, c)"></div>
                                <img class="photo" :src="'/storage' + file">
                            </div>
                        </div>
                    </div>
                </div>
            </perfect-scrollbar>
        </div>
    </div>
  <Player ref="player" @status="playerStatus"></Player>
</template>

<script setup>

  import Header from "./templates/Header.vue";
  import {useStore} from "vuex";
  import Player from "./templates/Player.vue";
  import {onMounted, ref} from "vue";
  import axios from "axios";

  const store = useStore();
  const player = ref(null);

  let photos = ref([]);
  let status = ref({});

  onMounted(()=>{
      list();
      music();
  });

  function showImage(file, i, c){
      store.state.photo.item = i;
      store.state.photo.current = c;
      store.commit('photo/files', photos.value);
      setTimeout(function (){
          store.state.photo.visible = true;
      }, 50);
  }

  function list(){
      axios.post('/photos').then(function (response){
          photos.value = response.data;
      })
  }

  function music(){
      axios.post('/last', {}).then(function (response){
          store.state.music.collection = response.data;
          status.value = store.state.player.status;
      }).catch(function (error){
          console.error(error);
      });
  }

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
