<template>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <card>
            <template slot="header">
              <h5 class="title">Экзамены</h5>
              <p class="category">Список экзаменов</p>
            </template>
            <l-table :data="exam.data"
                     :columns="exam.columns"
                     :translates="exam.translates">
              <template slot="columns"></template>

              <template slot-scope="{row}">
                <td>
                  <accordion-menu :contents="[
                        {
                          exam_id: row.exam_id,
                          title: row.exam_name,
                          msg: 'Результаты экзаменов',
                          result_short_answers: row.result_short_answers,
                          result_expanded_answers: row.result_expanded_answers
                        },
                    ]">
                  </accordion-menu>
                </td>
                <td>{{moment(row.start_date).format('DD.MM.YYYY', 'h:mm')}}</td>
                <td>{{row.total_primary}}</td>
                <td>{{row.total_test}}</td>
                <td>
                  <silentbox-single v-for="(image, index) in row.images"
                          :src=image
                          :key=index
                          :description="index+1+' Часть'">
                          <img :src=image width="100px">
                  </silentbox-single>
                </td>
              </template>
              <template slot="add"></template>
            </l-table>
            <div class="footer">
              <hr>
              <div class="stats">
                <i class="fa fa-history"></i> Последнее обновление {{moment(date.updated_at).fromNow()}}
              </div>
            </div>
          </card>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import Card from '../../../components/UIComponents/Cards/Card.vue'
  import LTable from '../../../components/UIComponents/Table.vue'

  export default {
    components: {
      Card,
      LTable
    },
    data () {
      return {
        content:[
            {
              exam_id: 1,
              title: '',
              msg: '',
              result_short_answers: [],
              result_expanded_answers: [],
            },
        ],
        exam: {
            translates:['Экзамен', 'Дата', 'Первичный балл', 'Тестовый балл', 'Файлы'],
            columns:['exam_name', 'start_date', 'total_primary', 'total_test', 'images'],
            data: []
        },
        date: {
            updated_at: ''//Чтобы свойство было реактивным необходимо создавать объекты со свойствами
        }
      }

    },
    methods:{
        setData(data){
            let app = this;

            let exam_id = data.exam_id;
            let result_short_answers = data.result_short_answers.split(':');
            let result_expanded_answers = data.result_expanded_answers.split(':');
            let start_date = data.start_date;
            let exam_name = data.exam_name;

            let total_primary = this.$dataUser.sumBalls(result_short_answers) + this.$dataUser.sumBalls(result_expanded_answers);
            let total_test = this.$dataUser.getTestBalls(total_primary);

            let images = JSON.parse(data.images);

            app.exam.data.push({
                exam_id: exam_id,
                result_short_answers: result_short_answers,
                result_expanded_answers: result_expanded_answers,
                exam_name: exam_name,
                start_date: start_date,
                total_primary: total_primary,
                total_test: total_test,
                images: images,
            });

        }
    },
    created(){
        let app = this;

        this.$dataUser.getData('/home_users', (response) => {

            app.date.updated_at = response.data.data[response.data.data.length-1].updated_at;

            response.data.data.forEach(function (item) {
                app.setData(item);
            });
        });
    }
  }
</script>
<style>
</style>
