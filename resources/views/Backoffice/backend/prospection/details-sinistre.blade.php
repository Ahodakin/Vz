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
                <a href="#">Details sinistre</a>
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
                                <li role="presentation" class="active"><a href="#new_sinistre" aria-controls="settingsTab" role="tab" data-toggle="tab">Details Sinistre</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">

                                <div role="tabpanel" class="tab-pane active" id="new_sinistre">

                                    <div class="wrap-reset">
 
                                        <!-- tile -->
                                        <section class="tile portlet">

                                            <!-- tile header -->
                                            <div class="tile-header dvd dvd-btm">
                                                <h1 class="custom-font"><strong>Details</strong> sinistre</h1>
                                               
                                            </div>
                                            <!-- /tile header -->

                                            <!-- tile body -->
                                            <div class="tile-body">
                                                <div class="row">  
                                                    <div class="col-md-4">
                                                        <section class="tile bg-blue">

                                                            <!-- tile header -->
                                                            <div class="tile-header dvd dvd-btm">
                                                                <h1 class="custom-font"><strong>Infos </strong>sinistre</h1>
                                                                <ul class="controls">
                                                                    <li class="remove"><a role="button" tabindex="0"><i class="fa fa-edit"></i></a></li>
                                                                </ul>
                                                            </div>
                                                            <!-- /tile header -->

                                                            <!-- tile body -->
                                                            <div class="tile-body p-0">
                                                                <table class="table table-condensed">
                                                                    <tr>
                                                                        <td>N°Sinistre</td>
                                                                        <td>:</td>
                                                                        <td>{{ $sinistre->sin_number }} {!! get_sinistre_decision($sinistre->decision_sin) !!}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Gestionnaire</td>
                                                                        <td>:</td>
                                                                        <td>
                                                                            {{ empty(getUserInfos($sinistre->sin_manager)) ? "N/A" : getUserInfos($sinistre->sin_manager)->firstname . " " . getUserInfos($sinistre->sin_manager)->lastname }}
                                                                        </td>
                                                                    
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Client</td>
                                                                        <td>:</td>
                                                                        <td>{{ $sinistre->client_name }} ({{$sinistre->client_phone}})</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>N°Police</td>
                                                                        <td>:</td>
                                                                        <td>{{ $sinistre->client_policy_number }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Date du sinistre</td>
                                                                        <td>:</td>
                                                                        <td>{{ date("d/m/Y",strtotime($sinistre->date_sinistre)) }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Déclaration</td>
                                                                        <td>:</td>
                                                                        <td>{{ $sinistre->client_declaration}}</td>
                                                                    </tr>
                                                                </table>

                                                            </div>
                                                            <!-- /tile body -->

                                                        </section>
                                                        <section class="tile bg-greensea">

                                                            <!-- tile header -->
                                                            <div class="tile-header dvd dvd-btm">
                                                                <h1 class="custom-font"><strong>Logs </strong>sinistre</h1>
                                                                
                                                            </div>
                                                            <!-- /tile header -->

                                                            <!-- tile body -->
                                                            <div class="tile-body" style="width: 100%;">

                                                                <table class="table table-condensed" style="width: 100%;">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Acteur</th>
                                                                        <th>Status</th>
                                                                        <th>Date</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach($logs_sinistre as $k=>$l)
                                                                    <tr>
                                                                        <td>{{ ++$k }}</td>
                                                                        <td>
                                                                            {{ empty(getUserInfos($l->id_user)) ? "N/A" : getUserInfos($l->id_user)->firstname . " " . getUserInfos($l->id_user)->lastname }}
                                                                        </td>                                                                        
                                                                        <td>{!! get_sinistre_status($l->status) !!}</td>
                                                                        <td>{{ date('d/m/Y',strtotime($l->created_at)) }}</td>
                                                                    </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                            <!-- /tile body -->

                                                        </section>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="row">

                                                            <div class="col-md-12">

                                                                <!-- tile -->
                                                                <section class="tile tile-simple">

                                                                    <!-- tile widget -->
                                                                    <div class="tile-widget bg-green text-center p-30 text-elg text-strong mb-0">
                                                                        @if($sinistre->sin_status==0)
                                                                            Sinistre déclarés
                                                                        @elseif($sinistre->sin_status==1)
                                                                            Documents collectés
                                                                        @elseif($sinistre->sin_status==2)
                                                                            Dossier transmis au service reseau de la compagnie
                                                                        @else
                                                                            Sinistre classé
                                                                        @endif
                                                                    </div>
                                                                    <!-- /tile widget -->

                                                                </section>
                                                                <!-- /tile -->

                                                            </div>

                                                            

                                                        </div>
                                                      @if($sinistre->sin_status==3)
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <form class="form-horizontal" method="post" action="{{ route('sinistre.details.decision') }}">
                                                                        {{csrf_field()}}
                                                                        <input type="hidden" value="{{ $sinistre->sin_id }}" readonly name="sin_id">
                                                                        <div class="form-group">
                                                                            <label>Décision finale (Réglé/Non Réglé)*</label>
                                                                            @if($sinistre->decision_sin==0)
                                                                            <select class="form-control" name="decision">
                                                                                <option></option>
                                                                                <option value="1">Réglé</option>
                                                                                <option value="2">Non Réglé</option>
                                                                            </select>
                                                                            @else
                                                                                <label class="label label-info">{{ ($sinistre->decision_sin==1) ? 'Réglé' : 'Non réglé'  }}</label>
                                                                            @endif
                                                                        </div>
                                                                        @if($sinistre->decision_sin==0)
                                                                        <div class="form-group">
                                                                        <button class="btn btn-success" type="submit"> Enregistrer </button>
                                                                        </div>
                                                                        @endif
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        @else
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <form class="form-horizontal" method="post" action="{{ route('sinistre.details.post') }}">
                                                                    {{csrf_field()}}
                                                                    <input type="hidden" value="{{ $sinistre->sin_id }}" readonly name="sin_id">
                                                                    <div class="form-group">
                                                                       <label>Faire evoluer le statut du sinistre*</label>
                                                                       <select required class="form-control" name="status_sin" id="status_sin">
                                                                            <option></option>
                                                                           <option value="1" {{ ($sinistre->sin_status==0)?'selected':'' }}>Status Documents collectés</option>
                                                                           <option value="2" {{ ($sinistre->sin_status==1)?'selected':'' }}>Status Dossier transmis au service reseau de la compagnie</option>
                                                                           <option value="3" {{ ($sinistre->sin_status==2)?'selected':'' }}>Status Sinistre classé</option>
                                                                       </select>
                                                                   </div>
                                                                   <div class="form-group">
                                                                       <label>Ovservation</label>
                                                                       <textarea class="form-control" rows="5" name="obs_sin" id="obs_sin">{!! $sinistre->observation !!}</textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                    <button class="btn btn-success" type="submit"> Enregistrer </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>

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