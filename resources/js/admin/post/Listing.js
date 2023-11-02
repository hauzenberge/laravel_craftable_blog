import AppListing from '../app-components/Listing/AppListing';

Vue.component('post-listing', {
    mixins: [AppListing],

    data() {
        return {
            categoriesFilter: true,
            categoriesMultiselect: '',
    
            filters: {
                categories: '',
            },
        }
    },
    
    watch: {
        categoriesFilter: function (newVal, oldVal) {
            this.categoriesMultiselect = [];
        },
        categoriesMultiselect: function(newVal, oldVal) {
            this.filters.categories = newVal.map(function(object) { return object['id']; });
            this.filter('categories', this.filters.categories);
        }
    }
});