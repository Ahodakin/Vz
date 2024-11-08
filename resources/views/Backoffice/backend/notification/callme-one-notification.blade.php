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
	
		<div class="row">
            <div class="col-md-12">
                <div class="col-md-4">
                    @if($call->advisor_user_id!=0)
                    <section class="tile">

                        <!-- tile header -->
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Appel Traité par</strong> {{getUserInfos($call->advisor_user_id)->firstname}} {{getUserInfos($call->advisor_user_id)->lastname}} </h1>
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body lined-paper">
                            <p>
                            <strong>Conseillé : </strong> : {{getUserInfos($call->advisor_user_id)->firstname}} {{getUserInfos($call->advisor_user_id)->lastname}}.<br/>
                            <br/>
                            <strong>Date</strong> : {{date('d/m/Y H:i:s',strtotime($call->updated_at))}}
                            </p>
                        </div>
                        <!-- /tile body -->

                    </section>
                    @else
                    <div class="alert alert-warning">Appel pas encore traité</div>
                    @endif
                    <section class="tile">

                        <!-- tile header -->
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Emetteur</strong> de l'appel</h1>
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body lined-paper">
                            <p>
                            <strong>Nom</strong> : {{$call->call_name}}.<br/>
                            <strong>Numero</strong> : {{$call->call_phone}}<br/>
                            <strong>Motif</strong> : 
                            @if($call->call_motif==1)
                            <label class="label label-danger">(1).Renouvelement</label>
                            @elseif($call->call_motif==2)
                            <label class="label label-warning">(2).Nouveau dévis</label>
                            @else
                            <label class="label label-info">(3).Information</label>
                            @endif
                            <br/>
                            <strong>Date</strong> : {{date('d/m/Y H:i:s',strtotime($call->created_at))}}
                            </p>
                        </div>
                        <!-- /tile body -->

                    </section>

                </div>
                <div class="col-md-8">
                    <section class="tile">

                        <!-- tile header -->
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Traitement</strong> de l'appel</h1>
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
                            <form class="form-horizontal" method="post" action="{{ route('call-me.post') }}">
                                {{csrf_field()}}
                                <input type="hidden" readonly class="form-control" name="call_id" id="call_id" value="{{$call->call_id}}">
                                <div class="form-group">
                                    <label for="call_name">Nom de l'utilisateur</label>
                                    <input type="text" required class="form-control" name="call_name" id="call_name" value="{{$call->call_name}}">
                                </div>
                                <div class="form-group">
                                    <label for="call_phone">Numéro de téléphone</label>
                                    <input type="text" required class="form-control" name="call_phone" id="call_phone" value="{{$call->call_phone}}">
                                </div>
                                <div class="form-group">
                                    <label for="call_motif">Motif de l'appel</label>
                                    <select class="form-control" required name="call_motif" id="call_motif">
                                        <option value="1" {{($call->call_motif==1)? 'selected':''}}>Renouvellement</option>
                                        <option value="2" {{($call->call_motif==2)? 'selected':''}}>Nouveau dévis</option>
                                        <option value="3" {{($call->call_motif==3)? 'selected':''}}>Informations</option>
                                    </select>
                                </div>
                                <div class="row">                            
                                    <div class="form-group col-sm-5">
                                        <label for="conclusion">Conclusion</label><br>
                                        <label class="checkbox-inline checkbox-custom">
                                            <input name="conclusion" {{($call->advisor_conclusion==1)? 'checked=""':''}} value="1" type="radio"><i></i> Intéressé
                                        </label>
                                        <label class="checkbox-inline checkbox-custom">
                                            <input name="conclusion" {{($call->advisor_conclusion==2)? 'checked=""':''}} value="2" type="radio"><i></i> Pas intéressé
                                        </label>
                                        <label class="checkbox-inline checkbox-custom">
                                            <input name="conclusion" {{($call->advisor_conclusion==3)? 'checked=""':''}} value="3" type="radio"><i></i> Relance
                                        </label>
                                        
                                    </div>
                                    {{-- <div id="div_relance" class="input-group relance_date w-330 mt-8" {{($call->advisor_conclusion==3)? 'style="display:block"':'style="display:none"'}} >
                                        <input type="hidden" name="relance_date" id="relance_date"  class="form-control" {{($call->advisor_conclusion==3)? 'value="'. date('d/m/Y',strtotime($call->date_relance)) .'"':'value=""'}}>
                                    </div> --}}
                                    <div id="div_relance" class="input-group relance_date w-330 mt-8" style="{{ ($call->advisor_conclusion == 3) ? 'display:block' : 'display:none' }}">
                                        <input type="text" name="relance_date" id="relance_date" class="form-control" 
                                               placeholder="JJ/MM/AAAA" 
                                               value="{{ ($call->advisor_conclusion == 3 && $call->date_relance) ? date('d/m/Y', strtotime($call->date_relance)) : '' }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="call_reason">Observation</label>
                                    <textarea rows="5" required class="form-control" name="call_reason" id="call_reason">{{$call->reason}}</textarea>
                                </div>
                                <div class="form-group">
                                <button class="btn btn-success" type="submit">Enregistrer</button>
                                </div>
                            </form>
                        </div>
                        <!-- /tile body -->

                    </section>
                    
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
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
@endsection

@section('footer-script')
<script src="{{asset('back/assets/js/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datatables/extensions/Responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datatables/extensions/ColVis/js/dataTables.colVis.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datatables/extensions/dataTables.bootstrap.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/daterangepicker/moment.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
@endsection
@section('custom-script')

<script type="text/javascript">


$(window).load(function(){
 
 $('input[name=conclusion]').change(function(){
    if($('input[name=conclusion]:checked').val()=='3'){
        $("#div_relance").show()
    }else{
        $("#div_relance").hide()
    }

 })

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

    $('.relance_date').datetimepicker({
            format: 'DD/MM/YYYY',
            inline:true,
         });



});
</script>
@endsection