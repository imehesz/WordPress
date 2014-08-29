<?php
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

<?php 
  $a ="aaa";
  // defaults
  $cover = "";
  $thumbnail = "";

  // parsing meta
  // images
  $images = get_post_meta( $post->ID, 'images', true ); 
  if (sizeof($images)>0) {
    $cover = $images[0]["cover"];
    $thumbnail = $images[0]["thumbnail"];
  }

  $pages_meta = get_post_meta($post->ID, "Pages", true);
  $pages = Array();
  if (sizeof($pages_meta)>0) {
    foreach($pages_meta as $page) {
      $url = $page["url"];
      $coordinates = explode("\n",$page["coordinates"]);
      array_push($pages, array(
        "url" => $url,
        "coordinates" => $coordinates
      ));
    }
  }
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

            <?php if($cover) : ?> 
              <img src="<?php echo $thumbnail; ?>" />
            <?php endif; ?>

        <?php endwhile; ?>
        <?php else: ?>

            <?php get_404_template(); ?>

        <?php endif; ?>

    </div>

    <?php //get the right sidebar ?>
    <?php get_sidebar( 'right' ); ?>

</div>
<!-- end content container -->

<?php get_footer(); ?>
<script>
  pages = [];
  jQuery(document).ready(function($) {
   // Inside of this function, $() will work as an alias for jQuery()
   // and other libraries also using $ will not be accessible under this shortcut
    window.pages = <?php echo json_encode($pages); ?>;
  });
</script>
