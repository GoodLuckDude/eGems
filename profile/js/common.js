(function() {

	let elChangeEmailButton = document.getElementById("change-email-button");
  let changeEmail = document.getElementById("change-email");
  let elChangePassButton = document.getElementById("change-password-button");
	let changePassword = document.getElementById("change-password");

	elChangeEmailButton.addEventListener( "click", function() {
		changeEmail.classList.toggle("hide");
  });

	elChangePassButton.addEventListener( "click", function() {
		changePassword.classList.toggle("hide");
	});


	$('.carousel-gems').owlCarousel({
		items: 2,
		slideBy: 2,
		nav: true,
		smartSpeed: 500,
		navText: ['<i class="fa fa-caret-left"></i>', '<i class="fa fa-caret-right"></i>']
	});

	// $('.dropdown').click(function(e){
	// 	$('.dropdown-menu').toggleClass('show');
	// });

})();