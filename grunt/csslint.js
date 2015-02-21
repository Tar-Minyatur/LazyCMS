module.exports = function (grunt)  {
    return {

        cms_after_sass: {
            src: ['src/assets/css/*.css']
        },
        example: {
            src: ['example/input/**.css']
        }

    }
};