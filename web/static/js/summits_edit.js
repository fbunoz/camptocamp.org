(function($) {

  // hide some parts of the editing form depending on selected summit_type 
  function summit_type_hide_unrelated_edit_fields() {

    var summit_type = $('#summit_type').val();

    // show/hide data-summit_type-filter tags depending on selected summit_type
    $('[data-summit_type-filter]').hide();
    $('[data-summit_type-filter~='+ summit_type +']').show();
  
  }

  // check fields state every time the summit_type selection changes
  $('#summit_type').on('change', summit_type_hide_unrelated_edit_fields);

  // be sure to hide fields once dom loaded
  summit_type_hide_unrelated_edit_fields();

})(jQuery);
