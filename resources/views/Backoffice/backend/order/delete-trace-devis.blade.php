@extends('Backoffice.layouts.app')

@section("content")

<div class="page page-tables-datatables">

    <div class="pageheader">
        <h2>Supprimer trace d'un dévis <span></h2>

        <div class="page-bar">

            <ul class="page-breadcrumb">
                <li>
                <a href="{{route('spaceDashboard')}}"><i class="fa fa-home"></i> MONASSURANCE.CI</a>
                </li>
                <li>
                    <a href="#">Configuration</a>
                </li>
                <li>
                    <a href="">Supprimer trace d'un dévis</a>
                </li>
            </ul>

        </div>

    </div>

    <!-- row -->
    <div class="row">
        <!-- col -->
        <div class="col-md-12">

       @if(\Illuminate\Support\Facades\Session::has('success'))
           <div class="text-center container w-420">
               <div class="alert alert-success alert-dismissable">
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                   <h4><p align="center">{{\Illuminate\Support\Facades\Session::get('success')}}</p></h4>
               </div>
           </div>
       @endif

       @if(\Illuminate\Support\Facades\Session::has('error'))
           <div class="text-center container w-420">
               <div class="alert alert-danger alert-dismissable">
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                   <h4><p align="center">{{\Illuminate\Support\Facades\Session::get('error')}}</p></h4>
               </div>
           </div>
       @endif
         

            <!-- tile -->
            <section class="tile">

                <!-- tile header -->
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Supprimer trace d'un dévis</strong></h1>
                    
                </div>
                <!-- /tile header -->

                <!-- tile body -->
                <div class="tile-body">
                    <div class="alert alert-danger"><i class="fa fa-warning"></i> Attention cette action est irréversible.</div>
                    <form class="form-horizontal" action="{{ route('deleteInfoDevisPost') }}" method="POST">
                     {{csrf_field()}}
                        <div class="form-group has-error">
                            <label class="col-sm-2 control-label" for="num_devis">Numéro de dévis</label>
                            <div class="col-sm-6">
                                <input type="text" required class="form-control" id="num_devis" name="num_devis" placeholder="Saisissez le numéro de devis que vous souhaitez supprimer">
                            </div>
                            <div class="col-sm-4">                      
                                <button class="btn btn-danger" type="submit"> Supprimer toutes infos relatif à ce devis</button>
                            </div>
                            
                        </div>
                        
                    </form>
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
<link rel="stylesheet" href="{{asset('back/assets/css/vendor/sweetalert/sweetalert.css')}}">
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
<link rel="stylesheet" href="<?php echo asset('back/assets/js/vendor/datatables/css/jquery.dataTables.min.css')?>">
<link rel="stylesheet" href="<?php echo asset('back/assets/js/vendor/datatables/datatables.bootstrap.min.css')?>">
<link rel="stylesheet" href="<?php echo asset('back/assets/js/vendor/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css')?>">
<link rel="stylesheet" href="<?php echo asset('back/assets/js/vendor/datatables/extensions/Responsive/css/dataTables.responsive.css')?>">
<link rel="stylesheet" href="<?php echo asset('back/assets/js/vendor/datatables/extensions/ColVis/css/dataTables.colVis.min.css')?>">
<link rel="stylesheet" href="<?php echo asset('back/assets/js/vendor/datatables/extensions/TableTools/css/dataTables.tableTools.min.css')?>">        
        
@endsection

@section('footer-script')
        <!--/ vendor javascripts -->
<script src="{{asset('back/assets/js/vendor/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/daterangepicker/moment.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/raty-fa/jquery.raty-fa.js')}}"></script>
<script src="<?php echo asset('back/assets/js/vendor/datatables/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo asset('back/assets/js/vendor/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js'); ?>"></script>
<script src="<?php echo asset('back/assets/js/vendor/datatables/extensions/Responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?php echo asset('back/assets/js/vendor/datatables/extensions/ColVis/js/dataTables.colVis.min.js'); ?>"></script>
<script src="<?php echo asset('back/assets/js/vendor/datatables/extensions/TableTools/js/dataTables.tableTools.min.js'); ?>"></script>
<script src="<?php echo asset('back/assets/js/vendor/datatables/extensions/dataTables.bootstrap.js'); ?>"></script>
@stop



@section('custom-script')

@stop

