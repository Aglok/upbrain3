<template>
        <v-layout row list-progresses scroll>
            <v-flex xs12>
                <v-card>
                    <v-list three-line>
                        <template>
                            <v-subheader :key="header">{{ header }}</v-subheader>
                            <v-list-tile v-for="(item, index) in progresses()" :key="item.name" avatar>
                                <div class="v-list__tile v-list__tile--link v-list__tile--avatar">
                                    <div class="v-avatar">
                                        <img :src="item.image">
                                    </div>
                                </div>
                                <v-list-tile-content>
                                    <v-list-tile-title v-html="item.name"></v-list-tile-title>
                                    <v-list-tile-sub-title v-html="item.description"></v-list-tile-sub-title>
                                </v-list-tile-content>
                            </v-list-tile>
                        </template>
                    </v-list>
                </v-card>
            </v-flex>
        </v-layout>
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
                return this.$store.state.app.user.subjects[this.$store.state.app.subject].progresses;
            }
        }
    }
</script>

<style scoped>

</style>