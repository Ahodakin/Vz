@extends('Backoffice.layouts.app')
@section("content")
<div class="page page-ui-portlets">
    <div class="pageheader">
        <h2>Import data <span></span></h2>
        <div class="page-bar">

            <ul class="page-breadcrumb">
                <li>
                    <a href="{{route('spaceDashboard')}}"><i class="fa fa-home"></i> AROLI ASSURANCE</a>
                </li>
                <li>
                <a href="#.">Import Data</a>
                </li>
            </ul>

        </div>
    </div>
    <!-- page content -->
    <div class="pagecontent">
        @if(\Illuminate\Support\Facades\Session::has('success'))
            <div class="text-center container w-420">
                <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><p align="center">{{\Illuminate\Support\Facades\Session::get('success')}}</p></h4>
                </div>
            </div>
        @endif
    
        <!-- row -->
        <div class="row">

            <!-- col -->
            <div class="col-sm-12 portlets sortable">
            
                <!-- tile -->
                <section class="tile tile-simple">

                    <!-- tile body -->
                    <div class="tile-body p-0">

                        <div role="tabpanel">

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs tabs-dark" role="tablist">
                                <li role="presentation" class="active"><a href="#auto" aria-controls="settingsTab" role="tab" data-toggle="tab">Automobile</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">

                                <div role="tabpanel" class="tab-pane active" id="auto">

                                    <div class="wrap-reset">
                                       
                                        <div class="row">
                                            <div class="col-md-12">
                                            <button class="btn btn-success" data-toggle="modal" data-target="#splash-client">Clients</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

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
</div>

@endsection
@section('header-script')
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/datatables/css/jquery.dataTables.min.css')}}">
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/datatables/datatables.bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css')}}">
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/datatables/extensions/Responsive/css/dataTables.responsive.css')}}">
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/datatables/extensions/ColVis/css/dataTables.colVis.min.css')}}">
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/datatables/extensions/TableTools/css/dataTables.tableTools.min.css')}}">
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/daterangepicker/daterangepicker-bs3.css')}}">
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/chosen/chosen.css')}}">
@endsection

@section('footer-script')
<script src="{{asset('back/assets/js/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datatables/extensions/Responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datatables/extensions/ColVis/js/dataTables.colVis.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datatables/extensions/dataTables.bootstrap.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/daterangepicker/moment.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
@endsection

@section('custom-script')
<!-- Splash Modal -->
<div class="modal splash fade" id="splash-client" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title custom-font">Exporter données clients</h3>
            </div>
            <form class="form-horizontal" method="post" action="{{route('postExportClient')}}">
            <div class="modal-body">  
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h4>Exporter les clients ayant effectuer une commande dans la période</h4>
                                <a role="button" tabindex="0" class="btn btn-lightred no-border pickDate" >
                                    <i class="fa fa-calendar"></i>&nbsp;&nbsp;<span></span>&nbsp;&nbsp;<i class="fa fa-angle-down"></i>
                                </a>
                                
                            </div>
                        </div>
                        <input type="hidden" value="{{ date('Y-m-d') }}" name="start" id="start">
                        <input type="hidden" value="{{ date('Y-m-d') }}" name="end" id="end">
                        <div class="form-group text-center">
                            <h4>Colonnes à exporter</h4>
                            <div class="col-sm-12">

                                <label class="checkbox-inline checkbox-custom">
                                    <input name="field_query[]" type="checkbox" value="lastname"><i></i> Nom
                                </label>
                                <label class="checkbox-inline checkbox-custom">
                                    <input name="field_query" type="checkbox" value="firstname"><i></i> Prénoms
                                </label>
                                <label class="checkbox-inline checkbox-custom">
                                    <input name="field_query[]" type="checkbox" value="email"><i></i> E-mail
                                </label>
                                <label class="checkbox-inline checkbox-custom">
                                    <input name="field_query[]" type="checkbox" value="dob"><i></i> Date naissance
                                </label>
                                <label class="checkbox-inline checkbox-custom">
                                    <input name="field_query[]" type="checkbox" value="contact" checked><i></i> Téléphone
                                </label>
                                <label class="checkbox-inline checkbox-custom">
                                    <input name="field_query[]" type="checkbox" value="number_n"><i></i> N° de police
                                </label>

                            </div>
                        </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-ef btn-ef-3 btn-ef-3c mb-10">Exporter données
                 <i class="fa fa-arrow-right"></i></button>
                <button type="reset" class="btn btn-danger btn-ef btn-ef-3 btn-ef-3c mb-10" data-dismiss="modal">Annuler</button>
            </div>
             </form>
        </div>
    </div>
</div>
<script type="text/javascript">

$(window).load(function(){
 

var table = $('#basic').DataTable({
        "dom": 'Rlfrtip'
    });

});
</script>
@endsection