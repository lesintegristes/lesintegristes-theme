# Les intégristes - WordPress Theme

## Installation

### Step 1: Install WordPress and the theme.

[Install WordPress](http://codex.wordpress.org/Installing_WordPress) as usual.

Clone this theme in the wordpress `themes` directory.

```shell
$ git clone git@github.com:lesintegristes/lesintegristes-theme.git ./wp-content/themes/lesintegristes
```

### Step 2: GeoLiteCity file, WordPress plugins.

The GeoLiteCity file is required to localize the IP of the visitors (to display the night or the weather in the header).

You also need to install the required plugins (Advanced Excerpt, Contact Form 7, Really Simple Captcha).

Just run `make` in the theme directory:

```shell
$ cd wp-content/themes/lesintegristes
$ make
```

### Step 3: Specific pages.

If you want to use the special homepage, you need to create two pages with the following slugs: `home` and `articles`.

Now, in *Settings* => *Reading*:

- Enable “A static page”
- Select the `home` page you created in the “Front page” menu
- Select the `articles` page you cretaed in the “Posts page” menu.

If you want to use the “Auteurs” and “Veille” page, add two empty pages with the following slugs: `auteurs`, `veille`.

## License

MIT, see the LICENSE file.
