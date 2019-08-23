<template>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
        <h3>{{exam_name}}</h3>
        <div class="mb-4">
            <div>{{full_name}}</div>
            <div>Общее количество первичных баллов: <span class="text-success">{{table1.total + table2.total}}</span></div>
            <div>Тестовый балл: <span class="text-success">{{this.$dataUser.getTestBalls(table1.total + table2.total)}}</span></div>
        </div>
          <card>
            <template slot="header">
              <h4 class="card-title">Результаты выполнения заданий с кратким ответом</h4>
              <p class="card-category">Максимальный балл 12</p>
            </template>
            <div class="table-responsive">
              <l-table class="table-hover table-striped"
                       :type="table1.type"
                       :columns="table1.columns"
                       :data="table1.data"
                       :translates="table1.translates"
                       :total="table1.total">
              </l-table>
            </div>
          </card>

        </div>

        <div class="col-12">
          <card class="card-plain">
            <template slot="header">
              <h4 class="card-title">Результаты выполнения заданий с развёрнутым ответом</h4>
              <p class="card-category">Максимальный балл 20</p>
            </template>
            <div class="table-responsive">
              <l-table class="table-hover"
                       :type="table2.type"
                       :columns="table2.columns"
                       :data="table2.data"
                       :translates="table2.translates"
                       :total="table2.total">
              </l-table>
            </div>
          </card>
        </div>
        <div>Комментарии к работе: {{comments}}</div>
      </div>
    </div>
  </div>
</template>
<script>
  import LTable from '../../../components/UIComponents/Table.vue';
  import Card from '../../../components/UIComponents/Cards/Card.vue';
  const balls = [2,2,2,3,3,4,4];

  export default {
    components: {
      LTable,
      Card
    },
    data () {
      return {
        table1: {
            type: 'short',
            columns: ['id', 'short_answer', 'exam_answer' ,'result_short_answer', 'ball'],
            data: [],
            translates: ['Номер', 'Ваш ответ', 'Правильный ответ', 'Ваш балл', 'Максимальный балл'],
            total: 0
        },
        table2: {
            type: 'expanded',
            columns: ['id', 'result_expanded_answer', 'ball'],
            data: [],
            translates: ['Номер', 'Ваш балл', 'Максимальный балл'],
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
                    app.table1.data.push({
                        id: i+1,
                        short_answer: short_answers[i],
                        exam_answer: exam_answers[i],
                        result_short_answer: result_short_answers[i],
                        ball: 1
                    });

                    if(result_expanded_answers[i]){
                        app.table2.data.push({
                            id: i+13,
                            result_expanded_answer: result_expanded_answers[i],
                            ball: balls[i]
                        });
                    }
                });

                app.table1.total = this.$dataUser.sumBalls(result_short_answers);
                app.table2.total = this.$dataUser.sumBalls(result_expanded_answers);
        }
    },
    created(){

        this.$dataUser.getData('/home_users/'+this.$route.params.id, (response) => {
            this.setData(response.data.data[0]);
        });
    }
  }
</script>
<style>
</style>
