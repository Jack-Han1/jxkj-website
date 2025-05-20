// window.requestAnimationFrame(unprintPage);
res = GetRequest();
if(res['loading']==1){
    unprintPage();
    document.addEventListener("DOMContentLoaded", (e)=>{
        let page = document.querySelector("html");
        page.style.transition = "opacity .4s ease-in";
        page.style.opacity = 1;
        document.body.scrollTop = 400;
    });
}

function unprintPage(){
    let page = document.querySelector("html");
    page.style.opacity = 0;
}

function GetRequest() {
    var url = location.search; 
    var theRequest = new Object();
    if (url.indexOf("?") != -1) {
        var str = url.substr(1);
        strs = str.split("&");
        for(var i = 0; i < strs.length; i ++) {
            theRequest[strs[i].split("=")[0]]=decodeURI(strs[i].split("=")[1]);
        }
    }
    return theRequest;
} 

// window.onload(()=>{
//     document.querySelector("html").scrollTop= 300;
// })