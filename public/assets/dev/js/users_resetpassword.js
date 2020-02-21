var usersResetpassword = (function(){
    return {
        formValidation: function() {
            var submitBtn = document.getElementById("js-reset-password__submit");
            var resetForm = document.getElementById("js-reset-password__form");
            var errorAll = document.getElementById("js-reset-password__error-all");
            var pswError = document.getElementById("js-reset-confpassword__error");

            submitBtn.addEventListener("click", function(event) {
                event.preventDefault();
                var password = document.getElementById("js-reset-password").value;
                var confPassword = document.getElementById("js-reset-confpassword").value;
                var error = false;

                if (password.length > 0 && confPassword.length > 0) {
                    errorAll.classList.remove("signup__error--box");
                    errorAll.textContent = "";

                    if (password != confPassword) {
                        error = true;
                        pswError.textContent = "Confirm password doesn't match";
                    }

                    if (!error) {
                        resetForm.submit();
                    }
                } else {
                    errorAll.classList.add("signup__error--box");
                    errorAll.textContent = "Please fillup all the empty fields";
                }
            });
        }
    }
})();

usersResetpassword.formValidation();