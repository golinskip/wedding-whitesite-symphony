module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        npmcopy: {
            options: {
                srcPrefix: 'node_modules',
                destPrefix: 'public'
            },
            libs: {
                files: {
                    'js/jquery.js': 'jquery/dist/jquery.js',
                    'js/bootstrap.js': 'bootstrap/dist/js/bootstrap.js',
                    'js/TimeCircles.js': 'timecircles/inc/TimeCircles.js'
                }
            },
            stylesheets: {
                files: {
                    'css/bootstrap.css': 'bootstrap/dist/css/bootstrap.css',
                    'css/font-awesome.css': 'font-awesome/css/font-awesome.css',
                    'css/TimeCircles.css': 'timecircles/inc/TimeCircles.css'
                }
            },
            fonts: {
                files: {
                    'fonts': 'font-awesome/fonts'
                }
            },
            tinymce: {
                files: {
                    'js/tinymce/jquery.tinymce.min.js': 'tinymce/jquery.tinymce.min.js',
                    'js/tinymce/tinymce.min.js': 'tinymce/tinymce.min.js',
                    'js/tinymce/skins': 'tinymce/skins',
                    'js/tinymce/plugins': 'tinymce/plugins',
                    'js/tinymce/themes': 'tinymce/themes',
                }
            },
        },
        copy: {
            main: {
                files: [
                    {expand: true, src: "src_web/js/**", dest: "web/assets"},
                    {expand: true, src: "src_web/img/**", dest: "web/assets"}
                ]
            }
        },
        sass: { // Task
            dist: { // Target
                options: { // Target options
                    compress: false,
                    yuicompress: false
                },
                files: { // Dictionary of files
                    'web/assets/css/style.css': 'src_web/sass/main.scss', // 'destination': 'source'
                }
            }
        },
        watch: {
            styles: {
                files: ['sass/**', 'js/**', 'img/**'], // which files to watch
                tasks: ['sass', 'copy'],
                options: {
                    nospawn: true
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-npmcopy');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.registerTask('default', ['npmcopy', 'sass', 'copy', 'watch']);
};
