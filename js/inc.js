//Autor: Igor Ivanov

(function($){
    $.fn.macStyleResize = function(settings){
    
        var config = {
            'imgMin': 35,
            'imgMax': 64,
            'distanceMax': 100
        };
        
        if (settings) 
            $.extend(config, settings);
        
		var zoomFactor = (config.imgMax - config.imgMin) / config.imgMin;
		var imgIcon = this;
		
		$(document).ready(function(){
			imgIcon.each(function(){
				this.style.width = config.imgMin + 'px';
			});
		});

        $(document).mousemove(function(e){
               
            var getMouseX = e.pageX;
            var getMouseY = e.pageY;
            
			imgIcon.each(function(){
                
                var currentPosition = $(this).offset();
				
				var cx = currentPosition.left + (this.width / 2);
				var cy = currentPosition.top + (this.height / 2);
                
				var distance = Math.sqrt((cx-getMouseX)*(cx-getMouseX) + (cy-getMouseY)*(cy-getMouseY));
                var distanceFactor = (config.distanceMax - distance) / config.distanceMax;
				
				var newWidth = config.imgMin; 
				
				if(distanceFactor >= 0)
				{
					newWidth = (config.imgMin * distanceFactor * zoomFactor) + config.imgMin;
				}

                this.style.width = newWidth + 'px';

            });
        });
    }
})(jQuery);

(function($) {
	$.extend($.fx.step,{
	    backgroundPosition: function(fx) {
            var n = fx.end.split(" "); 
            var x = (parseFloat(n[0]) - parseFloat(n[2])) * fx.pos + parseFloat(n[2]);
            var y = (parseFloat(n[1]) - parseFloat(n[3])) * fx.pos + parseFloat(n[3]);
            fx.elem.style.backgroundPosition = x + 'px ' + y + 'px';
        }
	});
})(jQuery);

jQuery(document).ready(function($){

	$('.tabs_left_1_50 a').mouseover(function(e){
		$(this).animate({"left" : "0px", "width": "180px"}, 500);
	}).mouseout(function(e){
		$(this).animate({"left" : "0px", "width": "60px"}, 300);
	});
	$('.tabs_right_1_50 a').mouseover(function(e){
		$(this).animate({"left" : "-118px", "width": "180px"}, 500);
	}).mouseout(function(e){
		$(this).animate({"left" : "0px", "width": "60px"}, 300);
	});
	
	$('.tabs_left_1_40 a').mouseover(function(e){
		$(this).animate({"left" : "0px", "width": "142px"}, 500);
	}).mouseout(function(e){
		$(this).animate({"left" : "0px", "width": "48px"}, 300);
	});
	$('.tabs_right_1_40 a').mouseover(function(e){
		$(this).animate({"left" : "-94px", "width": "142px"}, 500);
	}).mouseout(function(e){
		$(this).animate({"left" : "0px", "width": "48px"}, 300);
	});
	
	$('.tabs_inner_fm_s_2_50 img').macStyleResize({imgMin:45, imgMax:75});
	$('.tabs_inner_fm_s_2_40 img').macStyleResize({imgMin:35, imgMax:65});

	$('.widget_inner_fm_50 img').macStyleResize({imgMin:45, imgMax:75});
	$('.widget_inner_fm_40 img').macStyleResize({imgMin:35, imgMax:65});
	
    $('a.tabs_fm_s_a_50')
	.css( {backgroundPosition: "0 0"} )
	.mouseover(function(){
		$(this).stop().animate(
			{backgroundPosition:"0 -50 0 0"}, 
			{duration:500})
		})
	.mouseout(function(){
		$(this).stop().animate(
			{backgroundPosition:"0 0 0 -50"}, 
			{duration:500})
		});

    $('a.tabs_fm_s_a_40')
	.css( {backgroundPosition: "0 0"} )
	.mouseover(function(){
		$(this).stop().animate(
			{backgroundPosition:"0 -40 0 0"}, 
			{duration:500})
		})
	.mouseout(function(){
		$(this).stop().animate(
			{backgroundPosition:"0 0 0 -40"}, 
			{duration:500})
		});
})
