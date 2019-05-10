$(function() {

	// Custom JS
	//Вынести в отдельный модуль для странички авторизации
	let elButtonSignUp = document.getElementById("button-signup");
	let signupForm = document.getElementById("signupForm");

	elButtonSignUp.addEventListener( "click", function() {
		signupForm.classList.toggle("active");
	});

});
