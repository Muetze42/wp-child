# WordPress Child Theme
* Class autoload for the ´theme´ folder
* The slug for the theme is the theme folder name `wp-content/themes/:slug:`
---
## Instruction
### Theme Infos
Set up all theme information's „**Version**“, „Theme Name“, „Description“ etc. in `style.css` in the root folder

### Translation Text domain
Search for `'child-theme'` and replace with yours `'my-child-theme'`.  
_Whyyyy?_ 😢 _WordPress Plugins like „Loco Translate“ don't recognize it when it's set with a variable._

### Custom Global Slug For Assets
`theme\Kernel.php`:
```php
    public static string $themeSlug = ''; 
```


### Change namespace and autoload other function files (for WooCommerce etc)
Set up `files` in the `composer.json` file
```json
    "autoload": {
        "psr-4": {
            "NormanHuth\\WpChild\\": "theme/"
        },
        "files": [
            "functions/wordpress.php"
        ]
    },
```
run `composer dump-autoload`  
:warning: Don't forget to change the new namespace in the `functions.php` file and classes in the `theme` folder :warning:

### Assets
* Target for CSS: `assets/css`
* Target for JS: `assets/js`
* For Mix with version hashing use the `webpack.mix.js`
```javascript
mix
    .setPublicPath('assets')
    .sass('resources/scss/theme.scss', 'css')
    .scripts(['resources/js/theme.js'], 'assets/js/theme.js')
    .version();
```
#### Enqueue Assets
##### Enqueue Stylesheet from ´assets/css/*.css´
Edit `theme/Providers/ThemeProvider`:
```php
    public function enqueueAssets()
    {
        $this->enqueueStylesheet('theme.css');
        // Full
        $this->enqueueStylesheet('theme.css', ['parent-theme'], 'custom-handle-slug', 'v666');
    }
```
##### Enqueue Scripts from ´assets/js/*.js´
Edit `theme/Providers/ThemeProvider`:
```php
    public function enqueueAssets()
    {
        $this->enqueueScript('theme.js');
        // Full
        $this->enqueueScript('theme.js', ['jquery-core'], 'custom-handle-slug', 'v666');
    }
```