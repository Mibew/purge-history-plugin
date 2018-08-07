var eventStream = require('event-stream'),
    gulp = require('gulp'),
    chmod = require('gulp-chmod'),
    zip = require('gulp-zip'),
    tar = require('gulp-tar'),
    gzip = require('gulp-gzip'),
    rename = require('gulp-rename');

gulp.task('prepare-release', function() {
    var version = require('./package.json').version;

    return eventStream.merge(
        getSources()
            .pipe(zip('purge-history-plugin-' + version + '.zip')),
        getSources()
            .pipe(tar('purge-history-plugin-' + version + '.tar'))
            .pipe(gzip())
    )
    .pipe(chmod(644))
    .pipe(gulp.dest('release'));
});

// Builds and packs plugins sources
gulp.task('default', ['prepare-release'], function() {
    // The "default" task is just an alias for "prepare-release" task.
});

/**
 * Returns files stream with the plugin sources.
 *
 * @returns {Object} Stream with VinylFS files.
 */
var getSources = function() {
    return gulp.src([
            'Plugin.php',
            'LICENSE',
            'README.md'
        ],
        {base: './'}
    )
    .pipe(rename(function(path) {
        path.dirname = 'Mibew/Mibew/Plugin/PurgeHistory/' + path.dirname;
    }));
}
