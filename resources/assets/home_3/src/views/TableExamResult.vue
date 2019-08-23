<template>
  <v-container fill-height fluid grid-list-xl>
    <v-layout justify-center wrap>
      <v-flex md12>
        <material-card
                color="green"
                title="Результаты выполнения заданий с кратким ответом"
                text="Максимальный балл 12"
        >
              <h3>{{exam_name}}</h3>
              <div class="md-4">
                  <div>{{full_name}}</div>
                  <div>Общее количество первичных баллов: <span class="text-success">{{table1.data.total + table2.data.total}}</span></div>
                  <div>Тестовый балл: <span class="text-success">{{this.$dataUser.getTestBalls(table1.data.total + table2.data.total)}}</span></div>
              </div>
              <v-data-table :headers="table1.headers" :items="table1.data.items" :total-items ="12" hide-actions>
                <template slot="items" slot-scope="{ item }">
                  <td>{{ item.id }}</td>
                  <td>{{ item.short_answer }}</td>
                  <td>{{ item.exam_answer }}</td>
                  <td>{{ item.result_short_answer }}</td>
                  <td>{{ item.ball }}</td>
                </template>
                <template slot="footer">
                    <td :colspan="3">Общая сумма</td>
                    <td class="text-danger">{{table1.data.total}}</td>
                    <td>12</td>
                </template>
              </v-data-table>
      </material-card>
      </v-flex>

      <v-flex md12>
          <material-card
              color="green"
              title="Результаты выполнения заданий с развёрнутым ответом"
              text="Максимальный балл 20"
          >
          <v-data-table :headers="table2.headers" :items="table2.data.items" :total-items ="7" hide-actions>
              <template slot="items" slot-scope="{ item }">
                  <td>{{ item.id }}</td>
                  <td>{{ item.result_expanded_answer }}</td>
                  <td>{{ item.ball }}</td>
              </template>
              <template slot="footer">
                  <td>Общая сумма</td>
                  <td class="text-danger">{{table2.data.total}}</td>
                  <td>20</td>
              </template>
          </v-data-table>
          </material-card>
          <div>Комментарии к работе: {{comments}}</div>
      </v-flex>
    </v-layout>
  </v-container>
</template>
<script>

  const balls = [2,2,2,3,3,4,4];

  export default {
    data () {
      return {
        table1: {
            headers:[
              {
                  sortable: false,
                  text: 'Номер',
                  value: 'id',
                  aline: 'center'
              },
              {
                  sortable: false,
                  text: 'Ваш ответ',
                  value: 'short_answer',
                  aline: 'center'
              },
              {
                  sortable: false,
                  text: 'Правильный ответ',
                  value: 'exam_answer',
                  aline: 'center'
              },
              {
                  sortable: false,
                  text: 'Ваш балл',
                  value: 'result_short_answer',
                  aline: 'center'
              },
              {
                  sortable: false,
                  text: 'Максимальный балл',
                  value: 'ball',
                  aline: 'center'
              },
            ],
            data: {
                items: [],
                total: 0
            },

        },
        table2: {
            headers:[
                {
                    sortable: false,
                    text: 'Номер',
                    value: 'id',
                },
                {
                    sortable: false,
                    text: 'Ваш балл',
                    value: 'result_expanded_answer',
                },
                {
                    sortable: false,
                    text: 'Максимальный балл',
                    value: 'ball',
                },
            ],
            data: {
                items: [],
                total: 0
            },
            total: 0
        },
        comments: '',
        full_name: '',
        exam_name: ''
      }
    },
    methods:{
        setData(data){
                let app = this;

                let short_answers = data.short_answers.split(':');
                let exam_answers = data.exam_answers.split(':');
                let result_short_answers = data.result_short_answers.split(':');
                let result_expanded_answers = data.result_expanded_answers.split(':');
                this.full_name = data.full_name;
                this.comments = data.comments;
                this.exam_name = data.exam_name;

                exam_answers.forEach(function (item, i) {
                    app.table1.data.items.push({
                        id: i+1,
                        short_answer: short_answers[i],
                        exam_answer: exam_answers[i],
                        result_short_answer: result_short_answers[i],
                        ball: 1
                    });

                    if(result_expanded_answers[i]){
                        app.table2.data.items.push({
                            id: i+13,
                            result_expanded_answer: result_expanded_answers[i],
                            ball: balls[i]
                        });
                    }
                });

                app.table1.data.total = this.$dataUser.sumBalls(result_short_answers);
                app.table2.data.total = this.$dataUser.sumBalls(result_expanded_answers);
        }
    },
    created(){

        this.$dataUser.getData('/profile/exam/'+this.$route.params.id, (response) => {
            this.setData(response.data.data[0]);
        });
    }
  }
</script>
<style>
</style>
