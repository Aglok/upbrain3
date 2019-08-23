<template>
    <v-container fluid grid-list-md style="height: 427px; padding: 0">
        <v-layout row wrap>
            <!-- Аватар -->
            <v-flex d-flex xs12 sm6 md4 style="position: relative;">
                <div class="layout-items" :style="styleInventory.dollPanelBody">
                    <div class="wrapper-char-over"></div>
                    <div class="wrapper-char-flag">
                        <!-- Это один слот в котором находятся предметы slot.items они являются draggable -->
                        <draggable v-for="slot in slots"
                                   :key="slot.id"
                                   v-if="slot.type !== 0"
                                   class="layout-item"
                                   tag="div"
                                   v-model="slot.items"
                                   v-bind="{group: slot.type}"
                                   @start="onStart($event, slot)"
                                   @end="onEnd($event, slot)"
                                   :style="setStyleSlot(slot)"
                                   :class="{'slot-highlighted': slot.active}">
                                    <div v-if="slot.items.length" :title="slot.name" class="stuff-item stuff-imaged" v-for="item in slot.items" :key="item.id">
                                        <v-menu v-model="item.active" class="game-content" :close-on-content-click="false" :nudge-width="200" offset-y>
                                            <template slot="activator">
                                                <div class="grid-item stuff-img" :style="setStyleItem(item)"></div>
                                            </template>
                                            <profile-item-details :item="item"></profile-item-details>
                                        </v-menu>
                                        <div class="stuff-tap-highlight"></div>
                                    </div>
                        </draggable>
                        <!-- Это один слот -->
                        <div class="characteristics">
                            <v-flex d-flex xs12>
                                <v-layout row wrap>
                                    <v-flex d-flex>
                                        <v-layout row wrap>
                                            <v-flex d-flex xs12>D:30</v-flex>
                                            <v-flex d-flex xs12>C:25</v-flex>
                                        </v-layout>
                                    </v-flex>
                                    <v-flex d-flex>
                                        <v-layout row wrap>
                                            <v-flex d-flex xs12>B:10</v-flex>
                                            <v-flex d-flex xs12>A:2</v-flex>
                                        </v-layout>
                                    </v-flex>
                                </v-layout>
                            </v-flex>
                        </div>
                    </div>
                </div>
            </v-flex>
            <!-- Рюкзак -->
            <v-flex d-flex xs12 sm6 md4 style="position: relative;">
                <div class="grid-slots layout-item hidden-sm-and-down" :style="styleInventory.gridPanelBody">
                    <div class="grid-text">Рюкзак</div>
                    <div class="grid-inner" :style="styleInventory.gridInnerBody" :class="{'slot-highlighted': gridHighlighted}">
                        <draggable class="grid-items"
                                   tag="ul"
                                   :class="{filler:!items.length}"
                                   v-model="items"
                                   v-bind="{group: current_type}"
                                   @start="onStart($event)"
                                   @end="onEnd($event)">
                                    <li v-for="item in items" :key="item.id" class="grid-item" :data-type="item.type">
                                        <div class="stuff-item stuff-imaged">
                                            <v-menu v-model="item.active" :close-on-content-click="false" :nudge-width="200" offset-y>
                                                <template slot="activator">
                                                    <div class="grid-item stuff-img" :style="setStyleItem(item)"></div>
                                                </template>
                                                <profile-item-details :item="item"></profile-item-details>
                                            </v-menu>
                                            <div class="stuff-tap-highlight"></div>
                                        </div>
                                    </li>
                        </draggable>
                    </div>
                </div>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import draggable from 'vuedraggable'
    import {mapMutations, mapState} from 'vuex'

    export default {
        name: "Inventory",
        components:{
            draggable
        },
        data(){
            return {
                gridHighlighted: false, //Подсветка
                //Стиль - расположение панелей инветаря в пространстве
                styleInventory:{
                    dollPanelBody: {
                        width: '318px',
                        left: '8px',
                        top: 0,
                        height: '422px'
                    },
                    gridPanelBody:{
                        left: '137px',
                        top: '67px',
                        width: '323px',
                        height: '256px',
                    },
                    gridInnerBody:{
                        width: '320px',
                        height: '256px'
                    }
                },
                //Генерация слотов
                //Самое главное чтобы не было слотов с id 11 и 12, так как это значения заняты системными переменными
                slots: [
                    {
                        id: 1,
                        name: 'Голова',
                        items:[],
                        type: 1,
                        active: false,
                        visible: 1,
                        images: {
                            normal: "images/items/slots/helmet.png",
                            gold: "",
                            arena: ""
                        }
                    },
                    {
                        id:2,
                        name: 'Доспех',
                        items:[],
                        type: 2,
                        active: false,
                        visible: 1,
                        images: {
                            normal: "images/items/slots/cuirass.png",
                            gold: "",
                            arena: ""
                        }
                    },
                    {
                        id:3,
                        name: 'Оружие',
                        items:[],
                        type: 3,
                        active: false,
                        visible: 1,
                        images: {
                            normal: "images/items/slots/sword.png",
                            gold: "",
                            arena: ""
                        }
                    },
                    {
                        id:4,
                        name: 'Ноги',
                        items:[],
                        type: 4,
                        active: false,
                        visible: 1,
                        images: {
                            normal: "images/items/slots/boots.png",
                            gold: "",
                            arena: ""
                        }
                    },
                    {
                        id:5,
                        name: 'Тотем',
                        items:[],
                        type: 5,
                        active: false,
                        visible: 1,
                        images: {
                            normal: "images/items/slots/totem.png",
                            gold: "",
                            arena: ""
                        }
                    },
                    {
                        id:6,
                        name: 'Книга',
                        items:[],
                        type: 6,
                        active: false,
                        visible: 1,
                        images: {
                            normal: "images/items/slots/book.png",
                            gold: "",
                            arena: ""
                        }
                    },
                    {
                        id:7,
                        name: 'Амулет',
                        items:[],
                        type: 7,
                        active: false,
                        visible: 1,
                        images: {
                            normal: "images/items/slots/amulet.png",
                            gold: "",
                            arena: ""
                        }
                    },
                    {
                        id:8,
                        name: 'Щит',
                        items:[{
                            active: false,
                            id:17,
                            name: 'Щит силы 1',
                            type: 8,
                            data: {
                                stats: {
                                    strength: null,
                                    hard: 2800,
                                    mp: null,
                                    shield: 22,
                                    hp: 22,
                                    damage: 3,
                                },
                                item_grade: 1,
                                price: 1000,
                                quest: "",
                                modif: {},
                                description: ""
                            },
                            images: {
                                disabled: "",
                                item: "images/items/shields/demo_02.png",
                                off: "images/items/shields/demo_02.png",
                                info: "images/items/shields/demo_02.png",
                                on: "images/items/shields/demo_02.png"
                            },
                        },],
                        type: 8,
                        active: false,
                        visible: 1,
                        images: {
                            normal: "images/items/slots/shield.png",
                            gold: "",
                            arena: ""
                        }

                    },
                    {
                        id:9,
                        name: 'Кольцо',
                        items:[],
                        type: 9,
                        active: false,
                        visible: 1,
                        images: {
                            normal: "images/items/slots/ring.png",
                            gold: "",
                            arena: ""
                        }

                    },
                    {
                        id:10,
                        name: 'Облик',
                        items:[],
                        type: 10,
                        active: false,
                        visible: 1,
                        images: {
                            normal: "images/items/slots/shape.png",
                            gold: "",
                            arena: ""
                        }
                    },
                    {
                        id:11,
                        name: 'Трофеи',
                        items:[],
                        type: 0,
                        active: false,
                        visible: 1,
                        images: {
                            normal: "images/items/slots/locked.png",
                            gold: "",
                            arena: ""
                        }
                    },
                    {
                        id:12,
                        name: 'Экипировка',
                        items:[],
                        type: 0,
                        active: false,
                        visible: 1,
                        images: {
                            normal: "images/items/slots/empty.png",
                            gold: "",
                            arena: ""
                        }
                    },
                    {
                        id:13,
                        name: 'Образ',
                        items:[],
                        type: 13,
                        active: false,
                        visible: 1,
                        images: {
                            info: "images/characters/dwarf.png",
                            small: ""
                        }

                    },
                ],
                //Генерация предметов
                items:[
                    {
                        active: false, //Отвечает за открытие или закрытие меню
                        id: 14,
                        name: 'Меч силы',
                        type: 3,
                        label: "Единый - серый (оружие)",
                        param: {},
                        data: {
                            stats: {
                                strength: null,
                                hard: 2800,
                                mp: null,
                                shield: 22,
                                hp: 22,
                                damage: 3,
                            },
                            item_grade: 1,
                            price: 1000,
                            quest: "",
                            modif: {
                            },
                            description: ""
                        },
                        images: {
                            disabled: "",
                            item: "images/items/swords/sword_02.png",
                            off: "images/items/swords/sword_02.png",
                            info: "images/items/swords/sword_02.png",
                            on: "images/items/swords/sword_02.png"
                        },
                        action: [],
                        action_full: [{
                            type: "repair2",
                            label: "Ремонт",
                            count: 100
                        }, {
                            type: "sale",
                            cost: 100,
                            label: "Продажа"
                        }, {
                            type: "warehouse",
                            cost: {
                                currency: "gold",
                                value: 25000
                            },
                            label: "На склад"
                        }],
                    },
                    {
                        active: false,
                        id:15,
                        name: 'Щит силы',
                        type: 8,
                        data: {
                            stats: {
                                strength: null,
                                hard: 2800,
                                mp: null,
                                shield: 22,
                                hp: 22,
                                damage: 3,
                            },
                            item_grade: 1,
                            price: 1000,
                            quest: "",
                            modif: {
                            },
                            description: ""
                        },
                        images: {
                            disabled: "",
                            item: "images/items/shields/demo_02.png",
                            off: "images/items/shields/demo_02.png",
                            info: "images/items/shields/demo_02.png",
                            on: "images/items/shields/demo_02.png"
                        },
                    },
                    {
                        active: false,
                        id:16,
                        name: 'Кираса силы',
                        type: 2,
                        data: {
                            stats: {
                                strength: null,
                                hard: 2800,
                                mp: null,
                                shield: 22,
                                hp: 22,
                                damage: 3,
                            },
                            item_grade: 1,
                            price: 1000,
                            quest: "",
                            modif: {},
                            description: ""
                        },
                        images: {
                            disabled: "",
                            item: "images/items/armors/demo_04.png",
                            off: "images/items/armors/demo_04.png",
                            info: "images/items/armors/demo_04.png",
                            on: "images/items/armors/demo_04.png"
                        },
                    }
                ],
                current_type: 12,//Начальный тип общей группы
                buffer_type: 12,//Буфер обмена, содержит type о текущем типе группы предмета(во время перетаскивания предмета)
            }
        },
        methods:{
            ...mapState('app', ['user']),
            onStart: function (e, slot) {

                //Подсвечиваем переносимый элемент
                //e.item.classList.add('active');

                //Если есть, рассматривается контейнер(рюкзак) с предметами ищём в объекте слот по data-type и подсвечиваем слот active
                if(!slot){
                    this.current_type = parseInt(e.item.getAttribute('data-type'));
                    let slotEl = this.findSlot(this.current_type);
                    slotEl.active = true;
                }else{
                    this.gridHighlighted = true;
                    this.buffer_type = slot.type;//Запоминаем начальный тип слота
                    slot.type = this.current_type;
                }
            },
            //Когда предмет уже положили
            onEnd: function (e, slot) {

                //console.log(this.buildObjectSlots());
                //Удаляем подсветку переносимого элемента
                //e.item.classList.remove('active');

                //Если есть, рассматривается контейнер со слотами аватар
                if(!slot){
                    let type_id = parseInt(e.item.getAttribute('data-type'));
                    let slotEl = this.findSlot(type_id);
                    slotEl.active = false;
                    //Если есть однотипные предметы, то меняем их местами
                    if(slotEl.items.length > 1){
                        const item = slotEl.items.shift();
                        this.items.push(item);
                    }

                    this.$dataUser.getData('/profile/item', (response) => {
                        console.log(response);
                    }, {'action': 'item_on', 'artifact_id': slotEl.items[0].id});

                }else{
                    this.gridHighlighted = false;
                    //Необходимо чтобы вернуть предмету соответсвующий тип слота в инвентаре, так как он меняется в процессе претакивания на 12(тип для рюкзака)
                    //По type=12 группируются предметы в рюкзаке
                    slot.type = this.buffer_type;
                    this.$dataUser.getData('/profile/item', (response) => {
                        console.log(response);
                    }, {'action': 'item_off', 'artifact_id': 1});
                }

                this.current_type = 12;
            },
            //Поиск слота для подсветки ячейки
            findSlot: function (type_id) {
                return this.slots.find(s => s.type === type_id);
            },
            findItem: function (id) {
                return this.items.find(s => s.id === id);
            },

            //Генерация стиля для расположения слотов в пространстве
            //TODO: нужно ли переводить в отельный компонент вывод слотов?
            //TODO: (код будет более читабельным, но будет развёртка из div и создание классов и id для каждого слота)
            //TODO: стили для каждого слота в CSS
            //TODO: в этом компонененте сделать получение данных items и передача в props в компонент slots

            setStyleSlot:function (slot) {

                let top =  '64px';
                let left =  '11px';
                let width = '60px';
                let height = '60px';
                let image = slot.images.normal;
                let backgroundSize = '60px';

                if(slot.type > 1 && slot.type < 6)
                    top = 64+62*(slot.type-1)+'px';
                else if (slot.type === 13){
                    left = '71px';
                    top = '107px';
                    width = '169px';
                    height = '100%';
                    backgroundSize = 'contain';
                    image = slot.images.info;
                }else if(slot.type > 5 && slot.type < 11) {
                    top = 64+62 * (slot.type - 6) + 'px';
                    left = '247px';
                }else if(slot.type === 12){//Условие для отображения переноса от героя в инвентарь, чтобы изображение не вылезало за пределы ячейки
                    if(this.buffer_type > 1 && this.buffer_type < 6)
                        top = 64+62 * (this.buffer_type-1) + 'px';
                    else if(this.buffer_type > 5 && this.buffer_type < 11){
                        top = 64+62 * (this.buffer_type - 6) + 'px';
                        left = '247px';
                    }
                }

                return {
                    'background-image': 'url('+image+')',
                    'background-size': backgroundSize,
                    left: left,
                    top: top,
                    width: width,
                    height: height
                }
            },
            //Генерация стиля для расположения предметов в пространстве
            setStyleItem: function (item) {
                if('images' in item)
                    return {
                        'background-image': 'url('+item.images.info+')',
                    }
            },
            //TODO:: доделать объект с body, создать отдельную функцию или сгенерировать отдельный объект на сервере
            //TODO:: доделать генерицию объекта для items->artifacts, продумать какие характеристики оставить на первое время
            buildObjectSlots: function () {
                let slots = this.$store.state.app.user.slots;
                let artifacts = this.$store.state.app.user.artifacts;
                let body = this.$store.state.app.user.body;
                let user_class = this.$store.state.app.user.user_class;

                slots.map(function (slot) {
                    slot.active = false;
                    slot.images = {};
                    slot.images.normal = slot.image_normal;
                    slot.images.arena = slot.image_arena;
                    slot.images.gold = slot.image_gold;
                    slot.items = [];

                    let artifact = artifacts.find(a => (a.slot_id === slot.id && a.pivot.equip));
                    if(artifact){
                        artifact.data = {};
                        artifact.data.stats = {
                            strength: null,
                            hard: 2800,
                            mp: null,
                            shield: 22,
                            hp: 22,
                            damage: 3
                        };
                        artifact.type = artifact.slot_id;
                        artifact.images = {
                            disabled: "",
                            item: artifact.image,
                            off: artifact.image,
                            info: artifact.image,
                            on: artifact.image
                        };
                        slot.items.push(artifact);
                    }

                });

                slots.push({
                    id:13,
                    name: body[0][0].name,
                    type: 13,
                    images: {
                        info: body[0][0].image,
                        small: ""
                    }
                });
                //this.slots = slots;
                console.log(slots);
            }
        },

        mounted() {
            this.buildObjectSlots();
        }
    }
</script>
