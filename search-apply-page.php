<?php
/*
Template Name: Search/Apply Template
*/
?>

<?php get_header(); ?>

<section class="hero hero--job hero--arrows">
    <div class="hero__img-block">
        <div
                class="hero__img hero__img--desktop"
                style="background-image: url('<?php the_field('hero_desktop_image'); ?>');"
        ></div>
        <div
                class="hero__img hero__img--mobile"
                style="background-image: url('<?php the_field('hero_mobile_image'); ?>');"
        ></div>
        <div class="hero__text-wrap">
            <svg class="hero__arrow hero__arrow--top" width="37" height="24">
                <use xlink:href="#icon-arrow--decor"></use>
            </svg>
            <ul class="breadcrumbs">
                <li><a href="<?php echo get_bloginfo('url'); ?>">Home</a></li>
                <li>Search jobs</li>
            </ul>
            <h1 class="heading--lg">
                <span class="text-highlight"><?php the_title(); ?></span>
            </h1>
            <svg class="hero__arrow hero__arrow--bottom" width="37" height="24">
                <use xlink:href="#icon-arrow--decor"></use>
            </svg>
        </div>
    </div>
</section>


<div class="search_contain">
    <div id="allLocations" data-user-location='' data-relevant-terms=''>
        <?php
        $terms = get_terms(array(
            'taxonomy' => 'job_location',
            'hide_empty' => true,
        ));
        if (!empty($terms) && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                $thisJobSite = get_field('the_job_location', $term); ?>
                <li data-name="<?php echo $term->name; ?>" data-id="<?php echo $term->term_id; ?>"
                    data-lat='<?php echo $thisJobSite['lat']; ?>' data-lng='<?php echo $thisJobSite['lng']; ?>'></li>
            <?php }
        }
        ?>
    </div>
    <div class="filter">
        <form action="#" id="search-form">
            <fieldset class="filter__fieldset">
                <legend class="heading--sm">Refine by:</legend>

                <label for="keyword" class="screen-reader-text">Keyword</label>
                <input aria-label="Keyword" type="text" class="input" placeholder="Keyword" name="keyword" id="keyword"
                       value=""/>
                <label for="role-type" class="screen-reader-text">Roles</label>
                <span class="filter__label">Roles</span>
                <div class="select-list">
                    <?php
                    $terms = get_terms(array(
                        'taxonomy' => 'role_type',
                        'hide_empty' => true,
                    ));

                    $options = jj_select_options(null, 'role type');

                    ?>
                    <select class="select" id="role-type" <?= $options['title'] ?>>
                        <?= $options['list'] ?>
                    </select>
                </div>
                <span class="filter__label">Location</span>
                <label for="location" class="screen-reader-text">Location</label>
                <input id="location" aria-label="Location" name="location" type="text" class="input"
                       placeholder="City / Postcode" value=""/>
                <div class="select-list" data-miles="0">
                    <label for="radius" class="screen-reader-text">Radius (in miles)</label>
                    <select disabled class="select" id="radius"
                            aria-label="Radius (in miles)">
                        <option value="0" disabled selected>Radius (in miles)</option>
                        <option value="5">5 Miles</option>
                        <option value="10">10 Miles</option>
                        <option value="25">25 Miles</option>
                        <option value="50">50 Miles</option>
                        <option value="100">100 miles</option>
                    </select>
                </div>
                <span class="filter__label">Salary</span>
                <div class="select-list">
                    <label for="salary-min" class="screen-reader-text">Salary</label>
                    <select class="select" id="salary-min" aria-label="Salary Minimum">
                        <option disabled selected>Salary</option>
                        <option value="0">All</option>
                        <option value="20000">£20,000+</option>
                        <option value="30000">£30,000+</option>
                        <option value="40000">£40,000+</option>
                        <option value="50000">£50,000+</option>
                        <option value="60000">£60,000+</option>
                    </select>
                </div>
                <span class="filter__label">Working pattern</span>
                <div class="select-list">
                    <?php
                    $terms = get_terms(array(
                        'taxonomy' => 'working_pattern',
                        'hide_empty' => true,
                    ));

                    $options = jj_select_options(null, 'working pattern', true);

                    ?>
                    <label for="working-pattern" class="screen-reader-text">Working pattern</label>
                    <select class="select" id="working-pattern">
                        <?= $options['list'] ?>
                    </select>
                </div>
                <button class="btn btn--dark-blue search-page-link ga-main-form-button" role="button" type="submit">
                    Search
                    jobs
                </button>
                <div class="btn-reset-button-contain">
                    <button class="btn-reset" id="reset" type="reset">Reset form</button>
                </div>
            </fieldset>
        </form>
    </div>
    <div class="search_contain__wrap">

        <header>

            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

            $args = array(
                'post_type' => 'job',
                'posts_per_page' => 10,
                'paged' => $paged
            );
            $job_query = new WP_Query($args);

            if ($job_query->have_posts()) {

            $pagenum = $job_query->query_vars['paged'] < 1 ? 1 : $job_query->query_vars['paged'];
            $first = (($pagenum - 1) * $job_query->query_vars['posts_per_page']) + 1;
            $last = $first + $job_query->post_count - 1;
            echo "<span class='search_contain__results search_contain__results--live'>Showing <b>" . $first . " - " . $last . "</b> of <b>" . "$job_query->found_posts" . "</b> job results</span>";
            ?>
            <div class="pagination">
                <?php

                $big = 999999999; // need an unlikely integer
                echo paginate_links(array(
                    'base' => str_replace($big, '%#%', get_pagenum_link($big)),
                    'format' => '?paged=%#%',
                    'mid_size' => 2,
                    'current' => max(1, get_query_var('paged')),
                    'total' => $job_query->max_num_pages,
                    'prev_text' => '<span class="screen-reader-text">' . __('Search results - previous page',
                            'justicejobs') . '</span><span aria-hidden="true">' . __('PREV', 'justicejobs') . '</span>',
                    'next_text' => '<span class="screen-reader-text"> ' . __('Search results',
                            'justicejobs') . ' -  </span>' . __('NEXT',
                            'justicejobs') . ' <span class="screen-reader-text">' . __('page',
                            'justicejobs') . '</span>',
                    'before_page_number' => '<span class="screen-reader-text">' . __('Search results - page',
                            'justicejobs') . '</span>',
                    'after_page_number' => '<span class="screen-reader-text"> ' . __(' of ',
                            'justicejobs') . __($job_query->max_num_pages) . '</span>'
                ));
                ?>
            </div>


            <div class="search_contain__controls">
                <p>VIEW BY</p>
                <button class="search_contain__label search_contain__label--list" aria-pressed="true"
                        aria-controls="jj-search-results-view">
                    <span class="screen-reader-text">View search results as a </span> LIST
                    <svg width="28" height="28">
                        <use xlink:href="#icon-list"></use>
                    </svg>
                </button>
                <button class="search_contain__label search_contain__label--map" aria-pressed="false"
                        aria-controls="jj-search-results-view">
                    <span class="screen-reader-text">View search results as a </span>MAP
                    <svg width="17" height="24">
                        <use xlink:href="#icon-marker"></use>
                    </svg>
                </button>
            </div>

        </header>
        <div class="search_contain__container" id="js-hide-map">
            <div class="search_contain__list-wrap">
                <table class="search_contain__list" id="jj-search-results-view" role="region" aria-live="polite">
                    <caption class="screen-reader-text">Job search results</caption>
                    <thead>
                    <tr class="search_contain__heading">
                        <th scope="col">ROLE</th>
                        <th scope="col">LOCATION</th>
                        <th scope="col">SALARY</th>
                        <th scope="col">WORKING PATTERN</th>
                        <th scope="col">VIEW JOB</th>
                    </tr>
                    </thead>
                    <?php
                    while ($job_query->have_posts()) {
                        $job_query->the_post();
                        ?>

                        <tr class="search_contain__item" id="<?= 'job-listing-' . $post->ID ?>">
                            <td>
                                <p><?php the_title(); ?></p>
                            </td>
                            <td>
                                <p><?php the_field('location'); ?></p>
                            </td>
                            <td>
                                <p>
                                    <?php
                                    $salary_min = get_field('salary_min');

                                    if(!empty($salary_min)){
                                        echo '&pound;' . number_format($salary_min);

                                        $salary_max = get_field('salary_max');

                                        if(!empty($salary_max)){

                                            echo ' - &pound;' . number_format($salary_max);

                                        }
                                        $london_allowance = number_format(intval(get_field('salary_london')));
                                        if (!empty($london_allowance)) {
                                            echo "<br /> + &pound;$london_allowance LWA";
                                        }
                                    }
                                    ?>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <?php
                                    $working_pattern_copy = '';
                                    $terms = wp_get_post_terms($post->ID, 'working_pattern', array("fields" => "all"));
                                    foreach ($terms as $term) {
                                        $working_pattern_copy = $working_pattern_copy . $term->name . ', ';
                                    }
                                    echo substr($working_pattern_copy, 0, -2);
                                    ?>
                                </p>
                            </td>
                            <td>
                                <?php
                                $jj_view_label = strstr(get_the_title(), ' &#8211;', true);
                                ?>
                                <a href="<?php the_permalink(); ?>"
                                   class="btn btn--blue btn--small"
                                   aria-label="View the job description for <?= $jj_view_label ?: get_the_title() ?>">View</a>
                            </td>
                            <?php

                            $terms = wp_get_post_terms($post->ID, 'job_location', array("fields" => "all"));
                            foreach ($terms as $term) {
                                $thisJobSite = get_field('the_job_location', $term);
                                ?>
                                <td class="marker" style="height:0; width: 0;" data-url="<?php the_permalink(); ?>"
                                    data-id="<?php the_ID(); ?>" data-lat="<?php echo $thisJobSite['lat']; ?>"
                                    data-lng="<?php echo $thisJobSite['lng']; ?>"
                                    data-title="<?php echo get_the_title(); ?>"></td>
                            <?php } ?>
                        </tr>

                        <?php
                    }
                    ?>

                    <?php

                    }
                    wp_reset_postdata();

                    ?>


                </table>
            </div>

            <div class="search_contain__map-wrap">
                <div
                        class="map"
                        id="map"
                        data-zoom="14"
                        style="width: 100%; height: 100%;"
                >
                </div>
            </div>
        </div>

        <footer>
            <div class="pagination">
                <?php

                $big = 999999999; // need an unlikely integer
                echo paginate_links(array(
                    'base' => str_replace($big, '%#%', get_pagenum_link($big)),
                    'format' => '?paged=%#%',
                    'mid_size' => 2,
                    'current' => max(1, get_query_var('paged')),
                    'total' => $job_query->max_num_pages,
                    'prev_text' => '<span class="screen-reader-text">' . __('Search results - previous page',
                            'justicejobs') . '</span><span aria-hidden="true">' . __('PREV', 'justicejobs') . '</span>',
                    'next_text' => '<span class="screen-reader-text"> ' . __('Search results',
                            'justicejobs') . ' -  </span>' . __('NEXT',
                            'justicejobs') . ' <span class="screen-reader-text">' . __('page',
                            'justicejobs') . '</span>',
                    'before_page_number' => '<span class="screen-reader-text">' . __('Search results - page',
                            'justicejobs') . '</span>',
                    'after_page_number' => '<span class="screen-reader-text"> ' . __(' of ',
                            'justicejobs') . __($job_query->max_num_pages) . '</span>'
                ));
                ?>
            </div>
        </footer>
    </div>
</div>


<?php get_footer(); ?>
