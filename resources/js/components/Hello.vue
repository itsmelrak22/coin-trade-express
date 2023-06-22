<template>
    <v-card>
        <v-card-title style="background-color:#B2DFDB">Home</v-card-title>
        <v-card-text>
            <p>HOME</p>
            <p>some transcations & logics here....</p>
            <v-btn color="success" @click="test">tex</v-btn>
        </v-card-text>
    </v-card>
</template>

<script>
export default {
    methods: {
        test(){
            // this.$socket.emit('newUpdate', "hello world")
            this.$socket.emit('newUpdate', { updateType: "ViewTrade" })
        }
    }

}
</script>