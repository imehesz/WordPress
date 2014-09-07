    <!--
    <div class="dmbs-footer">
        <?php
            global $dm_settings;
            if ($dm_settings['author_credits'] != 0) : ?>
                <div class="row dmbs-author-credits">
                    <p class="text-center"><a href="<?php global $developer_uri; echo esc_url($developer_uri); ?>">DevDmBootstrap3 <?php _e('created by','devdmbootstrap3') ?> Danny Machal</a></p>
                </div>
        <?php endif; ?>

        <?php get_template_part('template-part', 'footernav'); ?>
    </div>
    -->

</div>

<section id="footer" class="section footer">
  <div class="container">
    <div class="row text-center copyright">
      <div class="col-sm-12">
        <p>
          <hr />
        </p>
        <p>
          <a href="https://www.facebook.com/bizzbuzzcomics">Facebook</a> -
          <a href="https://twitter.com/bizzbuzzcomics">Twitter</a> -
          <a href="http://www.pinterest.com/bizzbuzzcomics/">Pinterest</a>
        </p>
        <p>
          Copyright &copy; 2014 <a href="http://bizzbuzzcomics.com">Bizz Buzz Comics</a> -
          <a href="https://docs.google.com/document/d/1uc_juL24emg2E8n9c7htYX5FN3ihMG-g_yXvrPuT4R8">Terms and Conditions</a>
        </p>
        <p>
          <a href="http://bizzbuzzcomics.com" title="Bizz Buzz Comics.com"><img src="https://43d4888fbfad7eaa47cb1338f5932a464633e963.googledrive.com/host/0B55OYxnBow_9N3EzTXNRQzZnYjg/bizzbuzz-logo-08142.png"></div></a>
        </p>
      </div>
    </div>
  </div>
</section>
<!-- end main container -->

  <?php 
    // cheating //
    $bgArr = array(
        "https://7df183b2094d4f145c8b30e63ac113ad9805fff6.googledrive.com/host/0B55OYxnBow_9VWhzZXVybk1YUlU/01.jpg",
        "https://7df183b2094d4f145c8b30e63ac113ad9805fff6.googledrive.com/host/0B55OYxnBow_9VWhzZXVybk1YUlU/02.jpg",
        "https://7df183b2094d4f145c8b30e63ac113ad9805fff6.googledrive.com/host/0B55OYxnBow_9VWhzZXVybk1YUlU/03.jpg",
        "https://7df183b2094d4f145c8b30e63ac113ad9805fff6.googledrive.com/host/0B55OYxnBow_9VWhzZXVybk1YUlU/04.jpg",
        "https://7df183b2094d4f145c8b30e63ac113ad9805fff6.googledrive.com/host/0B55OYxnBow_9VWhzZXVybk1YUlU/05.jpg",
        "https://7df183b2094d4f145c8b30e63ac113ad9805fff6.googledrive.com/host/0B55OYxnBow_9VWhzZXVybk1YUlU/06.jpg",
    );
  ?>
  <style>
    body {
      background-image: url(<?php echo $bgArr[array_rand($bgArr)]; ?>);
    }
  </style>
<?php wp_footer(); ?>

<link rel='stylesheet' href='<?php echo get_template_directory_uri(); ?>/buzz/css/style.css' type='text/css' media='all' />

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-52628960-1', 'auto');
  ga('send', 'pageview');
</script>

</body>
</html>
