<template>
    <profile-window class="item-sale">
        <template v-slot:board-mm>
            <div class="board x-title">{{item.name}}</div>
            <div class="board x-tool" @click="item.sellDialog=false, item.confirmSale=false, $emit('sale', item)"></div>
        </template>
        <template v-slot:x-info>
            <div class="x-info">
                <div class="header">
                    <div class="image"><img :src=item.images.info :alt=item.name></div>
                    <div class="description">{{item.description}}</div>
                </div>
                <div class="details">
                    <div class="stuff-box">
                        Вы уверены что хотите продать товар за <span class="primary--text">{{item.artifact_trade.gold}}</span> <i class="icon icon-gold"></i> монет?
                    </div>
                </div>
            </div>x
        </template>
        <template v-slot:x-toolbar>
            <div class="x-toolbar">
                <!--В @click использует оператор "запятая" для обрабоки нескольких методов item.sellDialog=false убираем диалоговое окно по нажанию клавиши-->
                <!--В item.sellDialog=false, item.confirmSale=false генерируется динамически для каждого предмета в рюкзаке, порядок обязателен инициализировать до $emit('sale', item), иначе значение не будет передоваться.-->
                <div class="btn-tool" @click="item.sellDialog=false, item.confirmSale=false, $emit('sale', item), console(item)">Нет</div>
                <div class="btn-tool" @click="item.sellDialog=false, item.confirmSale=true, $emit('sale', item)">Да</div>
            </div>
        </template>
    </profile-window>
</template>

<script>
    export default {
        name: "user-item-sale",
        //inject: ['itemSale'],
        props:{
            item:{
                type: Object,
                default: () => {}
            }
        },
        methods:{
            console: function(i){
                console.log(i)
            }
        }
    }
</script>

<style scoped>

</style>