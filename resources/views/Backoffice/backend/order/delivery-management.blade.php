@extends('Backoffice.layouts.app')

@section("content")

<div class="page page-tables-datatables">

    <div class="pageheader">
        <h2>Tournées de livraison <span></h2>

        <div class="page-bar">

            <ul class="page-breadcrumb">
                <li>
                <a href="{{route('spaceDashboard')}}"><i class="fa fa-home"></i> MONASSURANCE.CI</a>
                </li>
                <li>
                    <a href="#">Gérer mes livraisons</a>
                </li>
                <li>
                    <a href="">Tournée de livraison</a>
                </li>
            </ul>
 
        </div>

    </div>

    <!-- row -->
    <div class="row">
        <!-- col -->
        <div class="col-md-12">


            @if(\Illuminate\Support\Facades\Session::has('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif

            <!-- tile -->
            <section class="tile">

                <!-- tile header -->
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Tournée de livraison</strong></h1>
                </div>
                <!-- /tile header -->

                <!-- tile body -->
                <div class="tile-body">
                    <div role="tabpanel">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs tabs-dark" role="tablist">
                                <li role="presentation" class="active"><a href="#my-tour" aria-controls="settingsTab" role="tab" data-toggle="tab">Mes tournées &nbsp;&nbsp;<span class="label label-danger">{{sizeof(getUserDeliveryTours())}}</span></a></li>
                                <li role="presentation" class=""><a href="#all-tour" aria-controls="settingsTab" role="tab" data-toggle="tab">Toutes les tournées &nbsp;&nbsp;</a> </li>
                                
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">

                                 <div role="tabpanel" class="tab-pane active" id="my-tour">

                                    <div class="wrap-reset">
                                        <table class="table table-custom" id="table1">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>N°</th>
                                                <th>Livreur</th>
                                                <th>Date/Heure</th>
                                                <th>Itineraire(s)</th>
                                                <th>Commandes</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            @php
                                            use Illuminate\Support\Facades\Auth;
                                        @endphp
                                        
                                        <tbody>
                                            @foreach($delivery_tour as $key=>$del_tour)
                                                @if(Auth::user()->id == $del_tour->deliveryman_id)
                                                    <tr>
                                                        <td>{{ ++$key }}</td>
                                                        <td>{{ $del_tour->tour_number }}</td>
                                                        <td>{{ $del_tour->firstname }} {{ $del_tour->lastname }}</td>
                                                        <td>
                                                            <label class="label {{ (strtotime($del_tour->tour_start_date) < time()) ? 'label-danger' : 'label-success' }}">
                                                                {{ date('d/m/Y H:i:s', strtotime($del_tour->tour_start_date)) }} 
                                                            </label>
                                                        </td>
                                                        <td>
                                                            {!! getListOfRouteByDeliveryId($del_tour->id) !!}
                                                        </td>
                                                        <td>
                                                            {!! getListOfOrderByDeliveryId($del_tour->id) !!}
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('delivery.details', $del_tour->id) }}" data-toggle="tooltip" title="Afficher la tournée" class="btn btn-success"><i class="fa fa-eye"></i></a>
                                                            @if($del_tour->delivery_tour_status != 2)
                                                                <label class="label label-info">Ouverte</label>
                                                            @else
                                                                <label class="label label-danger">Fermée</label>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                        
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="all-tour">

                                    <div class="wrap-reset">
                                        <table class="table table-custom" id="table2">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>N°</th>
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
                                                    <td>
                                                        {!! getListOfRouteByDeliveryId($del_tour->id) !!}
                                                    </td>
                                                    <td>
                                                        {!! getListOfOrderByDeliveryId($del_tour->id) !!}
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('delivery.details', $del_tour->id) }}"  data-toggle="tooltip" title="Afficher la tournée" class="btn btn-success"><i class="fa fa-eye"></i></a>
                                                            @if($del_tour->delivery_tour_status!=2)
                                                            <label class="label label-info">Ouverte</label>
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
                <!-- /tile body -->

            </section>
            <!-- /tile -->

        </div>
        <!-- /col -->
    </div>
    <!-- /row -->

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

        <!--/ vendor javascripts -->
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



@section('custom-script')



         
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
        <!--/ Page Specific Scripts -->


@stop
