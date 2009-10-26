;(function($){
  
  
  // Archives toggle button
  $('<button type="button">Replier</button>')
    .appendTo("#wrapper > footer .archives li strong")
    .toggle(
      function() { $(this).removeClass("expanded").text("Déplier").parent().next().hide(); },
      function() { $(this).addClass("expanded").text("Replier").parent().next().show(); }
    )
    .click().filter(":first").click();
  
})(jQuery);