import {
    mapState,
    mapMutations
} from 'vuex'

const myPlugins = {
    install(Vue) {
        Vue.mixin({
            data: () => ({
                

            }),
            computed: {
                ...mapState([
                    'userDeposit',
                    'toTrading',
                    'loggedInUser',
                    'ASSET'

                ]),
            },
            methods: {
                ...mapMutations([
                    
                ])
            }
        })
    }
}

export default myPlugins