/* Import Node.js modules */
var environments = require('gulp-environments'),
    autoprefixer = require('autoprefixer');


var config = {
    sourceDir: "./src/asset-files/",
    buildDir: "./src/asset-files/",
    styles: {
        lessDir: "./src/asset-files/less",
        lessFiles: ['./src/asset-files/less/styles.less'],
        scssDir: "./src/asset-files/scss/",
        scssFiles: "./src/asset-files/scss/**/*.scss",
        destinationDir: "./src/asset-files/css",
        mapsDir: "./maps", // relative to the destination directory
        postcss: [
            autoprefixer({browsers: ["last 5 versions", "> .5% in NG", "not ie < 11"]})
        ]
    },
    scripts: {
        sourceDir: "./src/asset-files/js",
        sourceFiles: ["./src/asset-files/js/**/*.js"],
        destinationDir: "./src/asset-files/js"
    },
    images: {
        sourceDir: "./src/asset-files/img",
        sourceFiles: "./src/asset-files/img/**/*",
        destinationDir: "./src/asset-files/img"
    },
    publicAssets: {
        sourceDir: "",
        sourceFiles: [],
        destinationDir: ""
    },
};

/* Add sourcemaps on all environments except production */
config.sourcemaps = !(environments.production());

/* Minify build files on all environments except development */
config.minify = !(environments.development());


module.exports = config;
