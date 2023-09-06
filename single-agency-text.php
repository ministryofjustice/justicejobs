<?php
/*
Template Name: Agency Text Template
Template Post Type: page, agency
*/
?>

<?php get_header(); ?>

<section class="hero hero--agency">
    <div class="hero__img-block">
        <div
            class="hero__img hero__img--desktop"
            style="background-image: url('<?php the_field('agency_hero_desktop_image'); ?>');"
        ></div>
        <div
            class="hero__img hero__img--mobile"
            style="background-image: url('<?php the_field('agency_hero_mobile_image'); ?>');"
        ></div>
        <div class="hero__img_description">
            <span class="text-highlight"><?php the_field('agency_hero_image_description'); ?></span>
        </div>
        <div class="hero__text-wrap">
            <svg class="hero__arrow hero__arrow--top" width="37" height="24">
                <use xlink:href="#icon-arrow--decor"></use>
            </svg>
            <ul class="breadcrumbs text-highlight">
                <li><a href="<?php echo get_bloginfo('url'); ?>">Home</a></li>
                <li><?php echo strip_tags(get_the_title()); ?></li>
            </ul>
            <h1 class="heading--lg"><?php the_title(); ?></h1>
            <svg class="hero__arrow hero__arrow--bottom" width="37" height="24">
                <use xlink:href="#icon-arrow--decor"></use>
            </svg>
        </div>
        <div class="hero__badge">
            <img
                src="<?php echo get_field('agency_logo_black'); ?>"
                width="164"
                height="77"
                alt="<?php echo strip_tags(get_the_title()) ?>"
            />
        </div>
    </div>
    <!-- <div class="hero__search hero__search--agency">
      <h2 class="heading--sm">Roles at HMCTS</h2>
      <button class="btn btn--green btn--full">Search jobs</button>
    </div> -->
</section>

<div class="agency">
    <div class="agency__col">
        <div class="agency__text">
            <?php the_field('agency_content'); ?>
        </div>
        <?php
        $add_link = get_field('add_link');
        if ($add_link == 1):
            $link = get_field('find-out-more_link');
            if ($link):
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
                ?>
                <a href="<?php echo esc_url($link_url); ?>" class="btn-big btn-big--green"
                   target="<?php echo esc_attr($link_target); ?>"
                   style="background-color: <?php echo get_field('agency_colour'); ?>"
                >
                    Find out more about <?php echo $link_title; ?>
                    <svg width="14" height="26">
                        <use xlink:href="#icon-arrow"></use>
                    </svg>
                </a>
            <?php endif; endif; ?>
    </div>
</div>


<?php get_footer(); ?>
