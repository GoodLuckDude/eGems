(function () {

  function showType(typeData) {
    if ( !typeof typeData === 'object' ) {
      throw new Error('Incorrect data to show type of gem');
    }
    //Копируем готовый макет с страницы и заполняем его
    let $type = $('#gem-type-layout').clone().attr('id', typeData['id']);
    $type.find('.amount').attr({
      "name": typeData['id'],
      "id": typeData['type']}
    );
    $type.find('.type').text(typeData['type']).attr("for", typeData['type']);

    $('#submit').before($type);
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
    }

  };

  $(document).ready(() => {
    $.ajax({
      type: 'GET',
      url: '../modules/get_gems_types.php',
      dataType: "JSON",
      success: (types) => {
        showTypes(types);
        $('.amount').focusout((e) => {
          let el = e.target;
          if (el.value < 0) el.value = 0;
        })
      },
      error:  function(xhr, str){
        alert('Возникла ошибка: ' + xhr.responseCode);
      }
    });
  });

  $('#submit').on('click', () => {
    extractedGems = $('#extracted-gems').serialize();
    $('.amount').val("");
    $.ajax({
      type: 'POST',
      url: './php/add_gems.php',
      data: extractedGems,
      dataType: "JSON",
      success: (msg) => {
        $('.msg').text(msg);
      },
      error:  function(xhr, str){
        alert('Возникла ошибка: ' + xhr.responseCode);
      }
    });
  });


})();