<template>
    <!--
        Тут жёстко привязваем стили подобранные под все экраны:
        Поменял поведение отображения блоков cols="4" sm="6" md="4", для мобильных 6 колонок, для остальных 4 колонок на каждый блок
        v-container: height: 427px; padding: 0
        v-col: position: relative
    -->
    <v-container fluid style="height: 427px; padding: 0">
        <v-row>
            <!-- Аватар -->
            <v-col cols="4" sm="6" md="4" style="position: relative;">
                <div class="layout-items" :style="styleInventory.dollPanelBody">
                    <v-menu v-model="menu" :close-on-content-click="false" :max-width="180" :min-width="180" :nudge-left="9" offset-y>
                        <template v-slot:activator="{ on }">
                            <div v-on="on" class="btn-tool-menu">Характеристики<span class="icon-tool" :class="menu ? 'show' : 'hide' "></span></div>
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
                                <!--Выплывающее меню с описанием предмета item.active генерируется v-menu автоматом-->
                                <v-menu v-model="item.active" class="game-content" :close-on-content-click="false" :nudge-width="200" offset-y>
                                    <template v-slot:activator="{ on }">
                                        <div v-on="on" class="grid-item stuff-img" :style="setStyleItem(item)"></div>
                                    </template>
                                    <profile-item-details :item="item" :items_bag="items_bag" :equip="slot" @change="changeItem($event, slot, item)"></profile-item-details>
                                </v-menu>
                                <div class="stuff-tap-highlight"></div>
                            </div>
                        </draggable>

                        <!-- Это один слот -->
                        <div class="characteristics">
                            <v-row no-gutters>
                                <v-col cols="12">
                                    <v-row align="center" justify="center">
                                        <v-col cols="6" class="pa-0">D:30</v-col>
                                        <v-col cols="6" class="pa-0">C:25</v-col>
                                    </v-row>
                                    <v-row align="center" justify="center">
                                        <v-col cols="6" class="pa-0">B:10</v-col>
                                        <v-col cols="6" class="pa-0">A:2</v-col>
                                    </v-row>
                                </v-col>
                            </v-row>
                    </div>
                    </div>
                </div>
            </v-col>
            <!-- Рюкзак -->
            <v-col cols="4" sm="6" md="4" style="position: relative;">
                <div class="grid-slots layout-item d-none d-md-flex d-lg-flex" :style="styleInventory.gridPanelBody">
                    <div class="grid-text">Рюкзак</div>
                    <div class="grid-inner" :style="styleInventory.gridInnerBody" :class="{'slot-highlighted': gridHighlighted}">
                        <draggable class="grid-items"
                                   tag="ul"
                                   :class="{filler:!items_bag.length}"
                                   v-model="items_bag"
                                   v-bind="{group: current_type}"
                                   @start="onStart($event)"
                                   @end="onEnd($event)"
                                   @change="onChange($event)"
                                   :move="onMove"
                                    >
                                    <li v-for="item in items_bag" :key="item.id" class="grid-item" :data-type="item.artifact_type.slot_id">
                                        <div class="stuff-item stuff-imaged">

                                            <!--Выплывающее меню с описанием предмета item.active генерируется v-menu автоматом-->

                                            <v-menu v-model="item.active" :close-on-content-click="false" :nudge-width="200" offset-y>
                                                <template v-slot:activator="{ on }">
                                                    <div v-on="on" class="grid-item stuff-img" :style="setStyleItem(item)"></div>
                                                </template>
                                                <profile-item-details :item="item" @change="changeItem($event, slot=null, item)" v-on:sale="sellItem(item)"></profile-item-details>
                                            </v-menu>

                                            <!-- Диалоговое окно с подтвержением продажи, item.sellDialog=false, генерериуется в компоненте profile-item-sale динимически-->

                                            <v-dialog v-model="sellDialog" :max-width="300">
                                                <profile-item-sale :item="itemSale" v-on:sale="sellItem"></profile-item-sale>
                                            </v-dialog>

                                            <v-badge v-if="notCanBuyOrEquip(item)" avatar overlap offset-x="20" offset-y="7" color="">
                                                <template v-slot:badge>
                                                    <v-avatar>
                                                        <v-img src="images/bg/profile/interface/lock.png"></v-img>
                                                    </v-avatar>
                                                </template>
                                            </v-badge>
                                            <div class="stuff-tap-highlight"></div>
                                        </div>
                                    </li>
                        </draggable>
                    </div>
                </div>
            </v-col>
        </v-row>
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
                //Открыть диалоговое окно для продажи предмета
                sellDialog: false,
                //Переменная небходима для буфера, чтобы передать предмет в компонент sale,
                //предмет через emit попадает из компонента detail
                itemSale: {},
                menu: false,
                gridHighlighted: false, //Подсветка
                //Стиль - расположение панелей инветаря в пространстве
                styleInventory:{
                    dollPanelBody: {
                        width: '318px',
                        left: '17px',
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
              items_bag:[],
                //Свойства героя
                user_property: [],
                current_type: 14,//Начальный тип общей группы
                buffer_type: 14,//Буфер обмена, содержит type о текущем типе группы предмета(во время перетаскивания предмета)
            }
        },
        provide: function () {
            return {
                changeItem: this.changeItem,
                notCanBuyOrEquip: this.notCanBuyOrEquip
            }
        },
        methods:{
            ...mapState('app', ['user']),
            ...mapMutations('app', ['setSlots', 'setItems']),
            onMove: function(e){
                return !this.notCanBuyOrEquip(e.draggedContext.element)
            },
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

                this.$dataUser.getPostData('/profile/item', (response) => {
                    this.slots = response.data.slots;
                    this.items_bag = response.data.items_bag;

                    this.setSlots(response.data.slots);
                    this.setItems(response.data.items);

                    this.user_property = response.data.user_property;
                }, {'action': action, 'artifact_id': artifact_id});
            },

            //Меняем местами
            swap(slot){
                const item = slot.items.shift();
                this.items_bag.unshift(item);
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
                        let type_id = e.removed.element.artifact_type.slot_id;
                        console.log(type_id)
                        let slotEl = this.findSlot(type_id);

                        //Если есть однотипные предметы, то меняем их местами
                        //Проверка массива, когда содержится в slotEl.items два элемента, так как при перетаскивании добавился ещё
                        if(slotEl.items.length > 1){
                            this.swap(slotEl);
                        }

                        this.request('item_on', slotEl.items[0]);
                    }

                    //Сняли предмет и положили в рюкзак
                    if(e.hasOwnProperty('added')){
                        this.request('item_off', e.added.element);
                    }
                }
            },

            changeItem: function(e, slot, item){

                let slotEl = this.findSlot(item.artifact_type.slot_id);
                //В рюкзаке: нажимаем на предмет надеть
                if(!slot){

                    //Если условия не выполнены, чтобы одеть предмет
                    if(this.notCanBuyOrEquip(item)){
                        return false;
                    }

                    if(slotEl.items.length){
                        this.swap(slotEl);
                    }

                    slotEl.items.push(item);//Вставляем в слот предмет
                    this.removeItem(item);//Удаляем предмет из массива this.items_bag по индексу
                    this.request('item_on', slotEl.items[0]);
                //Предмет экипирован: нажимаем снять
                }else{
                    this.swap(slot);
                }
            },

            removeItem: function(item){
                this.items_bag.splice(this.findIndexItem(item.id), 1);
            },

            sellItem: function(item){
                this.itemSale = item;

                this.sellDialog = item.sellDialog;
                if(item.confirmSale){
                    this.removeItem(item);
                    this.request('sale', item);
                    console.log('Товар продан')
                }
            },
            //Поиск слота для подсветки ячейки по type_id артефакта
            findSlot: function (type_id) {
                return this.slots.find(s => s.type === type_id);
            },

            //Поиск предмета из массива this.items_bag по индексу
            findIndexItem: function (id) {
                return this.items_bag.findIndex(s => s.id === id);
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

                if(slot.type !== 13 && slot.items.length){
                    image = "images/items/slots/slot_regular.png"
                }

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
                    //'background-position': backgroundPosition,
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
                let slots = this.$store.state.app.slots;
                let items_bag = this.$store.state.app.items_bag;
                let bodies = this.$store.state.app.user.bodies;
                let user_class = this.$store.state.app.user.user_class;

                this.slots = slots;
                this.items_bag = items_bag;
                console.log(items_bag)
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
            },

            //Провека на возможность покупки
            notCanBuyOrEquip: function(artifact){
                let canArray = ['canBuy', 'canEquip'];
                for(let can in canArray){
                    let prop = canArray[can];
                    if(artifact.hasOwnProperty(prop)){
                        return !!Object.keys(artifact[prop]).length;
                    }
                }
            }
        },

        mounted() {
            this.user_property = this.$store.state.app.user.user_property;
            this.buildObjectSlots();
            //console.log(this.$t('Common.needHelp'));
        }
    }
</script>
