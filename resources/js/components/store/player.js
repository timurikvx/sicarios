import {ref} from "vue";

export default {
    namespaced: true,
    state: {
        audio: new Audio(),
        collection: [],
        current: 0,
        repeat: false,
        repeatOne: false,
        shuffle: false,
        duration: {h: 0, m: 0, s: 0},
        currentTime: {h: 0, m: 0, s: 0},
        play: false,
        muted: false,
        loop: false,
        paused: false,
        track: false,
        progress: 0,
        album: null,
        status: {}
    },
    getters:{
        track(state){
            return state.collection[state.current];
        },
        current(state){
            return state.current;
        }
    },
    mutations: {
        tracks(state, tracks){
            state.collection = tracks;
        },
        current(state, current) {
            state.current = current;
        },
        album(state, album){
            state.album = album;
            console.log('state.album', state.album);
        },
        next(state){
            state.progress = 0;
            let max = state.current + 1; //Math.min(state.current + 1, state.list.length - 1);
            if(max >= state.collection.length && !state.repeat){
                state.current = 0;
            }else{
                state.current = max;
            }
        },
        prev(state){
            state.progress = 0;
            let min = state.current - 1;
            if(min < 0 && !state.repeat){
                min = Math.max(0, state.collection.length - 1);
            }else if(min < 0){
                min = 0;
            }
            state.current = min;
        },
        play(state){

        }
    },
    actions: {

    }
}
