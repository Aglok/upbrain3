<template>
    <v-container fluid grid-list-md style="height: 427px; padding: 0">
        <v-layout row wrap>
            <!-- Аватар -->
            <v-flex d-flex xs12 sm6 md4 style="position: relative;">
                <div class="layout-items" :style="styleInventory.dollPanelBody">
                    <v-menu v-model="menu" :close-on-content-click="false" :max-width="180" :min-width="180" :nudge-left="9" offset-y>
                        <template slot="activator">
                            <div class="btn-tool">Характеристики<span class="icon-tool" :class="menu ? 'show' : 'hide' "></span></div>
                        </template>
                        <profile-list-property :property="buildObjectProperties()"></profile-list-property>
                    </v-menu>
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
                                   @change="onChange($event, slot)"
                                   :style="setStyleSlot(slot)"
                                   :class="{'slot-highlighted': slot.active}">
                                    <div v-if="slot.items.length" :title="slot.name" class="stuff-item stuff-imaged" v-for="item in slot.items" :key="item.id">
                                        <v-menu v-model="item.active" class="game-content" :close-on-content-click="false" :nudge-width="200" offset-y>
                                            <template slot="activator">
                                                <div class="grid-item stuff-img" :style="setStyleItem(item)"></div>
                                            </template>
                                            <profile-item-details :item="item" :equip="slot" @change="changeItem($event, slot, item)"></profile-item-details>
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
                                   @end="onEnd($event)"
                                   @change="onChange($event)"
                                    >
                                    <li v-for="item in items" :key="item.id" class="grid-item" :data-type="item.slot_id">
                                        <div class="stuff-item stuff-imaged">
                                            <v-menu v-model="item.active" :close-on-content-click="false" :nudge-width="200" offset-y>
                                                <template slot="activator">
                                                    <div class="grid-item stuff-img" :style="setStyleItem(item)"></div>
                                                </template>
                                                <profile-item-details :item="item" @change="changeItem($event, slot=null, item)"></profile-item-details>
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
                menu: false,
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
                    }
                ],
                //Генерация предметов
                items:[
                    // {
                    //     active: false, //Отвечает за открытие или закрытие меню
                    //     id: 14,
                    //     name: 'Меч силы',
                    //     type: 6,
                    //     label: "Единый - серый (оружие)",
                    //     param: {},
                    //     data: {
                    //         stats: {
                    //             strength: null,
                    //             hard: 2800,
                    //             mp: null,
                    //             shield: 22,
                    //             hp: 22,
                    //             damage: 3,
                    //         },
                    //         item_grade: 1,
                    //         price: 1000,
                    //         quest: "",
                    //         modif: {
                    //         },
                    //         description: ""
                    //     },
                    //     images: {
                    //         disabled: "",
                    //         item: "images/items/swords/sword_02.png",
                    //         off: "images/items/swords/sword_02.png",
                    //         info: "images/items/swords/sword_02.png",
                    //         on: "images/items/swords/sword_02.png"
                    //     },
                    //     action: [],
                    //     action_full: [{
                    //         type: "repair2",
                    //         label: "Ремонт",
                    //         count: 100
                    //     }, {
                    //         type: "sale",
                    //         cost: 100,
                    //         label: "Продажа"
                    //     }, {
                    //         type: "warehouse",
                    //         cost: {
                    //             currency: "gold",
                    //             value: 25000
                    //         },
                    //         label: "На склад"
                    //     }],
                    // },
                    // {
                    //     active: false,
                    //     id:15,
                    //     name: 'Щит силы',
                    //     type: 8,
                    //     data: {
                    //         stats: {
                    //             strength: null,
                    //             hard: 2800,
                    //             mp: null,
                    //             shield: 22,
                    //             hp: 22,
                    //             damage: 3,
                    //         },
                    //         item_grade: 1,
                    //         price: 1000,
                    //         quest: "",
                    //         modif: {
                    //         },
                    //         description: ""
                    //     },
                    //     images: {
                    //         disabled: "",
                    //         item: "images/items/shields/demo_02.png",
                    //         off: "images/items/shields/demo_02.png",
                    //         info: "images/items/shields/demo_02.png",
                    //         on: "images/items/shields/demo_02.png"
                    //     },
                    // },
                    // {
                    //     active: false,
                    //     id:16,
                    //     name: 'Кираса силы',
                    //     type: 6,
                    //     data: {
                    //         stats: {
                    //             strength: null,
                    //             hard: 2800,
                    //             mp: null,
                    //             shield: 22,
                    //             hp: 22,
                    //             damage: 3,
                    //         },
                    //         item_grade: 1,
                    //         price: 1000,
                    //         quest: "",
                    //         modif: {},
                    //         description: ""
                    //     },
                    //     images: {
                    //         disabled: "",
                    //         item: "images/items/armors/demo_04.png",
                    //         off: "images/items/armors/demo_04.png",
                    //         info: "images/items/armors/demo_04.png",
                    //         on: "images/items/armors/demo_04.png"
                    //     },
                    // }
                ],
                //Свойства героя
                user_property: [],
                current_type: 14,//Начальный тип общей группы
                buffer_type: 14,//Буфер обмена, содержит type о текущем типе группы предмета(во время перетаскивания предмета)
            }
        },
        methods:{
            ...mapState('app', ['user']),
            onStart: function (e, slot) {

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

                //Если есть, рассматривается контейнер со слотами аватар
                if(!slot){
                    let type_id = parseInt(e.item.getAttribute('data-type'));
                    let slotEl = this.findSlot(type_id);
                    slotEl.active = false;
                }else{
                    this.gridHighlighted = false;
                    //Необходимо чтобы вернуть предмету соответсвующий тип слота в инвентаре, так как он меняется в процессе претакивания на 12(тип для рюкзака)
                    //По type=12 группируются предметы в рюкзаке
                    slot.type = this.buffer_type;
                }

                this.current_type = 14;
            },
            request(action = 'item_on', item){
                let artifact_id = item.id;

                this.$dataUser.getData('/profile/item', (response) => {
                    this.slots = response.data.slots;
                    this.items = response.data.items;
                    this.user_property = response.data.user_property;
                }, {'action': action, 'artifact_id': artifact_id});
            },

            //Меняем местами
            swap(slot){
                const item = slot.items.shift();
                this.items.unshift(item);
                //Когда происходит замена предмета, со слота снимается артефакт
                //Ниже запрос присваивает новый элемент, который остался в массиве после добавления
                this.request('item_off', item);
            },
            //Событие вызывается, когда действие завершается предмет добален/удалён
            //Удобное событие, так как она возвращает всегда перетаскиваемый предмет
            onChange: function (e, slot){

                //Если слота нет, рассматривается рюкзак
                if(!slot){
                    //Из рюкзака взяли и надели на героя
                    if(e.hasOwnProperty('removed')){
                        let type_id = e.removed.element.slot_id;
                        let slotEl = this.findSlot(type_id);

                        //Если есть однотипные предметы, то меняем их местами
                        //Проверка массива, когда содержится в slotEl.items два элемента, так как при перетаскивании добавился ещё
                        if(slotEl.items.length > 1){
                            this.swap(slotEl);
                        }

                        this.request('item_on', slotEl.items[0]);
                    }

                    //Из сняли предмет и положили в рюкзак
                    if(e.hasOwnProperty('added')){
                        this.request('item_off', e.added.element);
                    }
                }
            },

            changeItem: function(e, slot, item){

                let slotEl = this.findSlot(item.slot_id);
                //В рюкзаке: нажимаем на предмет надеть
                if(!slot){
                    if(slotEl.items.length){
                        this.swap(slotEl);
                    }

                    slotEl.items.push(item);//Вставляем в слот предмет
                    this.items.splice(this.findIndexItem(item.id), 1);//Удаляем предмет из массива this.items по индексу
                    this.request('item_on', slotEl.items[0]);
                //Предмет экипирован: нажимаем снять
                }else{
                    this.swap(slot);
                }
            },
            //Поиск слота для подсветки ячейки
            findSlot: function (type_id) {
                return this.slots.find(s => s.type === type_id);
            },
            findIndexItem: function (id) {
                return this.items.findIndex(s => s.id === id);
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
                    left = '49px';
                    top = '41px';
                    width = '215px';
                    height = '100%';
                    backgroundSize = 'contain';
                    image = slot.images.info;
                }else if(slot.type > 5 && slot.type < 11) {
                    top = 64+62 * (slot.type - 6) + 'px';
                    left = '247px';
                }else if(slot.type === 14){//Условие для отображения переноса от героя в инвентарь, чтобы изображение не вылезало за пределы ячейки
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
            buildObjectSlots: function () {
                let slots = this.$store.state.app.user.slots;
                let items = this.$store.state.app.user.items;
                let bodies = this.$store.state.app.user.bodies;
                let user_class = this.$store.state.app.user.user_class;

                this.slots = slots;
                this.items = items;
            },

            buildObjectProperties: function (){
                let user_class = this.$store.state.app.user.user_class;
                let subjects = this.$store.state.app.user.subjects;
                let levels = [];

                for (let subject in subjects){
                    if(subjects.hasOwnProperty(subject) && 'lvl' in subjects[subject]){
                        levels.push({subject: subject, lvl: subjects[subject].lvl})
                    }

                }
                return Object.assign(this.user_property, {class: {name: user_class.name, description: user_class.description, image: user_class.image, levels: levels}})
            }
        },

        mounted() {
            this.user_property = this.$store.state.app.user.user_property;
            this.buildObjectSlots();
            //console.log(this.$t('Common.needHelp'));
        }
    }
</script>
