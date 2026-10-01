# Our Work gallery

Open **Media → Our Work tabs** as a WordPress administrator or the restricted `admtakaros` account. A shortcut is also available in **Site Content → Our work → Tabs and photos**. Keep CMB2 active for photo uploads and tab ordering.

1. Add a parent tab, such as Ηχοσυστήματα, with **Parent tab: None**.
2. Add a child tab and select that parent. The gallery supports exactly two levels.
3. Click **Edit** on the child tab. In **Photos**, upload multiple images or select existing images from the Media Library. Click **Update** to save.
4. Edit a tab's name, parent, description, or **Tab order** whenever needed. Lower order numbers appear first; equal values follow creation order. A child description appears above its photos.
5. Remove a photo with its Remove control and click **Update**. This removes it from the collection without deleting the Media Library file.

Deleting a parent deletes its child tabs too. Deleting tabs never deletes their image files. A parent with children cannot be moved under another parent. Reassign or delete its children first. Promoting a photo collection to a parent hides its photos until it is moved under a parent again.

Photos are always sorted by their **Media Library upload date, newest first**, with descending attachment ID as the tie-breaker. Selecting an older image from the library does not make it newly uploaded. Dragging images in the editor does not change this ordering. Edit image alt text in the Media Library. The enlarged photo dialog displays only the image.

Visitors initially see four photos in the first child collection. **Περισσότερες φωτογραφίες** fetches the next four from the selected child only. The button disappears when all photos are visible. Switching child tabs resets the selected collection to four; switching parent tabs selects that parent's first child and starts at four. Empty collections display a message. Failed requests expose a retry button, and requests are cancelled when the visitor changes tabs.

The current site's original 16 images were imported into four parent tabs, each with an **Επιλεγμένα έργα** child. On a new installation, use **Import original gallery** on the tabs screen once to perform the same migration. The importer does not replace the source files and uses a completion flag to avoid recreating deliberately deleted tabs.

## Implementation and checks

- `inc/gallery.php`: hierarchy, CMB2 fields, image validation, and public read-only endpoint `/wp-json/teamtakaros/v1/gallery?tab=ID&page=1` (WordPress generates the correct URL for the installation).
- `template-parts/work-gallery.php`: nested accessible tab controls and the initial four server-rendered photos.
- `assets/js/gallery.js`: pagination, reset, race protection, keyboard navigation, and delegated dialog behavior.
- `assets/scss/desktop/_tab.scss` and `assets/scss/mobile/_tab.scss`: styling. Compile with `sass --no-cache --sourcemap=auto assets/scss/app.scss assets/css/app.css` using the installed Sass compiler.
- `inc/gallery-import.php` and `inc/gallery-legacy.json`: administrator-only migration.

WordPress integration checks use temporary terms and existing media, then delete only the temporary terms:

```sh
php tests/gallery.php /absolute/path/to/wp-load.php
```

The checks require at least ten existing images. Run them on a development copy, since temporary gallery tabs briefly exist during the checks.

The dependency-free JavaScript fixture tests pagination, tab resets, out-of-order replies, retries, keyboard controls, and photo dialogs. With Node available:

```sh
node -e 'require("./tests/gallery-state.js")(require("fs").readFileSync("assets/js/gallery.js", "utf8")).then(console.log).catch(error => { console.error(error); process.exitCode = 1; })'
```

These interaction tests use a small DOM fixture; they do not replace responsive visual browser testing.
