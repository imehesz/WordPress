<?php
  global $related; 

  include( TEMPLATEPATH . '/buzz/ComicParser.php' );
  $rels = $related->show($post->ID, true);

  $cp = new ComicParser($post);

/*
  echo $cp->getThumbnail();
  echo $cp->getCover();
  echo $cp->getWriter();
  echo $cp->getIllustrator();
  echo $cp->getTitle();
  echo $cp->getExcerpt();
  echo $cp->getContent();
  echo $cp->getPagesForJs();
  */

  $ENV = "dev";
  if ($ENV == "dev") {
    $JS_FOLDER = get_template_directory_uri() . "/js/";
  } else {
    $JS_FOLDER = "productionjsfolder";
  }

/* can't get the stupid caching right'
  function my_scripts_method() {
    wp_enqueue_script(
      'custom-script',
      get_stylesheet_directory_uri() . '/js/test.js',
      array( 'jquery' ),
      1
    );
  }

  add_action( 'wp_enqueue_scripts', 'my_scripts_method' );
*/

?>

<?php get_header(); ?>

<?php get_template_part('template-part', 'head'); ?>

<?php get_template_part('template-part', 'topnav'); ?>

<div id="modal-finish" class="modal-wrapper modal-effect"> 
  <div class="modal-window">
    <div class="modal-top">THE END</div> 
    <div class="modal-bottom"> 
      <p>You just finished this comic, we hope you had a good time, and you'll read some more.</p>
      <div class="modal-button-wrapper text-center"> 
        <a href="/comics" class="btn btn-primary">Back to Comics List</a>
        <a href="javascript:void(0);" class="btn btn-default modal-close">Close</a>
      </div> 
    </div> 
  </div> 
</div>
<div class="modal-overlay"></div>

<!-- start content container -->
<div class="row dmbs-content">

    <?php //left sidebar ?>
    <?php get_sidebar( 'left' ); ?>

    <div class="col-md-<?php devdmbootstrap3_main_content_width(); ?> dmbs-main">
        <?php // theloop
          if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

          <div class="row title-and-book-info">
            <div class="col-sm-12">
              <h1 class="page-header"><?php echo the_title();?></h1>

                <?php $tags = $cp->getTags(); if(is_array($tags) && sizeof($tags)>0) : ?>
                  <h4 class="tag-list">
                    <?php foreach($tags as $tag) : ?>
                      <span class="label label-default"><?php echo $tag->name; ?></span>
                    <?php endforeach; ?>
                  </h4>
                <?php endif; ?>

              <!-- <a href="/comics/search/{{tag.trim()}}" class="label label-default">{{tag}}</a> -->

              <p class="lead">
                <?php if ($cp->getWriter()): ?>
                  <div>Written by <strong><?php echo $cp->getWriter(); ?></strong></div>
                <?php endif; ?>
                <?php if ($cp->getIllustrator()): ?>
                  <div>Art by <strong><?php echo $cp->getIllustrator(); ?></strong></div>
                <?php endif; ?>
                <div>Pages <strong><?php echo sizeof($cp->getPages()); ?></strong></div>
                <?php if ($cp->getPublishDate()): ?>
                  <div>Published <strong><?php echo $cp->getPublishDate(); ?></strong></div>
                <?php endif; ?>
              </p>
            </div>
            <!--
            <div class="col-sm-6">
            <ins class="adsbygoogle"
            style="display:block"
            data-ad-client="ca-pub-1319358860215477"
            data-ad-slot="6070069179"
            data-ad-format="auto"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
            </div>
            -->
          </div> <!-- title-and-book-info -->

          <div class="row art-and-description">
            <div class="col-sm-6">
              <div>
                <a href="javascript:void(0)"><img src="<?php echo $cp->getCover(); ?>" class="img-responsive cover" /></a>
              </div>
              <p></p>
            </div>


            <div class="col-sm-6">
              <p>
                <button class="btn btn-success btn-lg" id="btn-buzz-reader">Launch Buzz Reader</button>
                or <a target="_blank" href="/?comics=how-to-use-the-buzz-reader">What's a Buzz Reader!?</a>
              </p>
  
              <p class="text-muted">About the book</p>
  
              <p><?php echo $cp->getExcerpt(); ?></p>
              <p><?php echo the_content(); ?></p>
  
              <p class="text-muted">Permalink</p>
              <p>
                <a href="<?php echo get_permalink($cp->getId());?>"><?php echo get_permalink($cp->getId()); ?></a>
              </p>
  
              <p class="text-center">
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- bizzbuzz-read-top -->
                <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-1319358860215477" data-ad-slot="6070069179" data-ad-format="auto"></ins>
                <script>
                  (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
              </p>
  
              <p class="text-muted">Share</p>
              <p>
                <span class='st_sharethis_hcount' displayText='ShareThis'></span>
                <span class='st_facebook_hcount' displayText='Facebook'></span>
                <span class='st_twitter_hcount' displayText='Tweet'></span>
                <span class='st_pinterest_hcount' displayText='Pinterest'></span>
                <span class='st_googleplus_hcount' displayText='Google +'></span>
                <p></p>
              </p>
  
              <p class="text-muted">Rate this comic</p>
              <p>
                <div class="rw-ui-container"></div>
              </p>
  
              <hr/>
  
              <div class="text-center">
                <p>
                <?php if ($cp->getLicense()) : ?>
                  <?php echo $cp->getLicense(); ?>
                <?php else: ?>
                  <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-nd/4.0/88x31.png"></a><br>This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/">Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License</a>.
                <?php endif; ?>
                </p>
              </div>
            </div>
          </div> <!-- art-and-description -->

          <?php if(is_array($rels) && sizeof($rels)>0) : ?>
            <section>
              <hr>
              <div class="row">
                <div class="col-sm-12">
                  <h3>Related Comics</h3>
                </div>
              </div>
              <div class="row related-container">
                <?php foreach($rels as $rel): ?>
                  <?php 
                    $cpRel = new ComicParser($rel); 
                  ?>
                  <?php if ($rel->post_status=="publish") : ?>
                    <div class="col-sm-2" title="<?php echo $cpRel->getTitle();?>">
                      <a href="<?php echo get_permalink($cpRel->getId());?>">
                        <img class="img-responsive" src="<?php echo $cpRel->getThumbnail();?>" />
                      </a>
                      <a href="<?php echo get_permalink($cpRel->getId());?>"><?php echo $cpRel->getTitle(); ?></a>
                    </div>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
              <hr>
            </section>
          <?php endif; ?>

          <div style="clear:both"></div>
            <div class="row disqus">
              <div class="col-sm-12">
                <div id="disqus_thread"></div>
                <script type="text/javascript">
                /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
                var disqus_shortname = 'bizzbuzzcomics'; // required: replace example with your forum shortname

                /* * * DON'T EDIT BELOW THIS LINE * * */
                (function() {
                  var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                  dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                  (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                })();
                </script>
                <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
              </div>
            </div> <!-- .disqus -->

          <?php endwhile; ?>
        <?php else: ?>
            <?php get_404_template(); ?>
        <?php endif; ?>
    </div>

    <?php //get the right sidebar ?>
    <?php get_sidebar( 'right' ); ?>

</div>
<!-- end content container -->

<div id="bizzbuzz-page-cache" style="display:none;"></div>

<div id="frame">
  <div class="click-action left"></div>
  <div class="click-action right"></div>
  <div class="jaws left"></div>
  <div class="jaws top"></div>
  <div class="jaws right"></div>
  <div class="jaws bottom"></div>
  <div class="action-line-wrapper">
    <div class="action-line text-center">
      <button data-buzz-view-level="1" class="btn-change-view-level btn btn-default btn-lg pull-left">Switch to Page View</button>
      <button data-buzz-view-level="2" class="btn-change-view-level btn btn-default btn-lg pull-left" style="display:none;">Switch to Panel View</button>
      <button id="btn-turn-previous" class="btn btn-default btn-lg" title="Previous"><</button>
      <button id="btn-turn-next" class="btn btn-default btn-lg" title="Next">></button>
      <button id="btn-buzz-reader-close" class="pull-right btn btn-danger btn-lg"> X </button>
    </div>
  </div>
</div>

<?php get_footer(); ?>

<script src="<?php echo get_template_directory_uri(); ?>/buzz/js/PageManager.js"></script>
<script>
  jQuery(document).ready(function($) {
    var book = {};
    book.pages = JSON.parse(<?php echo json_encode($cp->getPagesForJs()); ?>);

    var pm = PageManager.getInstance();
    var cacheIndex = 0;
    var cachePageIndex = 0;
    var cacheEl = $("#bizzbuzz-page-cache");

    var $coverImg = $("img.cover");
    var $btnBuzzReader = $("#btn-buzz-reader");
    var $btnBuzzReaderClose = $("#btn-buzz-reader-close");
    var $btnTurnPrevious = $("#btn-turn-previous");
    var $btnTurnNext = $("#btn-turn-next");
    var $pageClickAction = $(".click-action");
    var $btnChangeViewLevel = $(".btn-change-view-level");

    var $modalFinish = $("#modal-finish");
    var $modalClose = $("#modal-finish a.modal-close");

    pm.setCallbackOnEnd(function() {
      $modalFinish.addClass("modal-show");
    });

    $modalClose.on("click", function(){
      $modalFinish.removeClass("modal-show");
      $(pm.getFrameId()).hide();
    });

    var pageCache = function(cacheSize) {
      if (!cacheSize) cacheSize = 5;

      for(var i=cacheIndex; i<cacheIndex+cacheSize; i++) {
        var page = book.pages[i];
        if (page && page.url) {
          var cachedPageId = page.url.replace(/\W+/g,"");
          // if we don't have this cached yet ...
          if (cacheEl.length && cacheEl.find("#" + cachedPageId).length === 0 ) {
            cacheEl.append('<img id="' + cachedPageId + '" src="' + page.url + '">');
          }
        }
      }
      cacheIndex+=cacheSize;
    }

    pm.setPages(book.pages);
    pm.run();

    pageCache();

    // TODO fix modal and screen resize callback
    //pm.setCallbackOnEnd($scope.modalFinish.show);
    //$(window).resize(webApp.util.datetime.debounce(pm.resetFrame,1000));
    var launchReader = function() {
      $(pm.getFrameId()).show();
    }

    $coverImg.on("click", launchReader);
    $btnBuzzReader.on("click", launchReader);

    $btnBuzzReaderClose.on("click", function(){
      $(pm.getFrameId()).hide();
    });

    $btnTurnNext.on("click", function(){
      if (pm.getPageIndex() != cachePageIndex) {
        cachePageIndex = pm.getPageIndex();
        // triggering caching on the second page (loading 5-10)
        // and after every 5 pages so we are technically
        // at least 5 ahead
        if (cachePageIndex === 2 || cachePageIndex%5 === 0) {
          pageCache();
        }
      }
      pm.goNext();
    });

    $btnTurnPrevious.on("click", function(){
      pm.goPrev();
    });

    $pageClickAction.on("click", function(e){
      if($(e.target).hasClass("left")) {
        $btnTurnPrevious.trigger("click");
      }

      if($(e.target).hasClass("right")) {
        $btnTurnNext.trigger("click");
      }
    });

    $btnChangeViewLevel.on("click", function(e){
      var $el = $(e.target);
      if ($el.length) {
        pm.setViewLevel($el.attr("data-buzz-view-level"));
        $btnChangeViewLevel.toggle();
      }
    });


  });
</script>

<!-- rating widget -->
<script type="text/javascript">(function(d, t, e, m){
    // Async Rating-Widget initialization.
    window.RW_Async_Init = function(){
    RW.init({
huid: "181829",
uid: "ca11c87f64fb906b33ef7a7ee80c4a7d",
source: "website",
options: {
"advanced": {
"layout": {
"align": {
"hor": "center",
"ver": "top"
}
},
"font": {
"hover": {
"color": "#906461"
},
"color": "#906461"
}
},
"boost": {
"rate": 2
},
  "label": {
    "background": "#FFEDA4"
  },
  "style": "oxygen1"
  }
});
RW.render();
};

// Append Rating-Widget JavaScript library.
var randomId = Math.floor(Math.random()*(+new Date()));
var rw, s = d.getElementsByTagName(e)[0], id = "rw-js-" + randomId,
    l = d.location, ck = "Y" + t.getFullYear() +
    "M" + t.getMonth() + "D" + t.getDate(), p = l.protocol,
    f = ((l.search.indexOf("DBG=") > -1) ? "" : ".min"),
    a = ("https:" == p ? "secure." + m + "js/" : "js." + m);
if (d.getElementById(id)) return;              
rw = d.createElement(e);
rw.id = id; rw.async = true; rw.type = "text/javascript";
rw.src = p + "//" + a + "external" + f + ".js?ck=" + ck;
s.parentNode.insertBefore(rw, s);
}(document, new Date(), "script", "rating-widget.com/"));</script>
