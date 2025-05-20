function getClass(searchClass) {
    var classElements = new Array();
    //if ( node == null )
    var node = document;
    //if ( tag == null )
    var tag = '*';
    var els = node.getElementsByTagName(tag);
    var elsLen = els.length;
    var pattern = new RegExp("(^|\\s)"+searchClass+"(\\s|$)");
    for (i = 0, j = 0; i < elsLen; i++) {
        if ( pattern.test(els[i].className) ) {
            classElements[j] = els[i];
            j++;
        }
    }
    return classElements;
}

function ZoomPic ()
{
	this.initialize.apply(this, arguments)	
}
ZoomPic.prototype = 
{
	initialize : function (id)
	{
		var _this = this;
		this.wrap = typeof id === "string" ? document.getElementById(id) : id;
		this.oUl = this.wrap.getElementsByTagName("ul")[0];
		this.aLi = this.wrap.getElementsByTagName("li");
		this.prev = this.wrap.getElementsByTagName("span")[0];
		this.next = this.wrap.getElementsByTagName("span")[1];
        //console.log(document.getElementsByClassName('list-left'))
        //this.dot_prev = document.getElementsByClassName('list-left')[0];
        //this.dot_next = document.getElementsByClassName('list-right')[0];
        this.dot_prev = getClass('list-left')[0];
        this.dot_next = getClass('list-right')[0];
		this.timer = 1000;
		this.aSort = [];
		this.iCenter = 1;
		this._doPrev = function () {return _this.doPrev.apply(_this)};
		this._doNext = function () {return _this.doNext.apply(_this)};
		this.options = [
			/*{width:476, height:210, top:40, left:0, zIndex:1},
			{width:426, height:250, top:20, left:50, zIndex:2},
			{width:654, height:290, top:0, left:150, zIndex:3},
			{width:426, height:250, top:20, left:480, zIndex:2},
			{width:476, height:210, top:40, left:476, zIndex:1},*/
			{width:200, height:100, top:10, left:0, zIndex:1},
			//{width:280, height:100, top:19, left:0, zIndex:1},
			{width:250, height:180, top:0, left:120, zIndex:3},
			//{width:335, height:100, top:0, left:93, zIndex:3},
			{width:200, height:100, top:10, left:240, zIndex:1},
            //{width:280, height:100, top:19, left:240, zIndex:1},
		];
		for (var i = 0; i < this.aLi.length; i++) this.aSort[i] = this.aLi[i];
		this.aSort.unshift(this.aSort.pop());
		this.setUp();
		//this.addEvent(this.prev, "click", this._doPrev);
		//this.addEvent(this.next, "click", this._doNext);
        this.addEvent(this.dot_prev, "click", this._doPrev);
        this.addEvent(this.dot_next, "click", this._doNext);
		this.doImgClick();		
		this.timer = setInterval(function ()
		{
			_this.doNext()	
		}, 3000);
		this.wrap.onmouseover = function ()
		{
			clearInterval(_this.timer)	
		};
		this.wrap.onmouseout = function ()
		{
			_this.timer = setInterval(function ()
			{
				_this.doNext()	
			}, 3000);
		}
	},
	doPrev : function ()
	{
		this.aSort.unshift(this.aSort.pop());
		this.setUp()
	},
	doNext : function ()
	{
		this.aSort.push(this.aSort.shift());
		this.setUp()
	},
	doImgClick : function ()
	{
		var _this = this;
		for (var i = 0; i < this.aSort.length; i++)
		{
			this.aSort[i].onclick = function ()
			{
				if (this.index > _this.iCenter)
				{
                    //_this.doPrev();
                    _this.doNext();
					//for (var i = 0; i < this.index - _this.iCenter; i++) _this.aSort.push(_this.aSort.shift());
					//_this.setUp()
				}
				else if(this.index < _this.iCenter)
				{
                    _this.doPrev();
                    //_this.doNext();
					//for (var i = 0; i < _this.iCenter - this.index; i++) _this.aSort.unshift(_this.aSort.pop());
					//_this.setUp()
				}
			}
		}
	},
	setUp : function ()
	{
		var _this = this;
		var i = 0;
		for (i = 0; i < this.aSort.length; i++) this.oUl.appendChild(this.aSort[i]);
		for (i = 0; i < this.aSort.length; i++)
		{
			this.aSort[i].index = i;
			if (i < 3)
			{
				this.css(this.aSort[i], "display", "block");
				this.doMove(this.aSort[i], this.options[i], function ()
				{
					_this.doMove(_this.aSort[_this.iCenter].getElementsByTagName("img")[0], {opacity:100}, function ()
					{
						_this.doMove(_this.aSort[_this.iCenter].getElementsByTagName("img")[0], {opacity:100}, function ()
						{
							_this.aSort[_this.iCenter].onmouseover = function ()
							{
								_this.doMove(this.getElementsByTagName("div")[0], {bottom:0})
							};
							_this.aSort[_this.iCenter].onmouseout = function ()
							{
								_this.doMove(this.getElementsByTagName("div")[0], {bottom:-100})
							}
						})
					})
				});
                if(i==1){
                    this.aLi[i].getElementsByTagName("span")[0].style.display = 'inline-block';
                    //document.getElementById("focus-list").getElementsByTagName("li")[i].setAttribute("class",'select' );
                    //console.log(document.getElementById("focus-list").getElementsByTagName("li")[i]);
                }else{
                    this.aLi[i].getElementsByTagName("span")[0].style.display = 'none';
                }

			}
			else
			{
				this.css(this.aSort[i], "display", "none");
				this.css(this.aSort[i], "width", 0);
				this.css(this.aSort[i], "height", 0);
				this.css(this.aSort[i], "top", 37);
				this.css(this.aSort[i], "left", this.oUl.offsetWidth / 2)
			}
			if (i < this.iCenter || i > this.iCenter)
			{
				this.css(this.aSort[i].getElementsByTagName("img")[0], "opacity", 100)
				this.aSort[i].onmouseover = function ()
				{
					_this.doMove(this.getElementsByTagName("img")[0], {opacity:100})	
				};
				this.aSort[i].onmouseout = function ()
				{
					_this.doMove(this.getElementsByTagName("img")[0], {opacity:100})
				};
				this.aSort[i].onmouseout();
			}
			else
			{
				this.aSort[i].onmouseover = this.aSort[i].onmouseout = null
			}
		}
        select_dot();
	},
	addEvent : function (oElement, sEventType, fnHandler)
	{
		return oElement.addEventListener ? oElement.addEventListener(sEventType, fnHandler, false) : oElement.attachEvent("on" + sEventType, fnHandler)
	},
	css : function (oElement, attr, value)
	{
		if (arguments.length == 2)
		{
			return oElement.currentStyle ? oElement.currentStyle[attr] : getComputedStyle(oElement, null)[attr]
		}
		else if (arguments.length == 3)
		{
			switch (attr)
			{
				case "width":
				case "height":
				case "top":
				case "left":
				case "bottom":
					oElement.style[attr] = value + "px";
					break;
				case "opacity" :
					oElement.style.filter = "alpha(opacity=" + value + ")";
					oElement.style.opacity = value / 100;
					break;
				default :
					oElement.style[attr] = value;
					break
			}	
		}
	},
	doMove : function (oElement, oAttr, fnCallBack)
	{
		var _this = this;
            clearInterval(oElement.timer);
		oElement.timer = setInterval(function ()
		{
			var bStop = true;
			for (var property in oAttr)
			{
				var iCur = parseFloat(_this.css(oElement, property));
				property == "opacity" && (iCur = parseInt(iCur.toFixed(2) * 100));
				var iSpeed = (oAttr[property] - iCur) / 3;
				iSpeed = iSpeed > 0 ? Math.ceil(iSpeed) : Math.floor(iSpeed);
				
				if (iCur != oAttr[property])
				{
					bStop = false;
					_this.css(oElement, property, iCur + iSpeed)
				}
			}
			if (bStop)
			{
				clearInterval(oElement.timer);
				fnCallBack && fnCallBack.apply(_this, arguments)	
			}
		}, 30)
	}
};
window.onload = function ()
{
	new ZoomPic("focus_Box");
};

function select_dot (){
    var img_list = document.getElementById('focus_Box').getElementsByTagName('ul')[0].getElementsByTagName('li');
//        console.log(img_list[2].getElementsByTagName('span')[0].style.display);
    var ii = 0;
    var kk = 0;
    for(ii=0;ii<3;ii++){
        //console.log(i);
        if(img_list[ii].getElementsByTagName('span')[0].style.display=='inline-block'){
            kk=parseInt(img_list[ii].id);
            //console.log(kk);
        }
    }
    for(ii=0;ii<3;ii++){
        if(ii==kk){
            //console.log(ii)
            document.getElementById('focus-list').getElementsByTagName('li')[ii].setAttribute("class",'select' );
        }else{
            document.getElementById('focus-list').getElementsByTagName('li')[ii].setAttribute("class",'' );
        }
    }
}

