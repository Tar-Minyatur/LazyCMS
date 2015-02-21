module.exports = function (grunt) {
    return {

        dist: {
            src: ['src/assets/js/*.js'],
            dest: 'dist/assets/js/<%= package.name %>.js'
        },
        build: {
            src: ['src/assets/js/*.js'],
            dest: 'src/assets/js/<%= package.name %>.js'
        }

    };
};