$(document).ready(function () {
    'use strict';
    $('.testselect1').SumoSelect();
    $('.testselect2').SumoSelect();
    $('.optgroup_test').SumoSelect();
    $('.search_test').SumoSelect({
        search: true,
        searchText: 'Enter here.'
    });
    $('.select1').SumoSelect({okCancelInMulti: true, selectAll: true});
    $('.select2').SumoSelect({selectAll: true});
});