var gulp = require('gulp');
var sass = require('gulp-sass');


gulp.task('sass', function () {
    return gulp.src('./src/styles/*.scss')
      .pipe(sass().on('error', sass.logError))
      .pipe(gulp.dest('./css'));
  });



gulp.task('default', function() {
  // place code for your default task here
  console.log('task default');
});





gulp.task('watch', function () {
    gulp.watch('./src/styles/*.scss', ['sass']);
});


