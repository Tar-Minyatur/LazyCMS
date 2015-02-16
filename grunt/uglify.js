module.exports = function (grunt) {
    return {

        options: {
            banner: '/*! <%= package.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
        },
        dist: {
            files: {
                'dist/assets/js/<%= package.name %>.min.js': ['dist/assets/js/<%= package.name %>.js']
            }
        }

    }
};