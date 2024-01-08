<template>
  <v-container fluid game table>
    <v-row>
      <v-col cols="12">
        <material-card
          title="Экзамены"
          text="Список экзаменов"
        >
          <v-data-table
                  :disable-sort="true"
                  :headers="headers"
                  :items="exam.data"
                  hide-default-footer
                  item-key="exam_name"
          >

            <template v-slot:item.exam_name="{ item }">
                <accordion-menu-exam :contents="[
                        {
                          exam_id: item.exam_id,
                          title: item.exam_name,
                          msg: 'Результаты экзаменов',
                          result_short_answers: item.result_short_answers,
                          result_expanded_answers: item.result_expanded_answers
                        },
                    ]">
              </accordion-menu-exam>
            </template>

            <template v-slot:item.start_date="{ item }">
              {{moment(item.start_date).format('DD.MM.YYYY h:mm')}}
            </template>

            <template v-slot:item.images="{ item }">
              <silentbox-single class="hidden-sm-and-down" v-for="(image, index) in item.images"
                                :src=image
                                :key=index
                                :description="index+1+' Часть'">
                <img :src=image width="100px">
              </silentbox-single>
              <v-expansion-panels class="hidden-md-and-up mb-2">
                  <v-expansion-panel>
                    <v-expansion-panel-header>Изображения</v-expansion-panel-header>
                    <v-expansion-panel-content>
                      <silentbox-single v-for="(image, index) in item.images"
                                        :src=image
                                        :key=index
                                        :description="index+1+' Часть'">
                          <img :src=image width="50px">
                      </silentbox-single>
                    </v-expansion-panel-content>
                  </v-expansion-panel>
              </v-expansion-panels>
            </template>
          </v-data-table>
        </material-card>
        <div class="footer">
          <hr>
          <div class="stats">
            <i class="fa fa-history"></i> Последнее обновление {{moment(date.updated_at).fromNow()}}
          </div>
        </div>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    expanded: [],
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
          text: 'Экзамен',
          value: 'exam_name',
        },
        {
          text: 'Дата',
          value: 'start_date',
        },
        {
          text: 'Первичный балл',
          value: 'total_primary',
        },
        {
          text: 'Тестовый балл',
          value: 'total_test',
        },
        {
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

      this.$dataUser.getPostData('/profile/exam', (response) => {

          app.date.updated_at = response.data.data[response.data.data.length-1].updated_at;

          response.data.data.forEach(function (item) {
              app.setData(item);
          });
      });
  }
}
</script>
