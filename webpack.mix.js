let mix = require('laravel-mix');



mix.styles([
   'resources/assets/plantilla/css/font-awesome.min.css',
   'resources/assets/plantilla/css/simple-line-icons.min.css',
   'resources/assets/plantilla/css/style.css'
], 'public/css/plantilla.css')
.scripts([
   'resources/assets/plantilla/js/popper.min.js',
   'resources/assets/plantilla/js/jquery.min.js',
   'resources/assets/plantilla/js/bootstrap.min.js',
   'resources/assets/plantilla/js/Chart.min.js',   
   'resources/assets/plantilla/js/pace.min.js',   
   'resources/assets/plantilla/js/template.js',
   'resources/assets/plantilla/js/sweetalert2.all.min.js',
   'resources/assets/plantilla/js/jquery.rut.js',
   'resources/assets/plantilla/js/jquery.rut.min.js'
], 'public/js/plantilla.js')
.js(['resources/assets/js/app.js'],'public/js/app.js');