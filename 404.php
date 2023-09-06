<?php get_header(); ?>

  <section class="hero hero__404">
    <div class="hero__img-block">
      <div
        class="hero__img hero__img--desktop"
        style="background-image: url('<?php the_field( 'hero_desktop_image', 5 ); ?>');"
      ></div>
      <div
        class="hero__img hero__img--mobile"
        style="background-image: url('<?php the_field( 'hero_mobile_image', 5 ); ?>');"
      ></div>
      <div class="hero__img_description">
        <?php the_field( 'hero_image_description' ); ?>
      </div>
      <div class="hero__text-wrap">
        <svg class="hero__arrow hero__arrow--top" width="37" height="24">
          <use xlink:href="<?php echo esc_url( get_template_directory_uri() ); ?>/img/icon-arrow--decor"></use>
        </svg>
        <h1 class="heading--lg">Page not found</h1>
        <p>
          If you entered a web address please check it was correct.<br>
          You can <a href="<?php bloginfo('url');?>">browse from the homepage</a> to find the information you need.
        </p>
        <svg class="hero__arrow hero__arrow--bottom" width="37" height="24">
          <use xlink:href="<?php echo esc_url( get_template_directory_uri() ); ?>/img/icon-arrow--decor"></use>
        </svg>
      </div>
    </div>
  </section>

<?php get_footer(); ?>
