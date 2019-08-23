<template>
    <div class="position-relative">
        <div class="layout-item" :style="styleInventory.dollPanelBody">
            <draggable v-for="slot in slots"
                       :key="slot.id"
                       v-if="slot.type !== 0"
                       class="layout-item"
                       element="div"
                       draggable="false"
                       v-model="slot.items"
                       :options="{group: slot.type}"
                       @start="onStart($event, slot)"
                       @end="onEnd($event, slot)"
                       :style="setStyleSlot(slot)"
                       :class="{'slot-highlighted': slot.active}">
                        <div v-if="slot.items.length" :title="slot.name" class="stuff-item stuff-imaged" v-for="item in slot.items" :key="item.id" :style="setStyleItem(item)">
                            <div class="grid-item stuff-img" :style="setStyleItem(item)"></div>
                            <div class="stuff-tap-highlight"></div>
                        </div>
            </draggable>
        </div>
        <div class="grid-slots layout-item" :style="styleInventory.gridPanelBody">
            <div class="grid-inner" :style="styleInventory.gridInnerBody" :class="{'slot-highlighted': gridHighlighted}">
                <draggable class="grid-items"
                           element="ul"
                           :class="{filler:!items.length}"
                           v-model="items"
                           :options="{group: current_type}"
                           @start="onStart($event)"
                           @end="onEnd($event)">
                            <li v-for="item in items" :key="item.id" class="list-unstyled grid-item" :data-type="item.type">
                                <div class="stuff-item stuff-imaged">
                                    <div class="grid-item stuff-img" :style="setStyleItem(item)"></div>
                                    <div class="stuff-tap-highlight"></div>
                                </div>
                            </li>
                </draggable>
            </div>
        </div>
    </div>
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
                gridHighlighted: false,
                //Стиль - расположение панелей инветаря в пространстве
                styleInventory:{
                    dollPanelBody: {
                        width: '338px',
                        left: 0,
                        top: 0,
                        height: '320px'
                    },
                    gridPanelBody:{
                        left: '400px',
                        top: '22px',
                        width: '340px',
                        padding: '10px',
                        height: '276px',
                    },
                    gridInnerBody:{
                        width: '320px',
                        height: '256px'
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
                            normal: "images/items/slots/helmet.jpg",
                            gold: "images/items/slots/helmet_gold.jpg",
                            arena: "images/items/slots/helmet_30.jpg"
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
                            normal: "images/items/slots/cuirass.jpg",
                            gold: "images/items/slots/cuirass_gold.jpg",
                            arena: "images/items/slots/cuirass_30.jpg"
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
                            normal: "images/items/slots/sword.jpg",
                            gold: "images/items/slots/sword_gold.jpg",
                            arena: "images/items/slots/sword_30.jpg"
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
                            normal: "images/items/slots/boots.jpg",
                            gold: "images/items/slots/boots_gold.jpg",
                            arena: "images/items/slots/boots_30.jpg"
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
                            normal: "images/items/slots/totem.jpg",
                            gold: "images/items/slots/totem.jpg",
                            arena: "images/items/slots/totem.jpg"
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
                            info: "images/characters/monsters/monster_ghost_info.jpg",
                            small: "images/characters/monsters/monster_ghost_small.jpg"
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
                            normal: "images/items/slots/book.jpg",
                            gold: "images/items/slots/book_gold.jpg",
                            arena: "images/items/slots/book_30.jpg"
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
                            normal: "images/items/slots/amulet.jpg",
                            gold: "images/items/slots/amulet_gold.jpg",
                            arena: "images/items/slots/amulet_30.jpg"
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
                            normal: "images/items/slots/shield.jpg",
                            gold: "images/items/slots/shield_gold.jpg",
                            arena: "images/items/slots/shield_30.jpg"
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
                            normal: "images/items/slots/ring.jpg",
                            gold: "images/items/slots/ring_gold.jpg",
                            arena: "images/items/slots/ring_30.jpg"
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
                            normal: "images/items/slots/shape.jpg",
                            gold: "images/items/slots/shape.jpg",
                            arena: "images/items/slots/shape.jpg"
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
                            normal: "images/items/slots/locked.jpg",
                            gold: "images/items/slots/locked_gold.jpg",
                            arena: "images/items/slots/locked_30.jpg"
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
                            normal: "images/items/slots/empty.jpg",
                            gold: "images/items/slots/empty_gold.jpg",
                            arena: "images/items/slots/empty_30.jpg"
                        }
                    },
                ],
                //Генерация предметов
                items:[
                    {
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
                            item: "images/items/swords/10_grey_60_60.jpg",
                            off: "images/items/swords/10_grey_60_60.jpg",
                            info: "images/items/swords/10_grey_60_60.jpg",
                            on: "images/items/swords/10_grey_60_60.jpg"
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
                        id:15,
                        name: 'Щит силы',
                        type: 9,
                        images: {
                            disabled: "",
                            item: "images/items/shields/16_grey_60_60.jpg",
                            off: "images/items/shields/16_grey_60_60.jpg",
                            info: "images/items/shields/16_grey_60_60.jpg",
                            on: "images/items/shields/16_grey_60_60.jpg"
                        },
                    },
                    {
                        id:16,
                        name: 'Кираса силы',
                        type: 2,
                        images: {
                            disabled: "",
                            item: "images/items/armors/16_grey_60_60.jpg",
                            off: "images/items/armors/16_grey_60_60.jpg",
                            info: "images/items/armors/16_grey_60_60.jpg",
                            on: "images/items/armors/16_grey_60_60.jpg"
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

                //Если есть, рассматривается контейнер с предметами
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
            setStyleSlot:function (slot) {

                let top =  0;
                let left =  0;
                let width = '64px';
                let height = '64px';
                let image = slot.images.normal;
                let backgroundSize = '64px';

                if(slot.type > 1 && slot.type < 6)
                    top = 64*(slot.type-1)+'px';
                else if (slot.type === 6){
                    left = '64px';
                    top = '1px';
                    width = '210px';
                    height = '316px';
                    backgroundSize = 'contain';
                    image = slot.images.info;
                }else if(slot.type > 6 && slot.type < 12) {
                    top = 64 * (slot.type - 7) + 'px';
                    left = '274px';
                }else if(slot.type === 12){//Условие для отображения переноса от героя в инвентарь, чтобы изображение не вылезало за пределы ячейки
                    if(this.buffer_type > 1 && this.buffer_type < 6)
                        top = 64 * (this.buffer_type-1) + 'px';
                    else if(this.buffer_type > 6 && this.buffer_type < 12){
                        top = 64 * (this.buffer_type - 7) + 'px';
                        left = '274px';
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

<style scoped>

</style>