var post_addpost = (function() {
    return {
        formValidation: function() {
            var form_btn = document.getElementById("js-blog-form__input-btn");
            var form = document.getElementById("js-blog-form");
            var msg_tag = document.getElementById("js-blog-form__err");

            form_btn.addEventListener("click", function(e) {
                e.preventDefault();
                var title = document.getElementById("js-blog-form__input-title").value;
                var blogImage = document.getElementById("js-blog-form__input-img").value;
                var body = CKEDITOR.instances.blog_body.getData();
                
                if(title.length > 0 && blogImage.length > 0 && body.length > 0) {
                    form.submit();
                } else {
                    msg_tag.textContent = "You must fillup all the required* field";
                }
            })
        },

        fixedOnScroll: function() {
            if(window.innerWidth > 700) {
                var blogList = document.getElementById("js-blog-list");
                var sidebar = document.getElementById("js-sidebar");
                var viewPort = window.innerHeight;

                if(blogList.offsetHeight > sidebar.offsetHeight) {
                    var tragetElement = blogList;
                    var refElement = sidebar;
                    var fixedElement = sidebar.lastChild;
                } else {
                    var tragetElement = sidebar;
                    var refElement = blogList;
                    var fixedElement = blogList;
                }

                // Set the scroll position from where the element should fixed
                var targetPosition = blogList.offsetTop + refElement.offsetHeight - viewPort;

                // Set the scroll position from where the element should give abolute postion
                var targetRelease = blogList.offsetTop + tragetElement.offsetHeight - viewPort;
                var htmlRoot = document.documentElement;
                var sidebarWidth = refElement.offsetWidth;
                var left = refElement.offsetLeft;

                // At targetRelease position the fixedElements distance from top
                var fromTop = blogList.offsetTop + tragetElement.offsetHeight - fixedElement.offsetHeight;
                var test = document.getElementById("test");

                window.addEventListener("scroll", function() {
                    if(htmlRoot.scrollTop >= targetPosition) {
                        fixedElement.style.position = "fixed";
                        fixedElement.style.bottom = "0px";
                        fixedElement.style.left = left + "px";
                        fixedElement.style.width = sidebarWidth + "px";
                        fixedElement.style.top = "";
                        test.style.display = "block";
                    }
                    if(htmlRoot.scrollTop <= targetPosition) {
                        fixedElement.style.position = "static";
                        test.style.display = "none";
                    }
                    if(htmlRoot.scrollTop >= targetRelease) {
                        fixedElement.style.position = "absolute";
                        fixedElement.style.top = fromTop + "px";
                        fixedElement.style.bottom = "";
                        test.style.display = "block";
                    }
                });
            }
        }
    }
})();

post_addpost.formValidation();

// Check the ckeditor "cke_blog_body" ID present in the DOM
// If ture it will execute the "fixedOnScroll()" function
var ckEditor = setInterval(function() {
    if(document.getElementById("cke_blog_body")) {
        post_addpost.fixedOnScroll();
        clearInterval(ckEditor);
    }
});



