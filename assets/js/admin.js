jQuery(function($) {
  $(document).ready(function() {

    /* Select 2 */
    $('.mementor-wrapper select').select2({
      minimumResultsForSearch: -1,
      dropdownCssClass: 'mementor-select'
    });

  });
});
