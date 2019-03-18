let gulp = require('gulp'); 

let clean = require('gulp-clean');
let rename = require('gulp-rename');
let sass = require('gulp-sass');
let autoprefixer = require('gulp-autoprefixer');
let cleanCSS = require('gulp-clean-css');
let babel = require('gulp-babel');
let uglify = require('gulp-uglify');

/*------ 合併 task  ------*/
function cleanAll(){
  return gulp.src('./dist', {read:false})
    .pipe(clean());  
};

function css(){
  return gulp.src('./src/*.scss')
    .pipe(sass().on('error', sass.logError)) //SCSS 轉 CSS
    .pipe(autoprefixer()) // 加 prefixer
    .pipe(cleanCSS()) //壓縮
    .pipe(rename('min.css'))
    .pipe(gulp.dest('./dist'))
};

function js(){
  return gulp.src('./src/*.js')
    .pipe(babel({ //ES6 轉成 ES5
      presets: ['@babel/env']
    }))
    .pipe(uglify()) //壓縮
    .pipe(rename('min.js'))
    .pipe(gulp.dest('./dist'))
};

exports.clean = cleanAll;
exports.css = css;
exports.js = js;

exports.default = gulp.series(
  cleanAll,
  gulp.parallel(css,js)
);



/*------ task 都分開  ------
function cleanAll(){
  let files = ['./src/build/*' , './dist/*']
  return gulp.src( files , {read:false})
    .pipe(clean());  
};

function sassToCss(){
  return gulp.src('./src/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(rename('sass.css'))
    .pipe(gulp.dest('./src/build'));
};

function addPrefixer(){
  return gulp.src('./src/build/*.css')
    .pipe(autoprefixer())
    .pipe(rename('prefixer.css'))
    .pipe(gulp.dest('./src/build'));
}

function minCss(){
  return gulp.src('./src/build/prefixer.css')
    .pipe(cleanCSS())
    .pipe(rename('min.css'))
    .pipe(gulp.dest('./dist'));
}

function jsES5(){
  return gulp.src('./src/*.js')
    .pipe(babel({
      presets: ['@babel/env']
    }))
    .pipe(rename('es5.js'))
    .pipe(gulp.dest('./src/build'))
}

function minJs(){
  return gulp.src('./src/build/*.js')
    .pipe(uglify())
    .pipe(rename('min.js'))
    .pipe(gulp.dest('./dist'))
}

exports.clean = cleanAll;
exports.sass = sassToCss;
exports.autoprefixer = addPrefixer;
exports.cleanCSS = minCss;
exports.babel = jsES5;
exports.uglify= minJs;

exports.default = gulp.series(
  cleanAll, //清空
  gulp.parallel(
    gulp.series(sassToCss,addPrefixer,minCss), //處理 CSS
    gulp.series(jsES5,minJs) //處理 JS
  )
);
*/