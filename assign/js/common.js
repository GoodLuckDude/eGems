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
    $('.err-msg').text('');
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
            let name;
            for (var key in usersNames) {
              if (usersNames[key] == elfId) {
                name = key;
              }
            }
            $('#'+gemId).children('.name').val(name);
            $('#'+gemId).children('.elfId').val(elfId);
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
    $('.err-msg').text('');
    let assign = {};
    if (typeof assignment === 'object' && Object.keys(assignment).length != 0) {
      for (let elfId in assignment) {
        assignment[elfId].forEach((gemId) => {
          let $el = $('#'+gemId);
  
          if($el.children('.name').val().length) {
            assign[gemId] = { 'elfId': $el.children('.elfId').val() };
            if ($el.children('.elfId').val() == elfId) {
              assign[gemId]['by_hand'] = false;
            } else {
              assign[gemId]['by_hand'] = true;
            }
          }        
        })
      }
    } else {
      $(".input.elfId").each(function(indx) {
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

  let usersNames = {};

  $.ajax({
    type: "GET",
    url: "./getUsers.php",
    dataType: "JSON",
    success: (responce) => {
      if (responce.code === 'success') {
        usersNames = responce.users
      }
    },
    error: function(xhr, textStatus, errThrow) {
      console.log($('#assign').parent(), errThrow, 'msg err-msg');
    }
  })

  $('.input.name').focusout((e) => {
    let el = e.target;
    $(el).siblings('.err-msg').text('');
    let name = $(el).val();
    if ( name in usersNames) {
      $(el).siblings('.input.elfId').val(usersNames[name]);
    } else if (name == "") {
      $(el).siblings('.input.elfId').val("");
    } else {
      $(el).siblings('.input.elfId').val("");
      $(el).siblings('.err-msg').text('Не существует');
    }
  })

})();
