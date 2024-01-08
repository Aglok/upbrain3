<template>
    <v-card class="items-shop scroll">
    <v-container fluid grid-list-md>
        <div class="primary--text">
            <p class="my-0">Золото: {{this.$store.state.app.user.gold}}</p>
            <p class="my-0" v-for="(subject, key, index) in this.user" :key="index">Уровень {{$t('Subjects.'+subject.subject)}}: {{subject.user_level}}</p>
        </div>
        <div class="title mb-1">
            <v-tabs v-model="subject.tabs" color="white" background-color="transparent">
                <span class="font-weight-light mx-3" style="align-self: center">Предметы:</span>
                <v-tab class="mr-3" v-for="(subject, key, index) in this.shop" :key="index" @click="current_item_type = 'all'">
                    <!--<v-icon class="mr-2">mdi-bug</v-icon>-->
                    {{dataSetSubjects[key].name}}
                </v-tab>
            </v-tabs>
        </div>
        <!-- Большой цикл tab value значение свойства по каждому предмету-->
        <v-tabs-items v-model="subject.tabs">
            <v-tab-item v-for="(value, subject, index) in this.shop" :key="index">
                <div class="d-flex align-content-start flex-wrap">
                    <div v-if="getItemsToSubject(subject, 'all').length">
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <img v-on="on" class="icon" @click="current_item_type = 'all'" :src="'/images/items/shop/all_items.png'">
                            </template>
                            <span>{{$t('Items.all_items')}}</span>
                        </v-tooltip>
                    </div>
                    <div class="icon" v-for="(type_id, item_type, index) in item_types" :key="index" v-if="getItemsToSubject(subject, item_type).length">
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <img v-on="on" class="icon" @click="current_item_type = item_type" :src="'/images/items/shop/'+item_type+'.png'">
                            </template>
                            <span>{{$t('Items.'+item_type)}}</span>
                        </v-tooltip>
                    </div>
                </div>
                <v-row class="d-flex align-content-end flex-wrap mt-2">
                    <v-col cols="12" sm="12" md="4" lg="4" v-for="item in getItemsToSubject(subject, current_item_type)" :key="item.title">
                        <v-card color="darken-2" class="item-shop">
                            <v-row>
                                <v-col cols="12" class="py-0 text-center">
                                    <img :src="item.images.info" height="125px">
                                </v-col>
                                <v-col cols="12" class="py-0 text-center">
                                    <div class="headline">{{item.title}}</div>
                                    <div class="caption">{{item.description}}</div>
                                </v-col>
                                <v-col cols="12" class="py-0">
                                    <div class="text-center">Цена: {{item.artifact_trade.gold}}</div>
                                    <div class="text-center">Количество: {{quantity}}/{{item.quantity}}</div>
                                    <v-divider class="brown darken-4"></v-divider>
                                </v-col>
                                <v-col cols="12" class="py-0">
                                  <div class="text-md-center text-xs-center">
                                    <v-menu v-model="item.active" :nudge-width="200" offset-y>
                                      <template v-slot:activator="{ on }">
                                        <div v-on="on" class="btn-tool" :class="{'not-active' : notCanBuyOrEquip(item) || item.quantity === 0}" @click="buy(item, quantity)">Купить</div>
                                      </template>
                                      <profile-item-difference :item="item"></profile-item-difference>
                                    </v-menu>
                                  </div>
                              </v-col>
                            </v-row>
                        </v-card>
                    </v-col>
                </v-row>
            </v-tab-item>
        </v-tabs-items>
    </v-container>
    </v-card>
</template>

<script>
    export default {
        name: "Items",
        data () {
            return {
                dataSetSubjects: {},
                user:{},
                shop:{},
                item_types:{},
                current_item_type: 'all',
                quantity: 0,
                items: [],
                subject:{
                    tabs: 0,
                    list: {},//Объект необходим для хранения свойств вкладок таба, активный/неактивный таб
                },
            }
        },
        methods: {
            //Провека на возможность покупки
            notCanBuyOrEquip(artifact){
                return !!Object.keys(artifact.canBuy).length;
            },
            getItemsToSubject(subject, item_type = "all"){
                let shop = this.shop;
                let app = this;

                if(shop.hasOwnProperty(subject)){

                    //Фильтруем данные по типу артефакта
                    let filtered_items = shop[subject].filter(function (item) {
                        if(item_type === "all")
                            return true;

                        return item.artifact_type_id === app.item_types[item_type]
                    });

                    //Сортруем данные по canBuy артефакта
                    filtered_items.sort(function (a, b) {

                        if (Object.keys(a.canBuy).length > Object.keys(b.canBuy).length) {
                            return 1;
                        }else
                            return -1;
                    });

                    return filtered_items
                }
                return []
            },

            buy(artifact, quantity){
                //Нет в наличии или неподходит под условия, то прекращаем покупку
                if(this.notCanBuyOrEquip(artifact) || !quantity){
                    console.log('Вывод условий');
                    return false;
                }

                //Оправка axios.post
                this.$dataUser.getPostData('/profile/shop_items', (response) => {
                    console.log(response)
                }, {'action': 'buy', 'artifact_id': artifact.id, 'quantity': quantity});
            }
        },
        mounted() {
            this.user = this.$store.state.app.user.subjects;
            this.shop = this.$store.state.app.user.shop;
            this.item_types = this.$store.state.app.user.item_types;
            //Динамически генерируется list для subject.tabs предметов
            this.subject.list = this.$dataUser.generateTabList(this.shop);
            this.dataSetSubjects = this.$dataUser.dataSetSubjects;
        }
    }
</script>

<style scoped>

.item-shop img{
    text-align: center;
    margin-top: 10px;
}
.items-shop .icon{
    margin-right: 15px;
    cursor: pointer;
    width: 35px;
    height: 35px;
}
</style>