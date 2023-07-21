require('./bootstrap');
import Vue from 'vue'

Vue.component('vue-questions-create-component', require('./vue-components/questions/create.vue').default);
Vue.component('vue-questions-edit-component', require('./vue-components/questions/edit.vue').default);
Vue.component('vue-group-questions-create-component', require('./vue-components/group-questions/create.vue').default);
Vue.component('vue-questions-group-create-component', require('./vue-components/questions-group/create.vue').default);

const app = new Vue({
    el: '#app',
});