<?php
/**
 * Created by PhpStorm.
 * User: arti
 * Date: 01.07.15
 * Time: 20:55
 */

echo 'Здесь будут архивы статей';
?>

<?php get_header(); ?>

<?php get_template_part('includes/breadcrumbs', 'page'); ?>

<?php
    if(have_posts()) : while(have_posts()) : the_post();
        the_title();
        echo '<div class="entry-content">';
        the_content();
        echo '</div>';
    endwhile;
    endif;
?>

<?php get_footer(); ?>