@extends('Backoffice.layouts.app')
@section("content")
<div class="page page-ui-portlets">
	<div class="pageheader">
        <h2>Notification <span></span></h2>
		<div class="page-bar">

			<ul class="page-breadcrumb">
				<li>
					<a href="{{route('spaceDashboard')}}"><i class="fa fa-home"></i> AROLI ASSURANCE</a>
				</li>
				<li>
				<a href="#">Notifications</a>
				</li>
                <li>
                <a href="#">Call Me</a>
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
                                <li role="presentation" class="active"><a href="#active_call" aria-controls="settingsTab" role="tab" data-toggle="tab">Appels non traités</a></li>
                                <li role="presentation" class=""><a href="#my_finish_call" aria-controls="settingsTab" role="tab" data-toggle="tab">Mes Appels traités</a></li>
                                <li role="presentation" class=""><a href="#all_finish_call" aria-controls="settingsTab" role="tab" data-toggle="tab">Tous les Appels traités</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">

                                <div role="tabpanel" class="tab-pane active" id="active_call">

                                    <div class="wrap-reset">
 
                                        <!-- tile -->
                                        <section class="tile portlet">

                                            <!-- tile header -->
                                            <div class="tile-header dvd dvd-btm">
                                                <h1 class="custom-font"><strong>Listes des</strong> appel à traiter</h1>
                                                <ul class="controls">
                                                    <li class="dropdown">

                                                        <a role="button" tabindex="0" class="dropdown-toggle settings" data-toggle="dropdown">
                                                            <i class="fa fa-cog"></i>
                                                            <i class="fa fa-spinner fa-spin"></i>
                                                        </a>

                                                        <ul class="dropdown-menu pull-right with-arrow animated littleFadeInUp">
                                                            <li>
                                                                <a role="button" tabindex="0" class="tile-toggle">
                                                                    <span class="minimize"><i class="fa fa-angle-down"></i>&nbsp;&nbsp;&nbsp;Réduire</span>
                                                                    <span class="expand"><i class="fa fa-angle-up"></i>&nbsp;&nbsp;&nbsp;Agrandir</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a role="button" tabindex="0" class="tile-refresh">
                                                                    <i class="fa fa-refresh"></i> Rafraichir
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a role="button" tabindex="0" class="tile-fullscreen">
                                                                    <i class="fa fa-expand"></i> Fullscreen
                                                                </a>
                                                            </li>
                                                        </ul>

                                                    </li>
                                                </ul>
                                            </div>
                                            <!-- /tile header -->

                                            <!-- tile body -->
                                            <div class="tile-body">
                                                <div class="table-responsive">
                                                    <table class="table table-custom" id="basic">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Nom</th>
                                                            <th>Contact</th>
                                                            <th>Date</th>
                                                            <th>Priorité</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($active_call_me as $key=>$c)
                                                            <tr>
                                                                <td>{{ ++$key }}</td>
                                                                <td>{{ $c->call_name }}</td>
                                                                <td>{{ $c->call_phone }}</td>
                                                                <td>{{ date('d/m/Y H:i:s',strtotime($c->created_at)) }}</td>
                                                                <td>
                                                                @if($c->call_motif==1)
                                                                <label class="label label-danger">(1).Renouvelement</label>
                                                                @elseif($c->call_motif==2)
                                                                <label class="label label-warning">(2).Nouveau dévis</label>
                                                                @else
                                                                <label class="label label-info">(3).Information</label>
                                                                @endif
                                                                </td>
                                                                <td><a href="{{ route('single.notiication.call',$c->call_id) }}" class="btn btn-primary"><i class="fa fa-check"></i>Afficher</a></td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- /tile body -->

                                        </section>
                                        <!-- /tile -->
                                    </div>

                                </div>

                                <div role="tabpanel" class="tab-pane" id="my_finish_call">

                                    <div class="wrap-reset">
 
                                        <!-- tile -->
                                        <section class="tile portlet">

                                            <!-- tile header -->
                                            <div class="tile-header dvd dvd-btm">
                                                <h1 class="custom-font"><strong>Listes des</strong> appel traité</h1>
                                                <ul class="controls">
                                                    <li class="dropdown">

                                                        <a role="button" tabindex="0" class="dropdown-toggle settings" data-toggle="dropdown">
                                                            <i class="fa fa-cog"></i>
                                                            <i class="fa fa-spinner fa-spin"></i>
                                                        </a>

                                                        <ul class="dropdown-menu pull-right with-arrow animated littleFadeInUp">
                                                            <li>
                                                                <a role="button" tabindex="0" class="tile-toggle">
                                                                    <span class="minimize"><i class="fa fa-angle-down"></i>&nbsp;&nbsp;&nbsp;Réduire</span>
                                                                    <span class="expand"><i class="fa fa-angle-up"></i>&nbsp;&nbsp;&nbsp;Agrandir</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a role="button" tabindex="0" class="tile-refresh">
                                                                    <i class="fa fa-refresh"></i> Rafraichir
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a role="button" tabindex="0" class="tile-fullscreen">
                                                                    <i class="fa fa-expand"></i> Fullscreen
                                                                </a>
                                                            </li>
                                                        </ul>

                                                    </li>
                                                </ul>
                                            </div>
                                            <!-- /tile header -->

                                            <!-- tile body -->
                                            <div class="tile-body">
                                                <div class="table-responsive">
                                                    <table class="table table-custom" id="basic2">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Nom</th>
                                                            <th>Contact</th>
                                                            <th>Motif de l'appel</th>
                                                            <th>Date</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($my_finish_call_me as $key=>$c)
                                                            <tr>
                                                                <td>{{ ++$key }}</td>
                                                                <td>{{ $c->call_name }}</td>
                                                                <td>{{ $c->call_phone }}</td>
                                                                <td>{{ $c->reason }}</td>
                                                                <td>{{ $c->created_at }}</td>
                                                                <td><a href="{{ route('single.notiication.call',$c->call_id) }}" class="btn btn-primary"><i class="fa fa-check"></i>Traiter</a></td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- /tile body -->

                                        </section>
                                        <!-- /tile -->
                                    </div>

                                </div>

                                <div role="tabpanel" class="tab-pane" id="all_finish_call">

                                    <div class="wrap-reset">
 
                                        <!-- tile -->
                                        <section class="tile portlet">

                                            <!-- tile header -->
                                            <div class="tile-header dvd dvd-btm">
                                                <h1 class="custom-font"><strong>Listes de</strong> tous les appels traités</h1>
                                                <ul class="controls">
                                                    <li class="dropdown">

                                                        <a role="button" tabindex="0" class="dropdown-toggle settings" data-toggle="dropdown">
                                                            <i class="fa fa-cog"></i>
                                                            <i class="fa fa-spinner fa-spin"></i>
                                                        </a>

                                                        <ul class="dropdown-menu pull-right with-arrow animated littleFadeInUp">
                                                            <li>
                                                                <a role="button" tabindex="0" class="tile-toggle">
                                                                    <span class="minimize"><i class="fa fa-angle-down"></i>&nbsp;&nbsp;&nbsp;Réduire</span>
                                                                    <span class="expand"><i class="fa fa-angle-up"></i>&nbsp;&nbsp;&nbsp;Agrandir</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a role="button" tabindex="0" class="tile-refresh">
                                                                    <i class="fa fa-refresh"></i> Rafraichir
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a role="button" tabindex="0" class="tile-fullscreen">
                                                                    <i class="fa fa-expand"></i> Fullscreen
                                                                </a>
                                                            </li>
                                                        </ul>

                                                    </li>
                                                </ul>
                                            </div>
                                            <!-- /tile header -->

                                            <!-- tile body -->
                                            <div class="tile-body">
                                                <div class="table-responsive">
                                                    <table class="table table-custom" id="basic2">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Nom</th>
                                                            <th>Contact</th>
                                                            <th>Motif de l'appel</th>
                                                            <th>Conseillé</th>
                                                            <th>Date</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($all_finish_call_me as $key=>$c)
                                                            <tr>
                                                                <td>{{ ++$key }}</td>
                                                                <td>{{ $c->call_name }}</td>
                                                                <td>{{ $c->call_phone }}</td>
                                                                <td>{{ $c->reason }}</td>
                                                                <td>{{ $c->firstname." ".$c->lastname }}</td>
                                                                <td>{{ date('d/m/Y H:i:s',strtotime($c->created_at)) }}</td>
                                                                <td><a href="{{ route('single.notiication.call',$c->call_id) }}" class="btn btn-primary"><i class="fa fa-check"></i>Afficher</a></td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
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
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/datatables/css/jquery.dataTables.min.css')}}">
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/datatables/datatables.bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css')}}">
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/datatables/extensions/Responsive/css/dataTables.responsive.css')}}">
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/datatables/extensions/ColVis/css/dataTables.colVis.min.css')}}">
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/datatables/extensions/TableTools/css/dataTables.tableTools.min.css')}}">
@endsection

@section('footer-script')
<script src="{{asset('back/assets/js/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datatables/extensions/Responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datatables/extensions/ColVis/js/dataTables.colVis.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datatables/extensions/dataTables.bootstrap.js')}}"></script>
@endsection
@section('custom-script')

<script type="text/javascript">


$(window).load(function(){
 

var table = $('#basic').DataTable({
        "dom": 'Rlfrtip'
    });

table = $('#basic2').DataTable({
        "dom": 'Rlfrtip'
    });

    $('#basic tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('row_selected') ) {
            $(this).removeClass('row_selected');
        }
        else {
            table.$('tr.row_selected').removeClass('row_selected');
            $(this).addClass('row_selected');
        }
    });

    

});
</script>
@endsection