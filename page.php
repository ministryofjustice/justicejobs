<?php get_header(); ?>

<section class="hero hero--agency">
  <div class="hero__img-block">
    <div
      class="hero__img hero__img--desktop"
      style="background-image: url('<?php the_field( 'page_hero_desktop_image' ); ?>');"
    ></div>
    <div
      class="hero__img hero__img--mobile"
      style="background-image: url('<?php the_field( 'page_hero_mobile_image' ); ?>');"
    ></div>
    <div class="hero__img_description">
        <span class="text-highlight"><?php the_field('hero_image_description'); ?></span>
    </div>
    <div class="hero__text-wrap">
      <svg class="hero__arrow hero__arrow--top" width="37" height="24">
        <use xlink:href="#icon-arrow--decor"></use>
      </svg>
      <ul class="breadcrumbs text-highlight">
        <li><a href="<?php echo get_bloginfo( 'url' ); ?>">Home</a></li>
        <li><?php echo the_field( 'page_category' ); ?></li>
      </ul>
      <h1 class="heading--lg"><span class="text-highlight"><?php the_title(); ?></span></h1>
      <svg class="hero__arrow hero__arrow--bottom" width="37" height="24">
        <use xlink:href="#icon-arrow--decor"></use>
      </svg>
    </div>
  </div>
</section>

<div class="page-content">
    <div class="page-content__wrap">
      <?php the_field('page_content'); ?>

        <?php
        $add_link = get_field( 'add_link' );
        if( $add_link == 1 ):
            $link = get_field( 'find-out-more_link' );
            if( $link ):
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
                ?>
                <a href="<?php echo esc_url($link_url); ?>" class="btn-big btn-big--green"
                   target="<?php echo esc_attr($link_target); ?>"
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
