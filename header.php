<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package teamtakaros
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<!-- font awesome -->
    <script src="https://kit.fontawesome.com/d495971c43.js" crossorigin="anonymous"></script>

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<header class="header site-header">
        <div class="top-header">

        </div>
        <div class="header-wraper">
            <div class="logo">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/imgs/logo.jpg" alt="" class="logo-img">
                <div class="tagline">
                    <h1>TEAM <span class="emf">TAKAROS</span></h1>
                    <p>CAR AUDIO & CUSTOM INTERIORS</p>
                </div>
            </div>

            <nav class="main-nav">
                <ul class="main-menu">
                    <li><a href="#services">Υπηρεσίες</a></li>
                    <li><a href="#ourwork">Η δουλειά μας</a></li>
                    <li><a href="#about-us">Σχετικά με εμάς</a></li> 
                    <li><a href="">Επικοινωνία</a></li>
                </ul>
            </nav>

            <div class="contact-info">
                <p><i class="fa-solid fa-phone"></i>+30 698 479 5793</p>
            </div>

        </div>
        
    </header>