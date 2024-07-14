<?php
/**
 * Template One Post
 *
 */
?>
<?php 
    $imagePost = get_the_post_thumbnail_url(get_the_ID(),'thumbnail');
    if (empty($imagePost)) {
        $imagePost = plugins_url( (new Last_Post_Display())->getPluginName() . '/public/img/lpd-no-image.jpg' );
    }
?>
<div class="lpd__item">
    <a class="lpd__item-image" href="<?php the_permalink( get_the_ID() )?>"><img src="<?= $imagePost ?>" alt="<?php get_the_title(get_the_ID()); ?>"></a>
    <div class="lpd__item-content">
        <a class="lpd__item-title" href="<?php the_permalink( get_the_ID() )?>"><?= get_the_title(get_the_ID()); ?></a>
        <div class="lpd__item-desc"><?= get_the_content('', '', get_the_ID()); ?></div>
        <div class="lpd__item-more"><a href="<?php the_permalink( get_the_ID() )?>"><?php _e('Show more'); ?></a></div>
    </div>    
</div>