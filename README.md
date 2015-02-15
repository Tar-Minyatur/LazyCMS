# LazyCMS
A very simple CMS that can edit a single JSON file with text labels.

### Goals

Simple and easy, no unnecessary features. This is supposed to be used for very small projects
where all that is needed is some very basic content management and nothing fancy.

### Features

- Content can be split into into sections (with a global section for shared content)
- Mechanism to generate output files with replaced text labels
- Script to retrieve text labels from source files (similar to gettext)

### Upcoming Features

- Mechanism to render output files with replaced text labels on the fly

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
