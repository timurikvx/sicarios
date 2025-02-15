<template>
    <div class="player">
        <div class="progress" @click="seek($event)">
            <div class="value" :style="'width: ' + store.state.player.progress + '%'"></div>
        </div>
        <div class="main p-4">
            <div class="self-center">
                <div class="font-bold">{{ (track)? track.name: '' }}</div>
            </div>
            <div class="flex">
                <button @click="prev" class="self-center prev"></button>
                <button @click="play" class="px-4 self-center play" v-if="store.state.player.paused"></button>
                <button @click="pause" class="px-4 self-center pause" v-else></button>
                <button @click="next" class="self-center next"></button>
            </div>
            <div class="flex">
                <div class="grow"></div>
                <div class="self-center">{{ toDoubleString(currentTime.m) + ':' + toDoubleString(currentTime.s) }}</div>
                <div class="mx-1 self-center">/</div>
                <div class="self-center">{{ toDoubleString(duration.m) + ':' + toDoubleString(duration.s) }}</div>
            </div>
        </div>
    </div>
</template>

<script setup>

  import {useStore} from "vuex";
  import {onMounted, ref, defineEmits, defineExpose} from "vue";

  const store = useStore();
  const emits = defineEmits(['status']);

  defineExpose({
      play,
      setTrack,
      pause
  })

  //let audio = new Audio();
  //let context = new AudioContext();
  //let analyser = context.createAnalyser();
  //let source = null; //context.createMediaElementSource(audio);
  let duration = ref({h: 0, m: 0, s: 0});
  let currentTime = ref({h: 0, m: 0, s: 0});
  let track = ref(null);

  onMounted(()=>{

      let audio = store.state.player.audio;
      audio.addEventListener('play', onplay);
      audio.addEventListener('pause', onpause);
      audio.addEventListener('ended', onended);
      audio.addEventListener('timeupdate', function (e){
          currentTime.value = getDuration(audio.currentTime);
          if(!audio.duration){
              store.state.player.progress = 0;
          }else{
              store.state.player.progress = Math.floor(10000 * audio.currentTime / audio.duration) / 100;
          }
      });
      audio.addEventListener('durationchange', function (e){
          duration.value = getDuration(audio.duration);
      });
      track.value = store.getters['player/track'];
      store.state.player.muted = audio.muted;
      store.state.player.loop = audio.loop;
      store.state.player.paused = audio.paused;
      document.addEventListener('keydown', keydown)

  });

  function setTrack(current){
      track.value = store.getters['player/track'];
      if(!track.value){
          return;
      }
      if(Number.isInteger(current)){
          store.commit('player/current', current);
      }
      store.state.player.audio.src = track.value.src;
      store.state.player.audio.play();
  }

  function play(){
      store.state.player.audio.play();
      store.state.player.paused = store.state.player.audio.paused;
  }

  function getDuration(value){
      let m = Math.trunc(value / 60);
      let s = Math.trunc(value - (m * 60));
      return {
        h: 0,
        m: m,
        s: s
      }
  }

  function toDoubleString(value){
      if(value < 10){
          return '0' + value;
      }
      return value;
  }

  function next(){
      store.commit('player/next');
      setTrack();
  }

  function prev(){
      store.commit('player/prev');
      setTrack();
  }

  function pause(){
      let audio = store.state.player.audio;
      audio.pause();
      store.state.player.muted = audio.muted;
      store.state.player.loop = audio.loop;
      store.state.player.paused = audio.paused;
  }

  function onplay(e){
      let audio = store.state.player.audio;
      store.state.player.muted = audio.muted;
      store.state.player.loop = audio.loop;
      store.state.player.paused = audio.paused;
      store.state.player.play = true;
      status();
  }

  function onpause(e){
      //console.log('onpause', e);
      let audio = store.state.player.audio;
      store.state.player.muted = audio.muted;
      store.state.player.loop = audio.loop;
      store.state.player.paused = audio.paused;
      store.state.player.play = false;
      status();
  }

  function onended(e){
      let audio = store.state.player.audio;
      store.state.player.muted = audio.muted;
      store.state.player.loop = audio.loop;
      store.state.player.paused = audio.paused;
      store.state.player.play = !store.state.player.paused;
      status();
  }

  function status(){
      let data = {
          track: track.value,
          paused: store.state.player.paused,
          muted: store.state.player.muted,
          play: store.state.player.play,
          audio: store.state.player.audio,
          album: store.state.player.album,
      }
      emits('status', data);
      store.state.player.status = data;
  }

  function keydown(e){
      if(e.which === 32){
          space();
      }
  }

  function space(){
        if(store.state.player.paused){
            play();
        }else{
            pause();
        }
  }

  function seek(e){
      let audio = store.state.player.audio;
      let value = e.x / document.documentElement.clientWidth;
      if(value < 0.005){
          value = 0;
          audio.currentTime = 0;
      }else if(value > 0.995){
          value = 100;
          next();
      }else{
          audio.currentTime = audio.duration * value;
      }
      store.state.player.progress = Math.floor(10000 * value) / 100;
  }

</script>

<style scoped>

</style>
