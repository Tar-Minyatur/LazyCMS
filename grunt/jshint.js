module.exports = function (grunt) {
    return {

        cms_before_concat: ['Gruntfile.js', 'src/assets/js/**'],
        cms_after_concat: ['dist/assets/js/<%= package.name %>.js'],
        example: ['example/input/**.js']

    }
};