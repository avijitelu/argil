// // Contain all the blogs body images within the parent container
// if(document.querySelector("#js-fullblog__body p img")) {
//     var blogBody = document.getElementById("js-fullblog__body");
//     var blogImg = document.querySelector("#js-fullblog__body p img");
//     var blogWidth = blogBody.offsetWidth;
//     var imgWidth = blogImg.offsetWidth;

//     if(imgWidth > blogWidth) {
//         blogImg.style.width = "100%";
//         blogImg.style.height = "300px";
//     }
// }

// // Fixed the element which is which has the shorter height
// if(window.innerWidth > 700) {
//     var container = document.getElementById("js-container");
//     var blogList = document.getElementById("js-blog-list");
//     var sidebar = document.getElementById("js-sidebar");
//     var viewPort = window.innerHeight;

//     if(blogList.offsetHeight > sidebar.offsetHeight) {
//         var tragetElement = blogList;
//         var refElement = sidebar;
//         var fixedElement = sidebar.lastChild;
//     } else {
//         var tragetElement = sidebar;
//         var refElement = blogList;
//         var fixedElement = blogList;

//         // This dummy element is created only when "blogList" height is less then "sidebar"
//         // This dummy element is created to contain the "sidebar" to its own position
//         // because when "blogList" position is fixed "sidebar" will try to take "blogList" position
//         var divEl = document.createElement("DIV");
//         divEl.style.display = "none";
//         divEl.style.width = "70%";
//         divEl.id = "dummyEl";
//         container.insertBefore(divEl, sidebar);
//         var dummy = document.getElementById("dummyEl");
//     }

//     // Set the scroll position from where the element should fixed
//     var targetPosition = blogList.offsetTop + refElement.offsetHeight - viewPort;

//     // Set the scroll position from where the element should give abolute postion
//     var targetRelease = blogList.offsetTop + tragetElement.offsetHeight - viewPort;
//     var htmlRoot = document.documentElement;
//     var sidebarWidth = refElement.offsetWidth;
//     var left = refElement.offsetLeft;

//     // At targetRelease position the fixedElements distance from top
//     var fromTop = blogList.offsetTop + tragetElement.offsetHeight - fixedElement.offsetHeight;
//     // var test = document.getElementById("test");

//     window.addEventListener("scroll", function() {
//         if(htmlRoot.scrollTop >= targetPosition) {
//             fixedElement.style.position = "fixed";
//             fixedElement.style.bottom = "0px";
//             fixedElement.style.left = left + "px";
//             fixedElement.style.width = sidebarWidth + "px";
//             fixedElement.style.top = "";

//             if(dummy) {
//                 dummy.style.display = "block";
//             }
//         }
//         if(htmlRoot.scrollTop <= targetPosition) {
//             fixedElement.style.position = "static";

//             if(dummy) {
//                 dummy.style.display = "none";
//             }
//         }
//         if(htmlRoot.scrollTop >= targetRelease) {
//             fixedElement.style.position = "absolute";
//             fixedElement.style.top = fromTop + "px";
//             fixedElement.style.bottom = "";

//             if(dummy) {
//                 dummy.style.display = "block";
//             }
//         }
//     });
// }

// Send a ajax request to increase the view count
// if user wait for 15sec
var increaseViewCount = setTimeout(function() {
    var xhttp = new XMLHttpRequest();
    var url = BASE_HREF + "/posts/fullpost/" + postId + "-full-post-view-1";
    xhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200) {

        }
    }
    xhttp.open('GET', url, true);
    xhttp.send();
}, 15000);