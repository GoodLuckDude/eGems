(function () {

  function showGem(gemData) {
    if ( !typeof gemData === 'object' ) {
      throw new Error('Gem to show incorrect')
    }
    
    let $gem = $('#gem-layout').clone().attr('id', gemData['id']);
    for (field in gemData) {
      if(field != 'id') {
        $gem.find('.'+field).text(gemData[field] || '-');
      }
    }
    $('.gem').first().before($gem);
    return;
  };

  function deleteGem(gemId) {
    let data = {'gemId': gemId};
    $.ajax({
      type: 'GET',
      url: './php/delete_gem.php',
      data: data,
      dataType: "JSON",
      success: (msg) => {
        $('#'+gemId).slideToggle();
      },
    });
  };

  function toggleConfirmation($confirmation) {
    $confirmation.toggle();
  }

  function showGems(gems) {
    if (gems.length == 0) {
      $msg = $('<div>', {
        "class": "row msg neutral-msg",
        text: 'Упс! Ничего не найдено.'
        }
      );
      $('#gem-layout').after($msg);
    } else {
      $.each(gems, (key, gem) => {
        showGem(gem);
      });

      $('.delete').on('click', (e) => {
        $('.confirmation').hide();
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

  $(document).click(function(event) {
    if ( $(event.target).closest(".confirmation, .delete").length ) return;
    $(".confirmation").hide();
    event.stopPropagation();
  });






  //Попытка сделать запрос через ajax с изменением url
  // function setLocation(urlParams){
  //   try {
  //     let url = "http://localhost:3000/all_gems/all_gems.php?"+urlParams;
  //     history.pushState(null, null, url);
  //     return;
  //   } catch(e) {
  //     location.hash = '#' + url;
  //   }

  // }

  // function getUrlParams(){
  //   let urlParams = "";
  //   if (window.location.href.indexOf('?') != -1) {
  //     urlParams = window.location.href.slice(window.location.href.indexOf('?'));
  //   }
  //   return urlParams;
  // };





  // function showGemsList(){
  //   urlParams = getUrlParams();
  //   $.getJSON('./php/gems_list_contructor.php' + urlParams, (gems) => {
  //     $.each(gems, (key, gem) => {
  //       showGem(gem);
  //     })
  //   })
  //   return;
  // }

  // $(document).ready(showGemsList());

})();