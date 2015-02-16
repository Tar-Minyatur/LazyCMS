# LazyCMS
Lightweight CMS that generates static output files on demand instead of running on every page impression.

### Goal

A lot of smaller web projects stumble upon the situation where some content of the website needs
to be editable, because it might occasionally change. But do you really want to setup a fully-fledged
CMS with all its on-the-fly page rendering just because every now and then some content is updated?

We think this is not at all the right approach. Instead of rendering pages on every page impression,
LazyCMS renders static files on demand, i.e. after you modified your content. This way the webserver
only needs to crunch through code when it is really necessary: once per code change.

### Features

- A single click triggers the code generator, which replaces text labels in all your source files
- The source files are never touched, so the code generation is repeatable and nondestructive
- Content can be split into into sections (with a global section for shared content)
- The CMS can extract text labels from the source files and generate a new data scheme (gettext approach)

### How to use?

1. Download our [latest release][5] and unzip it to where you want the CMS to be located
2. Make sure you know where your website source files are located relative to the CMS' location
3. Rename `config-sample.inc.php` to `config.inc.php` and open it
4. Edit the `fileMapping` and `homepageURL` setting to tell LazyCMS where to find your code and
   where to copy the generated files
5. Open the URL to your CMS location in your browser
6. Login with the default password "admin"
7. Hit the "Extract Text Labels" button and watch LazyCMS peruse your source code for labels that look
   like this: `{{some_text_label}}` (unless you edited the delimiter configuration)
8. Save the generated JSON and start editing content with the button "Content Management"
9. Hit "Regenerate Files" and your website will become available at the configured location

**Recommended additional steps:**

- Change the admin password in `config.inc.php`. To make this easier, you can navigate to
  `http://yourdomain.tld/path/to/the/cms/createPassword.php` and copy the generated hash into the file.
- Make sure that the source files of your website are not available via the browser. Either move them out
  of your webserver's docroot or if you are using Apache, you can just copy our file
  `example/input/.htaccess` to your source directory.
- If you are not using our default folders, you can just delete `example/` completely.

### I want to change something. How do I run the build?

We're mainly using [Grunt][3] to build our project and in the background [Composer][1] takes care of our
dependency management and class autoloading. After checking out the repository and making sure that you
have [Node.js][4] installed, you need to run this command once to get all necessary dependencies:

    $ npm install && grunt install

This will download all [Node.js][4] dependencies and setup [Composer][1] locally. From now on you only
need to deal with `grunt`:

- `$ grunt` \\
  Runs build and validation steps
- `$ grunt watch` \\
  Fires up a development environment that auto-builds if you change a file and spawns a local PHP webserver,
  so you can immediately check out your progress on http://localhost:5000
- `$ grunt package` \\
  We use this to build our releases, so you most likely won't need it

As a final step you need to copy `config-sample.inc.php` to `config.inc.php`. You probably
want to change quite a few things in there.

### License

This projected is licensed under the terms of the [MIT license][6].

### Credits

Thanks to these awesome projects for making our life so much easier:

- [Composer][1] - Dependency management for PHP
- [Plates][2] - Lightweight template engine without its own bulky syntax (pure PHP, yay!)
- [Grunt][3] - Most common task runner for web projects
- [Node.js][4] - JavaScript development platform, but we only use it for Grunt

[1]: http://getcomposer.org
[2]: http://platesphp.com
[3]: http://gruntjs.com
[4]: http://nodejs.org
[5]: https://github.com/Tar-Minyatur/LazyCMS/releases/latest
[6]: https://github.com/Tar-Minyatur/LazyCMS/blob/master/LICENSE