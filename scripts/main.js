;(function($){
  
  
  // Archives toggle button
  $('<button type="button">Replier</button>')
    .appendTo("#wrapper > footer .archives li strong")
    .toggle(
      function() { $(this).removeClass("expanded").text("Déplier").parent().next().slideUp(150); },
      function() { $(this).addClass("expanded").text("Replier").parent().next().slideDown(150); }
    )
    .click().filter(":first").click();
  
})(jQuery);