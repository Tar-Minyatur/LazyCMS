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

### Installation

We're using [Composer][1] for dependency management and class autoloading, so all you need to
do after checking out the repository is:

    $ php composer install

If you're not going to develop anything, you probably won't need the development dependencies.
In this case you can skip those by adding `--no-dev´ to the call:

    $ php composer install --no-dev

As a final step you need to copy `config-sample.inc.php` to `config.inc.php`. You probably
want to change quite a few things in there.

### Credits

Thanks to these awesome projects for making our life so much easier:

- [Composer][1] - Dependency management for PHP
- [Plates][2] - Lightweight template engine without its own bulky syntax (pure PHP, yay!)

[1]: http://getcomposer.org
[2]: http://platesphp.com/
