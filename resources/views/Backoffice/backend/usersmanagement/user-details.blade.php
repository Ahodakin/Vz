@extends('Backoffice.layouts.app')
@section("content")
<div class="page page-shop-single-order">
    <div class="pageheader">
        <h2>Details 
        @if($user->usertype==99)utilisateur
        @elseif($user->usertype==0)prospect
        @elseif($user->usertype==1)client
        @endif
        </h2>

        <div class="page-bar">

            <ul class="page-breadcrumb">
                <li>
                    <a href="{{route('spaceDashboard')}}"><i class="fa fa-home"></i> MONASSURANCE.CI</a>
                </li>
                <li>
                    <a href="{{route('users.afficher')}}">Utilisateurs</a>
                </li>
                <li>
                    <a href="#">Détails</a>
                </li>
                <li>
                    <a href="#">{{$user->lastname}} {{$user->firstname}}</a>
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
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><p align="center">{{\Illuminate\Support\Facades\Session::get('error')}}</p></h4>
                </div>
            </div>
        @endif
	
        <div class="pagecontent">
            <div class="add-nav">
                <div class="nav-heading">
                    <h3><strong class="text-greensea">{{$user->lastname}} {{$user->firstname}}</strong></h3>
                    <span class="controls pull-right">
                      <img width="64x64" src="/back/assets/uploads/avatar/{{$user->avatar}}">
                    </span>
                </div>
                <div role="tabpanel">

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    @if($user->usertype==99)
                                    <li role="presentation" class="active"><a href="#roles" aria-controls="details" role="tab" data-toggle="tab">Roles & Permissions</a></li>
                                    @endif
                                    <li role="presentation" class="{{($user->usertype==99)? '':'active'}}"><a href="#sms" aria-controls="sms" role="tab" data-toggle="tab">Envoyer SMS</a></li>

                                    <li role="presentation"><a href="#history" aria-controls="history" role="tab" data-toggle="tab">Historique</a></li>
                                </ul>

                                <div class="tab-content">
                                    <!-- tab in tabs -->
                                    @if($user->usertype==99)
                                    <div role="tabpanel" class="tab-pane active" id="roles">
                                        <!-- row -->
                                        <div class="row">
                                            <!-- col -->
                                            <div class="col-md-12">
                                                <!-- tile -->
                                                <section class="tile time-simple">
                                                    <!-- tile body -->
                                                    <div class="tile-body p-0">

                                                        <form class="form-horizontal" method="post" action="{{route('userrole.edit')}}">
                                                            {{csrf_field()}}
                                                            <input type="hidden" readonly value="{{$user->id}}" name="iduser">
                                                            <div class="form-group">
                                                            <div class="col-sm-1"></div>
                                                                <div class="col-sm-6">
                                                                    @foreach($roles as $r)
                                                                  <div class="col-md-6">
                                                                  <div class="checkbox">
                                                                    <input type="checkbox"  id="{{$r->id}}" value="{{$r->id}}" name="roles[]"
                                                                       
                                                                        
                                                                        @foreach($user->roles as $ur)
                                                                            @if($ur->id == $r->id) 
                                                                            checked
                                                                            @endif
                                                                        @endforeach
                                                                    >
                                                                    <label for="{{$r->id}}">  {{$r->display_name}} </label>
                                                                  </div>
                                                                  </div>
                                                                @endforeach
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-sm-1"></div>
                                                                 <button type="submit" class="btn btn-success btn-ef btn-ef-3 btn-ef-3c mb-10">Enregistrer
                                                                 <i class="fa fa-arrow-right"></i></button>
                                                                <button type="reset" class="btn btn-danger btn-ef btn-ef-3 btn-ef-3c mb-10">Annuler</button>
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
                                    @endif

                                    <!-- tab in tabs -->
                                    <div role="tabpanel" class="tab-pane" id="sms">
                                        <!-- row -->
                                        <div class="row">
                                            <!-- col -->
                                            <div class="col-md-12">
                                                <!-- tile -->
                                                <section class="tile time-simple">
                                                    <!-- tile body -->
                                                    <div class="tile-body p-0">
                                                        
                                                    </div>
                                                    <!-- /tile body -->
                                                </section>
                                                <!-- /tile -->
                                            </div>
                                            <!-- /col -->
                                        </div>
                                        <!-- /row -->

                                    </div>
                                    

                                    <!-- tab in tabs -->
                                    <div role="tabpanel" class="tab-pane" id="history">
                                        <!-- row -->
                                        <div class="row">
                                            <!-- col -->
                                            <div class="col-md-12">
                                                <!-- tile -->
                                                <section class="tile time-simple">
                                                    <!-- tile body -->
                                                    <div class="tile-body p-0">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-hover table-custom" id="basic">
                                                                <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Action</th>
                                                                    <th>Description</th>
                                                                    <th>Date</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($logs as $key=>$log)
                                                                <tr>
                                                                    <td>{{++$key}}</td>
                                                                    <td>{{$log->log_action}}</td>
                                                                    <td>{{$log->log_description}}</td>
                                                                    <td>{{$log->createdAt}}</td>
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
                                            <!-- /col -->
                                        </div>
                                        <!-- /row -->

                                    </div>
                                </div>
                            </div>
                        </div>
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
<script src="{{asset('back/assets/js/vendor/datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
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

var table1 = $('#basic').DataTable({
        "dom": 'Rlfrtip'
    });
});
</script>
@endsection