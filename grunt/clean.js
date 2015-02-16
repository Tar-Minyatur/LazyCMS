module.exports = function (grunt)  {
    return {

        dist_clean: ['dist/**', '!dist/vendor/**'],
        installer: ['composer_installer.php']

    }
};