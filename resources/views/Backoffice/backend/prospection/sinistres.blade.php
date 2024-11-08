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
                <a href="#">Gerer mes sinistres</a>
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
                                <li role="presentation" class="active"><a href="#active_sinistre" aria-controls="settingsTab" role="tab" data-toggle="tab">Sinistre actif</a></li>
                                <li role="presentation" class=""><a href="#all_sinistre" aria-controls="settingsTab" role="tab" data-toggle="tab">Tous les sinistres</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">

                                <div role="tabpanel" class="tab-pane active" id="active_sinistre">

                                    <div class="wrap-reset">
 
                                        <!-- tile -->
                                        <section class="tile portlet">

                                            <!-- tile header -->
                                            <div class="tile-header dvd dvd-btm">
                                                <h1 class="custom-font"><strong>Listes des</strong> sinistres actifs</h1>
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
                                                            <th>N° sinistre</th>
                                                            <th>Nom du client</th>
                                                            <th>Contact</th>
                                                            <th>N° de police</th>
                                                            <th>Date sinistre</th>
                                                            <th>Gestionnaire</th>
                                                            <th>Status</th>
                                                            <th>Créé le</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($sinistres as $key=>$s)
                                                            @if($s->decision_sin==0)
                                                            <tr>
                                                                <td>{{ ++$key }}</td>
                                                                <td>{{ $s->sin_number }}</td>
                                                                <td>{{ $s->client_name }}</td>
                                                                <td>{{ $s->client_phone }}</td>
                                                                <td>{{ $s->client_policy_number }}</td>
                                                                <td>{{ date('d/m/Y',strtotime($s->date_sinistre)) }}</td>
                                                                <td>
                                                                    {{ optional($s->sinManager)->firstname ? $s->sinManager->firstname . ' ' . $s->sinManager->lastname : 'N/A' }}
                                                                 </td> 
                                                                <td>{!! get_sinistre_status($s->sin_status) !!}</td>
                                                                <td>{{ date('d/m/Y',strtotime($s->created_at)) }}</td>
                                                                <td><a href="{{ route('sinistre.details',$s->sin_id) }}" class="btn btn-primary"><i class="fa fa-plus"></i>Détails</a></td>
                                                            </tr>
                                                            @endif
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

                                <div role="tabpanel" class="tab-pane" id="all_sinistre">

                                    <div class="wrap-reset">
 
                                        <!-- tile -->
                                        <section class="tile portlet">

                                            <!-- tile header -->
                                            <div class="tile-header dvd dvd-btm">
                                                <h1 class="custom-font"><strong>Tous </strong> les sinistres</h1>
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
                                                          <th>N° sinistre</th>
                                                          <th>Nom du client</th>
                                                          <th>Contact</th>
                                                          <th>N° de police</th>
                                                          <th>Date sinistre</th>
                                                          <th>Gestionnaire</th>
                                                          <th>Status</th>
                                                          <th>Décision</th>
                                                          <th>Créé le</th>
                                                          <th>Action</th>
                                                      </tr>
                                                      </thead>
                                                      <tbody>
                                                      @foreach($sinistres as $key=>$s)
                                                          <tr>
                                                              <td>{{ ++$key }}</td>
                                                              <td>{{ $s->sin_number }}</td>
                                                              <td>{{ $s->client_name }}</td>
                                                              <td>{{ $s->client_phone }}</td>
                                                              <td>{{ $s->client_policy_number }}</td>
                                                              <td>{{ date('d/m/Y',strtotime($s->date_sinistre)) }}</td>
                                                              <td>
                                                                {{ optional($s->sinManager)->firstname ? $s->sinManager->firstname . ' ' . $s->sinManager->lastname : 'N/A' }}
                                                             </td>                                                                                                                                                                       
                                                              <td>{!! get_sinistre_status($s->sin_status) !!}</td>
                                                              <td>{!! get_sinistre_decision($s->decision_sin) !!}</td>
                                                              <td>{{ date('d/m/Y',strtotime($s->created_at)) }}</td>
                                                              <td><a href="{{ route('sinistre.details',$s->sin_id) }}" class="btn btn-primary"><i class="fa fa-plus"></i>Détails</a></td>
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
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>

<script>

new DataTable('#basic');
new DataTable('#basic2');
</script>
@endsection