(function() {
	//spagetti-code need to refact!!
	let elChangeEmailButton = document.getElementById("change-email-button");
  let changeEmail = document.getElementById("change-email");
  let elChangePassButton = document.getElementById("change-password-button");
	let changePassword = document.getElementById("change-password");

	function refreshAvalible() {
		let available = $('#available').val();
		$('#to-avail').text(available);
	}

	function toggleDis() {
		if ($('#checkbox').attr('disabled')) {
			$('#checkbox').attr('disabled', false)
		}	else {
			$('#checkbox').attr('disabled', true)
		}
	}

	function toggleWishes(elem) {
		$(elem).parents('.show-container').find('.to-show').slideToggle();
		$(elem).text( $(elem).text() == 'Изменить' ? 'Отменить' : 'Изменить' );
		if ($('.range-2').slider('option', 'disabled') == true) {
			$('.range-2').slider('option', 'disabled', false);
			return;
		}
		$('.range-2').slider('option', 'disabled', true);
	}

  $("#change-email-button").on('click', (e) => {
		$('#suc-email').text("");
	})


  $("#change-password-button").on('click', (e) => {
		$('#suc-passw').text("");
	});

	$('.carousel-gems').owlCarousel({
		items: 2,
		slideBy: 2,
		nav: true,
		smartSpeed: 500,
		navText: ['<i class="fa fa-caret-left"></i>', '<i class="fa fa-caret-right"></i>']
	});

	$('.show').on('click', (e) => {
		elem = e.currentTarget;
		if ($(elem).attr('id') == "gems-count") {
			$(elem).parents('.show-container').find('.to-show').slideToggle();
			$(elem).find('i').toggleClass('fa-angle-down');
			$(elem).find('i').toggleClass('fa-angle-up');
			return;
		}	else if ($(elem).attr('id') == "change-wishes") {
			$('#success-wishes').text("");
			toggleWishes(elem);
		} else {
			$(elem).parents('.show-container').find('.to-show').toggle();
			$('#new-name-err').text("");
		}
	})

	function toggleType(el) {
		$(el).toggle();
	};

	$('.confirm').on('click', (e) => {
		let type = e.target;
		let typeId = $(type).parent().attr('id');

		$.ajax({
			type: "POST",
			url: "../../modules/gain_confirmation.php",
			data: "typeId=" + typeId,
			dataType: "JSON",
			success: (response) => {
				if (response.code == 'success') {
					let $par = $(type).parent();
					$par.html('<span class="msg">Подтверждено!</span>');
				}
				if (response.code == 'error') {
					alert(response.msg);
				}
				return;
			},
			error: function(xhr, textStatus, errThrow) {
				console.log(textStatus, errThrow);
			}
		})
	});

	$(".range-2").each((indx, elem) => {
		let wish = $(elem).parents('.gem-wishes').find('.gem-wish').val();
		wish = Math.round(wish*100);
		$(elem).parents('.gem-wishes').find('.previous-value').val(wish);
		$(elem).slider({
			disabled: true,
			min: 0,
			max: 100,
			value: wish,
			range: "min",
			animate: "fast",
			slide : function(event, ui) {
				let prevVal = $(event.target).parents('.gem-wishes').find(".previous-value");
				let difference = ui.value - prevVal.val();
				if ( difference > $('#available').val()) return false;
				$('#available').val( $('#available').val() - difference );
				refreshAvalible();
				$(prevVal).val( ui.value );

			$(event.target).parents('.gem-wishes').find(".val").text(ui.value);
			},
			change : function(event, ui) {
				let prevVal = $(event.target).parents('.gem-wishes').find(".previous-value");
				let difference = ui.value - prevVal.val();
				if ( difference > $('#available').val()) return false;
				$('#available').val( $('#available').val() - difference );
				refreshAvalible();
				$(prevVal).val( ui.value );

			$(event.target).parents('.gem-wishes').find(".val").text(ui.value);
			},
		});
	})

	let diff = 100;

	$('.gem-wishes').each((indx, el) => {
		let value = $(el).find('.gem-wish').val();
		$(el).find(".range-2 span").html("<b>&lt;</b><span class='val'>" + Math.round(value*100) + "</span><b>&gt;</b>");
		diff -= Math.round(value*100)
	});

	if (diff != 0) {
		$('#available').val(diff)
	}

	refreshAvalible();

	$('#send-wishes').on('click', (e) => {
		$("#success-wishes").text("");
		if ( +$('#available').val() > 0 ) {
			$("#success-wishes").text("Не распределено: ");
			return;
		}
		let cansel = $(e)
		let wishes = $('#elf-wishes-form').serialize();
		$.ajax({
			type: "POST",
			url: "../../modules/change_wishes.php",
			data: wishes,
			dataType: "JSON",
			success: (response) => {
				if (response.code == 'success') {
					toggleWishes($('#change-wishes'));
					$('#success-wishes').text('Успешно!');
				}
				if (response.code == 'error') {
					$('#seccess-wish').text(response.msg);
				}
				return;
			},
			error: function(xhr, textStatus, errThrow) {
				console.log(textStatus, errThrow);
			}
		})
	});

	$('#nullify').on('click', () => {
		$('.range-2').slider( "value", 0 );
	})

	if ( +$('#available').val() != 0 ) {
		let add = +$('#available').val();
		let curr = $('.range-2').first().slider("value");
		let newVal = add + curr;
		$('.range-2').first().slider( "value", +newVal );
	}

	$('#change-name').on('click', () => {
		$('#new-name-err').text("");
		let data = $('#change-name').parents('form').serialize();
		$.ajax({
			type: "POST",
			url: "../../modules/change_name.php",
			data: data,
			dataType: "JSON",
			success: (response) => {
				if (response.code == 'success') {
					$('#name').text(response.name);
					$("#new-name").val("");
					$("#new-name-form").toggle();
				}
				if (response.code == 'error') {
					$('#new-name-err').text(response.msg);
				}
				return;
			},
			error: function(xhr, textStatus, errThrow) {
				console.log(textStatus, errThrow);
			}
		})
	})

	$("#send-password").on("click", (e) => {
		let elem = e.target;
		let data = $("#change-password").serialize();
		$('#err-pass').text("");
		$.ajax({
			type: "POST",
			url: "../../modules/change_pass.php",
			data: data,
			dataType: "JSON",
			success: (response) => {
				if (response.code == 'success') {
					$(elem).parents('.main').find('.hide').toggle();
					$('#suc-passw').text(response.msg);
					$(elem).parents('.main').find('input').val("");
				}
				if (response.code == 'error') {
					$('#err-pass').text(response.msg);
				}
				return;
			},
			error: function(xhr, textStatus, errThrow) {
				console.log(textStatus, errThrow);
			}
		})

	})

	$("#send-email").on("click", (e) => {
		let elem = e.target;
		let data = $("#change-email").serialize();
		$('#err-email').text("");
		$.ajax({
			type: "POST",
			url: "../../modules/change_email.php",
			data: data,
			dataType: "JSON",
			success: (response) => {
				if (response.code == 'success') {
					$(elem).parents('.main').find('.hide').toggle();
					$('#suc-email').text(response.msg);
					$('#user-email').text(response.email);
					$(elem).parents('.main').find('input').val("");
				}
				if (response.code == 'error') {
					$('#err-email').text(response.msg);
				}
				return;
			},
			error: function(xhr, textStatus, errThrow) {
				console.log(textStatus, errThrow);
			}
		})

	})

	$('#show-master-change').on('click', () => {
		toggleDis();
		$('#send-master').toggle();
		$('#suc-master').text("");
	});

	$('#send-master').on('click', () => {
		$('#suc-master').text("");
		let data = $('#master-form').serialize();
		$.ajax({
			type: "POST",
			url: "../../modules/change_master.php",
			data: data,
			dataType: "JSON",
			success: (response) => {
				if (response.code == 'success') {
					$('#send-master').toggle();
					$('#suc-master').text(response.msg);
					toggleDis();
				}
				if (response.code == 'error') {
					$('#err-master').text(response.msg);
				}
				return;
			},
			error: function(xhr, textStatus, errThrow) {
				console.log(textStatus, errThrow);
			}
		})
	})

})();