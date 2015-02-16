module.exports = function (grunt) {
    return {

        files: [{
            url: 'https://getcomposer.org/installer',
            dest: '<%= cwd %>',
            name: 'composer_installer.php'
        }]

    }
};