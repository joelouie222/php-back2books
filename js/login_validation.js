// JavaScript Document

/*EMAIL VALIDATION*/
function validateEmail(email){
	var validRegex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var elEmailStatus=document.getElementById('loginEmailStatus');
	elEmailStatus.classList.add("alert");
	if (email.value.match(validRegex)){
		elEmailStatus.classList.remove("alert-danger");
		elEmailStatus.classList.add("alert-success");
		elEmailStatus.innerHTML="Email is valid!";
	}
	else{
		elEmailStatus.classList.remove("alert-success");
		elEmailStatus.classList.add("alert-danger");
		elEmailStatus.innerHTML="Email is not valid!";
	}
}
var elEmail=document.getElementById('loginEmail');
elEmail.addEventListener('blur', function() {validateEmail(elEmail);},false);



/*PASSWORD VALIDATION*/
function validatePassword(password){
	var validRegex = /.+/
	var elPasswordStatus=document.getElementById('loginPasswordStatus');
	elPasswordStatus.classList.add("alert");
	
	if (password.value.match(validRegex)){
		elPasswordStatus.classList.remove("alert-danger");
		//elCommentStatus.classList.add("alert-success");
		elCommentStatus.innerHTML=" ";
	}
	else{
		//elPasswordStatus.classList.remove("alert-success");
		elPasswordStatus.classList.add("alert-danger");
		elPasswordStatus.innerHTML="Password cannot be blank!";
	}
}

var elPassword=document.getElementById('loginPassword');
elPassword.addEventListener('blur', function() {validatePassword(elPassword);},false);