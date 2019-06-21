(function () {
  function showMessage($el, message, msgClass) {
    $el.after("<div class='"+msgClass+"'>"+ message +'</div>');
    return;
  }

  let assignment;

  $('.button').on('click', function(e) {
    $('.msg').remove();
  })

  $('#assign').on('click', function(e) {
    $.ajax({
      url: "./distributor.php",
      dataType: "json",
      success: function(assign) {
        if('error' in assign) {
          showMessage($('#assign').parent(), assign['error'], 'msg err-msg col');
          return;
        }
        for (let elfId in assign) {
          assign[elfId].forEach((gemId) => {
            $('#'+gemId).children('.email').val(elfId);
          });
        };
        showMessage($('#assign').parent(), 'Готово!', 'msg col');
        assignment = assign;
      },
      error: function(xhr, textStatus, errThrow) {
      }
    })
  })

  $("#submit").on('click', function(e) {
    //Проверка на правильность заполнения данных.
    let assign = {};
    if (typeof assignment === 'object' && Object.keys(assignment).length != 0) {
      for (let elfId in assignment) {
        assignment[elfId].forEach((gemId) => {
          let $el = $('#'+gemId);
  
          if($el.children('.email').val().length) {
            assign[gemId] = { 'elfId': $el.children('.email').val() };
            if ($el.children('.email').val() == elfId) {
              assign[gemId]['by_hand'] = false;
            } else {
              assign[gemId]['by_hand'] = true;
            }
          }        
        })
      }
    } else {
      $(".input.email").each(function(indx) {
        if ( $(this).val() ) {
          assign[$(this).parent().attr('id')] = {"elfId": $(this).val(), "by_hand": true};
        }
      })
    }

    $.ajax({
      type: "POST",
      url: "./confirm.php",
      data: "assign=" + JSON.stringify(assign),
      dataType: "JSON",
      success: (data) => {
        location.reload();
        return;
      },
      error: function(xhr, textStatus, errThrow) {
        showMessage($('#assign').parent(), errThrow, 'msg err-msg');
      }
    })
  })

})();
