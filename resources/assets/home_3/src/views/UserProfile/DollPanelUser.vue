<template>
    <v-container fluid grid-list-md>
        <v-layout row wrap>
            <v-flex d-flex xs12 sm6 md4>
                <div class="layout-items" :style="styleInventory.dollPanelBody">
                    <div class="wrapper-char-over"></div>
                    <div class="wrapper-char-flag">
                        <!-- Это я один слот в котором находятся предметы slot.items они являются draggable -->
                        <draggable v-for="slot in slots"
                                   :key="slot.id"
                                   v-if="slot.type !== 0"
                                   class="layout-item"
                                   element="div"
                                   v-model="slot.items"
                                   :options="{group: slot.type}"
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
                        <!-- Это я один слот -->
                    </div>
                </div>
            </v-flex>
            <v-flex d-flex xs12 sm6 md4>
                <div class="grid-slots layout-item hidden-sm-and-down" :style="styleInventory.gridPanelBody">
                    <div class="grid-inner" :style="styleInventory.gridInnerBody" :class="{'slot-highlighted': gridHighlighted}">
                        <draggable class="grid-items"
                                   element="ul"
                                   :class="{filler:!items.length}"
                                   v-model="items"
                                   :options="{group: current_type}"
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

    export default {
        name: "dollPanelUser",
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
                        left: 0,
                        top: 0,
                        height: '422px'
                    },
                    gridPanelBody:{
                        left: '380px',
                        top: '0px',
                        width: '340px',
                        height: '276px',
                    },
                    gridInnerBody:{
                        width: '320px',
                        height: '320px'
                    }
                },
                //Генерация слотов
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
                        name: 'Образ',
                        items:[],
                        type: 6,
                        active: false,
                        visible: 1,
                        images: {
                            info: "images/characters/dwarf.png",
                            small: ""
                        }

                    },
                    {
                        id:7,
                        name: 'Книга',
                        items:[],
                        type: 7,
                        active: false,
                        visible: 1,
                        images: {
                            normal: "images/items/slots/book.png",
                            gold: "",
                            arena: ""
                        }
                    },
                    {
                        id:8,
                        name: 'Амулет',
                        items:[],
                        type: 8,
                        active: false,
                        visible: 1,
                        images: {
                            normal: "images/items/slots/amulet.png",
                            gold: "",
                            arena: ""
                        }
                    },
                    {
                        id:9,
                        name: 'Щит',
                        items:[],
                        type: 9,
                        active: false,
                        visible: 1,
                        images: {
                            normal: "images/items/slots/shield.png",
                            gold: "",
                            arena: ""
                        }

                    },
                    {
                        id:10,
                        name: 'Кольцо',
                        items:[],
                        type: 10,
                        active: false,
                        visible: 1,
                        images: {
                            normal: "images/items/slots/ring.png",
                            gold: "",
                            arena: ""
                        }

                    },
                    {
                        id:11,
                        name: 'Облик',
                        items:[],
                        type: 11,
                        active: false,
                        visible: 1,
                        images: {
                            normal: "images/items/slots/shape.png",
                            gold: "",
                            arena: ""
                        }
                    },
                    {
                        id:12,
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
                        id:13,
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
                ],
                //Генерация предметов
                items:[
                    {
                        active: false, //Отвечает за открытие или закрытие меню
                        id:14,
                        name: 'Меч силы',
                        type: 3,
                        label: "Единый - серый (оружие)",
                        param: {
                        },
                        data: {
                            repair2_count: 100,
                            stats: {
                                strength: null,
                                hard: 2800,
                                mp: null,
                                shield: 22,
                                hp: 22,
                                damage: 3,
                            },
                            item_grade: 1,
                            stack: null,
                            strict: {
                                level: 1
                            },
                            price: 1000,
                            expire_after: "",
                            summary: {
                                dur: null,
                                mass: 1
                            },
                            quest: "",
                            validto: null,
                            repair2: [{
                                type: 1,
                                params: {
                                    hidden: "",
                                    type: "56",
                                    quantity: 1,
                                    slot_type: 0,
                                    id: "2633"
                                }
                            }],
                            modif: {
                            },
                            validto_replace: [],
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
                        condition_action: [],
                        spec_desc: {},
                        fucina_cost: [10, 20, 50, 90]
                    },
                    {
                        active: false,
                        id:15,
                        name: 'Щит силы',
                        type: 9,
                        data: {
                            repair2_count: 100,
                            stats: {
                                strength: null,
                                hard: 2800,
                                mp: null,
                                shield: 22,
                                hp: 22,
                                damage: 3,
                            },
                            item_grade: 1,
                            stack: null,
                            strict: {
                                level: 1
                            },
                            price: 1000,
                            expire_after: "",
                            summary: {
                                dur: null,
                                mass: 1
                            },
                            quest: "",
                            validto: null,
                            repair2: [{
                                type: 1,
                                params: {
                                    hidden: "",
                                    type: "56",
                                    quantity: 1,
                                    slot_type: 0,
                                    id: "2633"
                                }
                            }],
                            modif: {
                            },
                            validto_replace: [],
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
                            repair2_count: 100,
                            stats: {
                                strength: null,
                                hard: 2800,
                                mp: null,
                                shield: 22,
                                hp: 22,
                                damage: 3,
                            },
                            item_grade: 1,
                            stack: null,
                            strict: {
                                level: 1
                            },
                            price: 1000,
                            expire_after: "",
                            summary: {
                                dur: null,
                                mass: 1
                            },
                            quest: "",
                            validto: null,
                            repair2: [{
                                type: 1,
                                params: {
                                    hidden: "",
                                    type: "56",
                                    quantity: 1,
                                    slot_type: 0,
                                    id: "2633"
                                }
                            }],
                            modif: {
                            },
                            validto_replace: [],
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
                buffer_type: 12,//Буфер обмена, о текущем типе группы предмета(во время перетаскивания предмета)
            }
        },
        methods:{
            onStart: function (e, slot) {

                //Подсвечиваем переносимый элемент
                //e.item.classList.add('active');

                //Если есть, рассматривается контейнер с предметами ищём в объекте слот по data-type и подсвечиваем слот active
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
            onEnd: function (e, slot) {

                //Удаляем подсветку переносимого элемента
                //e.item.classList.remove('active');

                //Если есть, рассматривается контейнер со слотами аватар
                if(!slot){
                    let type_id = parseInt(e.item.getAttribute('data-type'));
                    let slotEl = this.findSlot(type_id);
                    slotEl.active = false;
                }else{
                    this.gridHighlighted = false;
                    slot.type = this.buffer_type;
                }

                this.current_type = 12;
            },
            //Поиск слота для подсветки ячейки
            findSlot: function (type_id) {
                return this.slots.find(s => s.type === type_id);
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
                else if (slot.type === 6){
                    left = '71px';
                    top = '107px';
                    width = '169px';
                    height = '100%';
                    backgroundSize = 'contain';
                    image = slot.images.info;
                }else if(slot.type > 6 && slot.type < 12) {
                    top = 64+62 * (slot.type - 7) + 'px';
                    left = '247px';
                }else if(slot.type === 12){//Условие для отображения переноса от героя в инвентарь, чтобы изображение не вылезало за пределы ячейки
                    if(this.buffer_type > 1 && this.buffer_type < 6)
                        top = 64+62 * (this.buffer_type-1) + 'px';
                    else if(this.buffer_type > 6 && this.buffer_type < 12){
                        top = 64+62 * (this.buffer_type - 7) + 'px';
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
            }
        }
    }
</script>
