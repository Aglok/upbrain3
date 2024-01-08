<template>
    <v-container fluid game table>
        <v-row>
            <v-col cols="12">
                <material-card
                        :title=this.getUserMission().name
                        :text=this.getUserMission().description
                >
                    <!-- Чтобы включить expanded panel нужно добавить свойство show-expand-->
                    <v-data-table :headers="headers" :items="tasks" hide-default-footer :expanded.sync="expanded" item-key="number_task">

                        <!--<template v-slot:item.data-table-expand="{ item }">-->
                            <!--<v-icon color="black">mdi-chevron-down</v-icon>-->
                        <!--</template>-->

                        <template v-slot:item.percent="{ item }">
                            <v-chip :color="getColor(item.percent)">{{ item.percent }}</v-chip>
                        </template>

                        <template v-slot:item.done="{ item }">
                            <span :class="[item.done ? 'green--text' : 'red--text']">{{ (item.done)? 'Да' : 'Нет'}}</span>
                        </template>

                        <template v-slot:item.task="{ item }">
                            <span ref="task_{{item.id}}">{{item.task}}</span>
                            <img v-if="item.image" :src="item.image">
                        </template>

                        <!--<template v-slot:expanded-item="{ item }">-->
                            <!--<v-card flat>-->
                                <!--<v-card-text>Подсказка</v-card-text>-->
                            <!--</v-card>-->
                            <!--<v-card flat class="d-sm-none">-->
                                <!--<v-card-text>Трудность: {{item.grade}}</v-card-text>-->
                                <!--<v-card-text>Опыт: {{item.experience}}</v-card-text>-->
                                <!--<v-card-text>Монет: {{item.gold}}</v-card-text>-->
                                <!--<v-card-text>Ответ: {{item.answer}}</v-card-text>-->
                                <!--<v-card-text>Выполнено: <span :class="[item.done ? 'green&#45;&#45;text' : 'red&#45;&#45;text']">{{item.percent}}</span></v-card-text>-->
                            <!--</v-card>-->
                        <!--</template>-->
                    </v-data-table>
                </material-card>
                <div class="footer">
                    <hr>
                    <div class="stats">
                        <!--<i class="fa fa-history"></i> Последнее обновление {{moment(date.updated_at).fromNow()}}-->
                    </div>
                </div>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import {mapMutations, mapState} from 'vuex'
    export default {
        name: "TableTasks",
        data: () => ({
            expanded: [],
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
                    text: 'Процент',
                    value: 'percent',
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
            mission_id: 0,
            title: '',
            text: ''
        }),
        methods:{
            getColor (percent) {
                if (percent < 30) return 'red'
                else if (percent < 60 && percent < 60) return 'orange'
                else return 'green'
            },
            setData(data){
                let app = this;
                let id = data.id;
                let number_task = data.number_task;
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
                    number_task: number_task,
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
                    console.log(response)
                    response.data.tasks.forEach(function (item) {
                        app.setData(item);
                    });
                });
            },
            ...mapState('app', ['subject']),
            getUserMission(){
                return this.$store.state.app.user.subjects[this.$store.state.app.subject].user_missions.find(m => m.id === parseInt(this.$route.params.mission_id));
            }
        },
        created(){
            this.getData();
            // this.title = this.getUserMission().name;
            // this.text = this.getUserMission().description;
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