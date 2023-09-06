</main>
<footer class="page-footer container">
  <div class="page-footer__col">
    <a class="page-footer__logo" href="<?php bloginfo('url');?>" aria-label="Back to Home">
      <span class="screen-reader-text">Back to Home</span>
      <img
        src="<?php echo esc_url( get_template_directory_uri() ); ?>/dist/img/logo--white.svg"
        width="215"
        height="31"
        alt="Ministry of Justice Logo - this takes the user back to the homepage"
        aria-hidden="true"
      />
    </a>
    <nav class="page-footer__nav">
      <?php

        $defaults_footer = array(
          'container' => false,
          'theme_location'  => 'footer-menu',
          // 'menu_class' => 'page-header__nav'
        );

        wp_nav_menu( $defaults_footer );

      ?>
      <p class="page-footer__copyright page-footer__copyright--desktop">
        © Ministry of Justice <?php echo date ( 'Y' );?>
      </p>
    </nav>
  </div>
  <div class="page-footer__col">
    <div class="page-footer__crown-wrap">
      <img
        src="<?php echo esc_url( get_template_directory_uri() ); ?>/dist/img/logo--footer.svg"
        width="63"
        height="52"
        alt=""
        aria-hidden="true"
      />
      <p>© Crown copyright</p>
    </div>
    <p class="page-footer__copyright page-footer__copyright--mobile">
      © Ministry of Justice <?php echo date ( 'Y' );?>
    </p>
  </div>
  <?php
    $menu = wp_get_nav_menu_object( 'Footer Menu' );
    $linkedin_link = get_field('linkedin_link', $menu);
    $facebook_link = get_field('facebook_link', $menu);
  ?>
  <ul class="social">
    <li>
      <a href="<?php echo $facebook_link; ?>" aria-label="Link to Facebook" target="_blank">
        <span class="screen-reader-text">Link to Facebook</span>
        <svg width="30" height="30" aria-hidden="true">
          <use xlink:href="#icon-facebook"></use>
        </svg>
      </a>
    </li>
    <li>
      <a href="<?php echo $linkedin_link; ?>" aria-label="Link to LinkedIn" target="_blank">
        <span class="screen-reader-text">Link to LinkedIn</span>
        <svg width="30" height="30" aria-hidden="true">
          <use xlink:href="#icon-linkedin"></use>
        </svg>
      </a>
    </li>
  </ul>
</footer>

<?php
$map_key = get_field( 'google_maps_api_key', 'option' );

if(strlen($map_key) > 0) {
?>
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $map_key; ?>&libraries=places&libraries=geometry"></script>
<?php } ?>
<?php wp_footer(); ?>
</body>
</html>
