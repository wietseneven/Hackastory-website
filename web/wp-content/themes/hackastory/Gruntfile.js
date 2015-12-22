module.exports = function (grunt) {
    // Load grunt tasks automatically
    require('load-grunt-tasks')(grunt);

    grunt.initConfig({
        sass: {
            options : {
                outputStyle : 'compressed'
            },

            dist : {
                files : {
                    'css/style.css' : 'css/scss/style.scss'
                }
            }
        },

        autoprefixer : {
            dist : {
                files : {
                    'css/style.css' : 'css/style.css'
                }
            }
        },

        watch : {
            css : {
                files : 'app/css/scss/*.scss',
                tasks : ['sass', 'autoprefixer']
            }
        }
    });

    grunt.registerTask('style', [
        'sass',
        'autoprefixer'
    ]);

    grunt.registerTask('default', ['style']);
};