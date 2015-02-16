module.exports = function (grunt) {
    return {

        build: {
            files: [{
                expand: true,
                cwd: 'src/assets/scss/',
                src: 'screen.scss',
                dest: 'src/assets/css/',
                ext: '.css'
            }]
        },
        dist: {
            files: [{
                expand: true,
                cwd: 'src/assets/scss/',
                src: 'screen.scss',
                dest: 'dist/assets/css/',
                ext: '.css'
            }]

        }
    }
};