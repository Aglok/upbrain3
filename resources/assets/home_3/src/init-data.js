
const dataUserStore = {
    //Принимает 3 параметра url, функцию замыкания, параметр в виде строки json
    getData(url ='/profile', callback, json){
        axios.post(url, json).then((response) => {
            callback(response);//Функция замыкания чтобы сохранить переменную запроса response, иначе undefined
        }).catch(function (error) {
            console.log(error);
            //swal(error.message);
        });
    },
    sumBalls(array){
        return array.reduce((a, b) => {return parseInt(a) + parseInt(b);}, 0);
    },

    getTestBalls(primary){
        let arrayTableTranslation = {1:5,2:9,3:14,4:18,5:23,6:27,7:33,8:39,9:45,10:50,11:56,12:62,13:68,14:70,15:72,16:74,17:76,18:78,19:80,20:82,21:84,22:86,23:88,24:90,25:92,26:94,27:96,28:98,29:99,30:100,31:100,32:100};
        return arrayTableTranslation[primary];
    },
    sumArrayObj(arrayObjs ,prop){
        return Object.keys(arrayObjs).reduce(function(previous, key){return previous + arrayObjs[key][prop]}, 0);//Считаем общую сумму массива объектов
    },
    unique(arr) {
        var obj = {};

        for (var i = 0; i < arr.length; i++) {
            var str = arr[i];
            obj[str] = true; // запомнить строку в виде свойства объекта
        }

        return Object.keys(obj); // или собрать ключи перебором для IE8-
    },
    generateTabList(obj){
        //Динамически генерируется list для subject.tabs предметов
        let list = {};
        for (let i=0; i < Object.keys(obj).length; i++){
            list[i] = false;
        }
        return list;
    },
    dataSetSubjects: {
        math: {
            name: 'Математика',
            color: 'red',
            sum_exp: {
                value: 0,
                show: false,
                text: 'Весь накопленный опыт по математике',
                icon_class: 'icon-experience'
            },
            sum_gold:{
                value: 0,
                show: false,
                text: 'Все накопленные монеты по математике',
                icon_class: 'icon-gold'
            },
            sum_tasks: {
                value: 0,
                show: false,
                text: 'Суммарное количество выполненных задач по математике',
                icon_class: 'icon-tasks'
            },
            crystal_red:{
                value: 0,
                show: false,
                text: 'Красные кристаллы даются за специальные математические задачи',
                icon_class: 'icon-crystal-red'
            },
            A:{
                value: {},
                show: false,
                text: 'Задачи самого высокого уровня сложности. Уровень: A',
                icon_class: 'icon-grade-a'
            },
            B:{
                value: {},
                show: false,
                text: 'Задачи высокого уровня сложности. Уровень: B',
                icon_class: 'icon-grade-b'
            },
            C:{
                value: {},
                show: false,
                text: 'Задачи самого среднего уровня сложности. Уровень: C',
                icon_class: 'icon-grade-c'
            },
            D:{
                value: {},
                show: false,
                text: 'Задачи самого легоко уровня сложности. Уровень: D',
                icon_class: 'icon-grade-d'
            },
        },
        physics: {
            name: 'Физика',
            color: 'blue',
            sum_exp: {
                value: 0,
                show: false,
                text: 'Весь накопленный опыт по физике',
                icon_class: 'icon-experience'
            },
            sum_gold:{
                value: 0,
                show: false,
                text: 'Все накопленные монеты по физике',
                icon_class: 'icon-gold'
            },
            sum_tasks: {
                value: 0,
                show: false,
                text: 'Суммарное количество выполненных задач по физике',
                icon_class: 'icon-tasks'
            },
            crystal_blue:{
                value: 0,
                show: false,
                text: 'Красные кристаллы даются за специальные физические задачи',
                icon_class: 'icon-crystal-blue'
            },
            A:{
                value: {},
                show: false,
                text: 'Задачи самого высокого уровня сложности. Уровень: A',
                icon_class: 'icon-grade-a'
            },
            B:{
                value: {},
                show: false,
                text: 'Задачи высокого уровня сложности. Уровень: B',
                icon_class: 'icon-grade-b'
            },
            C:{
                value: {},
                show: false,
                text: 'Задачи самого среднего уровня сложности. Уровень: C',
                icon_class: 'icon-grade-c'
            },
            D:{
                value: {},
                show: false,
                text: 'Задачи самого легоко уровня сложности. Уровень: D',
                icon_class: 'icon-grade-d'
            },
        },
        informatics: {name: 'Информатика', color: 'green'},
        general:{
            sum_exp: {
                value: 0,
                show: false,
                text: 'Весь накопленный опыт за все предметы',
                icon_class: 'icon-experience'
            },
            sum_gold: {
                value: 0,
                show: false,
                text: 'Все накопленные монеты за все предметы',
                icon_class: 'icon-gold'
            },
            sum_tasks: {
                value: 0,
                show: false,
                text: 'Суммарное количество выполненных задач за все предметы',
                icon_class: 'icon-tasks'
            },
            crystal_red: {
                value: 0,
                show: false,
                text: 'Красные кристаллы даются за специальные математические задачи',
                icon_class: 'icon-crystal-red'
            },
            crystal_blue: {
                value: 0,
                show: false,
                text: 'Синие кристаллы даются за специальные физические задачи',
                icon_class: 'icon-crystal-blue'
            },
            crystal_green: {
                value: 0,
                show: false,
                text: 'Зелёные кристаллы даются за специальные задачи по информатике',
                icon_class: 'icon-crystal-green'
            },
            average_percent_complete: {
                value: 0,
                show: false,
                text: 'Средний процент выполнения задач, как рейтинг самодостаточного навыка',
                icon_class: 'icon-percent-complete'
            }
        }
    }
};
const initDataUser = {

    install (Vue) {
        Vue.mixin({
            data () {
                return {
                    dataUser: dataUserStore
                }
            },
        });

        Object.defineProperty(Vue.prototype, '$dataUser', {
            get () {
                return this.$root.dataUser;
            }
        });
    }
};

export default initDataUser