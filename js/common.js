$(function() {

	// Custom JS
	// Вынести в отдельный модуль для странички авторизации
	// let elButtonSignUp = document.getElementById("button-signup");
	// let signupForm = document.getElementById("signupForm");

	// elButtonSignUp.addEventListener( "click", function() {
	// 	signupForm.classList.toggle("active");
	// });

	$('#button-signup').on('click', () => {
		$('#signupForm').toggleClass('active');
	})

	$(document).click(function(event) {
		if ( $(event.target).closest("#signupForm, #button-signup").length ) return;
		$('#signupForm').removeClass('active');
		event.stopPropagation();
	});

	$('input:radio[name=race]').on('change', function () {
		if ($(this).val() === 'elf') {
			$("#avatar").attr('src', "./img/elf.png");
		} else {
			$("#avatar").attr('src', "./img/dwarf.png");
		}
	});

});
