<template>
    <v-card class="items-shop scroll">
    <v-container fluid grid-list-md>
        <div class="title mb-1">{{items.header}}</div>
        <v-layout row wrap>
            <v-flex xs12 md4 v-for="item in items" :key="item.title">
                <v-card color="darken-2" class="item-shop">
                    <v-layout row wrap>
                        <v-flex xs12>
                            <v-img :src="item.image" height="125px" contain></v-img>
                        </v-flex>
                        <v-flex xs12>
                            <div class="headline text-md-center text-xs-center">{{item.title}}</div>
                            <div class="caption">{{item.description}}</div>
                        </v-flex>
                        <v-flex xs12>
                            <div class="text-md-center text-xs-center">{{item.money}}</div>
                        </v-flex>
                    </v-layout>
                    <v-divider class="brown darken-4"></v-divider>
                    <div class="text-md-center text-xs-center">
                        <div class="btn-tool">Купить</div>
                    </div>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
    </v-card>
</template>

<script>
    export default {
        name: "Items",
        data () {
            return {
                items: [
                    {
                        image: '/images/items/artifacts/anvil_t.png',
                        title: 'Наковальня',
                        description: "Краткое описание - характеристики и цена",
                        money: "1000"
                    },
                    {
                        image: '/images/items/artifacts/armor_body_t.png',
                        title: 'Броня',
                        description: "Краткое описание - характеристики и цена",
                        money: "1000"
                    },
                    {
                        image: '/images/items/artifacts/bag_t.png',
                        title: 'Сумка',
                        description: "Краткое описание - характеристики и цена",
                        money: "1000"
                    },
                    {
                        image: '/images/items/artifacts/beer_t.png',
                        title: 'Пиво',
                        description: "Краткое описание - характеристики и цена",
                        money: "1000"
                    },
                    {
                        image: '/images/items/artifacts/boomb_t.png',
                        title: 'Бомба',
                        description: "Краткое описание - характеристики и цена",
                        money: "1000"
                    },
                    {
                        image: '/images/items/artifacts/carrot_t.png',
                        title: 'Морковь',
                        description: "Краткое описание - характеристики и цена",
                        money: "1000"
                    }
                ]
            }
        }
    }
</script>

<style scoped>

</style>