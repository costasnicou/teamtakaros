# Editing site content

With CMB2 active, sign in as a WordPress administrator and open **Site Content** in the dashboard sidebar.

The six tabs cover the header branding, hero, services, gallery, about section, and contact section. Edit a tab and click **Save content** before switching tabs. Changes apply immediately to the site.

- The current theme copy is supplied as the default. Clearing a field restores that default; it does not hide the text.
- Navigation text and menu accessibility labels are fixed in the theme; the header tab edits only the brand heading and tagline.
- Services overview labels are fixed in the template; the Services tab edits the section introduction and service descriptions.
- Footer text and credits are fixed in `footer.php` and have no Site Content controls.
- The phone field on the Contact tab updates both the header and contact section.
- Formatted fields accept `<strong>`, `<em>`, `<br>`, and `<span class="brand">`. The header logo uses `<span class="emf">`. Use `<br>` for explicit line breaks; paragraph or heading tags are not supported inside these fields.
- The Our Work tab edits only the intro label, heading, and introduction. Filter button labels, project captions, image descriptions, and gallery accessibility labels are fixed in `front-page.php`.
- Contact form fields and messages are managed in **Contact → Contact Forms** (Contact Form 7).
- Images, gallery item counts, service counts, and the video remain in the templates; these controls manage the existing site's text and social links.

Settings are stored in one WordPress option per tab (`teamtakaros_content_header`, `teamtakaros_content_hero`, etc.). Saved text still renders if CMB2 is deactivated; administrators see a reminder to reactivate it for editing. Only administrators with `manage_options` can access the content editor.

The field definitions and original copy live in `inc/content-options.php`. Templates read them with `teamtakaros_content( $section, $key )` and escape output according to its context. Add new fields to the schema and connect them to a template to extend the editor.

The options screens use the [CMB2 options-page API](https://cmb2.io/docs/Box-Properties).
