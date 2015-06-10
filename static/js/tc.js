 $(function(){  
        var mask = $(".mask");  
        var box = $(".tcbox");  
        $(".fsdsj").click(function(){  
            mask.show();  
            box.show();  
            MaskAdapt();  
            BoxAdapt();  
        });  
        $(".close").click(function(){  
            mask.hide();  
            box.hide();  
        });  
          
        $(window).scroll(function(){  
            BoxAdapt();  
        });  
        $(window).resize(function(){  
            BoxAdapt();  
            MaskAdapt();  
        });  
    });  
    function MaskAdapt(){  
        var docWidth = $(document.body).outerWidth(true);  
        var docHeight = $(document).height();  
        $(".mask").height(docHeight).width(docWidth);  
    };  
    function BoxAdapt(){  
        var winWidth = $(window).width();  
        var winHeight = $(window).height();  
        var scrHeight = $(document).scrollTop();  
        var boxHeight = $(".tcbox").height();  
        var boxWidth = $(".tcbox").width();  
        var centerWidth = (winWidth-boxWidth)/2  
        var centerHeight = (winHeight-boxHeight)/2+scrHeight  
        var offsetHeight = $(".tcbox").offset().top;  
        if(offsetHeight < centerHeight){  
            $(".tcbox").stop(true,false).animate({"top":centerHeight,"left":centerWidth},500);  
        }else{  
            $(".tcbox").stop(true,false).animate({"top":centerHeight,"left":centerWidth},500);  
        };  
    };  