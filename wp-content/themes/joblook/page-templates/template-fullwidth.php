<?php
/**
 *
 * Template Name: Fullwidth Template

 *
 * @package Joblook
 */
get_header();
?>
<div class="full-width section-spacing">
  <div class="container">
  <div class="row">
      <div class="col-md-12">
<?php if ( have_posts() ) : ?>

<?php while ( have_posts() ) : ?>
  <?php the_post(); ?>
    <?php the_content();?>
<?php endwhile;

endif; ?>
</div>
</div>
</div>
</div>


<?php

get_footer();
