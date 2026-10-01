# Restricted account: admtakaros

The active Team Takaros theme restricts the exact WordPress **username** `admtakaros` to:

- **Site Content**, including all section editors and saves.
- **Media**, including uploads, existing-image editing/deletion, and **Our Work tabs** and their photo collections.

Other dashboard pages, plugin settings, posts/pages, user administration, and unrelated administrative AJAX/REST routes are denied. The account lands on Site Content after login. The toolbar keeps Visit site, Site Content, and Log out.

The theme automatically changes this account's stored role to **Subscriber** and removes individually assigned capabilities on the next WordPress request. It grants the required content/media capabilities only while this theme is active. This also prevents old administrator privileges returning if the theme is switched. Other users retain their existing permissions. The one-time original-gallery import remains administrator-only.

## Deploy to the live website

Upload these files to the matching locations in the live `teamtakaros` theme:

- `functions.php`
- `inc/access-control.php` (new)
- `inc/content-options.php`
- `inc/gallery.php`

Once deployed, load the site, then sign in as `admtakaros`. Only Site Content and Media should appear. Check a content save, an image upload, and the Our Work tab editor. The implementation was tested locally; deploying these files is required to change the live account's access.

The access rule uses the username, not display name or email. If the login name changes, update it in `inc/access-control.php`. Removing this feature does not restore previously removed roles or individual capabilities; an administrator must deliberately assign a new role.

## Verification

On a development copy:

```sh
php tests/access-control.php /absolute/path/to/wp-load.php
```

If the account is absent, the test creates a temporary `admtakaros` account and deletes it afterward. It creates and removes one temporary gallery term and checks existing media without modifying image files. Checks cover stored privilege removal, content permissions, media editing/uploads, direct URLs, AJAX, REST, and unaffected administrator access.
