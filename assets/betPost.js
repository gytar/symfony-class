import Vue from 'vue';
import BetPostForm from './Components/BetPostForm.vue'

new Vue({
    template: '<BetPostForm />',
    components: { BetPostForm }
}).$mount('#betPostForm');

console.log('====================================');
console.log(BetPostForm);
console.log('====================================');