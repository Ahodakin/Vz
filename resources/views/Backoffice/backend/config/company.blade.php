@extends('Backoffice.layouts.app')
@section("content")
<div class="page page-ui-portlets">
	<div class="pageheader">
        <h2>Compagnie d'assurance <span></span></h2>
		<div class="page-bar">

			<ul class="page-breadcrumb">
				<li>
					<a href="{{route('spaceDashboard')}}"><i class="fa fa-home"></i> MONASSURANCE.CI</a>
				</li>
				<li>
				<a href="{{route('profilepage')}}">Compagnie d'assurance</a>
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
                                                <h1 class="custom-font"><strong>Listes des</strong> Compagnies</h1>
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
                                                            <th>Logo</th>
                                                            <th>Nom compagnie</th>
                                                            <th>Garanties de base</th>
                                                            <th>Statut</th>
                                                            <th>Note</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($compagnies as  $key => $c)
                                                            <tr>
                                                                <td>{{++$key}}</td>
                                                                <td><img width="20%" src="/images/assureurs/{{$c->complogo}}"></td>
                                                                <td>{{$c->compname}}</td>
                                                                <td>{{$c->baseguar}}</td>
                                                                <td>
                                                                 @if($c->enabled==1)
                                                                    <span class='label label-success'>on</span>
                                                                @else
                                                                    <span class='label label-danger'>off</span>
                                                                @endif      
                                                                </td>
                                                                <td>{{$c->rate}}/5</td>
                                                                <td>

                                                                <button title="Modifier" onclick="getCompany({{$c->id}})" class="btn btn-primary btn-sm mb-10" data-toggle="modal" data-target="#splash" data-options="splash-2 splash-ef-15"><i class="glyphicon glyphicon-edit"></i> Modifier</button>

                                                                <a title="Tarifs/Taux" href="{{route('tarifCompany', $c->id)}}" class="btn btn-default btn-sm mb-10" ><i class="glyphicon glyphicon-list"></i> Tarif</a>

                                                                <a title="Supprimer" onclick="deleteCompany('{{route('deleteCompany', $c->id)}}')" href="javascript:;"  class="btn btn-danger btn-sm mb-10" ><i class="glyphicon glyphicon-trash"></i> Supprimer</a>

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
                        <h3 class="modal-title custom-font">Modifier la compagnie d'assurance</h3>
                    </div>
                    <form class="form-horizontal" method="post" action="{{route('editCompany')}}">
                    <div class="modal-body">
                        
                            {{csrf_field()}}
                            <input type="hidden" name="idcomp" id="idcomp" readonly>
                            <!--<div class="form-group text-center">
                                <img src="/images/assureurs/aroli.png" alt="">
                           
                            </div>-->
                           <div class="form-group">
                                <label for="compname" class="col-sm-2 control-label">Nom</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="compname" name="compname" placeholder="Nom de la compagnie">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="location" class="col-sm-2 control-label">Adresse</label>
                                <div class="col-sm-10">
                                    <textarea name="location" id="location" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="codeguar" class="col-sm-2 control-label">Contacts</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="No de téléphone de la compagnie">
                                </div>
                            </div>
                            <div role="tabpanel" style="border:dashed 1px grey">
                            <ul class="nav nav-tabs nav-justified mt-20 mb-20">
                                <li role="presentation" class="active"><a href="#base" aria-controls="settingsTab" role="tab" data-toggle="tab">Base</a></li>
                                <li role="presentation"><a href="#tsimple" aria-controls="settingsTab" role="tab" data-toggle="tab">Tiers Simple</a></li>
                                <li role="presentation"><a href="#tcomplet" aria-controls="settingsTab" role="tab" data-toggle="tab">Tiers Complet</a></li>
                                <li role="presentation"><a href="#tcol" aria-controls="settingsTab" role="tab" data-toggle="tab">Tiers Collision</a></li>
                                <li role="presentation"><a href="#trisque" aria-controls="settingsTab" role="tab" data-toggle="tab">Tout risque</a></li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="base">
                                    <div class="wrap-reset">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Garanties de base</label>
                                            <div class="col-sm-10">
                                                <select multiple="" class="chosen-select" style="width: 240px;">
                                                    @foreach($guaranties as $c)
                                                    <option value="{{$c->codeguar}}">{{$c->codeguar}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="tsimple">
                                    <div class="wrap-reset">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Tiers simple</label>
                                            <div class="col-sm-10">
                                                <select multiple="" class="chosen-select" style="width: 240px;">
                                                    @foreach($guaranties as $c)
                                                    <option value="{{$c->codeguar}}">{{$c->codeguar}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="tcomplet">
                                    <div class="wrap-reset">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Tiers complet</label>
                                            <div class="col-sm-10">
                                                <select multiple="" class="chosen-select" style="width: 100%;">
                                                    @foreach($guaranties as $c)
                                                    <option value="{{$c->codeguar}}">{{$c->codeguar}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="tcol">
                                    <div class="wrap-reset">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Tiers collision</label>
                                            <div class="col-sm-10">
                                                <select multiple="" class="chosen-select" style="width: 100%;">
                                                    @foreach($guaranties as $c)
                                                    <option value="{{$c->codeguar}}">{{$c->codeguar}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="trisque">
                                    <div class="wrap-reset">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Tout risque</label>
                                            <div class="col-sm-10">
                                                <select multiple="" class="chosen-select" style="width: 100%;">
                                                    @foreach($guaranties as $c)
                                                    <option value="{{$c->codeguar}}">{{$c->codeguar}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
function getCompany (id_comp) {
     $.get("/admin/company/"+id_comp, function(data) {
        if(data!='0'){

        var d = JSON.parse(data);
        
        }else{
        
        }
     })
 }

function deleteCompany (url) {
    swal({
        title:"Suppression de compagnie!",
        text: "Voulez vous vraiment supprimer cet enregistrement?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Oui",
        cancelButtonText: "Non",
        closeOnConfirm: false
        }, function () {
        swal("Supprimé!", "", "success");
        $.ajax(
            {
                type: "get",
                url: url,
                success: function(data){
                }
            }
        )
        .done(function(data) {
        swal("Supprimé!", "Compagnie supprimée", "success");
        setTimeout(function(){
            $("#basic").load(document.URL+" #basic"); 
        }, 1000);
      })
      .error(function(data) {
        swal("Oops", "Erreur interne!", "error");
      })
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
