(function () {

  function showType(typeData) {
    if ( !typeof typeData === 'object' ) {
      throw new Error('Incorrect data to show type of gem');
    }
    //Копируем готовый макет с страницы и заполняем его
    let $type = $('#gem-type-layout').clone().attr('id', typeData['id']);
    $type.find('.new-name').attr({
      "name": typeData['id'],
      "id": typeData['type']}
    );
    $type.find('.type').text(typeData['type']).attr("for", typeData['type']);

    $('#gem-type-layout').before($type);
    return;
  }; 

  function showTypes(types) {
    if (Object.keys(types).length == 0) {
      $('.msg').text('Упс! Типы драгоценностей не найдены.');
      $('#gem-type-layout').after($msg);
    } else {
      $.each(types, (key, type) => {
        showType(type);
      });

      $('.delete').on('click', (e) => {
        let el = e.target;
        toggleConfirmation($(el).siblings('.confirmation'));
      });
    
      $('.yes').on('click', (e) => {
        let el = e.target;
        let typeId = $(el).parents('.gem-type').attr("id");
        deleteType(typeId);
        toggleConfirmation($(el).parent('.confirmation'));
      });
    
      $('.no').on('click', (e) => {
        let el = e.target;
        toggleConfirmation($(el).parent('.confirmation'));
      })
    }

  };

  function makeList() {
    $.ajax({
      type: 'GET',
      url: '../modules/get_gems_types.php',
      dataType: "JSON",
      success: (types) => {
        showTypes(types);
      },
      error:  function(xhr, str){
        alert('Возникла ошибка: ' + xhr.responseCode);
      }
    });
  }

  function refreshList() {
    $('.gem-type:not(#gem-type-layout)').remove();
    makeList();
  }

  $(document).ready(() => {
    makeList();
  });

  $('#submit').on('click', () => {
    $('#change-msg').text('');
    let gemsTypes = $('#gems-types').serialize();
    $('.new-name').val("");
    $.ajax({
      type: 'POST',
      url: '../modules/change_gems_types.php',
      data: gemsTypes,
      dataType: "JSON",
      success: (msg) => {
        $('#change-msg').text(msg);
        $('.new-name, .conf').toggle();
        $('#change-type').text("Изменить");
        refreshList();
      },
      error:  function(xhr, str){
        alert('Возникла ошибка: ' + xhr.responseCode);
      }
    });
  });

  function deleteType(typeId) {
    let data = {'typeId': typeId};
    $.ajax({
      type: 'POST',
      url: '../../modules/delete_type.php',
      data: data,
      dataType: "JSON",
      success: (msg) => {
        let $msg = $('<div>', {
          "class": "msg col-12 gem-type text-left",
          text: msg
        });
        $('#'+typeId).toggle();
        $('#'+typeId).before($msg);
      },
    });
  };

  function toggleConfirmation($confirmation) {
    $(".confirmation").not($confirmation).hide();
    $confirmation.toggle();
  }

$('#change-type').on('click', (e) => {
  $('#change-msg').text("");
  let text = $(e.target).text() == 'Изменить' ? 'Отменить' : 'Изменить';
  $(e.target).text(text);
  $('.new-name, .conf').toggle();
  $('.gem-type:not(#gem-type-layout)').find('i').toggle();
  
});

let values = [];

$(document).ready(() => {
  $.ajax({
    type: 'GET',
    url: '../modules/get_coeff.php',
    dataType: "JSON",
    success: (coeffs) => {
      values[0] = Math.round(coeffs['equally'] * 100) ;
      values[1] = Math.round((1 - coeffs['preferred']) * 100);
      $(".range").slider( "values", values );
      $("#equally").val(values[0]);
      $('#wishes').val(100 - values[1]);
      $("#least-one").val( 100 - values[0] - (100 - values[1]) );
    },
    error:  function(xhr, str){
      alert('Возникла ошибка: ' + xhr.responseCode);
    }
  });
});

$(".range").slider({
  min: 0,
  max: 100,
  values: [33, 66],
  range: true,
  animate: "fast",
  disabled: true,
  slide : function(event, ui) {
    let max = $(".range").slider("option", "max");
    $("#equally").val(ui.values[ 0 ]);
    $("#wishes").val(max - ui.values[ 1 ]);
    $("#least-one").val(max - $("#wishes").val() - ui.values[ 0 ]);
  }
});

$('.range-input').focusout(function() {
  let max = $(".range").slider("option", "max");
  var input_left = $("#equally").val().replace(/[^0-9]/g, ''),
  opt_left = $(".range").slider("option", "min"),
  where_right = $(".range").slider("values", 1),
  input_right = $("#wishes").val().replace(/[^0-9]/g, ''),
  opt_right = $(".range").slider("option", "max"),
  where_left = $(".range").slider("values", 0),
  input_middle = $("#least-one").val().replace(/[^0-9]/g, '');    //Spaghetti Code
  if (input_left > where_right) {
    input_left = where_right;
  }
  if (input_left < opt_left) {
    input_left = opt_left;
  }
  if (input_left == "") {
    input_left = 0;
  }
  if (input_right < 0) {
    input_right = 0;
  }
  if (input_right > opt_right - input_left) {
    input_right = opt_right - input_left;
  }
  if (input_right == "") {
    input_right = 0;
  }

  if (input_middle > opt_right) {
    input_middle = opt_right;
  }

  if (input_middle < opt_left) {
    input_middle = opt_left;
  }

  if (input_middle == "") {
    input_middle = opt_left;
  }

  if (input_left == where_left && input_right == max - where_right) {
    if ( (max - input_middle) % 2 == 1 ) {
      input_left = (max - input_middle - 1) / 2;
      input_right = input_left + 1;
    } else {
      input_left = input_right = (max - input_middle) / 2;
    }
  }

  $("#equally").val(input_left); 
  $("#wishes").val(input_right);
  $('#least-one').val(max - input_left - input_right);
  $(".range").slider( "values", [ input_left, max - input_right] );
});

function toggleChangeCoeff() {
  let text = $('#change-coeff').text() == 'Изменить' ? 'Отменить' : 'Изменить';
  let dis = $(".range").slider("option", "disabled");
  $('#change-coeff').text(text);

  if (dis == true) {
    $(".range").slider("option", "disabled", false);
  } else {
    $(".range").slider("option", "disabled", true);
  }

  if ($('.range-input').attr('disabled')) {
    $('.range-input').removeAttr('disabled');
  } else {
    $('.range-input').attr('disabled', true)
  };

  $('#send-coeff').toggle();
}

$('#change-coeff').on('click', (e) => {
  toggleChangeCoeff();
  $('#coeffs-msg').text("");
});

$('#send-coeff').on('click', (e) => {
  let coeff = $('#coeff-form').serialize();
  $.ajax({
    type: 'POST',
    url: '../modules/change_coeffs.php',
    data: coeff,
    dataType: "JSON",
    success: (response) => {
      $('#coeffs-msg').text("");
      toggleChangeCoeff();
      if (response.code == 'success') {
        $('#coeffs-msg').text(response.msg);
      } else {
        $('#coeffs-msg').text('Ошибка. Попробуйте позже!');
      }
    },
    error:  function(xhr, str){
      alert('Возникла ошибка: ' + xhr.responseCode);
    }
  });
})

$('#add-type-button').on('click', () => {
  $('#add-type-msg').text('');
  $('#add-type').slideToggle();
});

$('#create-type-submit').on('click', () => {
  let data = $('#add-type').serialize();
  $.ajax({
    type: 'POST',
    url: '../modules/create_type.php',
    data: data,
    dataType: "JSON",
    success: (response) => {
      if (response.code === 'success') {
        $('#add-type').toggle();
        $('#add-type-msg').text('Успешно!');
        $('#type').val('');
        refreshList();
      }
    },
    error:  function(xhr, str){
      alert('Возникла ошибка: ' + xhr.responseCode);
    }
  });
})

})();