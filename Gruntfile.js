module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        npmcopy: {
            options: {
                srcPrefix: 'node_modules',
                destPrefix: 'public/vendor'
            },
            libs: {
                files: {
                    'js/jquery.js': 'jquery/dist/jquery.js',
                    'js/bootstrap.js': 'bootstrap/dist/js/bootstrap.js',
                    'js/TimeCircles.js': 'timecircles/inc/TimeCircles.js',
                    'js/jquery.litebox.js': 'jquery-litebox/dist/jquery.litebox.js'
                }
            },
            stylesheets: {
                files: {
                    'css/bootstrap.css': 'bootstrap/dist/css/bootstrap.css',
                    'css/font-awesome.css': 'font-awesome/css/font-awesome.css',
                    'css/TimeCircles.css': 'timecircles/inc/TimeCircles.css',
                    'css/jquery.litebox.css': 'jquery-litebox/dist/jquery.litebox.css',
                    'css/jquery.litebox.gallery.css': 'jquery-litebox/dist/jquery.litebox.gallery.css'
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
                    {expand: true, flatten:true, filter: 'isFile', src: "src_web/js/**", dest: "public/js"},
                    {expand: true, src: "src_web/img/**", dest: "public/img"}
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
                    'public/css/style.css': 'src_web/sass/main.scss', // 'destination': 'source'
                }
            }
        },
        watch: {
            styles: {
                files: ['src_web/**'], // which files to watch
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
