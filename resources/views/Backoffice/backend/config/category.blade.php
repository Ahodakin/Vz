@extends('Backoffice.layouts.app')
@section("content")
<div class="page page-ui-portlets">
	<div class="pageheader">
        <h2>Categories <span></span></h2>
		<div class="page-bar">

			<ul class="page-breadcrumb">
				<li>
					<a href="{{route('spaceDashboard')}}"><i class="fa fa-home"></i> MONASSURANCE.CI</a>
				</li>
				<li>
				<a href="#">Catégories</a>
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
                                <li role="presentation"><a href="#habitation" aria-controls="settingsTab" role="tab" data-toggle="tab">Habitation</a></li>
                                <li role="presentation"><a href="#voyage" aria-controls="settingsTab" role="tab" data-toggle="tab">Voyage</a></li>
                                <li role="presentation"><a href="#prevoyance" aria-controls="settingsTab" role="tab" data-toggle="tab">Prévoyance</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">

                                <div role="tabpanel" class="tab-pane active" id="auto">

                                    <div class="wrap-reset">
 
                                        <!-- tile -->
                                        <section class="tile portlet">

                                            <!-- tile header -->
                                            <div class="tile-header dvd dvd-btm">
                                                <h1 class="custom-font"><strong>Listes des</strong> Catégories Auto</h1>
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
                                                            <th>Categorie</th>
                                                            <th>Description</th>
                                                            <th>Activé</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($categories as  $categorie)
                                                            <tr>
                                                                <td>{{$categorie->id}}</td>
                                                                <td>{{$categorie->categorie}}</td>
                                                                <td>{{$categorie->shortdesc}}</td>
                                                                <td>
                                                                @if($categorie->enabled==1)
                                                                    <span class='label label-success'>on</span>
                                                                @else
                                                                    <span class='label label-danger'>off</span>
                                                                @endif
                                                                </td>
                                                                <td>

                                                                <button onclick="getCategory({{$categorie->id}})" class="btn btn-primary mb-10" data-toggle="modal" data-target="#splash" data-options="splash-2 splash-ef-15"><i class="glyphicon glyphicon-edit"></i> Modifier</button>

                                                                </td>
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
                                <div role="tabpanel" class="tab-pane" id="habitation">

                                    <div class="wrap-reset">

                                        

                                    </div>

                                </div>

                                <div role="tabpanel" class="tab-pane" id="voyage">

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


<!-- Splash Modal -->
<div class="modal splash fade" id="splash" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title custom-font">Modifier Catégorie</h3>
            </div>
            <form class="form-horizontal" method="post" action="{{route('editCategory')}}">
            <div class="modal-body">
                
                    {{csrf_field()}}
                    <input type="hidden" name="idcat" id="idcat" readonly>
                    <div class="form-group">
                        <label for="codeguar" class="col-sm-2 control-label">Categorie</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="category" name="category" placeholder="Code Categorie" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="codeguar" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10">
                            <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <label class="checkbox checkbox-custom">
                                <input type="checkbox" name="enabled" id="enabled"><i></i>
                                Statut
                            </label>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-ef btn-ef-3 btn-ef-3c mb-10">Enregistrer
                 <i class="fa fa-arrow-right"></i></button>
                <button type="reset" class="btn btn-danger btn-ef btn-ef-3 btn-ef-3c mb-10" data-dismiss="modal">Annuler</button>
            </div>
             </form>
        </div>
    </div>

</div>
<script type="text/javascript">
    function getCategory(id) {
        $.get("/admin/category/" + id, function(data) {
            if (data != '0') {
                var d = JSON.parse(data);
                $('#idcat').val(d.id);
                $('#category').val(d.categorie);
                $('#description').val(d.shortdesc);
                $('#enabled').prop('checked', d.enabled == 1);
            } else {
                $('#idcat').val("");
                $('#category').val("");
                $('#description').val("");
                $('#enabled').prop('checked', false);
            }
        });
    }

    
    
    $(window).load(function(){
     
    
    var table = $('#basic').DataTable({
            "dom": 'Rlfrtip'
        });
    
        $('#basic-usage tbody').on( 'click', 'tr', function () {
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