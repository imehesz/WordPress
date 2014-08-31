<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/buzz/css/style.css" />
<?php
  include( TEMPLATEPATH . '/buzz/ComicParser.php' );
  $cp = new ComicParser($post);

  echo $cp->getThumbnail();
  echo $cp->getCover();
  echo $cp->getWriter();
  echo $cp->getIllustrator();
  echo $cp->getTitle();
  echo $cp->getExcerpt();
  echo $cp->getContent();
  echo $cp->getPagesForJs();

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

<!-- start content container -->
<div class="row dmbs-content">

    <?php //left sidebar ?>
    <?php get_sidebar( 'left' ); ?>

    <div class="col-md-<?php devdmbootstrap3_main_content_width(); ?> dmbs-main">

        <?php // theloop
        if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

            <h2 class="page-header"><?php the_title() ;?></h2>
            <?php the_content(); ?>
            <?php wp_link_pages(); ?>
            <?php comments_template(); ?>

            <?php if($cp->getThumbnail()) : ?> 
              <img src="<?php echo $cp->getThumbnail(); ?>" />
            <?php endif; ?>

            <button class="btn btn-success" id="btn-buzz-reader">Launch Buzz Reader</button>

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

<div id="frame" ng-show="buzzOn">
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
<!-- <div class="fog"></div>-->

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

    var $btnBuzzReader = $("#btn-buzz-reader");
    var $btnBuzzReaderClose = $("#btn-buzz-reader-close");
    var $btnTurnPrevious = $("#btn-turn-previous");
    var $btnTurnNext = $("#btn-turn-next");
    var $pageClickAction = $(".click-action");
    var $btnChangeViewLevel = $(".btn-change-view-level");

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

    $btnBuzzReader.on("click", function(){
      $(pm.getFrameId()).show();
    });

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
