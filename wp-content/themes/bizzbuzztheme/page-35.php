<?php include( TEMPLATEPATH . '/buzz/ComicParser.php' ); ?>

<?php get_header(); ?>

<?php get_template_part('template-part', 'head'); ?>

<?php get_template_part('template-part', 'topnav'); ?>

<?php
  $args = array(
    'post_type'  => "comics",
    'meta_key'   => 'ComicStatus',
  );

  // The Query
  $the_query = new WP_Query( $args );
?>

<!-- start content container -->
<div class="row dmbs-content">

    <?php //left sidebar ?>
    <?php get_sidebar( 'left' ); ?>

    <div class="col-md-<?php devdmbootstrap3_main_content_width(); ?> dmbs-main">
      <?php if ( $the_query->have_posts() ) : ?>
        <div id="buzzCarousel" class="carousel slide" data-ride="carousel">

          <!-- Indicators -->
          <?php /*
          <ol class="carousel-indicators">
            <?php $cnt=0; while ( $the_query->have_posts() ): ?>
            <li slide-to="<?php echo $cnt; ?>" class="<?php if($cnt==0) echo "active"; ?>"></li>
            <?php $cnt++; endwhile; wp_reset_postdata(); ?>
          </ol>
          */ ?>

          <?php $the_query2 = new WP_Query( $args ); $cnt=0; while ( $the_query2->have_posts() ): ?>
            <?php $the_query2->the_post(); $cp = new ComicParser($post); ?>
            <div class="carousel-inner">
              <div class="item <?php if($cnt==$the_query2->post_count-1) echo "active"; ?>">
                <img src="<?php echo $cp->getCover(); ?>" alt="<?php echo $cp->getTitle(); ?>">
                  <div class="container">
                    <div class="carousel-caption">
                      <h1><?php echo $cp->getTitle(); ?></h1>
                      <p><?php echo $cp->getExcerpt(); ?></p>
                      <p><a class="btn btn-lg btn-success" href="<?php echo get_permalink($cp->getId()); ?>" role="button">Check it out!</a></p>
                    </div>
                  </div>
              </div>
            </div>
          <?php $cnt++; endwhile ?>

          <a class="left carousel-control" onclick="return false;" href="#buzzCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
          <a class="right carousel-control" onclick="return false;" href="#buzzCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
 
        </div>
      <?php endif; wp_reset_postdata(); ?>
    </div>

</div>
<!-- end content container -->

<?php get_footer(); ?>
