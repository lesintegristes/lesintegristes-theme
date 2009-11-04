;(function($){
  
  
  // Archives toggle button
  $('<button type="button">Replier</button>')
    .appendTo("#wrapper > footer .archives li strong")
    .click(function() {
      var $this = $(this);
      
      if ($this.hasClass("expanded")) {
        $(this).removeClass("expanded").text("Déplier").parent().next().slideUp(150);
      } else {  
        $(this).addClass("expanded").text("Replier").parent().next().slideDown(150);
      }
    })
    .filter(":not(:first)").parent().next().hide().end().end()
    .end().filter(":first").addClass("expanded").text("Replier")
  
})(jQuery);