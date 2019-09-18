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
                    <div class="description">{{item.description}}</div>
                </div>
                <div class="details">
                    <div class="stuff-box">
                        <div v-for="(stat, key) in item.stats">
                            <p>{{$t('Inventory.'+key)}}:</p><p :class="key" class="icon">{{stat}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:x-toolbar>
            <div class="x-toolbar">
                <div class="btn-tool" @click="$emit('change', $event, equip, item)" v-if="equip">Снять</div>
                <div class="btn-tool equip" v-else @click="$emit('change', $event, equip, item)">Надеть</div>
                <div class="btn-tool" v-if="equip">Изменить</div>
            </div>
        </template>
    </profile-window>
</template>

<script>
    export default {
        name: "user-item-details",
        props:{
            item:{},
            equip:{}
        }
    }
</script>

<style scoped>

</style>