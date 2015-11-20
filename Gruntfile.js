module.exports = function(grunt) {

    // load all grunt tasks matching the `grunt-*` pattern
    require('load-grunt-tasks')(grunt);

    grunt.initConfig({

        // watch for changes and trigger sass, jshint, uglify and livereload
        watch: {
            sass: {
                files: ['styles/**/*.{scss,sass}'],
                tasks: ['sass', 'autoprefixer']
            },
            js: {
                files: '<%= jshint.all %>',
                tasks: ['jshint', 'uglify']
            },
            images: {
                files: ['images/**/*.{png,jpg,gif}'],
                tasks: ['imagemin']
            }
        },

        // sass
        sass: {
            dist: {
                options: {
                    style: 'expanded'
                },
                files: {
                    'styles/build/style.css': 'styles/style.scss'
                }
            }
        },

        // autoprefixer
        autoprefixer: {
            options: {
                browsers: ['last 2 versions', 'ie 9', 'ios 6', 'android 4'],
                map: true
            },
            your_target: {
                expand: false,
                flatten: true,
                src: 'styles/build/*.css',
                dest: 'style.css'
            }
        },

        // javascript linting with jshint
        jshint: {
            options: {
                jshintrc: '.jshintrc',
                "force": true
            },
            all: [
                'Gruntfile.js',
                'js/source/**/*.js'
            ]
        },

        // uglify to concat, minify, and make source maps
        uglify: {
            plugins: {
                options: {
                    sourceMap: 'js/plugins.js.map',
                    sourceMappingURL: 'plugins.js.map',
                    sourceMapPrefix: 2
                },
                files: {
                    'js/plugins.min.js': [
                        'js/source/plugins.js',
                        'js/vendor/navigation.js',
                        'js/vendor/skip-link-focus-fix.js',
                        // 'js/vendor/yourplugin/yourplugin.js',
                    ]
                }
            },
            accordion: {
                options: {
                    sourceMap: 'js/accordion.js.map',
                    sourceMappingURL: 'accordion.js.map',
                    sourceMapPrefix: 2
                },
                files: {
                    'js/accordion.min.js': [
                        'js/source/accordion.js'
                    ]
                }
            },
            main: {
                options: {
                    sourceMap: 'js/main.js.map',
                    sourceMappingURL: 'main.js.map',
                    sourceMapPrefix: 2
                },
                files: {
                    'js/main.min.js': [
                        'js/source/main.js'
                    ]
                }
            }
        },

        // image optimization
        imagemin: {
            dist: {
                options: {
                    optimizationLevel: 7,
                    progressive: true,
                    interlaced: true
                },
                files: [{
                    expand: true,
                    cwd: 'images/',
                    src: ['**/*.{png,jpg,gif}'],
                    dest: 'images/'
                }]
            }
        },

        // browserSync
        browserSync: {
            dev: {
                bsFiles: {
                    src : ['style.css', 'js/*.js', 'images/**/*.{png,jpg,jpeg,gif,webp,svg}']
                },
                options: {
                    proxy: "http://bp-vagrant.dev/",
                    watchTask: true
                }
            }
        },

        // deploy via rsync
        deploy: {
            options: {
                src: "./",
                args: ["--verbose"],
                exclude: ['.git*', 'node_modules', '.sass-cache', 'Gruntfile.js', 'package.json', '.DS_Store', 'README.md', 'config.rb', '.jshintrc'],
                recursive: true,
                syncDestIgnoreExcl: true
            },
            staging: {
                options: {
                    dest: "~/path/to/theme",
                    host: "user@host.com"
                }
            },
            production: {
                options: {
                    dest: "~/path/to/theme",
                    host: "user@host.com"
                }
            }
        }

    });

    // rename tasks
    grunt.renameTask('rsync', 'deploy');

    // register task
    grunt.registerTask('default', ['sass', 'autoprefixer', 'uglify', 'browserSync', 'watch']);

};
