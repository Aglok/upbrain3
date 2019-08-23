<template>
    <v-container fill-height fluid grid-list-xl game>
        <v-layout justify-center wrap>
            <v-flex md12>
                <material-card
                        :title="this.$store.state.app.user.subjects[this.$store.state.app.subject].user_missions[this.$route.params.mission_id].name"
                        :text="this.$store.state.app.user.subjects[this.$store.state.app.subject].user_missions[this.$route.params.mission_id].description"
                >
                    <v-data-table :headers="headers" :items="tasks" hide-actions :expand="expand" item-key="id">

                        <template v-slot:headers="props">
                            <tr>
                                <th v-for="header in props.headers" :class="(header.value == 'images') ? 'hidden-sm-and-down': 'hidden-xs-only'">
                                    <span class="subheading font-weight-light black--text" v-text="header.text"/>
                                </th>
                            </tr>
                        </template>
                        <template v-slot:items="props">
                            <tr @click="props.expanded = !props.expanded">
                                <td>{{props.item.id}}</td>
                                <td v-html="props.item.task" ref="task_{{props.item.id}}">
                                    <img v-if="props.item.image" :src="props.item.image">
                                </td>
                                <td class="hidden-xs-only">{{props.item.grade}}</td>
                                <td class="hidden-xs-only">{{props.item.experience}}</td>
                                <td class="hidden-xs-only">{{props.item.gold}}</td>
                                <td class="hidden-xs-only">{{props.item.answer}}</td>
                                <td class="hidden-xs-only">
                                    <span :class="[props.item.done ? 'green--text' : 'red--text']">{{props.item.percent}}</span>
                                    <!--<span class="green&#45;&#45;text">Ok</span>-->
                                </td>
                            </tr>
                        </template>
                        <template v-slot:expand="props">
                            <v-card flat class="hidden-md-and-up">
                                <v-card-text>Трудность: {{props.item.grade}}</v-card-text>
                                <v-card-text>Опыт: {{props.item.experience}}</v-card-text>
                                <v-card-text>Монет: {{props.item.gold}}</v-card-text>
                                <v-card-text>Ответ: {{props.item.answer}}</v-card-text>
                                <v-card-text>Выполнено: <span :class="[props.item.done ? 'green--text' : 'red--text']">{{props.item.percent}}</span></v-card-text>
                            </v-card>
                        </template>
                    </v-data-table>
                </material-card>
                <div class="footer">
                    <hr>
                    <div class="stats">
                        <!--<i class="fa fa-history"></i> Последнее обновление {{moment(date.updated_at).fromNow()}}-->
                    </div>
                </div>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import {mapMutations, mapState} from 'vuex'
    export default {
        name: "TableTasks",
        data: () => ({
            expand: true,
            headers:[
                {
                    sortable: false,
                    text: 'Номер',
                    value: 'number_task',
                },
                {
                    sortable: false,
                    text: 'Задача',
                    value: 'task',
                },
                {
                    sortable: false,
                    text: 'Трудность',
                    value: 'grade',
                },
                {
                    sortable: false,
                    text: 'Опыт',
                    value: 'experience',
                },
                {
                    sortable: false,
                    text: 'Монет',
                    value: 'gold',
                },
                {
                    sortable: false,
                    text: 'Ответ',
                    value: 'answer',
                },
                {
                    sortable: false,
                    text: 'Выполнено',
                    value: 'done',
                },
            ],
            tasks: [],
            date: {
                updated_at: ''//Чтобы свойство было реактивным необходимо создавать объекты со свойствами
            },
            mission_id: 0
        }),
        methods:{
            setData(data){
                //console.log(data);
                let app = this;
                let id = data.id;
                let task = data.task;
                let image = data.image;
                let grade = data.grade;
                let section_id = data.section_id;
                let experience = data.experience;
                let gold = data.gold;
                let answer = data.answer;
                let percent = 100;
                let done = true;

                //TODO: получить массив опытов и монет. Расчитать общую сумму.
                // let total_experience = this.$dataUser.sumBalls(array_experience);
                // let total_gold = this.$dataUser.sumBalls(array_gold);

                app.tasks.push({
                    id: id,
                    task: task,
                    image: image,
                    grade: grade,
                    section: data.section_id,
                    experience: data.experience,
                    gold: gold,
                    answer: answer,
                    percent: percent,
                    done: done
                });

            },
            getData(){
                let app = this;
                //math переменную берём из vuex subjects
                this.$dataUser.getData('/profile/table_tasks/'+this.$store.state.app.subject+'/'+this.$route.params.mission_id, (response) => {
                    response.data.forEach(function (item) {
                        app.setData(item);
                    });
                });
            },
            ...mapState('app', ['subject']),
        },
        created(){
            this.getData()
        },
        updated: function () {
            //app.tasks = [];
            //this.getData()
            this.$nextTick(function () {
                window.MathJax.Hub.Queue(["Typeset", window.MathJax.Hub]);
            })
        },
        // обрабатываем изменение параметров маршрута...
        // не забываем вызвать next()
        beforeRouteUpdate (to, from, next) {
            const route = this.$route.params.mission_id;
            this.$route.params.mission_id = to.params.mission_id;//Обновляем параметр роутера до post запроса
            this.tasks = []; //Обнуляем массив tasks, для заполнения новыми задачами
            this.getData(); //Вызываем повторную загрузку missions с новыми id
            this.$route.params.mission_id = route;//Возвращаем текущий роутер на место, после получения данных tasks
            next()
        }
    }
</script>

<style scoped>

</style>