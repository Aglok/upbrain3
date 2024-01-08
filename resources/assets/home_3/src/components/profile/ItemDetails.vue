<template>
    <div>
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
                        <profile-item-info :item="item" can="canEquip"></profile-item-info>
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:x-toolbar>
            <div class="x-toolbar">
                <!--В @click использует оператор "запятая" для обрабоки нескольких методов item.sellDialog=false, item.active=false, item.changeDialog=true, item.changeItem=true убираем меню по нажанию клавиши-->
                <!--В item.sellDialog=false, item.confirmSale=false, item.changeDialog=true, item.changeItem=true генерируется динамически для каждого предмета в рюкзаке, порядок обязателен инициализировать до $emit('sale', item), иначе значение не будет передоваться.-->
                <div class="btn-tool" @click="item.active=false, $emit('change', $event, equip, item)" v-if="equip">Снять</div>
                <div class="btn-tool" :class="{'not-active' : notCanBuyOrEquip(item)}" v-else @click="item.active=false, $emit('change', $event, equip, item)">Надеть</div>
                <div class="btn-tool" v-if="equip" @click="item.changeDialog=true, item.active=false, changeDialogToggle($event, item)">Изменить</div>
                <div class="btn-tool d-flex justify-center" v-else @click="item.sellDialog=true, item.confirmSale=false, item.active=false, $emit('sale', item)">
                    <div class="icon icon-gold"></div>
                    <div>{{item.artifact_trade.gold}}</div>
                </div>
            </div>
        </template>
    </profile-window>
    <!-- Диалоговое окно для изменения товара, item.changeDialog=false, генерериуется в компоненте profile-item-change динимически-->
    <v-dialog v-model="changeDialog" :max-width="300" v-if="equip">
        <profile-item-change :item="item" :items_bag="items_bag" :equip="equip" @change="changeDialogToggle($event, item)"></profile-item-change>
    </v-dialog>
    </div>
</template>

<script>
    export default {
        name: "user-item-details",
        data(){
          return{
              current_item: {},
              changeDialog: false//Открыть диалоговое окно изменения предмета
          }
        },
        inject: ['notCanBuyOrEquip'],
        methods:{
            changeDialogToggle: function(e, item){
                this.changeDialog = item.changeDialog;
                if(item.changeItem){
                    console.log("Поменяли", item.name);
                }
            }
        },
        updated(){
            console.log(this.item)
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
            }
        }
    }
</script>

<style scoped>
</style>