/*----- Field -----*/

<?php the_field(''); ?>


<?php if (get_field('')): ?>
<?php endif; ?>

/*----- Repeater -----*/

<?php $i = 0;
if (have_rows('slider')): ?>

    <?php while (have_rows('slider')): the_row();

        // vars
        $title = get_sub_field('title');
        $image = get_sub_field('image');
        ?>


        <?php if ($i == 0) {
            echo 'active';
        } ?>

        <?php echo $title; ?>
        <?php echo $image['url']; ?>


        <?php $i++; endwhile; ?>

<?php endif; ?>


/*----- Shortcode -----*/


<?php echo do_shortcode(''); ?>

/*----- Part -----*/

<?php get_template_part('templates/content', 'page'); ?>


/*----- Post Query -----*/


<?php

$args = array(
    'order' => 'DESC',
    'orderby' => 'date',
    'posts_per_page' => 1,
);

$the_query = new WP_Query($args);

if ($the_query->have_posts()) :
    while ($the_query->have_posts()) : $the_query->the_post();
        ?>
        <?php echo the_post_thumbnail_url(); ?>

        <?php the_category(); ?>

        <?php the_title(); ?>

        <?php
        echo wp_trim_words(get_the_content(), 10, '...');
        ?>

        <?php the_permalink(); ?>


    <?php endwhile; endif; wp_reset_query(); ?>


/*----- Relationship Query -----*/


<?php

$relatedPosts = get_field('');

if ($relatedPosts): ?>
    <?php foreach ($relatedPosts as $relatedPost): // variable must NOT be called $post (IMPORTANT) ?>

        <?php echo get_the_title($relatedPost->ID); ?>
        <?php the_field('', $relatedPost->ID); ?>
        <?php echo get_permalink($relatedPost->ID); ?>

        <?php echo get_the_post_thumbnail_url($relatedPost->ID); ?>

    <?php endforeach; ?>
    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
<?php endif; ?>