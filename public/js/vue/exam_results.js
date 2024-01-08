Vue.component('short-answers', Vue.extend({
    props: ['id'],
    template: '<div class="col-md-12">' +
    '          <div class="col-md-6">'+
    '          <label for="result_short_answers" class="control-label">Баллы за задачи 1-12</label>    ' +
    '               <table class="table-primary table table-striped">'+
    '               <thead>' +
    '                   <tr>' +
    '                       <th>№ задачи</th>' +
    '                       <th>Ответы ученика</th>' +
    '                       <th>Правильные ответы</th>' +
    '                       <th>Баллы</th>' +
    '                       <th>Масимальный балл</th>' +
    '                   </tr>' +
    '               </thead>'+
    '               <tbody>'+
    '                   <tr v-for="input, index in result_short_answers">' +
    '                       <td>{{index+1}}</td>' +
    '                       <td><input class="form-control" :id="\'short_answers_\'+index" v-model=short_answers[index] type=text></td>' +
    '                       <td>{{exam_answers[index]}}</td>' +
    '                       <td v-bind:class="[!!compare.result_short_answers[index] ? correct : wrong]">' +
    '                           <input class="form-control" :id="\'result_short_answers_\'+index" v-model=compare.result_short_answers[index] type=text disabled>' +
    '                       </td>' +
    '                       <td>1</td>' +
    '                   </tr>' +
    '                    <tr>' +
    '                       <td colspan="3">Общая сумма</td>' +
    '                       <td><b>{{compare.sumBalls}}</b</td>' +
    '                       <td>12</td>' +
    '                   </tr>    ' +
    '           </tbody>'+
    '           </table>' +
    '           </div>' +
    '          <div class="col-md-6">'+
    '          <label for="result_expanded_answers" class="control-label">Баллы за задачи 13-19</label>' +
    '               <table class="table-primary table table-striped">'+
    '               <thead>' +
    '                   <tr>' +
    '                       <th>№ задачи</th>' +
    '                       <th>Баллы</th>               ' +
    '                       <th>Масимальный балл</th>' +
    '                   </tr>' +
    '               </thead>'+
    '               <tbody>'+
    '                   <tr v-for="input, index in result_expanded_answers">' +
    '                       <td>{{index+13}}</td>' +
    '                       <td><input class="form-control" :id="\'answer_\'+index" v-model=result_expanded_answers[index] type=text></td>' +
    '                       <td>{{balls_expanded[index]}}</td>' +
    '                   </tr>' +
    '                    <tr>' +
    '                       <td>Общая сумма</td>' +
    '                       <td>{{total.result_expanded_answers}}</td>' +
    '                       <td>20</td>' +
    '                   </tr>    ' +
    '               </tbody>'+
    '           </table>' +
    '           </div>' +
    '           <div class="form-group form-element-text col-md-6">' +
    '               <input type="hidden" class="form-control" name="result_short_answers" :value="toStringArray.result_short_answers">' +
    '               <input type="hidden" class="form-control" name="result_expanded_answers" :value="toStringArray.result_expanded_answers">' +
    '               <input type="hidden" class="form-control" name="short_answers" :value="toStringArray.short_answers">' +
    '           </div>' +
    '          </div>',
    data: function (){
            return {
                correct: 'text-success text-bold',
                wrong: 'text-warning text-bold',
                result_short_answers: [],
                result_expanded_answers: [],
                short_answers: [],
                exam_answers: [],
                balls_expanded : [2,2,2,3,3,4,4]
            }

    },
    mounted: function(){
        let toArrayString = string => {
            return string.split(':');
        };

        const app = this;
        //Параметр id передаётся от родителя, в section
        if(this.id){
            axios.post('/admin/exam_results/'+this.id)
                .then(function (resp) {
                    console.log(resp);
                    app.result_short_answers = toArrayString(resp.data.result_short_answers);
                    app.result_expanded_answers = toArrayString(resp.data.result_expanded_answers);
                    app.short_answers = toArrayString(resp.data.short_answers);
                    app.exam_answers = toArrayString(resp.data.exam_answers.exam_answers);
                }).catch(function (resp) {
                console.log(resp);
                    swal('Заполние ваши данные!');
                })
        }else{
            app.result_short_answers = [...Array(12).keys()]
                .map(function (item) {return 'result_short_answers_' + (item + 1)});//Преобразуем массива в вид "short"
            app.short_answers = [...Array(12).keys()]
                .map(function (item) {return 'short_' + (item + 1)});//Преобразуем массива в вид "short"
            app.result_expanded_answers = [...Array(7).keys()]
                .map(function (item) {return 'expand_' + (item + 6)});
        }
    },
    methods: {
    },
    computed: {
        toStringArray: function (array) {
            return {
                result_short_answers: this.result_short_answers.join(':'),
                result_expanded_answers: this.result_expanded_answers.join(':'),
                short_answers: this.short_answers.join(':'),
            };
        },
        total: function () {
            console.log(this.result_short_answers);
            return {
                result_expanded_answers: this.result_expanded_answers.reduce(function(a, b) {return parseInt(a) + parseInt(b);}, 0)
            }
        },
        compare: function(){
            let short_answers = this.short_answers;
            let result_short_answers = this.result_short_answers;

            this.exam_answers.forEach(function (item, i, arr) {
                if(item === short_answers[i])
                    result_short_answers[i] = 1;
                else result_short_answers[i] = 0;
            });

            let sumBalls = result_short_answers.reduce(function(a, b) {return parseInt(a) + parseInt(b);}, 0);
            return {
                result_short_answers: result_short_answers,
                sumBalls: sumBalls
            };
        }
    }
}));