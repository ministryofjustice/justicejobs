<?php
/**
 * Customised log-in page
 */

function my_login_logo() {
?>
    <style type="text/css">
    /* Add fonts */
    @font-face {
      font-family: 'Barlow';
      src: url('<?php echo get_template_directory_uri();?>/fonts/Barlow-Light.woff2') format('woff2'),
        url('<?php echo get_template_directory_uri();?>/fonts/Barlow-Light.woff') format('woff'),
        url('<?php echo get_template_directory_uri();?>/fonts/Barlow-Light.ttf') format('truetype');
      font-weight: 300;
      font-style: normal;
    }

    @font-face {
      font-family: 'Barlow';
      src: url('<?php echo get_template_directory_uri();?>/fonts/Barlow-Regular.woff2') format('woff2'),
        url('<?php echo get_template_directory_uri();?>/fonts/Barlow-Regular.woff') format('woff'),
        url('<?php echo get_template_directory_uri();?>/fonts/Barlow-Regular.ttf') format('truetype');
      font-weight: normal;
      font-style: normal;
    }

    @font-face {
      font-family: 'Barlow';
      src: url('<?php echo get_template_directory_uri();?>/fonts/Barlow-Medium.woff2') format('woff2'),
        url('<?php echo get_template_directory_uri();?>/fonts/Barlow-Medium.woff') format('woff'),
        url('<?php echo get_template_directory_uri();?>/fonts/Barlow-Medium.ttf') format('truetype');
      font-weight: 500;
      font-style: normal;
    }

    @font-face {
      font-family: 'Barlow';
      src: url('<?php echo get_template_directory_uri();?>/fonts/Barlow-Bold.woff2') format('woff2'),
        url('<?php echo get_template_directory_uri();?>/fonts/Barlow-Bold.woff') format('woff'),
        url('<?php echo get_template_directory_uri();?>/fonts/Barlow-Bold.ttf') format('truetype');
      font-weight: bold;
      font-style: normal;
    }

    @font-face {
      font-family: 'Barlow';
      src: url('<?php echo get_template_directory_uri();?>/fonts/Barlow-SemiBold.woff2') format('woff2'),
        url('<?php echo get_template_directory_uri();?>/fonts/Barlow-SemiBold.woff') format('woff'),
        url('<?php echo get_template_directory_uri();?>/fonts/Barlow-SemiBold.ttf') format('truetype');
      font-weight: 600;
      font-style: normal;
    }


    #login h1 a, .login h1 a {
        background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/img/logo--white.png);
                    height:auto;
                    width:320px;
                    background-size: contain;
                    background-repeat: no-repeat;
        padding-bottom: 50px;
    }
    body.login {
        /* background-color: #00b1eb; */
        background-color: #000;
        font-family: Barlow, Arial, sans-serif;
    }
    body.login form {
      box-shadow: inset 0 1px 3px 0 rgba(0,0,0,.5), 0 18px 53px 0 rgba(0,0,0,.17);
        /* background: rgb(229, 0, 80); */
        /* box-shadow: 0 5px 30px 0 rgba(255, 255, 255, 0.17); */
    }

    body.login form label {
      font-size: 17px !important;
      color: #000;
    }
    body.login form label[for="rememberme"] {
      font-size: 14px !important;
    }

    body.login form input[type="text"],
    body.login form input[type="password"] {
       padding: 15px 18px;
       width: 100%;
       height: 50px;
       font-size: 1.7rem;
       letter-spacing: 0.15px;
       line-height: 18.7px;
       background: #fff;
       border: 1px solid #d9d9d9;
       border-radius: 3px;
        /* background: #fff !important; */
    }
    body.login form input[type="checkbox"] {
      border-radius: 3px;
    }
    body.login form input[type="submit"] {
      margin-top: 40px !important;
      padding: 14px 30px !important;
      height: 20px !important;
      min-height: 50px;
      min-width: 188px;
      display: inline-flex !important;
      align-items: center;
      justify-content: center;
      color: #ffffff;
      /* color: #000; */
      font-family: Barlow, Arial, sans-serif;
      font-size: 18px;
      font-weight: 600;
      letter-spacing: 0.16px;
      line-height: 18px !important;
      text-transform: uppercase;
      text-shadow: none;
      text-align: center;
      border-radius: 3px;
      border: 1px solid #000 !important;
      /* border: 1px solid #00b1eb; */
      /* background-color: #00b1eb; */
      background-color: #000 !important;
      /* background-color: rgb(255, 255, 255); */
      box-shadow: 0 17px 15px -5px #d9d9d9 !important;
      /* box-shadow: 0 17px 15px -5px rgba(0,177,235,.3) !important; */
      /* box-shadow: 0 17px 15px -5px rgba(#00b1eb, 0.3); */

      cursor: pointer;

    }
    body.login form input[type="submit"]:hover {
      /* color: #00b1eb;
      border-color: #00b1eb !important; */
      color: #000 !important;
      border-color: #000 !important;
      background-color: #fff !important;
    }
    .login #backtoblog a, .login #nav a {
        color: #fff !important;
        transition: color 0.4s ease;
    }
    .login #backtoblog a:hover, .login #nav a:hover, .login h1 a:hover {
        color: #fff !important;
    }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

// ACF Google Maps API
function my_acf_init() {

    $map_key = get_field( 'google_maps_api_key_location_lookup', 'option' );

    if(strlen($map_key) > 0) {
        acf_update_setting('google_api_key', $map_key);
    }
}

add_action('acf/init', 'my_acf_init');

?>
