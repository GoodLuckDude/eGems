(function () {

  function showDwarf(dwarfData) {
    if ( !typeof dwarfData === 'object' ) {
      throw new Error('Gem to show incorrect')
    }
    //Копируем готовый макет с страницы
    let $dwarf = $('#dwarf-layout').clone().attr('id', dwarfData['id']);
    if (dwarfData['status'] == 'deleted') $dwarf.find('.name').addClass('deleted');
    $dwarf.find('.name').attr('href', '/profile/profile.php?id='+dwarfData['id']);
    if (dwarfData['master'] == true) $('<i>', {class: 'fa fa-wrench'}).appendTo($dwarf.find('.master'));
    //Заполняем его
    for (field in dwarfData) {
      if(field == 'name' || field == 'gems_count') {
        $dwarf.find('.'+field).text(dwarfData[field] || '-');
      // } else if (field == 'master' && dwarfData[field] == true) {
      //   $('<i>', {class: 'fa fa-wrench'}).appendTo($dwarf.find('.master'));
      // } else if (field == 'status') {
      //   if(dwarfData['status'] == 'deleted') $dwarf.find('.name').addClass('deleted');
      }
    }
    $('.user.dwarf').first().before($dwarf);
    return;
  }; 


  function deleteUser(gemId) {
    let data = {'gemId': gemId};
    $.ajax({
      type: 'GET',
      url: './php/delete_gem.php',
      data: data,
      dataType: "JSON",
      success: (msg) => {
        $('#'+gemId).find('.msg').text(msg);
        $('#'+gemId).find('.delete').toggle();
      },
    });
  };

  function toggleConfirmation($confirmation) {
    $confirmation.toggle();
  }

  function showDwarfs(dwarfs) {
    if (dwarfs.length == 0) {
      $msg = $('<div>', {
        "class": "row msg neutral-msg",
        text: 'Упс! Никто не найден.'
        }
      );
      $('#dwarf-layout').after($msg);
    } else {
      $.each(dwarfs, (key, dwarf) => {
        showDwarf(dwarf);
      });
      $('.delete').on('click', (e) => {
        let el = e.currentTarget;
        toggleConfirmation($(el).siblings('.confirmation'));
      });

      $('.yes').on('click', (e) => {
        let el = e.currentTarget;
        let gemId = $(el).parents('.gem').attr("id");
        deleteGem(gemId);
        toggleConfirmation($(el).parent('.confirmation'));
      });

      $('.no').on('click', (e) => {
        let el = e.currentTarget;
        toggleConfirmation($(el).parent('.confirmation'));
      })
    }
  };

  $(document).ready(() => {
    let filters = $('#filters').serialize();
    $.ajax({
      type: 'GET',
      url: './php/dwarfs_list_contructor.php',
      data: filters,
      dataType: "JSON",
      success: (dwarfs) => {
        showDwarfs(dwarfs)
      },
      error:  function(xhr, str){
        //alert('Возникла ошибка: ' + xhr.responseCode);
      }
    });
  });

  $('#submit').on('click', () => {
    $('.gem:not(#gem-layout)').remove();
    $('.msg').remove();
    filters = $('#filters').serialize();
    $.ajax({
      type: 'GET',
      url: './php/gems_list_contructor.php',
      data: filters,
      dataType: "JSON",
      success: (gems) => {
        showGems(gems)
      },
      error:  function(xhr, str){
        alert('Возникла ошибка: ' + xhr.responseCode);
      }
    });
  });


})();