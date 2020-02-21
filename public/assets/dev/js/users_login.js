var login_form = (function(){
    return {
        formValidation: function() {
            var login_btn = document.getElementById("js-login__submit");
            var login_form = document.getElementById("js-login__form");
            
            var emailPattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            
            login_btn.addEventListener("click", function(e) {
                e.preventDefault();

                var email = document.getElementById("js-login-email").value;
                var password = document.getElementById("js-login-password").value;
                var error = false;
                
                if(email.length > 0 && password.length > 0) {

                    document.getElementById("js-login__error-all").textContent = "";
                    document.getElementById("js-login__error-all").classList.remove("login__error--box");

                    if(!emailPattern.test(email)) {
                        document.getElementById("js-login__error-email").textContent = "Invalid email ID";
                        error = true;
                    }

                    // Submit form if error is not true
                    if(!error) {
                        login_form.submit();
                    }
                    
                } else {
                    document.getElementById("js-login__error-all").classList.add("login__error--box");
                    document.getElementById("js-login__error-all").textContent = "Please fillup all the empty fields";
                }
            });
        }
    }
})();

login_form.formValidation();