(function($){
  $(function(){
    /* Rectify images line-height */
    var $imgs = $("#content article.hentry > div.content img");
    $imgs.each(function(){
      var $this = $(this),
          thisHeight = $this.height(),
          $target = $this,
          additionnalMargin = 24 - thisHeight % 24,
          mode = "margin";

      // Image + link, image + caption, image only
      if ($this.parent().is('a,div.wp-caption')) {
        $target = $this.parent();
      }

      // Image + link + caption
      if ($this.parent().is('a') && $this.parent('a').next().is('.wp-caption-text')) {
        $target = $this.parents('.wp-caption');
      }

      if (!$target.is(".wp-caption") && !$target.is("img.alignleft") && !$target.is("img.alignright") && additionnalMargin < 10) {
        additionnalMargin += 24;
      }

      if ($target.is("a")) {
        if (!$target.parent().is(".img-only")) {
          $target.css("display", "inline-block");
        } else {
          $target = $target.parent();
          mode = "padding";
        }
      }

      $target.css(mode + "Bottom", additionnalMargin + "px");
    });

    /* HTML Help animation */
    var $htmlHelp = $("#respond p.html-help");
    $htmlHelp.height($htmlHelp.height()).hide();
    $("#respond textarea").focus(function(){
      if (!$htmlHelp.is(":visible")) {
        $htmlHelp.slideDown(150);
      }
    });

    /* Post comment animation */
    $('#comments .post-comment a, article.hentry > footer a[href=#respond]').click(function(e){
      e.preventDefault();
      var curHref = $(this).attr("href");
      $('html').animate({scrollTop: $(curHref).offset().top}, 100, function(){
        window.location.hash = curHref.slice(1);
        $(curHref).focus();
      });
    });
  });
})(jQuery);
