import AppForm from '../app-components/Form/AppForm';

Vue.component('post-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                title:  '' ,
                description:  '' ,
                
                categories: '',

              //  title:  this.getLocalizedFormDefaults(),
              //  perex:  this.getLocalizedFormDefaults()
                
            },
            mediaCollections: ['post_image']
        }
    }

});