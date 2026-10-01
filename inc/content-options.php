<?php
/**
 * Editable site copy and CMB2 options pages.
 *
 * @package teamtakaros
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Return the content sections, fields, and original theme copy. */
function teamtakaros_content_schema() {
	static $sections = null;
	if ( null !== $sections ) {
		return $sections;
	}
	$sections = array(
		'header' => array(
			'title' => __( 'Header & navigation', 'teamtakaros' ),
			'fields' => array(
				'brand' => array(
					'name' => __( 'Brand heading', 'teamtakaros' ),
					'default' => 'TEAM <span class="emf">TAKAROS</span>',
					'format' => 'html',
				),
				'tagline' => array(
					'name' => __( 'Tagline', 'teamtakaros' ),
					'default' => 'CAR AUDIO & CUSTOM INTERIORS',
					'format' => 'text',
				),
			),
		),
		'hero' => array(
			'title' => __( 'Hero', 'teamtakaros' ),
			'fields' => array(
				'slogan' => array(
					'name' => __( 'Slogan', 'teamtakaros' ),
					'default' => 'TEAM TAKAROS · CAR AUDIO & CUSTOM INTERIORS',
					'format' => 'text',
				),
				'heading' => array(
					'name' => __( 'Main heading', 'teamtakaros' ),
					'default' => '<span class="brand">Δεν </span>είναι απλώς ένα αυτοκίνητο.',
					'format' => 'html',
				),
				'subheading' => array(
					'name' => __( 'Second heading', 'teamtakaros' ),
					'default' => 'Είναι το <span class="brand">δικό σου.</span>',
					'format' => 'html',
				),
				'description' => array(
					'name' => __( 'Introduction', 'teamtakaros' ),
					'default' => 'Βάλε τον δικό σου ήχο. <br >Διάλεξε το δικό σου στυλ. <br> Ζήσε αλλιώς τη διαδρομή.',
					'format' => 'html',
				),
				'button' => array(
					'name' => __( 'Button label', 'teamtakaros' ),
					'default' => 'Πάμε να το αλλάξουμε',
					'format' => 'text',
				),
				'passion' => array(
					'name' => __( 'Bottom slogan', 'teamtakaros' ),
					'default' => 'REAL WORK REAL PASSION',
					'format' => 'text',
				),
				'location' => array(
					'name' => __( 'Location', 'teamtakaros' ),
					'default' => 'ΤΡΙΠΟΛΗ, ΑΡΚΑΔΙΑ / GR',
					'format' => 'text',
				),
			),
		),
		'services' => array(
			'title' => __( 'Services', 'teamtakaros' ),
			'fields' => array(
				'intro' => array(
					'name' => __( 'Intro label', 'teamtakaros' ),
					'default' => 'TΕΣΣΕΡΙΣ ΤΡΟΠΟΙ ΝΑ ΞΕΧΩΡΙΣΕΙΣ.',
					'format' => 'text',
				),
				'heading' => array(
					'name' => __( 'Heading', 'teamtakaros' ),
					'default' => 'Μια ομάδα. Κάθε αναβάθμιση.',
					'format' => 'text',
				),
				'description' => array(
					'name' => __( 'Introduction', 'teamtakaros' ),
					'default' => 'Από τον <strong>ήχο </strong>μέχρι την τελευταία <strong>ραφή</strong> , φροντίζουμε <br> όσα κάνουν τη διαδρομή σου  <strong>ξεχωριστή.</strong>',
					'format' => 'html',
				),
				'service_1_english' => array(
					'name' => __( 'Service 1: English title', 'teamtakaros' ),
					'default' => 'CAR AUDIO',
					'format' => 'text',
				),
				'service_1_title' => array(
					'name' => __( 'Service 1: title', 'teamtakaros' ),
					'default' => 'Ηχοσυστήματα',
					'format' => 'text',
				),
				'service_1_description' => array(
					'name' => __( 'Service 1: description', 'teamtakaros' ),
					'default' => 'Από την καθημερινή ακρόαση μέχρι μια custom εγκατάσταση. Ηχεία, ενισχυτές, subwoofer και οθόνες, με μελέτη για το δικό σου αυτοκίνητο.',
					'format' => 'textarea',
				),
				'service_2_english' => array(
					'name' => __( 'Service 2: English title', 'teamtakaros' ),
					'default' => 'CUSTOM INTERIORS',
					'format' => 'text',
				),
				'service_2_title' => array(
					'name' => __( 'Service 2: title', 'teamtakaros' ),
					'default' => 'Ταπετσαρίες',
					'format' => 'text',
				),
				'service_2_description' => array(
					'name' => __( 'Service 2: description', 'teamtakaros' ),
					'default' => 'Νέα υφή, χρώμα και χαρακτήρας στο εσωτερικό σου. Επενδύσεις καθισμάτων, ουρανού και θυρών, με προσοχή σε κάθε ραφή.',
					'format' => 'text',
				),
				'service_3_english' => array(
					'name' => __( 'Service 3: English title', 'teamtakaros' ),
					'default' => 'WINDOW FILMS',
					'format' => 'text',
				),
				'service_3_title' => array(
					'name' => __( 'Service 3: title', 'teamtakaros' ),
					'default' => 'Αντηλιακές Μεμβράνες',
					'format' => 'text',
				),
				'service_3_description' => array(
					'name' => __( 'Service 3: description', 'teamtakaros' ),
					'default' => 'Αναβάθμισε την αίσθηση και την εμφάνιση του αυτοκινήτου σου. Συζητάμε τις επιλογές μεμβρανών που ταιριάζουν στις ανάγκες σου.',
					'format' => 'text',
				),
				'service_4_english' => array(
					'name' => __( 'Service 4: English title', 'teamtakaros' ),
					'default' => 'INTERIOR CARE',
					'format' => 'text',
				),
				'service_4_title' => array(
					'name' => __( 'Service 4: title', 'teamtakaros' ),
					'default' => 'Βιολογικοί καθαρισμοί',
					'format' => 'text',
				),
				'service_4_description' => array(
					'name' => __( 'Service 4: description', 'teamtakaros' ),
					'default' => 'Περιποίηση του εσωτερικού, των καθισμάτων και των υφασμάτινων επιφανειών. Για μια καμπίνα που χαίρεσαι να μπαίνεις.',
					'format' => 'text',
				),
			),
		),
		'work' => array(
			'title' => __( 'Our work', 'teamtakaros' ),
			'fields' => array(
				'intro' => array(
					'name' => __( 'Intro label', 'teamtakaros' ),
					'default' => 'ΑΠΟ ΤΟ ΣΥΝΕΡΓΕΙΟ ΜΑΣ.',
					'format' => 'text',
				),
				'heading' => array(
					'name' => __( 'Heading', 'teamtakaros' ),
					'default' => 'Η δουλειά μιλάει.',
					'format' => 'text',
				),
				'description' => array(
					'name' => __( 'Introduction', 'teamtakaros' ),
					'default' => 'Ξεχωριστές  <strong>ιδέες.</strong> Φωτογραφίες από το <br> Instagram της <strong>Team Takaros.</strong>',
					'format' => 'html',
				),
			),
		),
		'about' => array(
			'title' => __( 'About us', 'teamtakaros' ),
			'fields' => array(
				'heading' => array(
					'name' => __( 'Heading', 'teamtakaros' ),
					'default' => 'Σχετικά με εμάς.',
					'format' => 'text',
				),
				'subheading' => array(
					'name' => __( 'Subheading', 'teamtakaros' ),
					'default' => 'Team Takaros — Sound Systems and More',
					'format' => 'text',
				),
				'description' => array(
					'name' => __( 'Description', 'teamtakaros' ),
					'default' => 'Στο Team Takaros πιστεύουμε πως κάθε αυτοκίνητο <strong>αξίζει</strong> να έχει τη δική του ξεχωριστή <strong>ταυτότητα.</strong> 
                                 Με έδρα την Τρίπολη, δραστηριοποιούμαστε στον χώρο της αυτοκίνησης, προσφέροντας <strong>εξειδικευμένες</strong>
                                  υπηρεσίες σε ταπετσαρίες και επενδύσεις εσωτερικού, premium ηχοσυστήματα, αντηλιακές μεμβράνες,
                                  βιολογικούς καθαρισμούς, συνδυάζοντας <strong>υψηλή αισθητική</strong> , σύγχρονη τεχνολογία και <strong>άρτια τεχνική</strong> κατάρτιση. 
                                  
                                  Από την επιλογή των υλικών μέχρι την τελευταία λεπτομέρεια της εγκατάστασης, κάθε project αντιμετωπίζεται με  <strong>απόλυτη προσοχή</strong>
                                  και εξατομικεύεται στις <strong>ανάγκες</strong> και την <strong>αισθητική</strong> του κάθε πελάτη.',
					'format' => 'html',
				),
			),
		),
		'contact' => array(
			'title' => __( 'Contact', 'teamtakaros' ),
			'fields' => array(
				'intro' => array(
					'name' => __( 'Intro label', 'teamtakaros' ),
					'default' => 'ΤΟ ΟΝΕΙΡΕΥΤΗΚΑΤΕ ΑΣ ΤΟ ΦΤΙΑΞΟΥΜΕ',
					'format' => 'text',
				),
				'heading' => array(
					'name' => __( 'Heading', 'teamtakaros' ),
					'default' => 'Επικοινωνήστε Μαζί μας.',
					'format' => 'text',
				),
				'description' => array(
					'name' => __( 'Description', 'teamtakaros' ),
					'default' => 'Η Team Takaros Tripolis είναι πάντα ανοιχτή σε νέες ιδέες, συνεργασίες και ανθρώπους που μοιράζονται το ίδιο πάθος για την αυτοκίνηση και τα ηχοσυστήματα.',
					'format' => 'textarea',
				),
				'phone' => array(
					'name' => __( 'Phone', 'teamtakaros' ),
					'default' => '+30 698 479 5793',
					'format' => 'text',
				),
				'email' => array(
					'name' => __( 'Email', 'teamtakaros' ),
					'default' => 'teamtakaros@gmail.com',
					'format' => 'email',
				),
				'address' => array(
					'name' => __( 'Address', 'teamtakaros' ),
					'default' => '3ο Χλμ. Ε.Ο. Τριπολης Σπαρτης, Trípoli, Greece',
					'format' => 'text',
				),
				'facebook' => array(
					'name' => __( 'Facebook URL', 'teamtakaros' ),
					'default' => 'https://www.facebook.com/TeamTakaros/',
					'format' => 'url',
				),
				'instagram' => array(
					'name' => __( 'Instagram URL', 'teamtakaros' ),
					'default' => 'https://www.instagram.com/teamtakaros_tripolis/',
					'format' => 'url',
				),
			),
		),
	);
	return $sections;
}

/** Read saved copy without requiring CMB2 on frontend requests. */
function teamtakaros_content( $section, $key ) {
	$schema = teamtakaros_content_schema();
	if ( ! isset( $schema[ $section ]['fields'][ $key ] ) ) {
		return '';
	}
	$values = get_option( 'teamtakaros_content_' . $section, array() );
	if ( is_array( $values ) && isset( $values[ $key ] ) && is_string( $values[ $key ] ) && '' !== trim( $values[ $key ] ) ) {
		return $values[ $key ];
	}
	return $schema[ $section ]['fields'][ $key ]['default'];
}

/** Allow only inline markup that fits the existing headings and paragraphs. */
function teamtakaros_sanitize_inline_content( $value ) {
	return wp_kses( $value, array(
		'span' => array( 'class' => true ),
		'strong' => array(),
		'em' => array(),
		'b' => array(),
		'i' => array(),
		'br' => array(),
	) );
}

/** Keep CMB2 callback arguments separate from the URL protocol argument. */
function teamtakaros_sanitize_content_url( $value ) {
	return esc_url_raw( $value, array( 'http', 'https' ) );
}

/** Register tabbed options pages using CMB2's nonce and capability checks. */
function teamtakaros_register_content_options() {
	if ( ! function_exists( 'new_cmb2_box' ) ) {
		return;
	}
	foreach ( teamtakaros_content_schema() as $section => $settings ) {
		$box = new_cmb2_box( array(
			'id' => 'teamtakaros_content_box_' . $section,
			'title' => __( 'Site Content', 'teamtakaros' ) . ': ' . $settings['title'],
			'menu_title' => 'header' === $section ? __( 'Site Content', 'teamtakaros' ) : $settings['title'],
			'object_types' => array( 'options-page' ),
			'option_key' => 'teamtakaros_content_' . $section,
			'parent_slug' => 'header' === $section ? '' : 'teamtakaros_content_header',
			'capability' => 'tt_manage_site_content',
			'icon_url' => 'dashicons-edit-page',
			'tab_group' => 'teamtakaros_site_content',
			'tab_title' => $settings['title'],
			'save_button' => __( 'Save content', 'teamtakaros' ),
		) );
		$box->add_field( array(
			'id' => 'editing_help',
			'type' => 'title',
			'name' => $settings['title'],
			'desc' => __( 'Edit the text below and save this tab before switching tabs. Empty fields use the original theme text. The phone number is shared by the header and contact section. Contact form labels are edited in Contact Form 7.', 'teamtakaros' ),
		) );
		if ( 'work' === $section ) {
			$box->add_field( array(
				'id' => 'gallery_management',
				'type' => 'title',
				'name' => __( 'Tabs and photos', 'teamtakaros' ),
				'desc' => '<a href="' . esc_url( admin_url( 'edit-tags.php?taxonomy=tt_work_tab&post_type=attachment' ) ) . '">' . esc_html__( 'Manage gallery tabs and upload photos', 'teamtakaros' ) . '</a>',
			) );
		}
		foreach ( $settings['fields'] as $key => $definition ) {
			$format = $definition['format'];
			$field = array(
				'id' => $key,
				'name' => $definition['name'],
				'default' => $definition['default'],
				'type' => 'text',
				'sanitization_cb' => 'sanitize_text_field',
			);
			if ( 'html' === $format ) {
				$field['type'] = 'textarea_small';
				$field['sanitization_cb'] = 'teamtakaros_sanitize_inline_content';
				$field['desc'] = esc_html__( 'Supports <strong>, <em>, <br>, and <span class="brand"> (or class="emf" in the logo) for highlighted text. Use <br> for line breaks.', 'teamtakaros' );
			} elseif ( 'textarea' === $format ) {
				$field['type'] = 'textarea_small';
				$field['sanitization_cb'] = 'sanitize_textarea_field';
			} elseif ( 'email' === $format ) {
				$field['type'] = 'text_email';
				$field['sanitization_cb'] = 'sanitize_email';
			} elseif ( 'url' === $format ) {
				$field['type'] = 'text_url';
				$field['sanitization_cb'] = 'teamtakaros_sanitize_content_url';
			}
			$box->add_field( $field );
		}
	}
}
add_action( 'cmb2_admin_init', 'teamtakaros_register_content_options' );

/** Explain why the editing screen is unavailable when the plugin is inactive. */
function teamtakaros_content_plugin_notice() {
	if ( current_user_can( 'tt_manage_site_content' ) && ! function_exists( 'new_cmb2_box' ) ) {
		echo '<div class="notice notice-warning"><p>' . esc_html__( 'Team Takaros: activate CMB2 to edit the site text under Site Content. Saved content will still display while CMB2 is inactive.', 'teamtakaros' ) . '</p></div>';
	}
}
add_action( 'admin_notices', 'teamtakaros_content_plugin_notice' );
