<template>
    <profile-window class="item-details">
        <template v-slot:board-mm>
            <div class="board x-title">{{item.name}}</div>
            <div class="board x-tool" @click="item.active=false"></div>
        </template>
        <template v-slot:x-info>
            <div class="x-info">
                <div class="header">
                    <div class="image"><img :src=item.images.info :alt=item.name></div>
                    <div class="description">{{item.name}}</div>
                </div>
                <div class="details">
                    <div class="stuff-box">{{item.name}}</div>
                    <div class="stuff-box">{{item.data.stats.damage}}</div>
                </div>
            </div>
        </template>
        <template v-slot:x-toolbar>
            <div class="x-toolbar">
                <div class="btn-tool">Снять</div>
                <div class="btn-tool">Изменить</div>
            </div>
        </template>
    </profile-window>
</template>

<script>
    export default {
        name: "user-item-details",
        props:{
            item:{}
        }
    }
</script>

<style scoped>

</style>