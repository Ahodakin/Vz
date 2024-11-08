@extends('Backoffice.layouts.app')
@section("content")
<div class="page page-ui-portlets">
    <div class="pageheader">
        <h2>Configuration Relance <span></span></h2>
        <div class="page-bar">

            <ul class="page-breadcrumb">
                <li>
                    <a href="{{route('spaceDashboard')}}"><i class="fa fa-home"></i> MONASSURANCE.CI</a>
                </li>
                <li>
                <a href="#.">Relance</a>
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

        @if(\Illuminate\Support\Facades\Session::has('error'))
            <div class="text-center container w-420">
                <div class="alert alert-danger alert-dismissable">
                    <h4><p align="center">{{\Illuminate\Support\Facades\Session::get('error')}}</p></h4>
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
                                <li role="presentation" class="active"><a href="#prospect" aria-controls="settingsTab" role="tab" data-toggle="tab">Prospect/Devis</a></li>
                                <li role="presentation"><a href="#client" aria-controls="settingsTab" role="tab" data-toggle="tab">Client/Commande</a></li>
                                <li role="presentation"><a href="#call" aria-controls="settingsTab" role="tab" data-toggle="tab">Call center</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">

                                <div role="tabpanel" class="tab-pane active" id="prospect">

                                    <div class="wrap-reset">
                                        <div class="row">   
                                            <div class="col-md-4">
                                                <label class="checkbox checkbox-custom">
                                                    <input type="checkbox" name="sms" id="sms"><i></i>
                                                    SMS au prospect
                                                </label>
                                                <div class="form-group">                            
                                                    <label class="control-label">SENDER ID</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <div class="form-group">                            
                                                    <label class="control-label">CORPS DU SMS</label>
                                                    <textarea class="form-control" rows="3"></textarea>
                                                    {{--<div id="summernote_sms"></div>--}}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="checkbox checkbox-custom">
                                                    <input type="checkbox" name="email" id="email"><i></i>
                                                    EMAIL au prospect
                                                </label>
                                                <div class="form-group">                            
                                                    <label class="control-label">OBJET</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <div class="form-group">                            
                                                    <label class="control-label">CORPS DU MAIL</label>
                                                    <textarea class="form-control" rows="3"></textarea>
                                                    {{--<div id="summernote_email"></div>--}}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="checkbox checkbox-custom">
                                                    <input type="checkbox" name="dashboard" id="dashboard"><i></i>
                                                    DASHBOARD du conseiller
                                                </label>
                                                <div class="form-group">                            
                                                    <label class="control-label">TITRE</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <div class="form-group">                            
                                                    <label class="control-label">CORPS DU MESSAGE</label>
                                                    <textarea class="form-control" rows="3"></textarea>
                                                    {{--<div id="summernote_email"></div>--}}
                                                </div>
                                            </div>
                                        </div>
                                      
                                    </div>

                                </div>
                                <div role="tabpanel" class="tab-pane" id="client">

                                    <div class="wrap-reset">

                                        <div class="row">   
                                            <div class="col-md-4">
                                                <label class="checkbox checkbox-custom">
                                                    <input type="checkbox" name="sms" id="sms"><i></i>
                                                    SMS aux clients
                                                </label>
                                                <div class="form-group">                            
                                                    <label class="control-label">SENDER ID</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <div class="form-group">                            
                                                    <label class="control-label">CORPS DU SMS</label>
                                                    <textarea class="form-control" rows="3"></textarea>
                                                    {{--<div id="summernote_sms"></div>--}}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="checkbox checkbox-custom">
                                                    <input type="checkbox" name="email" id="email"><i></i>
                                                    EMAIL aux clients
                                                </label>
                                                <div class="form-group">                            
                                                    <label class="control-label">OBJET</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <div class="form-group">                            
                                                    <label class="control-label">CORPS DU MAIL</label>
                                                    <textarea class="form-control" rows="3"></textarea>
                                                    {{--<div id="summernote_email"></div>--}}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="checkbox checkbox-custom">
                                                    <input type="checkbox" name="dashboard" id="dashboard"><i></i>
                                                    DASHBOARD du conseiller
                                                </label>
                                                <div class="form-group">                            
                                                    <label class="control-label">TITRE</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <div class="form-group">                            
                                                    <label class="control-label">CORPS DU MESSAGE</label>
                                                    <textarea class="form-control" rows="3"></textarea>
                                                    {{--<div id="summernote_email"></div>--}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div role="tabpanel" class="tab-pane" id="call">

                                    <div class="wrap-reset">

                                        

                                    </div>

                                </div>

                                <div role="tabpanel" class="tab-pane" id="prevoyance">

                                    <div class="wrap-reset">

                                        

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
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/summernote/summernote.css')}}">
<style type="text/css">
    .note-popover.popover { z-index: 9999 !important; }
</style>
@endsection

@section('footer-script')
<script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
<script src="{{asset('back/assets/js/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datatables/extensions/Responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datatables/extensions/ColVis/js/dataTables.colVis.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datatables/extensions/dataTables.bootstrap.js')}}"></script>

<script src="{{asset('back/assets/js/vendor/summernote/summernote.min.js')}}"></script>

@endsection
@section('custom-script')
<script type="text/javascript">

$("#summernote_sms").summernote({
  height: 100,
  toolbar: false,
  hint: {
    mentions: ['nom', 'prenoms', 'num_devis', 'date_devis'],
    match: /\B@(\w*)$/,
    search: function (keyword, callback) {
      callback($.grep(this.mentions, function (item) {
        return item.indexOf(keyword) == 0;
      }));
    },
    content: function (item) {
      return '@' + item ;
    }    
  }
});

$("#summernote_email").summernote({
  height: 100,
  toolbar: false,
  hint: {
    mentions: ['nom', 'prenoms', 'num_devis', 'date_devis'],
    match: /\B@(\w*)$/,
    search: function (keyword, callback) {
      callback($.grep(this.mentions, function (item) {
        return item.indexOf(keyword) == 0;
      }));
    },
    content: function (item) {
      return '@' + item ;
    }    
  }
});

$("#summernote_dashboard").summernote({
  height: 100,
  toolbar: false,
  hint: {
    mentions: ['nom', 'prenoms', 'num_devis', 'date_devis'],
    match: /\B@(\w*)$/,
    search: function (keyword, callback) {
      callback($.grep(this.mentions, function (item) {
        return item.indexOf(keyword) == 0;
      }));
    },
    content: function (item) {
      return '@' + item ;
    }    
  }
});


</script>
@endsection