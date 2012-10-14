/*global module:false*/
module.exports = function(grunt) {
  
  var groups = grunt.file.readJSON('scripts/groups.json');
  
  // Project configuration.
  grunt.initConfig({
    pkg: {
      "name": "lesintegristes-theme",
      "title": "Les intégristes - Theme",
      "description": "The WordPress Theme that we use for our blog",
      "version": "0.1.0",
      "homepage": "https://github.com/lesintegristes/lesintegristes-theme",
      "author": {
        "name": "Pierre Bertet",
        "email": "bonjour@pierrebertet.net",
        "url": "http://pierrebertet.net/"
      },
      "licenses": [{
        "type": "MIT",
        "url": "https://github.com/lesintegristes/lesintegristes-theme/blob/master/LICENSE-MIT"
      }]
    },
    meta: {
      banner: '/*! <%= pkg.title || pkg.name %> - v<%= pkg.version %> - ' +
        '<%= grunt.template.today("yyyy-mm-dd") %>\n' +
        '<%= pkg.homepage ? "* " + pkg.homepage + "\n" : "" %>' +
        '* Copyright (c) <%= grunt.template.today("yyyy") %> <%= pkg.author.name %>;' +
        ' Licensed <%= _.pluck(pkg.licenses, "type").join(", ") %> */'
    },
    groups: groups,
    lint: {
      files: [
        'grunt.js',
        'scripts/single.js',
        'scripts/main.js'
      ]
    },
    concat: {
      single: {
        src: ['<banner:meta.banner>', '<config:groups.single.files>'],
        dest: groups.single.concat
      },
      main: {
        src: ['<banner:meta.banner>', '<config:groups.main.files>'],
        dest: groups.main.concat
      }
    },
    min: {
      single: {
        src: ['<banner:meta.banner>', '<config:concat.single.dest>'],
        dest: groups.single.min
      },
      main: {
        src: ['<banner:meta.banner>', '<config:concat.main.dest>'],
        dest: groups.main.min
      }
    },
    watch: {
      files: '<config:lint.files>',
      tasks: 'lint'
    },
    jshint: {
      options: {
        curly: true,
        eqeqeq: true,
        immed: false,
        latedef: true,
        newcap: true,
        noarg: true,
        sub: true,
        undef: true,
        boss: true,
        eqnull: true,
        browser: true,
        laxbreak: true
      },
      globals: {
        jQuery: false,
        LESINTEGRISTES: false
      }
    },
    uglify: {}
  });

  // Default task.
  grunt.registerTask('default', 'lint concat min');

};
