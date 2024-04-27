import { createStore } from 'vuex'
import cloneDeep from 'lodash/cloneDeep';

const store = createStore({
    state () {
        return {
            filters: {},
        }
    },
    mutations: {
        setFilters(state, filters){
            if(filters.length == 0){
                state.filters = cloneDeep({});
            } else{
                state.filters = cloneDeep(filters);
            }
        },
        updateFilters(state, info){
            let type = info.type;
            let typeId = info.id
            if(!state.filters[type]){
                state.filters[type] = [typeId];
            } else { 
                let index = state.filters[type].findIndex(id => id == typeId);
                if(index == -1){
                    state.filters[type].push(typeId)
                } else {
                    state.filters[type].splice(index, 1);
                }
            }
        }

    }
})

export default store