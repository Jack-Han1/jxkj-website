
// let t = window.devicePixelRatio
let r = getRatio()*0.01;
let w = getScreen()[1];
let w_ratio = r / w;
// document.body.style.zoom =1/ t;  
document.body.style.zoom = 1.25/1920/w_ratio; 


//获取屏幕缩放比例
function getRatio()
{
    var ratio=0;
    var screen=window.screen;
    var ua=navigator.userAgent.toLowerCase();
 
    if(window.devicePixelRatio !== undefined)
    {
        ratio=window.devicePixelRatio;    
    }
    else if(~ua.indexOf('msie'))
    {
        if(screen.deviceXDPI && screen.logicalXDPI)
        {
            ratio=screen.deviceXDPI/screen.logicalXDPI;        
        }
    
    }
    else if(window.outerWidth !== undefined && window.innerWidth !== undefined)
    {
        ratio=window.outerWidth/window.innerWidth;
    }
 
    if(ratio)
    {
        ratio=Math.round(ratio*100);    
    }
    return ratio;
}

function getScreen()
{
    // 屏幕分辨率的高：
    const h = window.screen.height*getRatio()/100   //乘以缩放比例为真实的像素
    // 屏幕分辨率的宽：
    const w = window.screen.width*getRatio()/100    //乘以缩放比例为真实的像素
    // 屏幕可用工作区高度：
    window.screen.availHeight;    
    // 屏幕可用工作区宽度：
    window.screen.availWidth;
    return [h,w];
}