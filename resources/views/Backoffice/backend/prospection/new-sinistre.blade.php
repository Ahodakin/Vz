@extends('Backoffice.layouts.app')
@section("content")
<div class="page page-ui-portlets">
	<div class="pageheader">
        <h2>Gestion des sinistres <span></span></h2>
		<div class="page-bar">

			<ul class="page-breadcrumb">
				<li>
					<a href="{{route('spaceDashboard')}}"><i class="fa fa-home"></i> AROLI ASSURANCE</a>
				</li>
				<li>
				<a href="#">Sinistre</a>
				</li>
                <li>
                <a href="#">Nouveau sinistre</a>
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
                                <li role="presentation" class="active"><a href="#new_sinistre" aria-controls="settingsTab" role="tab" data-toggle="tab">Declarer Sinistre</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">

                                <div role="tabpanel" class="tab-pane active" id="new_sinistre">

                                    <div class="wrap-reset">
 
                                        <!-- tile -->
                                        <section class="tile portlet">

                                            <!-- tile header -->
                                            <div class="tile-header dvd dvd-btm">
                                                <h1 class="custom-font"><strong>Declarer</strong> nouveau sinistre</h1>
                                               
                                            </div>
                                            <!-- /tile header -->

                                            <!-- tile body -->
                                            <div class="tile-body">
                                                <form class="form-horizontal" method="post" action="{{ route('sinistre.post') }}">
                                                    {{csrf_field()}}
                                                    <div class="form-group">
                                                        <label for="num_police">Numéro de police auto concerné*</label>
                                                        <select data-placeholder="..." required class="form-control chosen-select input-underline" name="num_police" id="num_police" style="width: 100%;">
                                                            <option></option>
                                                            @foreach($active_order as $o)
                                                                <option value="{{ $o->number_n }}">{{ $o->number_n }} ({{ $o->firstname }} {{ $o->lastname }})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name_client">Nom du sinistré*</label>
                                                        <input type="text" class="form-control" name="name_client" id="name_client" required placeholder="Entrez le nom du client sinistré">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="num_client">N° de téléphone*</label>
                                                        <input type="text" class="form-control" name="num_client" id="num_client" required placeholder="Entrez le N° du téléphone du client sinistré">
                                                    </div>

                                                    
                                                    <div class="form-group">
                                                        <label for="num_client">Date du sinistre*</label>
                                                        <div class="input-group datepicker_sinistredate w-330 mt-8" >
                                                            <input type="date"  name="sinistredate" required id="sinistredate"  class="datepicker_sinistredate form-control" placeholder="JJ/MM/AAAA">
                                                            <span class="input-group-addon">
                                                                <span class="fa fa-calendar"></span>
                                                            </span>

                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="declaration">Déclaration du sinistré*</label>
                                                        <textarea class="form-control" rows="5" name="declaration" id="declaration" required></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <button class="btn btn-success" type="submit">Enregistrer</button>
                                                        <button class="btn btn-danger" type="reset">Annuler</button>
                                                    </div>

                                                </form>
                                            </div>
                                            <!-- /tile body -->

                                        </section>
                                        <!-- /tile -->
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
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/datatables/css/jquery.dataTables.min.css')}}">
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/datatables/datatables.bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css')}}">
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/datatables/extensions/Responsive/css/dataTables.responsive.css')}}">
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/datatables/extensions/ColVis/css/dataTables.colVis.min.css')}}">
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/datatables/extensions/TableTools/css/dataTables.tableTools.min.css')}}">
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/chosen/chosen.css')}}">
@endsection

@section('footer-script')
<script src="{{asset('back/assets/js/vendor/daterangepicker/moment.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datatables/extensions/Responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datatables/extensions/ColVis/js/dataTables.colVis.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datatables/extensions/dataTables.bootstrap.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/chosen/chosen.jquery.min.js')}}"></script>
@endsection
@section('custom-script')

<script type="text/javascript">


$(window).load(function(){
 
    $('.datepicker_sinistredate').datetimepicker({
        format: 'DD/MM/YYYY'
        });
var table = $('#basic').DataTable({
        "dom": 'Rlfrtip'
    });

table2 = $('#basic2').DataTable({
        "dom": 'Rlfrtip'
    });


    

});
</script>
@endsection