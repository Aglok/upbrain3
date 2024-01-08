<template>
    <div>
    <profile-window class="item-details">
        <template v-slot:board-mm>
            <div class="board x-title">{{item.name}}</div>
            <div class="board x-tool" @click="$emit('change', $event)"></div>
        </template>
        <template v-slot:x-info>
            <div class="x-info">
                <div class="header">
                    <div class="image"><img :src=item.images.info :alt=item.name></div>
                    <div class="description">{{item.description}}</div>
                </div>
                <div class="details">
                    <div class="stuff-box">
                        <profile-item-info :item="item" can="canEquip"></profile-item-info>
                        <!--<div v-for="(stat, key) in item.stats">-->
                            <!--<p>{{$t('Inventory.'+key)}}:</p><p :class="key" class="icon">{{stat}}</p>-->
                        <!--</div>-->
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:x-toolbar>
            <div class="x-toolbar">
                <div class="btn-tool equip" @click="$emit('change', $event)">Закрыть</div>
            </div>
        </template>
    </profile-window>
    </div>
</template>

<script>
    export default {
        name: "user-item-change-details",
        props:{
            item:{
                type: Object,
                default: () => {}
            }
        }
    }
</script>

<style scoped>

</style>