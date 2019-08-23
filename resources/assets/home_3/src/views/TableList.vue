<template>
  <v-container fill-height fluid grid-list-xl>
    <v-layout justify-center wrap>
      <v-flex md12>
        <material-card
          color="green"
          title="Экзамены"
          text="Список экзаменов"
        >
          <v-data-table :headers="headers" :items="exam.data" hide-actions>

            <template slot="headerCell" slot-scope="{ header }">
              <span class="subheading font-weight-light text-success text--darken-3" v-text="header.text"/>
            </template>
            <template slot="items" slot-scope="{item}">
              <td>
                <accordion-menu :contents="[
                        {
                          exam_id: item.exam_id,
                          title: item.exam_name,
                          msg: 'Результаты экзаменов',
                          result_short_answers: item.result_short_answers,
                          result_expanded_answers: item.result_expanded_answers
                        },
                    ]">
                </accordion-menu>
              </td>
              <td>{{moment(item.start_date).format('DD.MM.YYYY', 'h:mm')}}</td>
              <td>{{item.total_primary}}</td>
              <td>{{item.total_test}}</td>
              <td class="hidden-sm-and-down">
                <silentbox-single v-for="(image, index) in item.images"
                                  :src=image
                                  :key=index
                                  :description="index+1+' Часть'">
                  <img :src=image width="100px">
                </silentbox-single>
              </td>
            </template>
          </v-data-table>
        </material-card>
        <div class="footer">
          <hr>
          <div class="stats">
            <i class="fa fa-history"></i> Последнее обновление {{moment(date.updated_at).fromNow()}}
          </div>
        </div>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    content:[
          {
              exam_id: 1,
              title: '',
              msg: '',
              result_short_answers: [],
              result_expanded_answers: [],
          },
      ],
      headers:[
        {
          sortable: false,
          text: 'Экзамен',
          value: 'exam_name',
        },
        {
          sortable: false,
          text: 'Дата',
          value: 'start_date',
        },
        {
          sortable: false,
          text: 'Первичный балл',
          value: 'total_primary',
        },
        {
          sortable: false,
          text: 'Тестовый балл',
          value: 'total_test',
        },
        {
          sortable: false,
          text: 'Файлы',
          value: 'images',
        }
      ],
      exam: {
          data: []
      },
      date: {
          updated_at: ''//Чтобы свойство было реактивным необходимо создавать объекты со свойствами
      }
  }),
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

      this.$dataUser.getData('/profile/exam', (response) => {

          app.date.updated_at = response.data.data[response.data.data.length-1].updated_at;

          response.data.data.forEach(function (item) {
              app.setData(item);
          });
      });
  }
}
</script>
