Vue.component('example', Vue.extend({
    template: '<div>Корзина задач</div>',
    props: {},
    data () {
        return {
            num: [1,2,3]
        }
    },
    mounted (){
        console.log('Запуск');
    },
    methods: {
        //....
    },
    computed: {
        //....
    }
}));