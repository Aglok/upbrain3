/*
* 1. Сделать обновление html модального окна после сохрания моделей
* 2. Ajax создание списка задач, с возможностью редактирования и удаления, до сохрания в модели
* 3. Создаётся вспомогательный html список набора задач, через массив объектов
* 4. Кнопки редактировать, удалить, сохранить
* 5. При нажатии на кнопку свойства -> меняется на оранжевый цвет
* 6. Отправка на сервер -> сохрание в БД set_of_tasks -> привязывание к связям
* 7. Сообщение о успешном принятии
*
* */
Vue.component('modal', Vue.extend({
    template: '#modal-template',
}));
Vue.component('multiselect', Multiselect);

Vue.component('tasks_cart', Vue.extend({
    template:   '<li class="dropdown notifications-menu">' +
                '<a href="#" class="dropdown-toggle" data-toggle="dropdown">' +
                    '<i class="fa fa-btn fa-shopping-cart"></i>' +
                    '<span class="label label-warning">{{tasks.length}}</span>' +
                '</a>' +
                '<ul class="dropdown-menu" v-if="!tasks.length">' +
                    '<li class="header">' +
                        '<i>Нет выбранных задач</i>' +
                    '</li>' +
                '</ul>' +
                '<ul class="dropdown-menu" v-if="tasks.length">' +
                    '<li class="header dropdown-item">У вас {{tasks.length}}: опыта:{{total_experience}} монет:{{total_gold}}</li>' +
                    '<li>' +
                        '<ul class="list-group">' +
                        '<li class="list-group-item border-0 p-2">' +
                            '<div class="task-table">' +
                                '<div class="task-header">' +
                                    '<div class="task-row">' +
                                        '<div class="task-cell">№</div>' +
                                        '<div class="task-cell">Задача</div>' +
                                        '<div class="task-cell">Опыт</div>' +
                                        '<div class="task-cell">Монет</div>' +
                                    '</div>' +
                                '</div>' +
                                '<div class="task-body">' +
                                    '<div class="task-row" v-for="task in tasks" :key="task.id">' +
                                        '<div class="task-cell">{{task.id}}</div>' +
                                        '<div class="task-cell">{{task.task}}</div>' +
                                        '<div class="task-cell">{{task.experience}}</div>' +
                                        '<div class="task-cell">{{task.gold}}</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                            '</li>'+
                        '</ul>' +
                    '</li>' +
                    '<li class="footer dropdown-item" @click="this.getSetOfTasks">' +
                        '<a href="#" class="btn btn-primary" id="show-modal" @click="showModal = true, toggleMenu()">К редактору</a>' +
                    '</li>' +
                '</ul>' +
                '<script type="text/x-template" id="modal-template">' +
                    '<transition name="modal">' +
                        '<div class="modal-mask">' +
                            '<div class="modal-wrapper">' +
                                '<div class="modal-content">' +
                                    '<div class="modal-header">' +
                                        '<slot name="header">Список задач</slot>' +
                                    '</div>' +
                                    '<div class="modal-body">' +
                                        '<slot name="body"></slot>' +
                                    '</div>' +
                                    '<div class="modal-footer">' +
                                        '<slot name="footer"></slot>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                    '</transition>' +
                '</script>' +
                '<modal v-if="showModal" @close="showModal = false">' +
                    '<div slot="header">' +
                        '<div class="row">' +
                            //Создание set_of_tasks
                            '<div class="form-group mr-2 col-lg-12">' +
                                '<label for="name">Набор задач</label>' +
                                '<multiselect v-model="set_of_tasks" tag-placeholder="Добавить этот набор" placeholder="Найти или добавить" label="name" track-by="name" :options="options" :multiple="true" :taggable="true" @tag="addSet"></multiselect>' +
                            '</div>' +
                            //Создание mission
                            '<div class="form-group mr-2 col-lg-12">' +
                                '<label for="name">Квест</label>' +
                                '<multiselect v-model="mission" @select="addToProgress" tag-placeholder="Добавить этот квест" placeholder="Найти или добавить" label="name" track-by="name" :options="missions" :taggable="true" @tag="addMission"></multiselect>' +
                            '</div>' +
                            //Скрытие input для создания set_of_task появляются при динамическом создании
                            '<div class="form-group form-inline col-lg-12" v-if="set_of_tasks && Object.keys(set_of_tasks).length !== 0">' +
                                '<transition name="fade">' +
                                    '<div class="task-table form-group mx-2">' +
                                        '<div class="task-row mx-3" v-for="set_of_task in set_of_tasks" :key="set_of_task.id">' +
                                            '<input class="task-cell" v-model=set_of_task.name placeholder="Название">' +
                                            '<input class="task-cell" v-model=set_of_task.alias placeholder="Кратко">' +
                                            '<input class="task-cell" v-model=set_of_task.type placeholder="Тип">' +
                                            '<input class="task-cell" v-model=set_of_task.description placeholder="Описание">' +
                                            '<element-image class="task-cell" :id="attributeId(set_of_task.id)" :url="url(set_of_task.id)" :value="set_of_task.image" :readonly="this.readonly ? true : false" :name="set_of_task.name" inline-template\>' +
                                                '<div>' +
                                                    '<div v-if="errors.length" class="alert alert-warning">' +
                                                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close" @click="closeAlert()">' +
                                                            '<span aria-hidden="true">&times;</span>' +
                                                        '</button><p v-for="error in errors"><i class="fa fa-hand-o-right" aria-hidden="true"></i> {{ error }}</p>' +
                                                    '</div>' +
                                                    '<div class="form-element-files clearfix" v-if="has_value">' +
                                                        '<div class="form-element-files__item">' +
                                                            '<a :href="image" class="form-element-files__image" data-toggle="lightbox">' +
                                                                '<img :src="image" width="100"/>' +
                                                            '</a>' +
                                                            '<div class="form-element-files__info">' +
                                                                '<a :href="image" class="btn btn-default btn-xs pull-right">' +
                                                                 '<i class="fa fa-cloud-download"></i>' +
                                                                '</a>'+
                                                            '<button id="remove" type="button" v-if="has_value && !readonly" class="btn btn-danger btn-xs" @click.prevent="remove()">' +
                                                                '<i class="fa fa-times"></i> Удалить' +
                                                            '</button>' +
                                                        '</div>' +
                                                    '</div>' +
                                                '</div>' +
                                                '<div v-if="!readonly">' +
                                                    '<div class="btn btn-primary btn-xs upload-button">' +
                                                        '<i :class="uploadClass"></i> Загрузить' +
                                                    '</div>' +
                                                '</div>' +
                                                    '<input :name="name" type="hidden" :value="val">' +
                                                '</div>' +
                                            '</element-image>' +
                                        '</div>' +
                                    '</div>'+
                                '</transition>' +
                            '</div>' +
                            //Скрытие input для создания mission появляются при динамическом создании
                            '<div class="form-group form-inline col-lg-12" v-if="mission && Object.keys(mission).length !== 0">' +
                                '<transition name="fade">' +
                                    '<div class="task-table form-group mx-2">' +
                                        '<div class="task-row mx-3">' +
                                            '<input class="task-cell" v-model=mission.name placeholder="Название">' +
                                            '<input class="task-cell" disabled="disabled" v-model=subjectObj().name placeholder="Предмет">' +
                                            '<input class="task-cell" v-model=mission.description placeholder="Описание">' +
                                            '<input class="task-cell" v-model=mission.level placeholder="Уровень">' +
                                        '</div>' +
                                        '<multiselect class="task-row mx-3" v-model="progress" tag-placeholder="Прогресс" placeholder="Добавить" label="name" track-by="name" :options="progresses"></multiselect>' +
                                    '</div>' +
                                '</transition>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                    '<div slot="body">' +
                        '<div class="task-table">' +
                            '<div class="task-header">' +
                                '<div class="task-row">' +
                                    '<div class="task-cell width-50 text-center">' +
                                        '<button href="#" @click.prevent="allSelectedTasks()" class="btn btn-primary btn-xs"><i class="fa fa-list-ul" aria-hidden="true"></i></button>' +
                                    '</div>' +
                                    '<div class="task-cell row">' +
                                        '<div class="task-row">' +
                                            '<div class="task-cell border-0 p-0">Разделы</div>' +
                                            '<multiselect class="task-cell border-0" v-model="section" :options="sections" placeholder="Раздел" label="name" track-by="name"></multiselect>' +
                                            '<button class="btn btn-primary btn-xs task-cell border-0" @click="allTasksChangeSection()"><i class="fa fa-angle-double-down"></i></button>' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="task-cell">Задача</div>' +
                                    '<div class="task-cell">Опыт</div>' +
                                    '<div class="task-cell">Монет</div>' +
                                    '<div class="task-cell">Уровень</div>' +
                                    '<div class="task-cell">Квест</div>' +
                                    '<div class="task-cell">Набор задач</div>' +
                                    '<div class="task-cell"></div>' +
                                '</div>' +
                            '</div>' +
                            '<div class="task-body">' +
                                '<div :class=classSelectedTask(task) @click="task.pick = !task.pick" class="task-row" v-for="(task, index) in tasks_cart" :key="task.id">' +
                                    '<div class="task-cell width-50 text-center">{{task.id}}</div>' +
                                    '<div class="task-cell">' +
                                        '<multiselect v-model="task.section" :options="sections" :value="task.section" placeholder="Раздел" label="name" track-by="name"></multiselect>' +
                                    '</div>' +
                                    '<div class="task-cell">{{task.task}}</div>' +
                                    '<div class="task-cell">{{task.experience}}</div>' +
                                    '<div class="task-cell">{{task.gold}}</div>' +
                                    '<div class="task-cell">{{task.grade}}</div>' +
                                    '<div class="task-cell"><span v-if="task.mission">{{task.mission.name}}</span></div>' +
                                    '<div class="task-cell row">' +
                                        '<span class="label label-info mx-2" v-for="(set_of_task, index) in task.set_of_tasks" :key="set_of_task.id">{{set_of_task.name}} <a href="#" @click.prevent="removeSetOfTask(task.set_of_tasks, set_of_task.id, index, task.id)" class="text-white fa fa-times"></a></span>' +
                                    '</div>' +
                                    '<a href="#" class="task-cell" v-on:click.prevent=remove(index)>Удалить</a>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                    '<div slot="footer" :showModal = showModal>' +
                        '<button class="modal-default-button btn btn-primary" @click="saveCart(), toggleMenu()">Сохранить</button>' +
                        '<button class="modal-default-button btn btn-primary" @click="showModal = false, toggleMenu()">Закрыть</button>' +
                    '</div>' +
                '</modal>' +
                '</li>',
    data: function (){
        return {
            show: false,
            showModal: false,
            set_of_tasks: [],
            options: [],
            tasks_cart:[],
            sections:[],
            mission: {},
            missions:[],
            subject: '',
            subjects:[],
            progress:{},
            progresses:[],
            images: [],
            pick: false,
            section: {}
        }

    },
    store,// Обязательно, чтобы видеть getters, actions, mutations
    mounted(){
        this.getSetOfTasks();
    },
    methods: {
        ...mapActions([
            'removeFromCart'
        ]),
        toggleMenu: function(){
          let menu = $('aside.main-sidebar');
            if(this.showModal)
                menu.hide();
            else
                menu.show();
        },
        remove: function(index){
            Swal.fire({
                title: 'Хотите удалить?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Да',
                cancelButtonText: 'Нет'
            }).then((result) => {
                if (result.value) {
                    this.removeFromCart(index);
                    this.tasks_cart.splice(index, 1);
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    return false;
                }
            })

        },
        removeSetOfTask: function(task_set, set_id, index, task_id){
            Swal.fire({
                title: 'Хотите удалить?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Да',
                cancelButtonText: 'Нет'
            }).then((result) => {
                if (result.value) {
                    task_set.splice(index, 1);
                    axios.post('tasks_cart/detach/'+this.subject,{
                        set_of_task_id: set_id,
                        task_id: task_id,
                    }).then(function (responsive){
                        console.log(responsive);
                        new Noty({
                            text: responsive.data,
                            type: 'success',
                        }).show();
                    }).catch(function () {
                        Swal.fire('Нельзя удалить!');
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    return false;
                }
            })
        },
        getSetOfTasks: function(){
            let app = this;
            let table = $('#table-tasks');
            if(table.length){
                if(this.tasks.length){
                    //Пареметр передаётся в модели task_{subject} через data-subject
                    this.subject = table.data('subject');
                    axios.post('tasks_cart/'+this.subject,{
                        tasks: JSON.stringify(this.tasks)
                    }).then(function (responsive) {
                        app.options = responsive.data[0];//Список задач
                        app.tasks_cart = responsive.data[1];//Задачи
                        app.sections = responsive.data[2];//Разделы предмета
                        app.missions = responsive.data[3];//Квесты фильтрованные по предмету
                        app.subjects = responsive.data[4];//Все предметы
                        app.progresses = responsive.data[5];//Все предметы
                        console.log(app.progresses);
                    }).catch(function (e) {
                        Swal.fire('Заполните ваши данные! Ошибка: ' + e);
                    });
                }else{
                    new Noty({text: 'Выберите задачи для сборки или набор задач или квест'});
                }
            }
        },
        saveCart: function () {
            console.log(1);
            if(this.tasks.length && (this.set_of_tasks.length || Object.keys(this.mission).length)){
                let app = this;
                axios.post('tasks_cart/save/'+this.subject,{
                    tasks: JSON.stringify(this.tasks_cart),
                    set_of_tasks: JSON.stringify(this.setWithImages(this.set_of_tasks)),
                    mission: JSON.stringify(this.mission),
                    progress: JSON.stringify(this.progress),
                }).then(function (responsive) {

                    let text = '';
                    responsive.data.forEach(function (item, i) {
                        text += item.set + ' :задача' + item.task_id + '<br>';
                    });

                    new Noty({
                        type: 'success',
                        text: (!text) ? 'Совпадений нет' :'Результат совпадений: <br>'+text//Список задач которые уже есть
                        }).show();
                }).catch(function (responsive) {
                    Swal.fire('Заполните ваши данные!');
                }).then(function () {
                    //Обновление данных после сохранения корзины
                    //app.getSetOfTasks();
                });
            }else{
                new Noty({
                    text: 'Выберите задачи для сборки в набор задач или ',
                    type: 'warning',
                }).show();
            }
        },
        setWithImages: function(set_of_tasks){
            set_of_tasks.forEach(function (set_of_task) {
                set_of_task.image = $('#set_of_task_image-'+set_of_task.id).find('input').val();
            });
            return set_of_tasks;
        },
        addSet (newTag) {
            const tag = {
                name: newTag,
                id: this.options.length+1,
                alias: '',
                image:'',
                type: '',
                description: ''
            };
            this.options.push(tag);
            this.set_of_tasks.push(tag);
        },
        addMission (newTag) {

            const tag = {
                name: newTag,
                id: this.missions.length+1,
                alias: '',
                subject_id: this.subjectObj().id,
                progress_id: '',
                description: '',
                level: 0
            };
            this.missions.push(tag);
        },

        url: function(id){
            if(id >= this.options.length)
                id = '';
            return 'set_of_task_' + ((this.subject === 'math') ? this.subject+'s' : this.subject) + '/image/image'+ ((id) ? '/'+id : '');
        },
        attributeId: function (id) {
            return 'set_of_task_image-'+id;
        },
        classSelectedTask: function(task){
            return {'bg-light' : task.pick};
        },
        allSelectedTasks: function () {
            this.pick = !this.pick;
            let pick = this.pick;

            this.tasks_cart.forEach(function (item) {
                item.pick = pick;
            })
        },
        allTasksChangeSection: function (value) {
            let section = this.section;
            this.tasks_cart.forEach(function (item) {
                if(item.pick){
                   item.section = section;
                }
            });
            console.log(this.section, this.tasks_cart);
        },
        addToProgress(mission) {
            //Определяем процесс по id и записываем объект процесса в миссию
            if(mission.progress_id)
                this.progress = this.progresses.find(p => p.id === mission.progress_id);
            else
                this.progress = {};
        },
        subjectObj() {
            //Определяем название предмета по alias
            let subject = this.subjects.find(s => s.alias === this.subject);
            //Записываем id предмета
            this.mission.subject_id = subject.id;

            return subject;
        }
    },
    computed: {
        ...mapGetters({
            tasks: 'cartTasks'
        }),
        total_experience () {
            return this.tasks.reduce((total, p) => {
                return total + parseInt(p.experience)
            }, 0)
        },
        total_gold () {
            return this.tasks.reduce((total, p) => {
                return total + parseInt(p.gold)
            }, 0)
        }
    }
}));
