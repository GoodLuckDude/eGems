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

  $(document).ready(() => {
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
  });

  $('#submit').on('click', () => {
    let gemsTypes = $('#gems-types').serialize();
    $('.new-name').val("");
    $.ajax({
      type: 'POST',
      url: '../modules/change_gems_types.php',
      data: gemsTypes,
      dataType: "JSON",
      success: (msg) => {
        $('change-msg').text(msg);
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
    $confirmation.toggle();
  }


})();