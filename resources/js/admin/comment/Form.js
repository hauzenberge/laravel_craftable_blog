import AppForm from '../app-components/Form/AppForm';

Vue.component('comment-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                post_id:  '' ,
                comment:  '' ,
                
            }
        }
    }

});