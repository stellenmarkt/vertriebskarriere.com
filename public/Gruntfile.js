module.exports = function(grunt) {

  var targetDir = grunt.config.get('targetDir');
  var moduleDir = targetDir + "/modules/JobsFrankfurt";

  grunt.config.merge({
    less: {
      stellenmarkt: {
        options: {
          compress: true,
          optimization: 2
        },
        files: [
            {
              dest: targetDir + "/modules/JobsFrankfurt/layout.css",
              src: moduleDir + "/less/layout.less"
            },
            { dest: moduleDir + "/templates/default/job.css", src: moduleDir + "/templates/default/less/job.less"}, // destination file and source file
            { dest: moduleDir + "/templates/modern/job.css", src: moduleDir + "/templates/modern/less/job.less"}, // destination file and source file
            { dest: moduleDir + "/templates/classic/job.css", src: moduleDir + "/templates/classic/less/job.less"} // destination file and source file
          ]

      }
    }
  });

  grunt.registerTask('yawik:vertriebsjobs', ['less:vertriebsjobs']);
};
