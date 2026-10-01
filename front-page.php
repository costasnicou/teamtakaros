<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package teamtakaros
 */

get_header();
?>

    <main id="main" class="main">
        <div  class="cover">
            <p class="slogan"><?php echo esc_html( teamtakaros_content( 'hero', 'slogan' ) ); ?></p>
            <hgroup class="main-hgroup">
                <h2><?php echo teamtakaros_sanitize_inline_content( teamtakaros_content( 'hero', 'heading' ) ); ?></h2>
                <h3><?php echo teamtakaros_sanitize_inline_content( teamtakaros_content( 'hero', 'subheading' ) ); ?></h3>
            </hgroup>
           

            <div class="cover-cta">
                <p><?php echo teamtakaros_sanitize_inline_content( teamtakaros_content( 'hero', 'description' ) ); ?></p>
                <a href="#contact-us" class="cover-cta-btn"><?php echo esc_html( teamtakaros_content( 'hero', 'button' ) ); ?></a>
            </div>

            <p class="passion"><?php echo esc_html( teamtakaros_content( 'hero', 'passion' ) ); ?></p>
            <p class="cover-location"><?php echo esc_html( teamtakaros_content( 'hero', 'location' ) ); ?></p>
        </div>
        <div class="services-overview">
            <div class="wraper">

            
                <p>ΗΧΟΣΥΣΤΗΜΑΤΑ</p>
                <p class="dot">/</p>
                <p>ΤΑΠΕΤΣΑΡΙΕΣ</p>
                <p class="dot">/</p>
                <p>ΑΝΤΗΛΙΑΚΕΣ ΜΕΜΒΡΑΝΕΣ</p>
                <p class="dot">/</p>
                <p>ΒΙΟΛΟΓΙΚΟΙ ΚΑΘΑΡΙΣΜΟΙ</p>
            </div>
        </div>

        <section class="services-detail" id="services">
            <div class="wraper">
                <div class="intro-article">
                    <div class="flex">
                        <div class="flex-left">
                            <p class="par-intro"><?php echo esc_html( teamtakaros_content( 'services', 'intro' ) ); ?></p>
                            <h2><?php echo esc_html( teamtakaros_content( 'services', 'heading' ) ); ?></h2>
                        </div>

                        <div class="flex-right">
                             <p class="par-brand"><?php echo teamtakaros_sanitize_inline_content( teamtakaros_content( 'services', 'description' ) ); ?></p>
                        </div>

                    </div>
                 
                   
                </div>

                <div class="services">

                    <div class="service">
                        <span class="num">01</span>
                        <p class="en-title"><?php echo esc_html( teamtakaros_content( 'services', 'service_1_english' ) ); ?></p>
                        <h3 class="gr-title"><?php echo esc_html( teamtakaros_content( 'services', 'service_1_title' ) ); ?></h3>
                        <p class="gr-desc"><?php echo esc_html( teamtakaros_content( 'services', 'service_1_description' ) ); ?></p>

                    </div>

                    <div class="service">
                        <span class="num">02</span>
                        <p class="en-title"><?php echo esc_html( teamtakaros_content( 'services', 'service_2_english' ) ); ?></p>
                        <h3 class="gr-title"><?php echo esc_html( teamtakaros_content( 'services', 'service_2_title' ) ); ?></h3>
                        <p class="gr-desc"><?php echo esc_html( teamtakaros_content( 'services', 'service_2_description' ) ); ?></p>
                        
                    </div>

                    <div class="service">
                        <span class="num">03</span>
                        <p class="en-title"><?php echo esc_html( teamtakaros_content( 'services', 'service_3_english' ) ); ?></p>
                        <h3 class="gr-title"><?php echo esc_html( teamtakaros_content( 'services', 'service_3_title' ) ); ?></h3>
                        <p class="gr-desc"><?php echo esc_html( teamtakaros_content( 'services', 'service_3_description' ) ); ?></p>
                    </div>

                    <div class="service">
                        <span class="num">04</span>
                        <p class="en-title"><?php echo esc_html( teamtakaros_content( 'services', 'service_4_english' ) ); ?></p>
                        <h3 class="gr-title"><?php echo esc_html( teamtakaros_content( 'services', 'service_4_title' ) ); ?></h3>
                        <p class="gr-desc"><?php echo esc_html( teamtakaros_content( 'services', 'service_4_description' ) ); ?></p>
                        
                    </div>
                </div>
            </div>
            
           
        </section>

        <section class="our-work" id="our-work">
            <div class="wraper">
                <div class="intro-article">
                    <div class="flex">
                        <div class="flex-left">
                            <p class="par-intro"><?php echo esc_html( teamtakaros_content( 'work', 'intro' ) ); ?></p>
                            <h2><?php echo esc_html( teamtakaros_content( 'work', 'heading' ) ); ?></h2>
                        </div>

                        <div class="flex-right">
                             <p class="par-brand"><?php echo teamtakaros_sanitize_inline_content( teamtakaros_content( 'work', 'description' ) ); ?></p>
                        </div>

                    </div>
                 
                   
                </div>

                <div class="filters" role="group" aria-label="Φίλτρο έργων">
                    
                    <button data-filter="Ηχοσυστήματα" aria-pressed="true" class="btnAutoselect" >Ηχοσυστήματα</button>
                    <button data-filter="Ταπετσαρίες" aria-pressed="false">Ταπετσαρίες</button>
                    <button data-filter="Αυτοκίνητα" aria-pressed="false">Αντηλιακές Μεμβράνες</button>
                    <button data-filter="Awards" aria-pressed="false">Διαγωνισμοί και Βραβεία</button>
                </div>
                <div class="project-grid">

                    <!-- ixosistimata -->
                    <article class="project" data-category="Ηχοσυστήματα">
                        <button
                            class="project-image"
                            data-photo="<?php echo get_template_directory_uri(); ?>/assets/imgs/audi-audio.jpg"
                            data-caption="Custom ήχος. Προσωπικός χαρακτήρας."
                            data-source="https://www.instagram.com/teamtakaros_tripolis/p/DdR5V2WiAy0/"
                            aria-label="Μεγέθυνση: Audi · custom εσωτερικό"
                        >
                            <img
                                class=""
                                src="<?php echo get_template_directory_uri(); ?>/assets/imgs/audi-audio.jpg"
                                alt="Audi · custom εσωτερικό"
                                loading="lazy"
                                width="640"
                                height="360"
                            /><span aria-hidden="true">↗</span>
                        </button>
                        
                    </article>

                     <article class="project" data-category="Ηχοσυστήματα">
                        <button
                            class="project-image"
                            data-photo="<?php echo get_template_directory_uri(); ?>/assets/imgs/audio-2.jpg"
                            data-caption="Custom ήχος. Προσωπικός χαρακτήρας."
                            data-source="https://www.instagram.com/teamtakaros_tripolis/p/DdR5V2WiAy0/"
                            aria-label="Μεγέθυνση: Audi · custom εσωτερικό"
                        >
                            <img
                                class=""
                                src="<?php echo get_template_directory_uri(); ?>/assets/imgs/audio-2.jpg"
                                alt="Audi · custom εσωτερικό"
                                loading="lazy"
                                width="640"
                                height="360"
                            /><span aria-hidden="true">↗</span>
                        </button>
                        
                    </article>

                    <article class="project" data-category="Ηχοσυστήματα">
                        <button
                            class="project-image"
                            data-photo="<?php echo get_template_directory_uri(); ?>/assets/imgs/audio-3.jpg"
                            data-caption="Custom ήχος. Προσωπικός χαρακτήρας."
                            data-source="https://www.instagram.com/teamtakaros_tripolis/p/DdR5V2WiAy0/"
                            aria-label="Μεγέθυνση: Audi · custom εσωτερικό"
                        >
                            <img
                                class=""
                                src="<?php echo get_template_directory_uri(); ?>/assets/imgs/audio-3.jpg"
                                alt="Audi · custom εσωτερικό"
                                loading="lazy"
                                width="640"
                                height="360"
                            /><span aria-hidden="true">↗</span>
                        </button>
                        
                    </article>


                    <article class="project" data-category="Ηχοσυστήματα">
                        <button
                            class="project-image"
                            data-photo="<?php echo get_template_directory_uri(); ?>/assets/imgs/audio-4.jpg"
                            data-caption="Custom ήχος. Προσωπικός χαρακτήρας."
                            data-source="https://www.instagram.com/teamtakaros_tripolis/p/DdR5V2WiAy0/"
                            aria-label="Μεγέθυνση: Audi · custom εσωτερικό"
                        >
                            <img
                                class=""
                                src="<?php echo get_template_directory_uri(); ?>/assets/imgs/audio-4.jpg"
                                alt="Audi · custom εσωτερικό"
                                loading="lazy"
                                width="640"
                                height="360"
                            /><span aria-hidden="true">↗</span>
                        </button>
                        
                    </article>

                    <!-- tapetsaries -->
                    <article class="project" data-category="Ταπετσαρίες">
                        <button
                            class="project-image"
                            data-photo="<?php echo get_template_directory_uri(); ?>/assets/imgs/interior-4.jpg"
                            data-caption="Ένα κλασικό εσωτερικό, ξανά στο προσκήνιο."
                            data-source="https://www.instagram.com/teamtakaros_tripolis/p/DalegZMCHRO/"
                            aria-label="Μεγέθυνση: BMW · εσωτερικό"
                        >
                            <img
                                class=""
                                src="<?php echo get_template_directory_uri(); ?>/assets/imgs/interior-4.jpg"
                                alt="BMW · εσωτερικό"
                                loading="lazy"
                                width="640"
                                height="360"
                            /><span aria-hidden="true">↗</span>
                        </button>
                        
                    </article>

                    <article class="project" data-category="Ταπετσαρίες">
                        <button
                            class="project-image"
                            data-photo="<?php echo get_template_directory_uri(); ?>/assets/imgs/red-stitch.jpg"
                            data-caption="Η υπογραφή βρίσκεται στη ραφή."
                            data-source="https://www.instagram.com/teamtakaros_tripolis/p/DbJGb8ECFwg/"
                            aria-label="Μεγέθυνση: Καθίσματα · κόκκινη ραφή"
                        >
                            <img
                                class=""
                                src="<?php echo get_template_directory_uri(); ?>/assets/imgs/red-stitch.jpg"
                                alt="Καθίσματα · κόκκινη ραφή"
                                loading="lazy"
                                width="640"
                                height="360"
                            /><span aria-hidden="true">↗</span>
                        </button>
                        
                    </article>

                    <article class="project" data-category="Ταπετσαρίες">
                        <button
                            class="project-image"
                            data-photo="<?php echo get_template_directory_uri(); ?>/assets/imgs/bmw-interior.jpg"
                            data-caption="Ένα κλασικό εσωτερικό, ξανά στο προσκήνιο."
                            data-source="https://www.instagram.com/teamtakaros_tripolis/p/DalegZMCHRO/"
                            aria-label="Μεγέθυνση: BMW · εσωτερικό"
                        >
                            <img
                                class=""
                                src="<?php echo get_template_directory_uri(); ?>/assets/imgs/bmw-interior.jpg"
                                alt="BMW · εσωτερικό"
                                loading="lazy"
                                width="640"
                                height="360"
                            /><span aria-hidden="true">↗</span>
                        </button>
                        
                    </article>

                    <article class="project" data-category="Ταπετσαρίες">
                        <button
                            class="project-image"
                            data-photo="<?php echo get_template_directory_uri(); ?>/assets/imgs/interior-3.jpg"
                            data-caption="Ένα κλασικό εσωτερικό, ξανά στο προσκήνιο."
                            data-source="https://www.instagram.com/teamtakaros_tripolis/p/DalegZMCHRO/"
                            aria-label="Μεγέθυνση: BMW · εσωτερικό"
                        >
                            <img
                                class=""
                                src="<?php echo get_template_directory_uri(); ?>/assets/imgs/interior-3.jpg"
                                alt="BMW · εσωτερικό"
                                loading="lazy"
                                width="640"
                                height="360"
                            /><span aria-hidden="true">↗</span>
                        </button>
                        
                    </article>
            

                    <!-- window films -->
                     
                    <article class="project" data-category="Αυτοκίνητα">
                        <button
                            class="project-image"
                            data-photo="<?php echo get_template_directory_uri(); ?>/assets/imgs/toyota.jpg"
                            data-caption="Στιγμές από το συνεργείο."
                            data-source="https://www.instagram.com/teamtakaros_tripolis/p/Dai6_U3CBMQ/"
                            aria-label="Μεγέθυνση: Toyota · εξωτερικό"
                        >
                            <img
                                class=""
                                src="<?php echo get_template_directory_uri(); ?>/assets/imgs/toyota.jpg"
                                alt="Toyota · εξωτερικό"
                                loading="lazy"
                                width="640"
                                height="360"
                            /><span aria-hidden="true">↗</span>
                        </button>
                       
                    </article>
                    
                    <article class="project" data-category="Αυτοκίνητα">
                        <button
                            class="project-image"
                            data-photo="<?php echo get_template_directory_uri(); ?>/assets/imgs/windowfilms2.jpg"
                            data-caption="Στιγμές από το συνεργείο."
                            data-source="https://www.instagram.com/teamtakaros_tripolis/p/Dai6_U3CBMQ/"
                            aria-label="Μεγέθυνση: Toyota · εξωτερικό"
                        >
                            <img
                                class=""
                                src="<?php echo get_template_directory_uri(); ?>/assets/imgs/windowfilms2.jpg"
                                alt="Toyota · εξωτερικό"
                                loading="lazy"
                                width="640"
                                height="360"
                            /><span aria-hidden="true">↗</span>
                        </button>
                       
                    </article>

                    <article class="project" data-category="Αυτοκίνητα">
                        <button
                            class="project-image"
                            data-photo="<?php echo get_template_directory_uri(); ?>/assets/imgs/windowfilms3.jpg"
                            data-caption="Στιγμές από το συνεργείο."
                            data-source="https://www.instagram.com/teamtakaros_tripolis/p/Dai6_U3CBMQ/"
                            aria-label="Μεγέθυνση: Toyota · εξωτερικό"
                        >
                            <img
                                class=""
                                src="<?php echo get_template_directory_uri(); ?>/assets/imgs/windowfilms3.jpg"
                                alt="Toyota · εξωτερικό"
                                loading="lazy"
                                width="640"
                                height="360"
                            /><span aria-hidden="true">↗</span>
                        </button>
                       
                    </article>

                    <article class="project" data-category="Αυτοκίνητα">
                        <button
                            class="project-image"
                            data-photo="<?php echo get_template_directory_uri(); ?>/assets/imgs/windowfilms4.jpg"
                            data-caption="Στιγμές από το συνεργείο."
                            data-source="https://www.instagram.com/teamtakaros_tripolis/p/Dai6_U3CBMQ/"
                            aria-label="Μεγέθυνση: Toyota · εξωτερικό"
                        >
                            <img
                                class=""
                                src="<?php echo get_template_directory_uri(); ?>/assets/imgs/windowfilms4.jpg"
                                alt="Toyota · εξωτερικό"
                                loading="lazy"
                                width="640"
                                height="360"
                            /><span aria-hidden="true">↗</span>
                        </button>
                       
                    </article>

                    <!-- awards -->
                     <!-- award 2 -->
                      <article class="project" data-category="Awards">
                        <button
                            class="project-image"
                            data-photo="<?php echo get_template_directory_uri(); ?>/assets/imgs/award2.jpg"
                            data-caption="Στιγμές από το συνεργείο."
                            data-source="https://www.instagram.com/teamtakaros_tripolis/p/Dai6_U3CBMQ/"
                            aria-label="Μεγέθυνση: Toyota · εξωτερικό"
                        >
                            <img
                                class=""
                                src="<?php echo get_template_directory_uri(); ?>/assets/imgs/award2.jpg"
                                alt="Toyota · εξωτερικό"
                                loading="lazy"
                                width="640"
                                height="360"
                            /><span aria-hidden="true">↗</span>
                        </button>
                       
                    </article>
                    <!-- award 4 -->
                      <article class="project" data-category="Awards">
                        <button
                            class="project-image"
                            data-photo="<?php echo get_template_directory_uri(); ?>/assets/imgs/award4.jpg"
                            data-caption="Στιγμές από το συνεργείο."
                            data-source="https://www.instagram.com/teamtakaros_tripolis/p/Dai6_U3CBMQ/"
                            aria-label="Μεγέθυνση: Toyota · εξωτερικό"
                        >
                            <img
                                class=""
                                src="<?php echo get_template_directory_uri(); ?>/assets/imgs/award4.jpg"
                                alt="Toyota · εξωτερικό"
                                loading="lazy"
                                width="640"
                                height="360"
                                
                            /><span aria-hidden="true">↗</span>
                        </button>
                       
                    </article>
                    
                  
                    <!-- award 3 -->
                     <article class="project" data-category="Awards">
                        <button
                            class="project-image portait"
                            data-photo="<?php echo get_template_directory_uri(); ?>/assets/imgs/award3.jpg"
                            data-caption="Στιγμές από το συνεργείο."
                            data-source="https://www.instagram.com/teamtakaros_tripolis/p/Dai6_U3CBMQ/"
                            aria-label="Μεγέθυνση: Toyota · εξωτερικό"
                        >
                            <img
                                class=""
                                src="<?php echo get_template_directory_uri(); ?>/assets/imgs/award3.jpg"
                                alt="Toyota · εξωτερικό"
                                loading="lazy"
                                width="640"
                                height="360"
                            /><span aria-hidden="true">↗</span>
                        </button>
                       
                    </article>

                   
                    <!-- award 1 -->
                    <article class="project" data-category="Awards">
                        <button
                            class="project-image portait"
                            data-photo="<?php echo get_template_directory_uri(); ?>/assets/imgs/award1.jpg"
                            data-caption="Στιγμές από το συνεργείο."
                            data-source="https://www.instagram.com/teamtakaros_tripolis/p/Dai6_U3CBMQ/"
                            aria-label="Μεγέθυνση: Toyota · εξωτερικό"
                        >
                            <img
                                class=""
                                src="<?php echo get_template_directory_uri(); ?>/assets/imgs/award1.jpg"
                                alt="Toyota · εξωτερικό"
                                loading="lazy"
                                width="640"
                                height="360"
                            /><span aria-hidden="true">↗</span>
                        </button>
                       
                    </article>
                   
                </div>

                <dialog id="photo-dialog" aria-label="Προβολή έργου">
                    <button class="close" aria-label="Κλείσιμο φωτογραφίας">×</button><img src="assets/audi-audio.jpg" alt="" />
                   
                </dialog>
                    
                <div class="overlay hidden"></div>
            </div>

        </section>


        <section class="about-us" id="about-us">
            <div class="wraper">
                <h2><?php echo esc_html( teamtakaros_content( 'about', 'heading' ) ); ?></h2>

                <div class="about-us-flex">
                    <div class="about-us-flex-left">
                        <article class="about-us-article">
                            <h3><?php echo esc_html( teamtakaros_content( 'about', 'subheading' ) ); ?></h3>

                            <p><?php echo teamtakaros_sanitize_inline_content( teamtakaros_content( 'about', 'description' ) ); ?></p>
                        </article>
                        

                    </div>

                    <div class="about-us-flex-right">
                       <iframe width="720" height="380" src="https://www.youtube.com/embed/OGkgsst5l38?si=LykAb8lmKgIiZQCs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
            
        </section>
        
        <section class="contact-us" id="contact-us">
            <div class="wraper">
                <article class="intro-article">
                    <p class="par-intro"><?php echo esc_html( teamtakaros_content( 'contact', 'intro' ) ); ?></p>
                    <h2><?php echo esc_html( teamtakaros_content( 'contact', 'heading' ) ); ?></h2>
                
                    
                </article>

              
                <div class="contact-flex">
                    <div class="contact-flex-left">
                        <?php echo apply_shortcodes( '[contact-form-7 id="da13b60" title="home"]' ); ?>

                    </div>

                    <div class="contact-flex-right">
                       <article>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/imgs/logo.jpg" alt="">
                            <div class="contact-article-content">
                                <p><?php echo esc_html( teamtakaros_content( 'contact', 'description' ) ); ?></p>
                                <p class="contact-channel"><i class="fa-solid fa-phone"></i><?php echo esc_html( teamtakaros_content( 'contact', 'phone' ) ); ?></p>
                                <p class="contact-channel"><i class="fa-solid fa-envelope"></i><?php echo esc_html( teamtakaros_content( 'contact', 'email' ) ); ?></p>
                                <p class="contact-channel"><i class="fa-solid fa-location-dot"></i><?php echo esc_html( teamtakaros_content( 'contact', 'address' ) ); ?></p>
                            </div>

                           
                           
                        </article>

                        <div class="social">
                            <a class="fb" target="_blank" href="<?php echo esc_url( teamtakaros_content( 'contact', 'facebook' ) ); ?>"><i class="fa-brands fa-square-facebook"></i></a>
                            <a href="<?php echo esc_url( teamtakaros_content( 'contact', 'instagram' ) ); ?>" class="insta" target="_blank"><i class="fa-brands fa-square-instagram"></i></a>
                        </div>
                   
                    </div>
                </div>

            </div>
                        
        </section>
                <!-- This empty div acts as the observer trigger -->
        <div class="scrollTopTrigger"></div>

        <a href="" class="to-top-link"><i class="fa-solid fa-circle-chevron-up"></i></a>
    </main>




<?php

get_footer();
?>