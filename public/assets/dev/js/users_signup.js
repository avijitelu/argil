var signup_form = (function(){
    return {
        formValidation: function() {
            var signup_btn = document.getElementById("js-signup__submit");
            var signup_form = document.getElementById("js-signup__form");
            var stringPattern = /^[A-Za-z ]*$/;
            var stringPattern_2 = /^[a-zA-Z0-9,-.!?() ]*$/;
            var emailPattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            
            signup_btn.addEventListener("click", function(e) {
                e.preventDefault();

                var fname = document.getElementById("js-signup-fname").value;
                var lname = document.getElementById("js-signup-lname").value;
                var about = document.getElementById("js-signup-about").value;
                var autherImg = document.getElementById("js-signup-img").value;
                var email = document.getElementById("js-signup-email").value;
                var password = document.getElementById("js-signup-password").value;
                var confirmPassword = document.getElementById("js-signup-cpassword").value;
                var error = false;
                
                if(fname.length > 0 && lname.length > 0 && about.length > 0 && autherImg.length > 0 && email.length > 0 && password.length > 0 && confirmPassword.length > 0) {

                    document.getElementById("js-signup__error-all").textContent = "";
                    document.getElementById("js-signup__error-all").classList.remove("signup__error--box");

                    if(!stringPattern.test(fname)) {
                        document.getElementById("js-signup__error-fname").textContent = "Only except alphabetic charecter";
                        error = true;
                    } else {
                        document.getElementById("js-signup__error-fname").textContent = "";
                    }

                    if(!stringPattern.test(lname)) {
                        document.getElementById("js-signup__error-lname").textContent = "Only except alphabetic charecter";
                        error = true;
                    } else {
                        document.getElementById("js-signup__error-lname").textContent = "";
                    }

                    if(!stringPattern_2.test(about)) {
                        document.getElementById("js-signup__error-about").textContent = "Special character are not allowed";
                        error = true;
                    } else {
                        document.getElementById("js-signup__error-lname").textContent = "";
                    }

                    if(!emailPattern.test(email)) {
                        document.getElementById("js-signup__error-email").textContent = "Invalid email ID";
                        error = true;
                    } else {
                        document.getElementById("js-signup__error-email").textContent = "";
                    }
                    
                    if(password != confirmPassword) {
                        document.getElementById("js-signup__error-cpsw").textContent = "Confirm password doesn't match";
                        error = true;
                    } else {
                        document.getElementById("js-signup__error-cpsw").textContent = "";
                    }

                    // Submit form if error is not true
                    if(!error) {
                        signup_form.submit();
                    }
                    
                } else {
                    document.getElementById("js-signup__error-all").classList.add("signup__error--box");
                    document.getElementById("js-signup__error-all").textContent = "Please fillup all the empty fields";
                }
            });
        }
    }
})();

signup_form.formValidation();