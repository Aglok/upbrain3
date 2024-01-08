<template>
    <v-container fluid>
        <v-row class="list-progresses scroll">
            <v-col cols="12">
                <v-card>
                    <v-list>
                        <v-subheader :key="header">{{ header }}</v-subheader>
                        <v-list-item two-line v-for="(item, index) in progresses()" :key="item.name">
                                <v-img aspect-ratio="1" :src="item.image" class="v-avatar"></v-img>
                            <v-list-item-content>
                                <v-list-item-title v-html="item.name"></v-list-item-title>
                                <v-list-item-subtitle v-html="item.description"></v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import {mapState} from 'vuex'
    export default {
        name: "Progresses",
        data () {
            return {
                header: 'Достижения',
            }
        },
        methods:{
            progresses: function () {
                return this.$store.state.app.user.progresses;
            }
        }
    }
</script>

<style scoped>

</style>