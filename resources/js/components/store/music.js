export default {
    namespaced: true,
    state: {
        collection: {},
        current: 0,
        repeat: false,
        repeatOne: false,
        shuffle: false
    },
    getters:{

    },
    mutations: {
        next(state){
            let max = state.current + 1; //Math.min(state.current + 1, state.list.length - 1);
            if(max >= state.list.length && state.repeat){
                state.current = 0;
            }else{
                state.current = max;
            }
        }
    },
    actions: {
        init(ctx){
            console.log('init music');
        }
    }
}
