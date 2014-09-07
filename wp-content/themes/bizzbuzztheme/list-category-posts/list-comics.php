<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

<div class="row">
  <div class="col-md-12">
    <script>
      (function() {
       var cx = '001043702482000574187:fblpe9q0pqi';
       var gcse = document.createElement('script');
       gcse.type = 'text/javascript';
       gcse.async = true;
       gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
       '//www.google.com/cse/cse.js?cx=' + cx;
       var s = document.getElementsByTagName('script')[0];
       s.parentNode.insertBefore(gcse, s);
       })();
    </script>
    <gcse:search></gcse:search>
  </div>
</div>


<?php

  include( TEMPLATEPATH . '/buzz/ComicParser.php' );

/**
 * The format for templates changed since version 0.17.
 * Since this code is included inside CatListDisplayer, $this refers to
 * the instance of CatListDisplayer that called this file.
 */

/* This is the string which will gather all the information.*/
$lcp_display_output = '';
$cnt = 0;
$randAd = array(
  rand(0,3),
  rand(4,18),
  rand(5,18)
);

// Show category link:
$lcp_display_output .= $this->get_category_link('strong');

//Add 'starting' tag. Here, I'm using an unordered list (ul) as an example:
$lcp_display_output .= '<div class="row"><div class="col-md-12">';

/**
 * Posts loop.
 * The code here will be executed for every post in the category.
 * As you can see, the different options are being called from functions on the
 * $this variable which is a CatListDisplayer.
 *
 * The CatListDisplayer has a function for each field we want to show.
 * So you'll see get_excerpt, get_thumbnail, etc.
 * You can now pass an html tag as a parameter. This tag will sorround the info
 * you want to display. You can also assign a specific CSS class to each field.
 */
foreach ($this->catlist->get_categories_posts() as $single){
  $cp = new ComicParser($single);

  //Start a List Item for each post:
  $lcp_display_output .= "<div class='books-book-wrapper col-lg-3 col-md-4 portfolio-item'>";

  $lcp_display_output .= "<div class='books-book-image-wrapper'>";

  $lcp_display_output .= "<a href='" . get_permalink($cp->getId()) ."' class='thumbnail'><img class='img-responsive' src='" . $cp->getThumbnail() ."'></a>";

  //Show the title and link to the post:
  $lcp_display_output .= "<h3>" . $this->get_post_title($single) . "</h3>";

  $lcp_display_output .= "<p>" . $cp->getExcerpt() . "</p>";

  //Show comments:
  // $lcp_display_output .= $this->get_comments($single);

  //Show date:
  // $lcp_display_output .= ' ' . $this->get_date($single);

  //Show author
  // $lcp_display_output .= $this->get_author($single);

  //Custom fields:
  // $lcp_display_output .= $this->get_custom_fields($this->params['customfield_display'], $single->ID);

  //Post Thumbnail
  // $lcp_display_output .= $this->get_thumbnail($single);

  /**
   * Post content - Example of how to use tag and class parameters:
   * This will produce:<p class="lcp_content">The content</p>
   */
  // $lcp_display_output .= $this->get_content($single, 'p', 'lcp_content');

  /**
   * Post content - Example of how to use tag and class parameters:
   * This will produce:<div class="lcp_excerpt">The content</div>
   */
  // $lcp_display_output .= $this->get_excerpt($single, 'div', 'lcp_excerpt');

  $lcp_display_output .= '</div>';
  //Close li tag
  $lcp_display_output .= '</div>';

  if($cnt==$randAd[0] || $cnt==$randAd[1] || $cnt==$randAd[2]){
    $lcp_display_output .= "<div class='books-book-wrapper col-lg-3 col-md-4 portfolio-item'>";
    $lcp_display_output .= "<div class='books-book-image-wrapper'>";
      $lcp_display_output .= <<<ADHERE
        <!-- bizzbuzz-read-top -->
        <ins class="adsbygoogle"
        style="display:block"
        data-ad-client="ca-pub-1319358860215477"
        data-ad-slot="6070069179"
        data-ad-format="auto"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
ADHERE;
    $lcp_display_output .= "</div></div>";
  }

  $cnt++;
}

$lcp_display_output .= '</div></div>';

// If there's a "more link", show it:
$lcp_display_output .= $this->catlist->get_morelink();

//Pagination
$lcp_display_output .= $this->get_pagination();

$this->lcp_output = $lcp_display_output;
