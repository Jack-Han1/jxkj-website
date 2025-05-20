// 获取所有需要懒加载的图片元素
let images = [...document.querySelectorAll('img.lazyload')];
 
// 定义一个函数，用来判断元素是否在可视区域内
function isInViewport(el) {
  const rect = el.getBoundingClientRect();
  return (
    rect.bottom >= 0 &&
    rect.right >= 0 &&
    rect.top <= (window.innerHeight || document.documentElement.clientHeight) &&
    rect.left <= (window.innerWidth || document.documentElement.clientWidth)
  );
}
 
// 定义一个定时器，每100ms检查一次需要懒加载的图片是否在可视区域内
const timer = setInterval(() => {
  images.forEach(img => {
    if (isInViewport(img)) {
      // 加载图片
      img.src = img.dataset.src;
      // 从需要懒加载的列表中移除该元素
      let index = images.indexOf(img);
      if (index !== -1) {
        images.splice(index, 1);
      }
    }
  });
  
  // 如果所有图片都已经加载完毕，则取消定时器
  if (images.length === 0) {
    clearInterval(timer);
  }
}, 100);