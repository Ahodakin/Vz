@extends('Backoffice.layouts.app')
@section("content")
<div class="page page-ui-portlets">
	<div class="pageheader">
        <h2>Envoyer un SMS <span>Gérer mes prospects</span></h2>
		<div class="page-bar">

			<ul class="page-breadcrumb">
				<li>
					<a href="{{route('spaceDashboard')}}"><i class="fa fa-home"></i> AROLI ASSURANCE</a>
				</li>
				<li>
				<a href="#">Gérer mes prospects</a>
				</li>
                <li>
                <a href="#">Envoyer un SMS</a>
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
                                <li role="presentation" class="active"><a href="#notif" aria-controls="settingsTab" role="tab" data-toggle="tab">Notification</a></li>
                                <li role="presentation" class=""><a href="#liste_notif" aria-controls="settingsTab" role="tab" data-toggle="tab">Liste</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">

                                <div role="tabpanel" class="tab-pane active" id="notif">

                                    <div class="wrap-reset">
 
                                        <div class="row">
                                            <!-- col -->
                                            <div class="col-md-4">
                                                <!-- tile -->
                                                <section class="tile widget-message">

                                                    <!-- tile header -->
                                                    <div class="tile-header bg-blue dvd dvd-btm">
                                                        <h1 class="custom-font"><strong>SMS </strong>Rapide</h1>
                                                        
                                                    </div>
                                                    <!-- /tile header -->
                                                    <form method="post" action="{{ route('sendSMSSimple') }}">
                                                    {{csrf_field()}}
                                                    <!-- tile widget -->
                                                    <div class="tile-widget bg-blue">

                                                            <div class="form-group">
                                                                <input type="text" name="sender_id" class="form-control underline-input" placeholder="Choisir un SENDERID" value="220 170 00" readonly required>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="text" name="contacts" id="contacts" class="form-control underline-input" placeholder="Numero de téléphone..."   required>
                                                            </div>

                                                    </div>
                                                    <!-- /tile widget -->

                                                    <!-- tile body -->
                                                    <div class="tile-body p-0">

                                                        <textarea name="sms_note" id="sms_note">Bonjour cher client,</textarea name="">

                                                    </div>
                                                    <!-- /tile body -->

                                                    <!-- tile footer -->
                                                    <div class="tile-footer bg-blue text-right">

                                                        <button type="submit" class="btn btn-blue btn-ef btn-ef-7 btn-ef-7h" activate-button="success"><i class="fa fa-envelope"></i> Envoyer SMS</button>

                                                    </div>
                                                    <!-- /tile footer -->
                                                    </form>

                                                </section>
                                                <!-- /tile -->
                                            </div>
                                            <!-- /col -->
                                            <!-- col -->
                                            <div class="col-md-4">
                                                <!-- tile -->
                                                <section class="tile widget-message">

                                                    <!-- tile header -->
                                                    <div class="tile-header bg-greensea dvd dvd-btm">
                                                        <h1 class="custom-font"><strong>Email </strong>Rapide</h1>
                                                        
                                                    </div>
                                                    <!-- /tile header -->
                                                    <form method="post" action="{{ route('sendEmailSimple') }}">
                                                    {{csrf_field()}}
                                                    <!-- tile widget -->
                                                    <div class="tile-widget bg-greensea">

                                                            <div class="form-group">
                                                                
                                                                <input type="email" name="emails" class="form-control underline-input" placeholder="Adresse email du destinataire" value=""  required>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="text" required name="objet" class="form-control underline-input" placeholder="Objet du mail">
                                                            </div>

                                                    </div>
                                                    <!-- /tile widget -->

                                                    <!-- tile body -->
                                                    <div class="tile-body p-0">

                                                        <textarea name="mail_note" id="mail_note" required>Bonjour cher client,</textarea>

                                                    </div>
                                                    <!-- /tile body -->

                                                    <!-- tile footer -->
                                                    <div class="tile-footer bg-greensea text-right">

                                                        <button type="submit" class="btn btn-greensea btn-ef btn-ef-7 btn-ef-7h" activate-button="success"><i class="fa fa-envelope"></i> Envoyer Mail</button>

                                                    </div>
                                                    <!-- /tile footer -->
                                                    </form>

                                                </section>
                                                <!-- /tile -->
                                            </div>

                                            <div class="col-md-4">

                                            </div>

                                            
                                        </div>
                                    </div>

                                </div>
                                <div role="tabpanel" class="tab-pane" id="liste_notif">
                                    <table class="table table-hover table-striped table-bordered" id="basic">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Type</th>
                                            <th>Contenu</th>
                                            <th>Auteur</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($last_sms as $k => $l)
                                        <tr>
                                            <td>{{ ++$k }}</td>
                                            <td>{{ $l->type_notif }}</td>
                                            <td>{!! $l->body_notif !!}</td>
                                            <td>{{ getUserInfos($l->from_user)->firstname." ".getUserInfos($l->from_user)->lastname }}</td>
                                            <td>{{ date('d/m/Y H:i:s', strtotime($l->created_at)) }}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
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

<link rel="stylesheet" href="{{asset('back/assets/js/vendor/chosen/chosen.css')}}">
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/summernote/summernote.css')}}">
@endsection

@section('footer-script')
<script src="{{asset('back/assets/js/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datatables/extensions/Responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datatables/extensions/ColVis/js/dataTables.colVis.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datatables/extensions/dataTables.bootstrap.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/chosen/chosen.jquery.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/summernote/summernote.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/summernote/lang/summernote-fr-FR.js')}}"></script>
@endsection
@section('custom-script')

<script type="text/javascript">
$(document).ready(function(){
      $("#contacts").inputmask("99999999",{ "placeholder": "XXXXXXXX"});
    });

$(window).load(function(){

$('#sms_note').summernote({
        toolbar: [
            ['help', ['help']]
        ],
        lang: 'fr-FR',
        height: 143
    });



    $('#mail_note').summernote({
        toolbar: [
            //['style', ['style']], // no style button
            ['style', ['bold', 'italic', 'underline']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            //['insert', ['picture', 'link']], // no insert buttons
            //['table', ['table']], // no table button
            //['help', ['help']] //no help button
        ],
        lang: 'fr-FR',
        height: 143
    });

var table1 = $('#basic').DataTable({
        "dom": 'Rlfrtip'
    });

table = $('#basic2').DataTable({
        "dom": 'Rlfrtip'
    });

    $('#basic2 tbody').on( 'click', 'tr', function () {
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