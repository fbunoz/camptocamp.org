(function(C2C, $) {

  // area selector size
  C2C.changeSelectSize = function(id, up_down) {
    var select = $('#' + id);
    var height = select.height();

    if (up_down) {
      height += 150;
    } else {
      height = Math.max(100, height - 150);
    }

    select.height(height);
  };

  // for some search inputs like date selection, we hide some parts
  // depending on the first field value
  // e.g. only display one input for selecting summits higher than 4000m,
  // two inputs for selecting summits between 2000m and 3000m
  C2C.update_on_select_change = function(field, optionIndex) {
    var index = $('#' + field + '_sel').val();

    if (index == '0' || index === ' ' || index == '-' || index >= 4) {

      $('#' + field + '_span1').hide();
      $('#' + field + '_span2').hide();

      if (optionIndex >= 4) {
        if (index == 4) {
          $('#' + field + '_span3').show();
        } else {
          $('#' + field + '_span3').hide();
        }
      }

    } else {

      $('#' + field + '_span1').show();

      if (index == '~' || index == 3) {
        $('#' + field + '_span2').show();
      } else {
        $('#' + field + '_span2').hide();
      }

      if (optionIndex >= 4) {
        $('#' + field + '_span3').hide();
      }

    }
  };

  // hide some fields depending onf the activity selected
  function act_hide_unrelated_filter_fields() {

    var activities = [];
    $.each($("input[name='act[]']:checked"), function() {
      activities.push($(this).val());
    });

    // show/hide data-act-filter tags depending on selected activities
    $('[data-act-filter]').hide();
    $('option[data-act-filter]').prop('disabled', true);

    $('[data-act-filter="none"]').toggle(!!activities);

    if (!!activities) $.each(activities, function (i, activity) {
      $('[data-act-filter~='+ activity +']').show();
      $('option[data-act-filter]').prop('disabled', false);
    });
    
    if (activities.length() == 1) {
      $('option[data-act-filter="multi"]').prop('disabled', true).hide();
    } else {
      $('option[data-act-filter="multi"]').prop('disabled', false).show();
    }

    // some configuration should only be available if
    // activity 2 (snow, ice, mixed) is selected
    // not that not all browser allow to hide option tags, so we also
    // disable them
    var select = $('#conf'), select_size;
    var options = select.find('option:eq(4), option:eq(5)');
    if (activities && $.inArray("2", activities) !== -1) {
      select_size = 6;
      options.prop('disabled', false).show();
    } else {
      select_size = 4;
      options.prop('disabled', true).hide();
    }
    select.attr('size', select_size);

  }

  $('#actform').on('click', "input[name='act[]']", function() {
    act_hide_unrelated_filter_fields();
  });
  
  
  // hide some parts of the editing form depending on selected summit_type 
  function summit_type_hide_unrelated_filter_fields() {

    var summit_types = $('#summit_type').val();

    // show/hide data-summit_type-filter tags depending on selected summit_type
    $('[data-summit_type-filter]').hide();
    $('option[data-summit_type-filter]').prop('disabled', true);
    
    if (!!summit_types) $.each(summit_types, function (i, summit_type) {
      if (summit_types.length() == 1)
      {
        $('[data-summit_type-filter~='+ summit_type +']').show();
        $('option[data-summit_type-filter]').prop('disabled', false);
    });
    
    if (summit_types.length() == 1) {
      $('option[data-summit_type-filter="multi"]').prop('disabled', true).hide();
    } else {
      $('option[data-summit_type-filter="multi"]').prop('disabled', false).show();
    }

  }

  // check fields state every time the summit_type selection changes
  $('#summit_type').on('change', summit_type_hide_unrelated_filter_fields);

})(window.C2C = window.C2C || {}, jQuery);
