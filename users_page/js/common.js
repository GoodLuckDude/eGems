(function () {

  function showUser(user) {
    if ( !typeof user === 'object') {
      throw new Error('Incorrect type of user')
    }

    let $layout = {};

    if (user.race === 'dwarf') {
      $layout = $('#dwarf-layout').clone();
      if (user.master == true) $('<i>', {'class': 'fa fa-wrench', 'title': "Этот гном является мастером"}).appendTo($layout.find('.master'));

    } else {
      $layout = $('#elf-layout').clone();
      $layout.find('.favorites').text(user.favorites.join(', ') || '-');
    }

    //Копируем готовый макет со страницы и заполняем его
    $layout.attr('id', user.id);
    if (user.status == 'deleted') {
      $layout.find('.name').addClass('deleted');
      $layout.find('.delete').toggle();
    }
    $layout.find('.name').attr('href', '/profile/profile.php?id='+user.id);
    for (field in user) {
      if(field == 'name' || field == 'gems_count') {
        $layout.find('.'+field).text(user[field] || '-');
      }
    }

    $('.user.'+user.race).first().before($layout);
    return;
  }; 


  function deleteUser(userId) {
    let data = {'userId': userId};
    $.ajax({
      type: 'POST',
      url: '../modules/delete_user.php',
      data: data,
      dataType: "JSON",
      success: (response) => {
        if (response.code === 'success') {
          $('#'+userId).find('.delete').toggle();
          $('#'+userId).find('.name').addClass('deleted');
        } else if (response.code === 'error'){
          // listError();
          alert('asd');
        }
      },
    });
  };

  function toggleConfirmation($confirmation) {
    $confirmation.toggle();
  }

  function showUsers(users) {
    if (users.length == 0) {
      return false;
    } else {

      $.each(users, (key, user) => {
        showUser(user);
      });

      $('.delete').on('click', (e) => {
        $('.confirmation').hide();
        let el = e.target;
        toggleConfirmation($(el).siblings('.confirmation'));
      });

      $('.yes').on('click', (e) => {
        let el = e.target;
        let userId = $(el).parents('.user').attr("id");
        deleteUser(userId);
        toggleConfirmation($(el).parent('.confirmation'));
      });

      $('.no').on('click', (e) => {
        let el = e.target;
        toggleConfirmation($(el).parent('.confirmation'));
      })
    }
  };

  function makeLists() {
    let filters = $('#filters').serialize();
    $.ajax({
      type: 'GET',
      url: './php/users_lists_contructor.php',
      data: filters,
      dataType: "JSON",
      success: (response) => {
        if (response.code === 'success') {
          showUsers(response.users);
        } else {
          // listError();
          alert('asd');
        }

      },
      error:  function(xhr, str){
        //alert('Возникла ошибка: ' + xhr.responseCode);
      }
    });
  };


  function refreshLists() {
    $('.user:not(#dwarf-layout, #elf-layout), .neutral-msg').remove();
    makeLists();
  };

  $(document).ready(() => {
    makeLists();
  });

  $('#filters').find('.input').keyup(function (e) {
    if( e.keyCode == 16 || e.keyCode == 18 || e.keyCode == 17 ) return true; // не искать если shift, ctr, alt
    refreshLists();
    });

  $('#filters').find('.checkbox').on('input', () => {
    refreshLists();
  });

  $('#add-user').on('click', (e) => {
    $('#create-user-form').stop().slideToggle();
  });

  $(document).delegate("#create-user-form","submit",function(){
    return false;
  });

  $('#create-user-submit').on('click', (e) => {
    let valid = true;
    $('#create-user-form').find('.input').each((ind, element) => {
      if (element.value == 0) valid = false;
    });
    if ($('#race-dwarf').prop('checked') == $('#race-elf').prop('checked')) valid = false;
    if (valid == false) return;
    $('#create-user-form').stop().slideToggle();
    $data = $('#create-user-form').serialize();
    $.ajax({
      type: 'POST',
      url: '../authorization/authorization.php',
      data: $data,
      dataType: "JSON",
      success: (response) => {
        if (response.code === 'success') {
          $('#create-user-submit').find('input').val("");
          $('#create-user-msg').text(response.msg);
          refreshLists();
        } else {
          // listError();
          alert('asd');
        }

      },
      error:  function(xhr, str){
        alert('Возникла ошибка: ' + xhr.responseCode);
      }
    });
  });

  $(document).click(function(event) {
    if ( $(event.target).closest(".confirmation, .delete").length ) return;
    $(".confirmation").hide();
    event.stopPropagation();
  });

})();