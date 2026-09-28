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
            <p class="slogan">TEAM TAKAROS · CAR AUDIO & CUSTOM INTERIORS</p>
            <hgroup class="main-hgroup">
                <h2><span class="brand">Δεν </span>είναι απλώς ένα αυτοκίνητο.</h2>
                <h3>Είναι το <span class="brand">δικό σου.</span></h3> 
            </hgroup>
           

            <div class="cover-cta">
                <p>Βάλε τον δικό σου ήχο. <br >Διάλεξε το δικό σου στυλ. <br> Ζήσε αλλιώς τη διαδρομή.</p> 
                <a href="" class="cover-cta-btn">Πάμε να το αλλάξουμε</a>   
            </div>

            <p class="passion">REAL WORK REAL PASSION</p>
            <p class="cover-location">ΤΡΙΠΟΛΗ, ΑΡΚΑΔΙΑ / GR</p>
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
                            <p class="par-intro">TΕΣΣΕΡΙΣ ΤΡΟΠΟΙ ΝΑ ΞΕΧΩΡΙΣΕΙΣ.</p>
                            <h2>Μια ομάδα. Κάθε αναβάθμιση.</h2>
                        </div>

                        <div class="flex-right">
                             <p class="par-brand">Από τον <strong>ήχο </strong>μέχρι την τελευταία <strong>ραφή</strong> , φροντίζουμε <br> όσα κάνουν τη διαδρομή σου  <strong>ξεχωριστή.</strong></p>
                        </div>

                    </div>
                 
                   
                </div>

                <div class="services">

                    <div class="service">
                        <span class="num">01</span>
                        <p class="en-title">CAR AUDIO</p>
                        <h3 class="gr-title">Ηχοσυστήματα</h3>
                        <p class="gr-desc">Από την καθημερινή ακρόαση μέχρι μια custom εγκατάσταση. Ηχεία, ενισχυτές, subwoofer και οθόνες, με μελέτη για το δικό σου αυτοκίνητο.</p>

                    </div>

                    <div class="service">
                        <span class="num">02</span>
                        <p class="en-title">CUSTOM INTERIORS</p>
                        <h3 class="gr-title">Ταπετσαρίες</h3>
                        <p class="gr-desc">Νέα υφή, χρώμα και χαρακτήρας στο εσωτερικό σου. Επενδύσεις καθισμάτων, ουρανού και θυρών, με προσοχή σε κάθε ραφή.</p>
                        
                    </div>

                    <div class="service">
                        <span class="num">03</span>
                        <p class="en-title">WINDOW FILMS</p>
                        <h3 class="gr-title">Αντηλιακές Μεμβράνες</h3>
                        <p class="gr-desc">Αναβάθμισε την αίσθηση και την εμφάνιση του αυτοκινήτου σου. Συζητάμε τις επιλογές μεμβρανών που ταιριάζουν στις ανάγκες σου.</p>
                    </div>

                    <div class="service">
                        <span class="num">04</span>
                        <p class="en-title">INTERIOR CARE</p>
                        <h3 class="gr-title">Βιολογικοί καθαρισμοί</h3>
                        <p class="gr-desc">Περιποίηση του εσωτερικού, των καθισμάτων και των υφασμάτινων επιφανειών. Για μια καμπίνα που χαίρεσαι να μπαίνεις.</p>
                        
                    </div>
                </div>
            </div>
            
           
        </section>

        <section class="our-work" id="our-work">
            <div class="wraper">
                <div class="intro-article">
                    <div class="flex">
                        <div class="flex-left">
                            <p class="par-intro">ΑΠΟ ΤΟ ΣΥΝΕΡΓΕΙΟ ΜΑΣ.</p>
                            <h2>Η δουλειά μιλάει.</h2>
                        </div>

                        <div class="flex-right">
                             <p class="par-brand">Ξεχωριστές  <strong>ιδέες.</strong> Φωτογραφίες από το <br> Instagram της <strong>Team Takaros.</strong></p>
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
                            data-photo="<?php echo get_template_directory_uri(); ?>/assets/imgs/audi-audio.jpg' ?>"
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


        <!-- <section class="team">
            <div class="wraper">
                <article class="team-article">
                    <h2>Η ομάδα.</h2>
                    <p>ΜΙΑ ΟΜΑΔΑ. ΜΙΑ ΔΥΝΑΜΗ. ΜΙΑ ΚΟΡΥΦΗ.</p>
                </article>
            
            
                <div class="members">
                    <div class="member">
                        <img src="/<?php echo get_template_directory_uri(); ?>/assets/imgs/team-1.jpg" alt="">
                        <p>Παναγιώτης Ζαχαρόπουλος</p>
                    </div>

                    <div class="member">
                        <img src="/<?php echo get_template_directory_uri(); ?>/assets/imgs/team-2.jpg" alt="">
                        <p>Πάνος Κουρούμαλος</p>
                    </div>

                    <div class="member">
                        <img src="/<?php echo get_template_directory_uri(); ?>/assets/imgs/team-3.jpg" alt="">
                        <p>Τάκης Τσιακανίκος</p>
                    </div>

                </div>
            </div>
        </section> -->

        <section class="about-us" id="about-us">
            <div class="wraper">
                <h2>Σχετικά με εμάς.</h2>

                <div class="about-us-flex">
                    <div class="about-us-flex-left">
                        <article class="about-us-article">
                            <h3>Team Takaros — Sound Systems and More</h3>

                            <p>Στο Team Takaros πιστεύουμε πως κάθε αυτοκίνητο <strong>αξίζει</strong> να έχει τη δική του ξεχωριστή <strong>ταυτότητα.</strong> 
                                 Με έδρα την Τρίπολη, δραστηριοποιούμαστε στον χώρο της αυτοκίνησης, προσφέροντας <strong>εξειδικευμένες</strong>
                                  υπηρεσίες σε ταπετσαρίες και επενδύσεις εσωτερικού, premium ηχοσυστήματα, αντηλιακές μεμβράνες,
                                  βιολογικούς καθαρισμούς, συνδυάζοντας <strong>υψηλή αισθητική</strong> , σύγχρονη τεχνολογία και <strong>άρτια τεχνική</strong> κατάρτιση. 
                                  
                                  Από την επιλογή των υλικών μέχρι την τελευταία λεπτομέρεια της εγκατάστασης, κάθε project αντιμετωπίζεται με  <strong>απόλυτη προσοχή</strong>
                                  και εξατομικεύεται στις <strong>ανάγκες</strong> και την <strong>αισθητική</strong> του κάθε πελάτη.</p>
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
                    <p class="par-intro">ΤΟ ΟΝΕΙΡΕΥΤΗΚΑΤΕ ΑΣ ΤΟ ΦΤΙΑΞΟΥΜΕ</p>
                    <h2>Επικοινωνήστε Μαζί μας.</h2>
                
                    
                </article>

              
                <div class="contact-flex">
                    <div class="contact-flex-left">
                        <?php echo apply_shortcodes( '[contact-form-7 id="041d0b3" title="home"]' ); ?>
                    </div>

                    <div class="contact-flex-right">
                       <article>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/imgs/logo.jpg" alt="">
                            <div class="contact-article-content">
                                <p>Η Team Takaros Tripolis είναι πάντα ανοιχτή σε νέες ιδέες, συνεργασίες και ανθρώπους που μοιράζονται το ίδιο πάθος για την αυτοκίνηση και τα ηχοσυστήματα.</p>
                                <p class="contact-channel"><i class="fa-solid fa-phone"></i>+30 698 479 5793</p>
                                <p class="contact-channel"><i class="fa-solid fa-envelope"></i>lprecords20@gmail.com</p>
                                <p class="contact-channel"><i class="fa-solid fa-location-dot"></i>3ο Χλμ. Ε.Ο. Τριπολης Σπαρτης, Trípoli, Greece</p>
                            </div>

                           
                           
                        </article>

                        <div class="social">
                            <a class="fb" target="_blank" href="https://www.facebook.com/TeamTakaros/"><i class="fa-brands fa-square-facebook"></i></a>
                            <a href="https://www.instagram.com/teamtakaros_tripolis/" class="insta" target="_blank"><i class="fa-brands fa-square-instagram"></i></a>
                        </div>
                   
                    </div>
                </div>

            </div>
                        
        </section>
                <!-- This empty div acts as the observer trigger -->
        <div class="scrollTopTrigger"></div>

        <a href="#" class="to-top-link"><i class="fa-solid fa-circle-chevron-up"></i></a>
    </main>




<?php

get_footer();
?>