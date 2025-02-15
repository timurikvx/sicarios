export default {
    namespaced: true,
    state: {
        visible: false,
        files: [],
        photo: '',
        name: '',
        item: 0,
        current: 0,
    },
    getters:{

    },
    mutations: {
        files(state, files){
            state.files = files;
            state.photo = state.files[state.item]?.files[state.current];
            state.name = state.files[state.item]?.name;
        },
        next(state){
            let files = state.files[state.item]?.files;
            if(state.current == (files.length - 1)){
                state.current = 0;
                if(state.item == (state.files.length - 1)){
                    state.item = 0;
                }else{
                    state.item++;
                }
            }else{
                state.current++;
            }
            state.photo = state.files[state.item]?.files[state.current];
            state.name = state.files[state.item]?.name;
        },
        prev(state){
            let files = state.files[state.item]?.files;
            if(state.current == 0){
                if(state.item == 0){
                    state.item = (state.files.length - 1);
                    files = state.files[state.item]?.files;
                    state.current = (files.length - 1);
                }else{
                    state.item--;
                    files = state.files[state.item]?.files;
                    state.current = (files.length - 1);
                }
            }else{
                state.current--;
            }
            state.photo = state.files[state.item]?.files[state.current];
            state.name = state.files[state.item]?.name;
        }
    },
    actions: {

    }
}
