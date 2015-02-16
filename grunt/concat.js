module.exports = function (grunt) {
    return {

        dist: {
            src: ['src/assets/js/*.js'],
            dest: 'dist/assets/js/<%= package.name %>.js'
        }

    }
};