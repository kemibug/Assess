(function($){
	var defaults={
		time:3000,//自动滚动时间 3000(3秒)
		animate:'left',//目前暂时只有 top|left 后续添加其他效果
		onClass:'Gfouce-on',//序列号选中样式名
		auto:true, //是否自动滚动 true[自动滚动] | false[不自动滚动]
		hasTit:true //设置是否有标题 true[有标题，对应图片title] | false[无标题]
	}
	$.fn.Gfouce=function(options){
		options = $.extend({},defaults,options);
		this.each(function(){
			var self = $(this),
				imgBox = self.find('.imgBox'),
				img = imgBox.children(),
				oImg = img.find('img, embed, object'),
				moveH = oImg.height(),
				moveW = oImg.width(),
				imgLen = img.length,
				current = 0,
				zIndex = 100,
				time = null;
				isHover=false;
			
			//添加序列号
			self.append("<ol class='num'></ol>");
			for(var i = 1;i<=imgLen;i++){
				self.find('.num').append("<li>"+i+"</li>")
			}
			
			var numBox = self.find('.num'),
				num = numBox.find('li');
				
			num.eq(current).addClass(options.onClass);
			
			if(options.hasTit){
				var titBgDom = "<div class='t-bg'></div>"
				var titTxtDom = "<span class='t-txt'></span>"
				$(titBgDom).appendTo(self);	
				$('.t-bg').css({
					
				});
				$(titTxtDom).appendTo(self);
				$('.t-txt').css({
					'position':'absolute',
					'font-weight':'800'
				})
			}
			
			if(options.hasTit){
				var firstTxt = oImg.eq(0).attr('title');
				self.find('.t-txt').text(firstTxt)
			}
				
			//动画模式函数
			function animateWay(marWay,moveWay){
					var obj = {};obj[marWay] = '-=' + moveWay + "px";
					var obj2 ={};obj2[marWay] = '0px';
					imgBox.animate(obj);
					
					if(current>imgLen-2){
						imgBox.stop().animate(obj2)
						current=0;
					}else{
						++current;
					}
					labelTo(current);
					if(options.hasTit){
						var titTxt = oImg.eq(current).attr('title');
						self.find('.t-txt').text(titTxt)
					}
			}
			
			//触碰停止滚动
			function tachNum(marWay,moveWay){
				self.hover(function(){
					stopAuto()
				},function(){				
					setAuto(marWay,moveWay)
				})
				
				num.bind('click',function(event){
					if(event.type == 'click'){
						var index = num.index(this);
						var obj3 = {};obj3[marWay] = - moveWay * index + "px";
						current = index;
						labelTo(index);
						imgBox.animate(obj3);
						self.find('.t-txt').text(oImg.eq(current).attr('title'));
					}else{
						stopAuto()
					}
				})
			}
								
			if(options.animate=="top"){
				setAuto("marginTop",moveH)
				tachNum("marginTop",moveH)
			}
			
			
			if(options.animate=="left"){
				imgBox.css({"width": moveW * imgLen + "px"})
				img.css({"float":"left"})
				setAuto("marginLeft",moveW)
				tachNum("marginLeft",moveW)
			}
			
			
			//定位当前序列号
			function labelTo(index){
				num.eq(index).addClass(options.onClass).siblings().removeClass(options.onClass);
			};
			
			//设置自动播放
			function setAuto(marWay,moveWay){
					if(options.auto === false){
						return;
					};
					var speed = options.time;
					stopAuto();
					time = setInterval(function(){
						animateWay(marWay,moveWay)
					},speed);
			};
			
			//停止自动播放
			function stopAuto(){
				if(time !== null){
					clearInterval(time);
					time = null;
				};
			};
			
		})
	}
})(jQuery);