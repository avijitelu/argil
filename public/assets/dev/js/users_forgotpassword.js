var usersForgotpassword = (function() {
    return {
        formValidation: function() {
            var submitBtn = document.getElementById("js-forgot-password__submit");
            var forgotForm = document.getElementById("js-forgot-password__form");
            var errorAll = document.getElementById("js-forgot-password__error-all");
            var emailError = document.getElementById("js-forgot-password__error-email");
            var emailRegx = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

            submitBtn.addEventListener("click", function(event) {
                event.preventDefault();

                var email = document.getElementById("js-forgot-password-email").value;
                var error = false;

                if (email.length > 0) {
                    // Remove the class and textContent for hiding the error
                    errorAll.classList.remove("signup__error--box");
                    errorAll.textContent = "";
                    
                    if (!emailRegx.test(email)) {
                        emailError.textContent = "Invalid email ID";
                        error = true;
                    }

                    if (!error) {
                        forgotForm.submit();
                    }
                } else {
                    errorAll.classList.add("signup__error--box");
                    errorAll.textContent = "Please fillup the empty fields";
                }
            })
        }
    }
})();

usersForgotpassword.formValidation();