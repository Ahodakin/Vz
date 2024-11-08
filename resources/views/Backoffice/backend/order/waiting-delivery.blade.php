@extends('Backoffice.layouts.app')

@section("content")

<div class="page page-tables-datatables">

    <div class="pageheader">
        <h2>Mise en livraison des commandes <span></h2>

        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li><a href="{{route('spaceDashboard')}}"><i class="fa fa-home"></i> MONASSURANCE.CI</a></li>
                <li><a href="#">Gérer mes commandes</a></li>
                <li><a href="">Mise en livraison</a></li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @if(\Illuminate\Support\Facades\Session::has('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif

            <section class="tile">
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Commandes</strong></h1>
                </div>
                <div class="tile-body">
                    <div role="tabpanel">
                        <div class="form-group">   
                            <button class="btn btn-success" data-toggle="modal" data-target="#new-tour">Nouvelle tournée</button>

                        </div>
                        <ul class="nav nav-tabs tabs-dark" role="tablist">
                            <li role="presentation" class="active"><a href="#waiting" aria-controls="settingsTab" role="tab" data-toggle="tab">Liste des commandes en attente de livraison</a></li>
                            <li role="presentation"><a href="#tour" aria-controls="settingsTab" role="tab" data-toggle="tab">Tournée de Livraison</a></li>
                        </ul>

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="waiting">
                                <div class="wrap-reset">
                                    <table class="table table-custom" id="table1">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>N° Commande</th>
                                                <th>N° Police</th>
                                                <th>Client</th>
                                                <th>Contact</th>
                                                <th>Type contrat</th>
                                                <th>Status</th>
                                                <th>Adresse</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($prospects as $key => $prospect)
                                                <tr>
                                                    <td>{{++$key}}</td>
                                                    <td>{{ $prospect->number_n}}</td>
                                                    <td>{{ $prospect->policy_number}}</td>
                                                    <td>{{ $prospect->firstname}} {{ $prospect->lastname}}</td>
                                                    <td>{{ $prospect->contact}}</td>
                                                    <td>
                                                        @if($prospect->priority==1)
                                                        <div id="raty4" class="inline-block" data-toggle="tooltip" title="Urgent"></div>
                                                        @endif
                                                        @if($prospect->product_type==1)
                                                        Auto
                                                        @elseif($prospect->product_type==3)
                                                        Voyage
                                                        @endif 
                                                    </td>
                                                    <td>{!! get_commande_status($prospect->status) !!}</td>
                                                    <td>{{ $prospect->delivery_location}} ({{ $prospect->phone_client}})</td>
                                                    <td>{{ date("d/m/Y H:i:s", strtotime($prospect->created_at))}}</td>
                                                    <td>
                                                        @if(isOrderSetToDeliveryTour($prospect->qid))
                                                            <a href="javascript:;" role="button" onclick="getOrder({{$prospect->qid}})" data-toggle="modal" data-target="#set-to-tour2">
                                                                <label data-toggle="tooltip" title="N° de la tournée" class="label label-{{(getDeliveryTourStatus($prospect->qid)->delivery_tour_status==0)?'warning':'success'}}">{{getDeliveryNumberForOrder($prospect->qid)->tour_number}} <i class="fa fa-edit"></i></label> 
                                                            </a>
                                                        @else
                                                        <a title="Mettre en livraison" onclick="getOrder({{$prospect->qid}})" data-toggle="modal" data-target="#set-to-tour" href="javascript:;" class="btn btn-primary"> <i class="fa fa-truck"></i> </a> 
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach  
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="tour">
                                <div class="wrap-reset">
                                    <table class="table table-custom" id="table2">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tournée N°</th>
                                                <th>Livreur</th>
                                                <th>Date/Heure</th>
                                                <th>Itineraire(s)</th>
                                                <th>Commandes</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($delivery_tour as $key=>$del_tour)
                                                <tr>
                                                    <td>{{++$key}}</td>
                                                    <td>{{$del_tour->tour_number}}</td>
                                                    <td>{{$del_tour->firstname}} {{$del_tour->lastname}}</td>
                                                    <td><label class="label {{(strtotime($del_tour->tour_start_date) < time())?'label-danger':'label-success' }}">{{date('d/m/Y H:i:s',strtotime($del_tour->tour_start_date))}} </label></td>
                                                    <td>{!! getListOfRouteByDeliveryId($del_tour->id) !!}</td>
                                                    <td><p>{!! getListOfOrderByDeliveryIdAdvanced($del_tour->id) !!}</p></td>
                                                    <td>
                                                        <a href="{{ route('delivery.operation.details', $del_tour->id) }}"  data-toggle="tooltip" title="Afficher la tournée" class="btn btn-default"><i class="fa fa-eye"></i></a>
                                                        <a href="javascript:;" onclick="getDeliveryTour({{$del_tour->id}})" data-toggle="modal" data-target="#update-tour" title="Modifier la tournée" class="btn btn-primary"><i class="fa fa-edit"></i></a>

                                                        @if($del_tour->delivery_tour_status==0)
                                                        <a href="javascript:;" onclick="StartDeliveryTour({{$del_tour->id}})" data-toggle="tooltip" title="Demarrer la tournée" class="btn btn-success"><i class="fa fa-play"></i></a>
                                                        @elseif($del_tour->delivery_tour_status==1)
                                                        <a href="javascript:;" onclick="closeTour({{$del_tour->id}})"  data-toggle="tooltip" title="Fermer la tournée" class="btn btn-info"><i class="fa fa-times"></i></a>
                                                        @else
                                                        <label class="label label-danger">Fermée</label>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

</div>
@endsection

@section('header-script')
<link rel="stylesheet" href="{{asset('back/assets/css/vendor/sweetalert/sweetalert.css')}}">
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/chosen/chosen.css')}}">
<link rel="stylesheet" href="<?php echo asset('back/assets/js/vendor/datatables/css/jquery.dataTables.min.css')?>">
<link rel="stylesheet" href="<?php echo asset('back/assets/js/vendor/datatables/datatables.bootstrap.min.css')?>">
<link rel="stylesheet" href="<?php echo asset('back/assets/js/vendor/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css')?>">
<link rel="stylesheet" href="<?php echo asset('back/assets/js/vendor/datatables/extensions/Responsive/css/dataTables.responsive.css')?>">
<link rel="stylesheet" href="<?php echo asset('back/assets/js/vendor/datatables/extensions/ColVis/css/dataTables.colVis.min.css')?>">
<link rel="stylesheet" href="<?php echo asset('back/assets/js/vendor/datatables/extensions/TableTools/css/dataTables.tableTools.min.css')?>">        
    
@endsection

@section('footer-script')
<div class="modal fade" id="new-tour" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title custom-font">Enregistrer une tournée de livraison</h3>
            </div>
            <div class="modal-body">
                <!-- Formulaire de création de tournée -->
                <form class="form-horizontal" method="post" action="{{ route('deliverytour.post') }}">
                    {{csrf_field()}}
                    <div class="form-group">
                      <label class="control-label">Titre de la tournée</label>
                      <input type="text" required class="form-control"  name="title" id="title">
                    </div>
                    <div class="form-group">
                      <label class="control-label">Choisir un livreur*</label>
                      <select class="form-control chosen-select" required name="deliveryman" id="deliveryman">
                            <option></option>
                          @foreach($adminUsers as $user)
                            @if($user->hasRole(['deliveryman']))
                            <option value="{{$user->id}}">{{$user->firstname}} {{$user->lastname}}</option>
                            @endif
                          @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Date de la tournée*</label>
                        <div class="input-group dp_datetour w-360 mt-10">
                            <input type="text" value="{{date('d/m/Y')}}" class="form-control dp_datetour" required name="tourdate" id="tourdate">
                            <span class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Heure de départ de la tournée*</label>
                        <div class="input-group dp_dimetour w-360 mt-10">
                            <input type="text" class="form-control dp_dimetour" required name="tourtime" id="tourtime">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-time"></span>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Itineraire de la tournée</label><br>
                        <select class="form-control chosen-select" name="tour_route[]" id="utour_route" multiple style="width: 480px;">
                            @foreach($communes as $c)
                            <option value="{{$c->id}}">{{$c->commune}}</option>
                            @endforeach
                        </select>
                    </div>
                    {{--<div class="form-group">
                        <label class="control-label">Commandes</label><br>
                        <select class="form-control chosen-select" name="tour_order" id="tour_order" multiple style="width: 480px;">
                            @foreach(waitingDelivery()->get() as $key => $c)
                            <option value="{{$c->qid}}">{{$c->number_n}}</option>
                            @endforeach
                        </select>
                    </div>--}}
                    <div class="form-group">
                      <button type="submit" class="btn btn-success">Enregistrer</button>
                      <button type="reset" class="btn btn-danger">Annuler</button>
                    </div>
                  </form>        
            </div>
            <div class="modal-footer">
                <button class="btn btn-default btn-ef btn-ef-4 btn-ef-4c" data-dismiss="modal"><i class="fa fa-arrow-left"></i>Quitter</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="update-tour" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title custom-font">Modifier une tournée de livraison</h3>
            </div>
            <div class="modal-body">              
                
                    
                      <form class="form-horizontal" method="post" action="{{ route('deliverytour.update') }}">
                        {{csrf_field()}}
                        <input type="hidden" id="idtour" name="idtour">
                        <div class="form-group">
                          <label class="control-label">Titre de la tournée</label>
                          <input type="text" class="form-control"  name="title" id="utitle">
                        </div>
                        <div class="form-group">
                          <label class="control-label">Choisir un livreur*</label>
                          <select class="form-control" required name="deliveryman" id="udeliveryman">
                                <option></option>
                              @foreach($adminUsers as $user)
                                @if($user->hasRole(['deliveryman']))
                                <option value="{{$user->id}}">{{$user->firstname}} {{$user->lastname}}</option>
                                @endif
                              @endforeach
                          </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Date de la tournée*</label>
                            <div class="input-group dp_datetour w-360 mt-10">
                                <input type="text" value="{{date('d/m/Y')}}" class="form-control dp_datetour" required name="tourdate" id="utourdate">
                                <span class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Heure de départ de la tournée*</label>
                            <div class="input-group dp_dimetour w-360 mt-10">
                                <input type="text" class="form-control dp_dimetour" required name="tourtime" id="utourtime">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Itineraire de la tournée</label><br>
                            <select class="form-control chosen-select" name="tour_route[]" id="utour_route" multiple style="width: 480px;">
                                @foreach($communes as $c)
                                <option value="{{$c->id}}" selected>{{$c->commune}}</option>
                                @endforeach
                            </select>
                        </div>
                        {{--<div class="form-group">
                            <label class="control-label">Commandes</label><br>
                            <select class="form-control chosen-select" name="tour_order" id="tour_order" multiple style="width: 480px;">
                                @foreach(waitingDelivery()->get() as $key => $c)
                                <option value="{{$c->qid}}">{{$c->number_n}}</option>
                                @endforeach
                            </select>
                        </div>--}}
                        <div class="form-group">
                          <button type="submit" class="btn btn-success">Enregistrer</button>
                          <button type="reset" class="btn btn-danger">Annuler</button>
                        </div>
                      </form>       
              </div>
               
            <div class="modal-footer">
                <button class="btn btn-default btn-ef btn-ef-4 btn-ef-4c" data-dismiss="modal"><i class="fa fa-arrow-left"></i>Quitter</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="set-to-tour" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title custom-font">Mise en livraison</h3>
            </div>
            <div class="modal-body">              
                
                    
                      <form class="form-horizontal" method="post" action="{{ route('settodelivery.post') }}">
                        {{csrf_field()}}
                        
                        <div class="form-group">
                            <label class="control-label">Commandes</label><br>
                            <select class="form-control" required name="tour_order[]" id="tour_order" multiple style="width: 480px;">
                                @foreach(waitingDelivery()->get() as $key => $c)
                                @if(!isOrderSetToDeliveryTour($c->qid))
                                <option value="{{$c->qid}}">{{$c->number_n}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Tournée de livraison</label><br>
                            <select class="form-control" name="tour" id="tour" required>
                                @foreach($delivery_tour as $key=>$del_tour)
                                @if($del_tour->delivery_tour_status!=2)
                                <option value="{{$del_tour->id}}"><span style="font-weight: bold; color:red">{{$del_tour->title}} - {{$del_tour->tour_number}}</span> - {{date('d/m/Y H:i:s',strtotime($del_tour->tour_start_date))}}</option>
                                @endif
                                @endforeach
                            </select>
                            <span class="help-block">Nom de la tournée - N° de tournée - Date de début</span>
                        </div>
                        <div class="form-group">
                          <button type="submit" class="btn btn-success">Enregistrer</button>
                          <button type="reset" class="btn btn-danger">Annuler</button>
                        </div>
                      </form>       
              </div>
               
            <div class="modal-footer">
                <button class="btn btn-default btn-ef btn-ef-4 btn-ef-4c" data-dismiss="modal"><i class="fa fa-arrow-left"></i>Quitter</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="set-to-tour2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title custom-font">Mise en livraison</h3>
            </div>
            <div class="modal-body">              
                
                    
                      <form class="form-horizontal" method="POST" action="{{ route('settodelivery.post') }}">
                        {{csrf_field()}}
                        
                        <div class="form-group">
                            <label class="control-label">Commandes</label><br>
                            <select class="form-control" name="tour_order[]" id="tour_order2" multiple style="width: 480px;">
                                @foreach(waitingDelivery()->get() as $key => $c)
                                <option value="{{$c->qid}}">{{$c->number_n}}</option>
                               
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Tournée de livraison</label><br>
                            <select class="form-control" name="tour" id="tour">
                                @foreach($delivery_tour as $key=>$del_tour)
                                <option value="{{$del_tour->id}}"><span style="font-weight: bold; color:red">{{$del_tour->tour_number}}</span> - {{date('d/m/Y H:i:s',strtotime($del_tour->tour_start_date))}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                          <button type="submit" class="btn btn-success">Enregistrer</button>
                          <button type="reset" class="btn btn-danger">Annuler</button>
                        </div>
                      </form>       
              </div>
               
            <div class="modal-footer">
                <button class="btn btn-default btn-ef btn-ef-4 btn-ef-4c" data-dismiss="modal"><i class="fa fa-arrow-left"></i>Quitter</button>
            </div>
        </div>
    </div>
</div>

        
<script>
    function clear () {
        $('#idtour').val("");
        $('#utitle').val("");
        $('#udeliveryman option[value=""]').attr("selected", "selected");
        $('#utourdate').val("");
        $('#utourtime').val("");
    }
    function getDeliveryTour (id_tour) {
         $.get("/admin/getdeliverytour/"+id_tour, function(data) {
            clear()
            d = JSON.parse(data)
            console.log(d)
            if(d.length!='0'){
                $('#idtour').val(d.id);
                $('#utitle').val(d.title);
                $('#udeliveryman').val(d.deliveryman_id);
                $('#udeliveryman option[value='+d.deliveryman_id+']').attr("selected", "selected");
                $('#utourdate').val(formatdate(d.tour_start_date));
                $('#utourtime').val(d.tour_start_date.substr(11,5));
            }else
            {
                clear()
            }
         })
     }

     function getOrder(id_order) {
         $.get("/admin/getorder/"+id_order, function(data) {
            clear()
            d = JSON.parse(data)
            console.log(d)
            if(d.length!='0'){
                $('#tour_order option[value='+d.id+']').attr("selected", "selected");
                $('#tour_order2 option[value='+d.id+']').attr("selected", "selected");
            }
         })
     }

     function formatdate(date){
        date = date.substr(0, 10)
        console.log(date)
        split = date.split('-');
        date = split[2]+'/'+split[1]+'/'+split[0];
        return date
     }

     function closeTour (idtour) {
        var url = "/admin/closedeliverytour/"+idtour
        swal({
              title:"Fermer!",
              text: "Voulez vous fermer cette tournée?",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#e05d6f",
              confirmButtonText: "Oui",
              cancelButtonText: "Non",
              closeOnConfirm: false
          }, function () {
              swal("Close!", "", "success");
              $.ajax(
              {
                  type: "get",
                  url: url,
                  success: function(data){
                  }
              }
              )
              .done(function(data) {
                  swal("Succes!", "La tourné est terminée!", "success");
                  setTimeout(function(){
                      window.location.reload()
                  }, 1000);
              })
              .error(function(data) {
                  swal("Oops", "Erreur interne!", "error");
              })
          });
     }

    function StartDeliveryTour (id) {
        url = "/admin/startdeliverytour/"+id
        swal({
            title:"Demarrer!",
            text: "Voulez vous demarrer cette tournée de livraison?",
            type: "warning",
            showCancelButton: true,
            //confirmButtonColor: "#",
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
                swal("Succes!", "La tournée à demarré", "success");
                d = JSON.parse(data);
                setTimeout(function(){
                     window.location.href = "/admin/commandes/list/?q="+d.tour_number
                }, 1000);
            })
            .error(function(data) {
                swal("Oops", "Erreur interne!", "error");
            })
        });
    }

        $(window).load(function(){
            //initialize responsive datatable
           var table = $('#table1').DataTable({
                   "dom": 'Rlfrtip'
               });

           var table = $('#table2').DataTable({
                   "dom": 'Rlfrtip'
               });

        });

        $('#raty4').raty({
            readOnly: true,
            score: 5,
            number:1,
            hints : ['Urgent'],
            starOn: 'fa fa-star text-orange'
        });

        $(".dp_datetour").datetimepicker({
            format : "DD/MM/YYYY",
            showTodayButton: true
            //minDate: moment()
        });

        $(".dp_dimetour").datetimepicker({
            format : "LT"
        });
</script>

<script src="{{asset('back/assets/js/vendor/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/daterangepicker/moment.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/raty-fa/jquery.raty-fa.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/chosen/chosen.jquery.min.js')}}"></script>
<script src="<?php echo asset('back/assets/js/vendor/datatables/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo asset('back/assets/js/vendor/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js'); ?>"></script>
<script src="<?php echo asset('back/assets/js/vendor/datatables/extensions/Responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?php echo asset('back/assets/js/vendor/datatables/extensions/ColVis/js/dataTables.colVis.min.js'); ?>"></script>
<script src="<?php echo asset('back/assets/js/vendor/datatables/extensions/TableTools/js/dataTables.tableTools.min.js'); ?>"></script>
<script src="<?php echo asset('back/assets/js/vendor/datatables/extensions/dataTables.bootstrap.js'); ?>"></script>
@stop
