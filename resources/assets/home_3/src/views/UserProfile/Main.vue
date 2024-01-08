<template>
    <v-container fluid game>
        <v-row>
            <material-card title="Общие данные" text="" offset="0" v-on:click="focus" :ripple="false">
                    <v-row class="d-flex align-content-end flex-wrap">
                        <v-col cols="12" sm="12" md="4" lg="4">
                            <v-list>
                                <v-list-item v-for="(item, index) in dataSetSubjects.general" :key="index">
                                    <v-list-item-icon>
                                        <v-btn icon ripple>
                                            <v-tooltip v-model="item.show" top>
                                                <template v-slot:activator="{ on }">
                                                    <v-icon @click="item.show = !item.show" class="icon" :class="item.icon_class"></v-icon>
                                                </template>
                                                <span>{{item.text}}</span>
                                            </v-tooltip>
                                        </v-btn>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>{{item.value}}</v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-list>
                        </v-col>
                        <v-col cols="12" sm="12" md="4" lg="4" >
                            <v-tabs v-model="chart.tabs" background-color="transparent" align-with-title color="black">
                                <v-tabs-slider color="yellow"></v-tabs-slider>
                                <span class="title font-weight-light mr-3" style="align-self: center">Графики роста:</span>
                                <v-tab class="mr-3" :key="0">
                                    По сложностям
                                </v-tab>
                                <v-tab class="mr-3" :key="1">
                                    По количеству задач
                                </v-tab>
                                <v-tab class="mr-3" :key="2">
                                    По опыту
                                </v-tab>
                            </v-tabs>
                            <v-list>
                            <v-list-item v-for="item in aliasSubjects()" :key="item" class="list-badge">
                                <v-list-item-action>
                                    <span :data-color="dataSetSubjects[item].color" class="badge filter" :class="`badge-${dataSetSubjects[item].color}`"></span>
                                </v-list-item-action>

                                <v-list-item-content>
                                    <v-list-item-title v-text="dataSetSubjects[item].name"></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list>
                            <v-tabs-items v-model="chart.tabs">
                            <v-tab-item :key="0">
                                <!-- Диаграмма распределения задач по уровням сложности -->
                                <material-chart-card
                                        @change="focus"
                                        ref="chart_card_0"
                                        class="main"
                                        :data="dataStats('grade_char', 'sum_tasks')"
                                        :options="dataStats('grade_char', 'sum_tasks').options"
                                        :responsive-options="dataStats('grade_char', 'sum_tasks').responsiveOptions"
                                        :elevation="0"
                                        type="Bar"
                                >
                                    <h4 class="title font-weight-light">График распределения задач по уровням сложности</h4>
                                    <p class="category d-inline-flex font-weight-light"></p>
                                </material-chart-card>
                            </v-tab-item>
                            <v-tab-item :key="1">
                                <!-- График роста задач по количеству решённых задач -->
                                <material-chart-card
                                        ref="chart_card_1"
                                        class="main"
                                        :data="dataStats('number_lesson', 'sum_tasks')"
                                        :options="{
                                            lineSmooth: this.$chartist.Interpolation.simple({divisor: 2}),
                                            axisY: {
                                                //Округляем до целого значения
                                                labelInterpolationFnc: function(value) {
                                                  return parseInt(value);
                                                }
                                            },
                                        }"
                                        :responsive-options="dataStats('number_lesson', 'sum_tasks').responsiveOptions"
                                        :elevation="0"
                                        type="Line"
                                >
                                    <h4 class="title font-weight-light">График распределения решённых задач по занятиям</h4>
                                    <p class="category d-inline-flex font-weight-light"></p>
                                </material-chart-card>
                            </v-tab-item>
                            <v-tab-item :key="2">
                                <!-- График роста задач по количеству опыту -->
                                <material-chart-card
                                        ref="chart_card_2"
                                        class="main"
                                        :data="dataStats('number_lesson', 'sum_exp')"
                                        :options="{
                                            lineSmooth: this.$chartist.Interpolation.simple({divisor: 2}),
                                            axisY: {
                                                //Округляем до целого значения
                                                labelInterpolationFnc: function(value) {
                                                  return parseInt(value);
                                                }
                                            },

                                        }"
                                        :responsive-options="dataStats('number_lesson', 'sum_exp').responsiveOptions"
                                        :elevation="0"
                                        type="Line"
                                >
                                    <h4 class="title font-weight-light">График распределения опыта по занятиям</h4>
                                    <p class="category d-inline-flex font-weight-light"></p>
                                </material-chart-card>
                            </v-tab-item>
                        </v-tabs-items>
                        </v-col>

                        <!-- Выводит 20 последних задач по всем предметам -->
                        <v-col cols="12" sm="12" md="4" lg="4" >
                            Последние 20 выполненных задач
                            <v-list-item v-for="item in listLastTasks(20)" :key="item.id" two-line>
                                <v-list-item-content>
                                    <v-list-item-title>{{ item.number_task}}. {{ item.task }}</v-list-item-title>
                                    <v-list-item-subtitle>{{ moment(item.created_at).format('MM.DD.YYYY')}} {{ item.subject}}</v-list-item-subtitle>
                                </v-list-item-content>

                                <v-list-item-action>
                                    <v-btn icon>
                                        <v-tooltip v-model="item.show" top>
                                            <template v-slot:activator="{ on }">
                                                <v-btn icon @click="item.show = !item.show" @handle="focus()">
                                                    <v-icon color="grey">fa-info-circle</v-icon>
                                                </v-btn>
                                            </template>
                                            <span>опыт: {{item.experience}} монет: {{item.gold}} трудность: {{item.grade}}</span>
                                        </v-tooltip>
                                    </v-btn>
                                </v-list-item-action>
                            </v-list-item>
                        </v-col>
                    </v-row>
            </material-card>
        </v-row>
        <!-- Статистика по каждому предмету tab -->
        <v-row>
            <material-card class="card-tabs" width="100%">
                <v-row slot="header">
                    <v-tabs v-model="subject.tabs" color="white" background-color="transparent">
                        <span class="font-weight-light mx-3" style="align-self: center">Предметы:</span>
                        <v-tab class="mr-3" v-for="(subject, key, index) in this.user" :key="index">
                            <!--<v-icon class="mr-2">mdi-bug</v-icon>-->
                            {{dataSetSubjects[key].name}}
                        </v-tab>
                    </v-tabs>
                </v-row>

                <!-- Большой цикл tab value значение свойства по каждому предмету-->
                <v-tabs-items v-model="subject.tabs">
                    <v-tab-item v-for="(value, subject, index) in this.user" :key="index">
                        <v-row class="d-flex align-content-end flex-wrap">
                            <!-- Статистика по предмету -->
                            <v-col @click="complete('subject' ,0)" cols="12" sm="12" md="4" lg="4">
                                Предмет {{dataSetSubjects[subject].name}}
                                <v-list>
                                    <v-list-item v-for="(item, key, i) in dataSetSubjects[subject]" :key="i" v-if="key !== 'color' && key !== 'name'">
                                        <v-list-item-icon>
                                            <v-btn icon ripple>
                                                <v-tooltip v-model="item.show" top>
                                                    <template v-slot:activator="{ on }">
                                                        <v-icon class="icon" :class="item.icon_class" @click="item.show = !item.show"></v-icon>
                                                    </template>
                                                    <span>{{item.text}}</span>
                                                </v-tooltip>
                                            </v-btn>
                                        </v-list-item-icon>

                                        <v-list-item-content v-if="typeof item.value !== 'object'">
                                            <v-list-item-title>{{item.value}}</v-list-item-title>
                                        </v-list-item-content>

                                        <!-- Вывод количества задач по трудностям -->
                                        <v-list-item-content v-else>
                                            <v-list-item-title>
                                                {{item.value.sum_tasks}}
                                                <v-tooltip bottom>
                                                    <template v-slot:activator="{ on }">
                                                        <v-btn icon v-on="on">
                                                            <v-icon color="grey">fa-info-circle</v-icon>
                                                        </v-btn>
                                                    </template>
                                                    <span>
                                                        Опыт: {{item.value.sum_exp}}
                                                        Монет: {{item.value.sum_gold}}
                                                    </span>
                                                </v-tooltip>
                                            </v-list-item-title>
                                        </v-list-item-content>
                                    </v-list-item>
                                </v-list>
                            </v-col>

                            <!-- Список достижений по предмету -->
                            <v-col @click="complete('subject', 1)" cols="12" sm="12" md="4" lg="4">
                                Достижения
                                <v-list two-line v-if="value.user_progresses.length">
                                    <div v-for="(progress, index) in value.user_progresses">
                                        <v-list-item :key="progress.name">
                                            <v-list-item-avatar>
                                                <img :src="progress.image">
                                            </v-list-item-avatar>

                                            <v-list-item-content>
                                                <v-list-item-title v-html="progress.name"></v-list-item-title>
                                                <v-list-item-subtitle v-html="progress.description"></v-list-item-subtitle>
                                            </v-list-item-content>
                                        </v-list-item>
                                    </div>
                                </v-list>
                                <div v-else>
                                    У вас пока нет достижений по этому предмету. Нужно решить больше задач разного уровня.
                                </div>
                            </v-col>
                            <v-col @click="complete('subject', 2)" cols="12" sm="12" md="4" lg="4">
                                    Доступные функции. Открываются новые возможности по изучению предмета. Вы можете пользоваться по достижению определённого уровня.
                            </v-col>
                        </v-row>
                    </v-tab-item>
                </v-tabs-items>
            </material-card>
        </v-row>
    </v-container>
</template>

<script>
    // Utilities
    import {mapMutations, mapState} from 'vuex'

    export default {
        name: "Main",
        data: () => ({
            dataSetSubjects: {},
            subject:{
                tabs: 0,
                list: {},//Объект необходим для хранения свойств вкладок таба, активный/неактивный таб
            },
            chart:{
                tabs: 0,
                list: {
                    0: false,
                    1: false,
                    2: false
                },
            }
        }),
        methods: {
            ...mapState('app', ['user']),
            complete (obj = 'subject', index) {
                this[obj].list[index] = !this[obj].list[index]
            },
            //Функция обновляет chartist объект при клике на общую карту главной страницы
            //Важно событие click обрабытывает после события change
            focus(){
                for (let ref in this.$refs){
                    if(this.$refs.hasOwnProperty(ref) && ref.indexOf('chart_cart'))
                        this.$refs[ref].$refs.chart.redraw();
                }
            },
            listLastTasks(index = 20){
                let user = this.user;
                let tasks = [];
                for (let prop in user){
                    if(user.hasOwnProperty(prop) && user[prop].last_tasks.length)
                        tasks = tasks.concat(user[prop].last_tasks);
                }

                tasks.sort(function (a, b) {
                    let data_a = new Date(a.created_at);
                    let data_b = new Date(b.created_at);
                    return data_a.getTime() - data_b.getTime()
                });

                return tasks.slice(0, index);
            },

            aliasSubjects(){
                return Object.keys(this.user);
            },
            //Универсальная функция принимает параметр группировки по полю и параметр свойства
            //Нужные данные для построения графика или диаграммы
            dataStats(group='grade_char', total='sum_tasks'){
                let user = this.user;
                let labels = [];
                let series = [];

                for (let subject in user){
                    let set = [];

                    if(user.hasOwnProperty(subject)){
                        let props = user[subject].stats[group];//Получаем массив свойств по группировки grade_char, number_lesson, section_id
                        labels = labels.concat(Object.keys(props));//Объединение ключей объекта для получения label

                        if(Object.keys(props).length !== 0){
                            for (let prop in props){
                                if(props.hasOwnProperty(prop))
                                    set.push(props[prop][total])
                            }
                        }
                        series.push(set);
                    }
                }
                return {
                    labels: this.$dataUser.unique(labels),
                    series: series
                }
            },
            setSubjectsGeneralValue(prop, number_lesson){
                this.dataSetSubjects.general[prop].value += this.$dataUser.sumArrayObj(number_lesson, prop);
            },
            generalSumStats(){
                let user = this.user;
                for (let subject in user){
                    if(user.hasOwnProperty(subject)){
                        let number_lesson = user[subject].stats.number_lesson;
                        let grade_char = user[subject].stats.grade_char;

                        //Суммируем характеристики по всем предметам
                        this.setSubjectsGeneralValue('sum_exp', number_lesson);
                        this.setSubjectsGeneralValue('sum_gold', number_lesson);
                        this.setSubjectsGeneralValue('sum_tasks', number_lesson);

                        this.dataSetSubjects[subject].sum_exp.value = user[subject].sum_res.sum_exp;
                        this.dataSetSubjects[subject].sum_gold.value = user[subject].sum_res.sum_gold;
                        this.dataSetSubjects[subject].sum_tasks.value = this.$dataUser.sumArrayObj(number_lesson, 'sum_tasks');;

                        for (let grade in grade_char){
                            this.dataSetSubjects[subject][grade].value = grade_char[grade];
                        }
                    }
                }
            },

            resetPropsGenerals(){
                //Обнуляем данные в случае обновления компонента, чтобы не суммировались старые данные
                this.dataSetSubjects.general['sum_exp'].value = 0;
                this.dataSetSubjects.general['sum_gold'].value = 0;
                this.dataSetSubjects.general['sum_tasks'].value = 0;
            },

        },

        mounted() {
            this.user = this.$store.state.app.user.subjects;
            this.dataSetSubjects = this.$dataUser.dataSetSubjects;
            this.resetPropsGenerals();
            this.generalSumStats();

            //Динамически генерируется list для subject.tabs предметов
            this.subject.list = this.$dataUser.generateTabList(this.user);

            this.$refs['chart_card_0'].$refs.chart.$on('change', function () {
                this.$refs['chart_card_0'].$refs.chart.redraw()
            });
        },
        updated: function () {
            this.$nextTick(function () {
                window.MathJax.Hub.Queue(["Typeset", window.MathJax.Hub]);
            });
        },
    }
</script>
<style>
    g.ct-labels {
        color: black;
    }
    /*Временное решение чтобы скрыть блоки формул заключённые в [], чтобы исправить нужно формулы держать внутри ()*/
    .MathJax_PHTML_Display {
        display: inline-block;
    }
</style>
