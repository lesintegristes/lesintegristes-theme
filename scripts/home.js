;(function($){
  $(function(){
    var maxHeight = 0;
    $("ul.last-articles li:lt(3) dt a").each(function(){
      var thisHeight = $(this).height();
      if (thisHeight > maxHeight) {
        maxHeight = thisHeight;
      }
    }).parent().height(maxHeight);
  })
})(jQuery);