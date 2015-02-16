module.exports = {

    cms: {
        expand: true,
        cwd: 'src/',
        src: [
            'classes/**',
            'templates/**',
            'assets/css/*.css',
            'index.php',
            'config-sample.inc.php',
            'createPassword.php',
            'composer.json'],
        dest: 'dist/',
        options: {
            process: function (content, srcpath) {
                content = content.replace(/\.\.\/example\//g, "example/");
                content = content.replace(/assets\/js\/LazyCMS.js/g, "assets/js/LazyCMS.min.js");
                return content;
            }
        }
    },
    example: {
        expand: true,
        src: [
            'example/data/**',
            'example/input/**'
        ],
        dest: 'dist/'
    }

}