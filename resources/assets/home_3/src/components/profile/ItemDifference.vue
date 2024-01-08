<template>
    <profile-window class="item-difference">
        <template v-slot:board-mm>
            <div class="board x-title">{{item.name}}</div>
            <div class="board x-tool" @click="item.active=false"></div>
        </template>
        <template v-slot:x-info>
            <div class="x-info">
                <div class="header">
                    <div class="image"><img :src=item.images.info :alt=item.name></div>
                    <div class="description">{{item.description}}</div>
                </div>
                <div class="details">
                    <div class="stuff-box">
                        <profile-item-info :item="item" can="canBuy"></profile-item-info>
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:x-toolbar>
            <div class="x-toolbar"></div>
        </template>
    </profile-window>
</template>

<script>
    import UserItemInfo from "./ItemInfo";
    export default {
        name: "user-item-difference",
        components: {UserItemInfo},
        props:{
            item:{
                type: Object,
                default: () => {}
            }
        },
        methods:{
        }

    }
</script>

<style scoped>
</style>