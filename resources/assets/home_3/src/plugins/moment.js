import Vue from 'vue'
import moment from 'moment';

require('moment/locale/ru');
Vue.prototype.moment = function (...args) {
    return moment(...args);
};