@extends('Backoffice.layouts.app')

@section("content")
<div class="page page-tables-datatables">

    <div class="pageheader">
       
        <h2>Détails & Documents du contrat #<span></h2>

        <div class="page-bar">

            <ul class="page-breadcrumb">
                <li>
            <a href="{{route('spaceDashboard')}}"><i class="fa fa-home"></i> AROLI ASSURANCE</a>
                </li>
                <li>
                    <a href="#">Gérer mes clients</a>
                </li>
                <li>
                    <a href="#">Détails & Documents du contrat</a>
                </li>
            </ul>

        </div>

    </div>

    <!-- row -->
    <div class="row">
        <!-- col -->
        <div class="col-md-12">


         

            <!-- tile -->
            <section class="tile">

                <!-- tile header -->
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Détails & Documents</strong> du contrat</h1>
                </div>
                <!-- /tile header -->

                <!-- tile body -->
                <div class="tile-body">

                        
                <div class="row" id="links">
                        @foreach($files as $file)
                        <!-- col -->
                        <div class="card-container col-lg-2 col-sm-4 col-sm-12">
                            <div class="card">
                                <div class="front bg-greensea">
                                    <!-- row -->
                                    <div class="row">
                                        <!-- col -->
                                        <div class="col-xs-12 text-center">
                                            <a href="/back/assets/js/vendor/file-upload/server/php/index.php?file={{$file}}&download=1">
                                                <img src="/back/assets/js/vendor/file-upload/server/php/index.php?file={{$file}}&version=thumbnail&download=1" >
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="back bg-lightred">

                                    <!-- row -->
                                    <div class="row">
                                        
                                        <!-- col -->
                                        <div class="col-xs-12">
                                            <a href="/back/assets/js/vendor/file-upload/server/php/index.php?file={{$file}}&download=1"><i class="fa fa-eye fa-2x"></i>Agrandir</a>
                                        </div>
                                        <!-- /col -->
                                    </div>
                                    <!-- /row -->

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div id="blueimp-gallery" class="blueimp-gallery">
                        <div class="slides"></div>
                        <h3 class="title"></h3>
                        <a class="prev">‹</a>
                        <a class="next">›</a>
                        <a class="close">×</a>
                        <a class="play-pause"></a>
                        <ol class="indicator"></ol>
                    </div>
                </div>
                <!-- /tile body -->

            </section>
            <!-- /tile -->

        </div>
        <!-- /col -->
    </div>
    <!-- /row -->

</div>
@endsection
                
@section('header-script')
<link rel="stylesheet" href="<?php echo asset('back/assets/js/vendor/datatables/css/jquery.dataTables.min.css')?>">
<link rel="stylesheet" href="<?php echo asset('back/assets/js/vendor/datatables/datatables.bootstrap.min.css')?>">
<link rel="stylesheet" href="<?php echo asset('back/assets/js/vendor/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css')?>">
<link rel="stylesheet" href="<?php echo asset('back/assets/js/vendor/datatables/extensions/Responsive/css/dataTables.responsive.css')?>">
<link rel="stylesheet" href="<?php echo asset('back/assets/js/vendor/datatables/extensions/ColVis/css/dataTables.colVis.min.css')?>">
<link rel="stylesheet" href="<?php echo asset('back/assets/js/vendor/datatables/extensions/TableTools/css/dataTables.tableTools.min.css')?>">

<link rel="stylesheet" href="<?php echo asset('back/assets/js/vendor/gallery/css/blueimp-gallery.min.css')?>">
@stop
      

@section('footer-script')
<script src="<?php echo asset('back/assets/js/vendor/parsley/parsley.min.js'); ?>"></script>

<script src="<?php echo asset('back/assets/js/vendor/form-wizard/jquery.bootstrap.wizard.min.js'); ?>"></script>
        <!--/ vendor javascripts -->

<script src="<?php echo asset('back/assets/js/vendor/datatables/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo asset('back/assets/js/vendor/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js'); ?>"></script>
<script src="<?php echo asset('back/assets/js/vendor/datatables/extensions/Responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?php echo asset('back/assets/js/vendor/datatables/extensions/ColVis/js/dataTables.colVis.min.js'); ?>"></script>
<script src="<?php echo asset('back/assets/js/vendor/datatables/extensions/TableTools/js/dataTables.tableTools.min.js'); ?>"></script>
<script src="<?php echo asset('back/assets/js/vendor/datatables/extensions/dataTables.bootstrap.js'); ?>"></script>

<script src="<?php echo asset('back/assets/js/vendor/gallery/js/blueimp-gallery.min.js'); ?>"></script>
@stop

@section('custom-script')

        <script>
            $(window).load(function(){
                document.getElementById('links').onclick = function (event) {
                    event = event || window.event;
                    var target = event.target || event.srcElement,
                        link = target.src ? target.parentNode : target,
                        options = {index: link, event: event},
                        links = this.getElementsByTagName('a');
                    blueimp.Gallery(links, options);
                };

            });
        </script>
@stop

