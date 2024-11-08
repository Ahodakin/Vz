@extends('Backoffice.layouts.app')
@section("content")
<div class="page page-ui-portlets">
    <div class="pageheader">
        <h2>Mes contrats souscrits <span></span></h2>
        <div class="page-bar">

            <ul class="page-breadcrumb">
                <li>
                    <a href="{{route('spaceDashboard')}}"><i class="fa fa-home"></i> AROLI ASSURANCE</a>
                </li>
                <li>
                <a href="#.">Mes contrats</a>
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
                                {{--<li role="presentation"><a href="#habitation" aria-controls="settingsTab" role="tab" data-toggle="tab">Habitation</a></li>--}}
                                <li role="presentation"><a href="#voyage" aria-controls="settingsTab" role="tab" data-toggle="tab">Voyage</a></li>
                                {{--<li role="presentation"><a href="#prevoyance" aria-controls="settingsTab" role="tab" data-toggle="tab">Prévoyance</a></li>--}}
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">

                                <div role="tabpanel" class="tab-pane active" id="auto">

                                    <div class="wrap-reset">

                                        <!-- tile header -->
                                        <div class="tile-header dvd dvd-btm">
                                            <h1 class="custom-font"><strong>Listes des</strong> contrats Auto</h1>
                                        </div>
                                        <!-- /tile header -->

                                        <!-- tile body -->
                                        <div class="tile-body">
                                            <div class="table-responsive">
                                                <table class="table table-custom" id="basic">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>N°Commande</th>
                                                        <th>Nom du client</th>
                                                        <th>Contact</th>
                                                        <th>Debut</th>
                                                        <th>Durée (Mois)</th>
                                                        <th>Echéance</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($contrats_auto as  $key => $c)
                                                        <tr>
                                                            <td>{{++$key}}</td>
                                                            {{-- <td><a href="{{route('devis.details',['id'=>$c->qid,'aid'=>$c->aid])}}">{{$c->number_n}}</a> </td> --}}
                                                            <td>{{$c->lastname}} {{$c->firstname}}</td>
                                                            <td>{{$c->contact}}</td>
                                                            <td>{{date('d/m/Y', strtotime($c->releasedate))}}</td>

                                                            <td> {{date('d/m/Y', strtotime($c->releasedate . "+$c->nbmois months -1 days")). " 23:59:59"}}</td>
                                                            <td>{{$c->nbmois}}</td>
                                                            <td> {{
                                                                date('d/m/Y', strtotime($c->releasedate . "+$c->nbmois months -1 days")). " 23:59:59"
                                                                }}
                                                            </td>
                                                            <td>
                                                                @if( (strtotime($c->releasedate . "+$c->nbmois months")) < (strtotime(date('Y-m-d'))) )
                                                              <label class="label label-danger">Expirée</label>
                                                                @else
                                                                <label class="label label-success">En cours</label>
                                                                @endif
                                                            </td>
                                                            
                                                            {{-- <td>{{$c->status}}</td> --}}
                                                            <td>
                                                                <button class="btn btn-primary" data-toggle="modal" data-target="#splash" onclick="loadContrat({{$c->qid}})" data-options="splash-2 splash-ef-15" title="Renouveller"><i class="glyphicon glyphicon-edit"></i> </button>
                                                                <a href="{{route('details-contrat',$c->qid)}}" class="btn btn-default" data-toggle="tooltip" title="Détails & Documents" ><i class="glyphicon glyphicon-plus"></i> </a>
                                                                <a href="javascript:;" onclick="cancelCommande({{$c->qid}})" class="btn btn-danger" data-toggle="tooltip" title="Annuler" ><i class="fa fa-times"></i> </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- /tile body -->

                                    </div>

                                </div>

                                <div role="tabpanel" class="tab-pane" id="voyage">

                                    <div class="wrap-reset">
                                        <div class="wrap-reset">

                                            <!-- tile header -->
                                            <div class="tile-header dvd dvd-btm">
                                                <h1 class="custom-font"><strong>Listes des</strong> contrats Voyage</h1>
                                            </div>
                                            <!-- /tile header -->

                                            <!-- tile body -->
                                            <div class="tile-body">
                                                <div class="table-responsive">
                                                    <table class="table table-custom" id="basic2">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>N°Commande</th>
                                                            <th>Nom du client</th>
                                                            <th>Debut</th>
                                                            <th>Echéance</th>
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($contrats_voyage as  $key => $c)
                                                            <tr>
                                                                <td>{{++$key}}</td>
                                                                <td><a href="#">{{$c->number_n}}</a> </td>
                                                                <td>{{$c->lastname}} {{$c->firstname}}<br/>
                                                                <i class="fa fa-phone"></i> : {{$c->contact}}<br/>
                                                                <i class="fa fa-flag"></i> : {{getCountryById($c->nationality_id)}}<br/>
                                                                </td>
                                                                <td> {{date('d/m/Y', strtotime($c->departure_date))}}</td>
                                                                <td> {{date('d/m/Y', strtotime($c->arrival_date))}}</td>
                                                                <td>
                                                                    @if( (strtotime($c->arrival_date)) < (strtotime(date('Y-m-d'))) )
                                                                  <label class="label label-danger">Expirée</label>
                                                                    @else
                                                                    <label class="label label-success">En cours</label>
                                                                    @endif
                                                                </td>
                                                                <td>{{$c->status}}</td>
                                                                <td>
                                                                    <button class="btn btn-primary" data-toggle="modal" data-target="#splash" onclick="loadContratVoyage({{$c->qid}})" data-options="splash-2 splash-ef-15" title="Renouveller"><i class="glyphicon glyphicon-edit"></i> </button>
                                                                    <a href="javascript:;" onclick="cancelCommande({{$c->qid}})" class="btn btn-danger" data-toggle="tooltip" title="Annuler" ><i class="fa fa-times"></i> </a>
                                                                </td>

                                                                {{-- <td>
                                                                    <button class="btn btn-primary" data-toggle="modal" data-target="#splash" onclick="loadContrat({{$c->qid}})" data-options="splash-2 splash-ef-15" title="Renouveller"><i class="glyphicon glyphicon-edit"></i> </button>
                                                                    <a href="{{route('details-contrat',$c->qid)}}" class="btn btn-default" data-toggle="tooltip" title="Détails & Documents" ><i class="glyphicon glyphicon-plus"></i> </a>
                                                                    <a href="javascript:;" onclick="cancelCommande({{$c->qid}})" class="btn btn-danger" data-toggle="tooltip" title="Annuler" ><i class="fa fa-times"></i> </a>
                                                                </td> --}}
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- /tile body -->

                                        </div>
                                        

                                    </div>

                                </div>

                                {{--<div role="tabpanel" class="tab-pane" id="prevoyance">

                                    <div class="wrap-reset">

                                        

                                    </div>

                                </div>--}}
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
<div class="modal splash fade" id="splash" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title custom-font">Renouveler ce contrat</h3>
            </div>
            <form class="form-horizontal" method="post" action="{{route('renewContract')}}">
            <div class="modal-body">
                    <div class="text-center" id="status"></div>
                    {{csrf_field()}}
                    <input type="hidden" name="id_cont" id="id_cont" readonly>
                    <div class="form-group">
                        <label for="codeguar" class="col-sm-3 control-label">N° Police</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="police" name="police" readonly placeholder="N° Police" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="codeguar" class="col-sm-3 control-label">Client</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="client" name="client" readonly placeholder="Nom client" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="codeguar" class="col-sm-3 control-label">Date de fin de contrat</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="echeance" name="echeance" readonly placeholder="Date d'échéance du contrat" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="codeguar" class="col-sm-3 control-label">Nouvelle date prise d'effet</label>
                        <div class="col-sm-9">
                            <div class="input-group datepicker_newreleasedate w-330 mt-8" >
                                <input type="text"  name="newreleasedate" id="newreleasedate"  class="form-control">
                                <span class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </span>

                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="codeguar" class="col-sm-3 control-label">Périodicité</label>
                        <div class="col-sm-9">
                            <select id="periode" name="periode" class="form-control" required>
                                <option value="" disabled>Select a periodicity</option> <!-- Default option -->
                                @foreach($periodes as $periode)
                                    <option value="{{ $periode->id }}" 
                                        {{ (isset($old_assur_info) && $old_assur_info->periode == $periode->id) ? 'selected' : '' }}>
                                        {{ $periode->periode }}
                                    </option>
                                @endforeach  
                            </select>
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


function loadContrat(id_contrat) {
    $.get(`/admin/loadcontrat/${id_contrat}`, function(data) {
        if (data !== '0') {
            const d = JSON.parse(data);
            $('#id_cont').val(d.qid);
            $('#police').val(d.number_n);
            $('#client').val(`${d.firstname} ${d.lastname}`);

            const releaseDate = new Date(d.releasedate);
            releaseDate.setMonth(releaseDate.getMonth() + d.nbmois);
            const formattedDate = releaseDate.toISOString().substr(0, 10);

            $('#echeance').val(`${formattedDate} 00:00:00`);
            $('#newreleasedate').val(formattedDate);

            if (releaseDate < new Date()) {
                $('#status').html("<h3 class='alert alert-danger'>Contrat Expiré</h3>");
            } else {
                $('#status').html("<h3 class='alert alert-success'>Contrat en cours</h3>");
            }
        } else {
            $('#id_cont, #police, #client, #echeance, #newreleasedate').val("");
            $('#status').html("");
        }
    }).fail(function() {
        $('#status').html("<h3 class='alert alert-warning'>Erreur de chargement des données</h3>");
    });
}


function cancelCommande(cont_id) {
    var url = "/admin/cancel-commande/" + cont_id;

    swal({
        title: "Suppression du contrat!",
        text: "Voulez-vous vraiment supprimer ce contrat?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#e05d6f",
        confirmButtonText: "Oui",
        cancelButtonText: "Non",
        closeOnConfirm: false
    }, function () {
        // Here we show a temporary success message while processing the request
        swal("Annulé!", "", "success");

        // Perform the AJAX request
        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {
                // On successful response, show a success message
                swal("Succès!", "Le contrat a bien été supprimé!", "success");
                setTimeout(function() {
                    window.location.reload();
                }, 2000);
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            // Handle errors and show an error message
            swal("Oops", "Erreur interne! Contacter le webmaster", "error");
        });
    });
}

    $(window).load(function(){
    $('.datepicker_newreleasedate').datetimepicker({
        format: 'DD/MM/YYYY'
        });
    var table = $('#basic').DataTable({
            "dom": 'Rlfrtip'
        });

    var table1 = $('#basic2').DataTable({
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
