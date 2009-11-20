(function($){
  $(function(){
    var $htmlHelp = $("#respond p.html-help");
    $htmlHelp.height($htmlHelp.height()).hide();
    $("#respond textarea").focus(function(){
    	if (!$htmlHelp.is(":visible")) {
    		$htmlHelp.slideDown(150);
    	}
    });
    
    /* Post comment animation */
  	$('#comments .post-comment a').click(function(e){
  		e.preventDefault();
  		var curHref = $(this).attr("href");
  		$('html').animate({scrollTop: $(curHref).offset().top}, 100, function(){
  			window.location.hash = curHref.slice(1);
  			$(curHref).focus();
  		});
  	});
  });
})(jQuery);