(function($){
  $(function(){
    var $htmlHelp = $("#respond p.html-help");
    $htmlHelp.height($htmlHelp.height()).hide();
    $("#respond textarea").focus(function(){
    	if (!$htmlHelp.is(":visible")) {
    		$htmlHelp.slideDown(150);
    	}
    });
  });
})(jQuery);