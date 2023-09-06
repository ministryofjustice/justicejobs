<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()): the_post(); ?>

    <section class="hero hero--job hero--arrows">
        <div class="hero__img-block">
            <div
                class="hero__img hero__img--desktop"
                style="background-image: url('<?php the_field('hero_desktop_image', 'option'); ?>');"
            ></div>
            <div
                class="hero__img hero__img--mobile"
                style="background-image: url('<?php the_field('hero_mobile_image', 'option'); ?>');"
            ></div>
            <div class="hero__img_description">
                <span class="text-highlight"><?php the_field('hero_image_description'); ?></span>
            </div>
            <div class="hero__text-wrap">
                <svg class="hero__arrow hero__arrow--top" width="37" height="24">
                    <use xlink:href="#icon-arrow--decor"></use>
                </svg>
                <ul class="breadcrumbs text-highlight">
                    <li><a href="<?php echo get_bloginfo('url'); ?>">Home</a></li>
                    <li>Job</li>
                </ul>
                <h1 class="heading--lg">
                    <?php // the_title(); ?>
                    <span class="text-highlight"><?php //the_field( 'role_type' );
                        $terms = wp_get_post_terms($post->ID, 'role_type', array("fields" => "all"));
                        foreach ($terms as $term) {
                            echo $term->name;
                        }

                        ?></span>
                </h1>
                <svg class="hero__arrow hero__arrow--bottom" width="37" height="24">
                    <use xlink:href="#icon-arrow--decor"></use>
                </svg>
            </div>
        </div>
    </section>

    <div class="job">
        <div class="job__wrap">
            <h2 class="heading--sm">
                <?php the_title(); ?>
                <?php
                /*
                $terms = wp_get_post_terms($post->ID, 'role_type', array("fields" => "all"));
                foreach ($terms as $term) {
                  echo $term->name;
                }
                */
                ?>
                <br/>
                <?php
                $salary_min = get_field(('salary_min'));

                if(!empty($salary_min)){
                    echo '&pound;' . number_format($salary_min);

                    $salary_max = get_field(('salary_max'));
                    $london_allowance = intval(get_field(('salary_london')));

                    if(!empty($salary_max)){
                        echo ' &ndash; &pound;' . number_format($salary_max);
                    }
                    if (!empty($london_allowance)) {
                        echo " + London weighting allowance of &pound;" . number_format($london_allowance);
                    }
                }

                $aria_label = strstr($post->post_title, ' -', true);
                $data_label = substr(strstr($post->post_title, '- '), 2, strlen($post->post_title));
                ?>
                <br/>
                <?php the_field('location'); ?>
            </h2>
            <div class="job__text-wrap">
                <header>
                    <a href="<?php the_field('application_link'); ?>" class="btn btn--blue apply-btn" target="_blank" data-id="<?= $data_label ?>" aria-label="Apply for the <?= $aria_label ?> job">Apply</a>
                    <a class="btn-back btn-back--blue back-to-search">
                        <svg width="8" height="13">
                            <use xlink:href="#icon-arrow"></use>
                        </svg>
                        BACK TO SEARCH
                    </a>
                </header>
                <div class="job__text">
                    <?php
                    the_content();
                    ?>
                    <?php
                    $salary = get_field(('salary'));
                    if (!empty($salary)) {
                    ?>
                    <h2>Salary</h2>
                    <p>
                        <span style="font-size: medium;">
                            <?php echo $salary; ?>
                        </span>
                    </p>
                    <?php } ?>
                    <h2>Additional Information</h2>
                    <?php the_field('additional_information'); ?>

                </div>
                <footer>
                    <a href="<?php the_field('application_link'); ?>" class="btn btn--blue apply-btn" target="_blank" data-id="<?= $data_label ?>" aria-label="Apply for the <?= $aria_label ?> job">Apply</a>
                    <a class="btn-back btn-back--blue back-to-search">
                        <svg width="8" height="13">
                            <use xlink:href="#icon-arrow"></use>
                        </svg>
                        BACK TO SEARCH
                    </a>
                </footer>
            </div>
        </div>
        <!-- <a href="#" class="btn-big">
          Find out more about MOJ HQ
          <svg width="14" height="26">
            <use xlink:href="#icon-arrow"></use>
          </svg>
        </a> -->
    </div>
<?php endwhile; endif; ?>

<?php get_footer(); ?>
