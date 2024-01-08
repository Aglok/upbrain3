<template>
    <profile-window class="item-change">
        <template v-slot:board-mm>
            <div class="board x-title">{{item.name}}</div>
            <div class="board x-tool" @click="item.changeDialog=false, item.changeItem=false, $emit('change', $event, item)"></div>
        </template>
        <template v-slot:x-info>
            <div class="x-info">
                <div class="header">
                    <div class="image"><img :src=item.images.info :alt=item.name></div>
                    <div class="description">{{item.description}}</div>
                </div>
                <div class="details">
                    <div class="stuff-box">
                        <div class="change justify-center" v-for="item_bag in items_bag" v-if="item_bag.artifact_type.slot_id === item.artifact_type.slot_id">
                            <v-menu v-model="dialog" class="game-content" :close-on-content-click="false" :nudge-width="200" offset-y>
                                <template v-slot:activator="{ on }">
                                    <img v-on="on" :src="item_bag.images.info" :alt=item_bag.name :title="item_bag.name">
                                </template>
                                <profile-item-change-details :item="item_bag" @change="dialog = !dialog"></profile-item-change-details>
                            </v-menu>
                            <div
                                    class="align-self-center btn-tool ml-auto"
                                    :class="{'not-active' : notCanBuyOrEquip(item_bag)}"
                                    @click="item.changeDialog=false,
                                    item.changeItem=true,
                                    changeItemFromDialog($event, equip, item_bag),
                                    $emit('change', $event, item)"
                            >Надеть</div>
                        </div>
                        <div class="change" v-if="!items_bag.find(i => i.artifact_type.slot_id === item.artifact_type.slot_id)">
                            Пока нет доступных предметов данного типа {{equip.name}}
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:x-toolbar>
            <div class="x-toolbar">
                <!--В @click использует оператор "запятая" для обрабоки нескольких методов item.changeDialog=false убираем диалоговое окно по нажанию клавиши-->
                <!--В item.changeDialog=false, item.changeItem=true генерируется динамически для каждого предмета в рюкзаке, порядок обязателен инициализировать до $emit('change', $event, equip, item), иначе значение не будет передоваться.-->
                <div class="btn-tool" @click="item.changeDialog=false, item.changeItem=false, $emit('change', $event, item)">Закрыть</div>
            </div>
        </template>
    </profile-window>
</template>

<script>
    export default {
        name: "user-item-change",
        data(){
            return {
                dialog: false
            }
        },
        inject: ['changeItem', 'notCanBuyOrEquip'],
        methods:{
            changeItemFromDialog: function(e, equip, item){
                this.changeItem(e, null, item);
                console.log("Поменяли");
            }
        },
        props:{
            item:{
                type: Object,
                default: () => {}
            },
          items_bag:{
                type: Array,
                default: () => []
            },
            equip:{
                type: Object,
                default: () => {}
            },
        }
    }
</script>

<style scoped>
</style>