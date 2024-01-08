Admin.Events.on('datatables::draw', function() {
    components.tasksItemToCart();
});

TasksButton = Vue.extend({
    template: '',
    computed:
        mapGetters({
            classButton: 'addClassToButton'
        }),
    methods: mapActions([
        'addToCart',
        'getTasksFromCookies'
    ]),
    name: 'tasks-cart',
    store,
});

//Монтировка vue компонетов по отрабоки Vue
window.components = {
    tasksItemToCart: () => {
        //Перебираем все строки в таблице для подсчёта индекса в таблице
        //Событие вызывается каждый раз после прорисовки таблицы
        let table_tasks = $('#table-tasks');

        if(table_tasks.length){
            const rows = table_tasks[0].tBodies[0].rows;
            for (let key in rows){
                if(rows.hasOwnProperty(key)){

                    let task_id = rows[key].cells[1].children[0].innerText.trim();
                    let task = rows[key].cells[2].children[0].innerText;

                    // if(rows[key].cells[3].children[0]){
                    //
                    //     let image = rows[key].cells[3].children[0].innerText;
                    // }

                    let experience = rows[key].cells[3].children[0].innerText;
                    let gold = rows[key].cells[4].children[0].innerText;
                    let grade = rows[key].cells[5].children[0].innerText;

                    new TasksButton({
                        template: '<div class="col-md-12"><a href="#" v-on:click.self.prevent=addToCart(task) :class="classButton(task)" class="fa fa-plus"></a></div>',
                        data: function (){
                            return {
                                task: {
                                    id:task_id,
                                    task: task,
                                    gold: gold,
                                    experience: experience,
                                    grade: grade,
                                }
                            }
                        },
                        mounted(){
                            this.getTasksFromCookies();
                        },
                    }).$mount('#tasks_button_' + task_id);
                }
            }
        }
    }
};