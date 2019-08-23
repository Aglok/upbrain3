const dataUserStore = {
    getData(url ='/home_users', callback){
        axios.post(url).then((response) => {
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