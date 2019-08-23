Vue.component('exam_answers', Vue.extend({
    props: ['id'],
    template: '<div class="col-md-12">' +
    '          <div class="col-md-4">'+
    '          <label for="exam_answers" class="control-label">Ответы к задачам  1-12</label>    ' +
    '               <table class="table-primary table table-striped">'+
    '               <thead>' +
    '                   <tr>' +
    '                       <th>№ задачи</th>' +
    '                       <th>Ответы</th>' +
    '                   </tr>' +
    '               </thead>'+
    '               <tbody>'+
    '                   <tr v-for="input, index in exam_answers">' +
    '                       <td>{{index+1}}</td>' +
    '                       <td><input :id="\'answer_\'+input" v-model=exam_answers[index] type=text></td>' +
    '                   </tr>' +
    '           </tbody>'+
    '           </table>' +
    '           </div>' +
    '           <div class="form-group form-element-text col-md-6">' +
    '               <input type="hidden" class="form-control" name="exam_answers" :value="toStringArray.exam_answers">' +
    '           </div>' +
    '          </div>',
    data: function (){
        return {
            exam_answers: [],
        }

    },
    mounted: function(){
        let toArrayString = string => {
            return string.split(':');
        };

        const app = this;
        //Параметр id передаётся от родителя, в section
        if(this.id){
            axios.post('/admin/exam_answer/'+this.id)
                .then(function (resp) {
                    if(resp.data.exam_answers)
                        app.exam_answers = toArrayString(resp.data.exam_answers);
                    else
                        app.exam_answers = [...Array(12).keys()].map(function (item) {return 'answer_' + (item + 1)});
                }).catch(function (resp) {
                swal('Заполните ваши данные!');
            })
        }else{
            app.exam_answers = [...Array(12).keys()]
                .map(function (item) {return 'answer_' + (item + 1)});//Преобразуем массива в вид "answer_1"
        }
    },
    methods: {
    },
    computed: {
        toStringArray: function () {
            return {
                exam_answers: this.exam_answers.join(':'),
            };
        }
    }
}));