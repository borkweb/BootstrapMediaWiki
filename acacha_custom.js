$(document).ready(function(){
  $("#toc_sidebar_toogle").click(function(){
      hide_toc_sidebar()
  });

$("#extruderTop").buildMbExtruder({
        position: "bottom",
        positionFixed:true,
        width:350,
        extruderOpacity:1,
        autoCloseTime:4000,
        closeOnExternalClick:false,
       // hidePanelsOnClose:false,
        onExtOpen:function(){
                show_toc_sidebar();
                $("#extruderTop").closeMbExtruder();
                },
        onExtContentLoad:function(){},
        onExtClose:function(){}
   });
   
   $("#extruderTop").hide();


});


function hide_toc_sidebar(){ 
      $('.toc-sidebar').hide();
      $('.wiki-body-section').removeClass('col-md-9').addClass('col-md-12');

      $("#extruderTop").show();
}

function show_toc_sidebar(){
      $('.toc-sidebar').show();
      $('.wiki-body-section').removeClass('col-md-12').addClass('col-md-9');
      
      $("#extruderTop").hide();
}

jQuery(window).scroll(function(e) {
	//fixed effect
	if(jQuery(window).width()>992){
		jQuery(".fixed-effect").each(function(index, element) {
			var windowHeight = jQuery(window).height();
			var offset =  jQuery(this).offset().top;
			var inner_height = jQuery('.fixed-effect-inner',this).outerHeight();
			var scrollTop = jQuery(document).scrollTop();
			if((scrollTop + windowHeight) >= offset){
				var opacity = ((scrollTop + windowHeight)-offset)/inner_height;
				if (opacity > 1) {
                                 opacity = 1;
				}
				jQuery('.fixed-effect-inner',this).css('opacity', opacity);
				//jQuery('.fixed-effect-inner',this).css('margin-bottom', (opacity-1)*120);				
				jQuery('.fixed-effect-inner',this).css('margin-top', (opacity-1)*300);
			}
		});
	}else{
		jQuery(".fixed-effect").each(function(index, element) {
			jQuery('.fixed-effect-inner',this).css('opacity', 1);
			jQuery('.fixed-effect-inner',this).css('margin-bottom', 0);
		});
	}
});

jQuery(window).resize(function(e) {
	//fixed effect
    jQuery(".fixed-effect").each(function(index, element) {
        var inner_height = jQuery('.fixed-effect-inner',this).outerHeight();
		jQuery(this).css('height', inner_height);
    });
});
