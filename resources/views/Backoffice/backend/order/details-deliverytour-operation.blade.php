@extends('Backoffice.layouts.app')

@section("content")

<div class="page page-tables-datatables">

    <div class="pageheader">
        <h2>Tournée de livraison <span></h2>

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

     @if(\Illuminate\Support\Facades\Session::has('error'))
    <!-- row -->
    <div class="row">
        <!-- col -->
        <div class="col-md-12">
                <div class="alert alert-danger">{{\Illuminate\Support\Facades\Session::get('error') }}</div>
        </div>
        <!-- /col -->
    </div>
    <!-- /row -->
    @endif
    <div class="add-nav">
        <div class="nav-heading">
            <h3>Tournée : <strong class="text-greensea">#{{$delivery_tour->tour_number}}</strong></h3><br/>
            <h5>Livreur : <strong class="text-greensea">{{$delivery_tour->firstname}} {{$delivery_tour->lastname}}</strong></h5>
            <span class="controls pull-right">
                @if($delivery_tour->delivery_tour_status==0)
                <a href="javascript:;" onclick="StartDeliveryTour({{$delivery_tour->id}})" data-toggle="tooltip" title="Demarrer la tournée" class="btn btn-success"><i class="fa fa-play"></i> Démarrer la tournée</a>
                @elseif($delivery_tour->delivery_tour_status==1)
                <a href="javascript:;" onclick="closeTour({{$delivery_tour->id}})"  data-toggle="tooltip" title="Fermer la tournée" class="btn btn-info"><i class="fa fa-times"></i> Fermer la tournée</a>
                @else
                <label class="label label-danger">Fermée</label>
                @endif
            </span>
        </div>

        <div role="tabpanel">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#details" aria-controls="details" role="tab" data-toggle="tab">Details</a></li>
            </ul>

            <div class="tab-content">
                <!-- tab in tabs -->
                <div role="tabpanel" class="tab-pane active" id="details">



                    <!-- row -->
                    <div class="row">
                        <!-- col -->
                        <div class="col-md-12">


                            <!-- tile -->
                            <section class="tile tile-simple">

                                <!-- tile body -->
                                <div class="tile-body p-0">

                                    <div class="table-responsive">
                                        <table class="table table-custom" id="table1">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>N° Commande</th>
                                                <th>Client</th>
                                                <th>Contact</th>
                                                <th>Type contrat</th>
                                                <th>Date création</th>
                                                <th>Expiration</th>
                                                <th>Status</th>
                                                <th>Prime</th>
                                                <th>Livraison</th>
                                                <th>Services</th>
                                                <th>Montant encaissé</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 0; $total=0 ?>
                                            @foreach($prospects as $key => $prospect)
                                                @if($prospect->status==5) <?php $i=$i+1; ?> @endif
                                                <tr>
                                                    <td>{{++$key}}</td>
                                                    <td><a data-toggle="tooltip" title="Voir détails" href="{{route('devis.details',['id'=>$prospect->qid,'aid'=>$prospect->aid])}}">{{ $prospect->number_n}}</a></td>
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
                                                    <td>{{ date("d/m/Y H:i:s", strtotime($prospect->date_created))}}</td>
                                                    
                                                    <td>
                                                           {!! get_commande_status($prospect->status) !!}
                                                    </td>
                                                    
                                                    <td>
                                                    
                                                    @foreach(getQuoteInfos($prospect->auto_id, $prospect->user_id, $prospect->aid) as $quote)
                                                    
                                                        @if($prospect->company_id==$quote->idcomp)
                                                           {{number_format($quote->TTC-$quote->FG)}}
                                                        @endif

                                                    @endforeach
                                                    </td>
                                                    <td>
                                                      
                                                    @foreach(getQuoteInfos($prospect->auto_id, $prospect->user_id, $prospect->aid) as $quote)
                                                        @if($prospect->company_id==$quote->idcomp)
                                                           {{number_format($quote->FG)}}
                                                        @endif

                                                    @endforeach
                                                    </td>
                                                    <td>
                                                    @foreach(getQuoteInfos($prospect->auto_id, $prospect->user_id, $prospect->aid) as $quote)
                                                        @if($prospect->company_id==$quote->idcomp)
                                                           {{number_format($quote->som_serv)}}
                                                        @endif

                                                    @endforeach
                                                    </td>
                                                    <td>
                                                        @if($prospect->inbox_amount!=0)
                                                            <span class="badge bg-blue"><i class="fa fa-thumbs-o-up"></i></span> <b>{{number_format($prospect->inbox_amount)}}</b>

                                                            <?php $total += ($prospect->inbox_amount); ?>
                                                        @else
                                                       @foreach(getQuoteInfos($prospect->auto_id, $prospect->user_id, $prospect->aid) as $quote)
                                                        @if($prospect->company_id==$quote->idcomp)
                                                           <span class="badge bg-lightred"><i class="fa fa-thumbs-o-down"></i></span> <b>{{number_format($quote->TTC+$quote->som_serv - $prospect->reduction_commerciale)}}FCFA</b>
                                                           <?php $total += $quote->TTC+$quote->som_serv- $prospect->reduction_commerciale; ?>
                                                        @endif

                                                    @endforeach
                                                    @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{route('devis.details',['id'=>$prospect->qid,'aid'=>$prospect->aid])}}"  class="btn btn-xs btn-primary"><i class="fa fa-plus"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach  
                                            @if(sizeof($prospects_voyage)>0)
                                                @foreach($prospects_voyage as $key => $prospect)
                                                    @if($prospect->status==5) <?php $i=$i+1; ?> @endif
                                                    <tr>
                                                        <td>{{++$key}}</td>
                                                        <td><a data-toggle="tooltip" title="Voir détails" href="{{route('devis.voyage.details',['id'=>$prospect->qid,'aid'=>$prospect->assur_voy_id])}}">{{ $prospect->number_n}}</a></td>
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
                                                        <td>{{ date("d/m/Y H:i:s", strtotime($prospect->created_at))}}</td>

                                                        <td>
                                                            @foreach(getQuoteVoyageInfos($prospect->user_id, $prospect->assur_voy_id,$prospect->pays_zone) as $quote)
                                                            
                                                                @if($prospect->company_id==$quote->idcomp)
                                                                   {{number_format($quote->ASSURANCE->DUREE)}} Jours
                                                                @endif

                                                            @endforeach
                                                        </td>
                                                        
                                                        <td>
                                                               {!! get_commande_status($prospect->status) !!}
                                                        </td>
                                                        
                                                        <td>
                                                        
                                                        @foreach(getQuoteVoyageInfos($prospect->user_id, $prospect->assur_voy_id,$prospect->pays_zone) as $quote)
                                                        
                                                            @if($prospect->company_id==$quote->idcomp)
                                                               {{number_format($quote->PRIME)}}
                                                            @endif

                                                        @endforeach
                                                        </td>
                                                        <td>
                                                          
                                                        @foreach(getQuoteVoyageInfos($prospect->user_id, $prospect->assur_voy_id,$prospect->pays_zone) as $quote)
                                                            @if($prospect->company_id==$quote->idcomp)
                                                               {{number_format($quote->FG)}}
                                                            @endif

                                                        @endforeach
                                                        </td>
                                                        <td>
                                                        @foreach(getQuoteVoyageInfos($prospect->user_id, $prospect->assur_voy_id,$prospect->pays_zone) as $quote)
                                                            @if($prospect->company_id==$quote->idcomp)
                                                               {{number_format($quote->AMOUNT_SERVICES)}}
                                                            @endif

                                                        @endforeach
                                                        </td>
                                                        <td>
                                                            @if($prospect->inbox_amount!=0)
                                                                <span class="badge bg-blue"><i class="fa fa-thumbs-o-up"></i></span> <b>{{number_format($prospect->inbox_amount)}}</b>

                                                                <?php $total += $prospect->inbox_amount; ?>
                                                            @else
                                                           @foreach(getQuoteVoyageInfos($prospect->user_id, $prospect->assur_voy_id,$prospect->pays_zone) as $quote)
                                                            @if($prospect->company_id==$quote->idcomp)
                                                               <span class="badge bg-lightred"><i class="fa fa-thumbs-o-down"></i></span> <b>{{number_format($quote->PRIME+$quote->FG+$quote->AMOUNT_SERVICES)}}FCFA</b>
                                                               <?php $total += $quote->PRIME+$quote->FG+$quote->AMOUNT_SERVICES; ?>
                                                            @endif

                                                        @endforeach
                                                        @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{route('devis.voyage.details',['id'=>$prospect->qid,'aid'=>$prospect->assur_voy_id])}}"  class="btn btn-xs btn-primary"><i class="fa fa-plus"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach 
                                            @endif


                                            </tbody>
                                        </table>

                                    </div>
                                    <div class="row">
                                        <!-- col -->
                                        <div class="col-md-3 col-md-offset-9 price-total">

                                            <!-- tile -->
                                            <section class="tile tile-simple bg-tr-black lter">

                                                <!-- tile body -->
                                                <div class="tile-body">

                                                    <ul class="list-unstyled">
                                                        
                                                        <li><strong class="inline-block w-sm">Total:</strong> <h4 class="inline-block text-success ng-binding">
                                                        {{--@if(tourIsSignature($delivery_tour->id))
                                                            {{number_format(getTourSignature($delivery_tour->id)->amount_inbox)}} FCFA
                                                        @else--}}
                                                        {{number_format($total)}} FCFA</h4>

                                                        {{--@endif--}}

                                                        </li>
                                                    </ul>

                                                </div>
                                                <!-- /tile body -->

                                            </section>
                                            <!-- /tile -->

                                        </div>
                                        <!-- /col -->
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
@endsection
                
{{--       
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

<!-- blueimp Gallery styles -->
<link rel="stylesheet" href="http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/file-upload/css/jquery.fileupload.css')}}">  

<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="{{asset('back/assets/js/vendor/file-upload/css/jquery.fileupload-noscript.css')}}"></noscript>
<noscript><link rel="stylesheet" href="{{asset('back/assets/js/vendor/file-upload/css/jquery.fileupload-ui-noscript.css')}}"></noscript>   
    
@endsection --}}

{{-- @section('footer-script') --}}
<!-- Modal -->
<div class="modal fade" id="modal_confirm_delivery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title custom-font">Confirmer la livraison</h3>
            </div>
            <div class="modal-body">
                <div id="div_info2"></div>
                <form id="fileupload" action="" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="order_id" id="order_id">
                    <input type="hidden" name="delivery_order_id" id="delivery_order_id">
                    <div class="form-group">
                        <label class="label-control">Observations</label>
                        <textarea class="form-control" rows="3" name="obs"></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success" id="confirm_delivery" type="button">Confirmer la livraison</button>
                    </div>
                    <!-- Redirect browsers with JavaScript disabled to the origin page -->
                    <noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
                    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                    <div class="row fileupload-buttonbar">
                        <div class="col-lg-9">
                            <!-- The fileinput-button span is used to style the file input field as button -->
                            <span class="btn btn-success fileinput-button">
                                <i class="glyphicon glyphicon-plus"></i>
                                <span>Ajouter des photos...</span>
                                <input type="file" name="files[]" multiple>
                            </span>
                            <button type="submit" class="btn btn-primary start">
                                <i class="glyphicon glyphicon-upload"></i>
                                <span>Demarrer l'upload</span>
                            </button>
                            <button type="reset" class="btn btn-warning cancel">
                                <i class="glyphicon glyphicon-ban-circle"></i>
                                <span>Annuler upload</span>
                            </button>
                            <button type="button" class="btn btn-danger delete">
                                <i class="glyphicon glyphicon-trash"></i>
                                <span>Supprimer</span>
                            </button>

                            <label class="checkbox checkbox-custom-alt checkbox-custom-lg inline-block ml-10">
                                <input type="checkbox" class="toggle"><i></i>
                            </label>
                            <!-- The global file processing state -->
                            <span class="fileupload-process"></span>
                        </div>
                        <!-- The global progress state -->
                        <div class="col-lg-3 fileupload-progress fade">
                            <!-- The global progress bar -->
                            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                            </div>
                            <!-- The extended global progress state -->
                            <div class="progress-extended">&nbsp;</div>
                        </div>
                    </div>
                    <!-- The table listing the files available for upload/download -->
                    <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
                </form>
                <!-- The blueimp Gallery widget -->
                <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
                    <div class="slides"></div>
                    <h3 class="title"></h3>
                    <a class="prev">‹</a>
                    <a class="next">›</a>
                    <a class="close">×</a>
                    <a class="play-pause"></a>
                    <ol class="indicator"></ol>
                </div>
            </div>
            <div class="confirmation_message_div"></div>
            <div class="modal-footer">
                <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Quitter</button>
            </div>
              <!-- The template to display files available for upload -->
              <script id="template-upload" type="text/x-tmpl">
                {% for (var i=0, file; file=o.files[i]; i++) { %}
                  <tr class="template-upload fade">
                    <td>
                      <span class="preview"></span>
                    </td>
                    <td>
                      <p class="name nomargin">{%=file.name%}</p>
                      <strong class="error text-danger"></strong>
                    </td>
                    <td class="upload">
                      <div class="progress-list">
                        <div class="details">
                          <div class="title">&nbsp;</div>
                          <div class="description">Progression</div>
                        </div>
                        <div class="status pull-right">
                          <span class="animate-number size" data-value="0" data-animation-duration="1500">Processing...</span>
                        </div>
                        <div class="clearfix"></div>
                        <div class="progress progress-striped active progress-xs nomargin" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
                      </div>

                    </td>
                    <td class="text-right actions">
                      {% if (!i && !o.options.autoUpload) { %}
                        <button class="btn btn-success start btn-sm" disabled>
                          <i class="fa fa-upload"></i>
                          <span> Demarer</span>
                        </button>
                      {% } %}
                      {% if (!i) { %}
                        <button class="btn btn-warning cancel btn-sm">
                          <i class="fa fa-times"></i>
                          <span> Annuler</span>
                        </button>
                      {% } %}
                    </td>
                  </tr>
                {% } %}
              </script>

            <!-- The template to display files available for download -->
            <script id="template-download" type="text/x-tmpl">
                {% for (var i=0, file; file=o.files[i]; i++) { %}
                  <tr class="template-download fade">
                    <td>
                      <span class="preview">
                        {% if (file.thumbnailUrl) { %}
                          <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                        {% } %}
                      </span>
                    </td>
                    <td>
                      <p class="name nomargin">
                        {% if (file.url) { %}
                            <a href="{%=file.url%}" class="white" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                        {% } else { %}
                            <span>{%=file.name%}</span>
                        {% } %}
                      </p>
                      {% if (file.error) { %}
                        <div><span class="label label-red">Error</span> {%=file.error%}</div>
                      {% } %}
                    </td>
                    <td>
                      <span class="size">{%=o.formatFileSize(file.size)%}</span>
                    </td>
                    <td class="text-right actions">
                      {% if (file.deleteUrl) { %}
                        <label class="checkbox checkbox-custom-alt checkbox-custom inline-block">
                            <input type="checkbox" id="delete-{%=file.name%}" class="toggle"><i></i>
                        </label>
                        <button class="btn btn-danger btn-sm delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                          <i class="fa fa-trash-o"></i>
                          <span> Supprimer</span>
                        </button>
                      {% } else { %}
                        <button class="btn btn-warning btn-sm cancel">
                          <i class="fa fa-times"></i>
                          <span> Annuler</span>
                        </button>
                      {% } %}
                    </td>
                  </tr>
                {% } %}
              </script>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_not_delivery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title custom-font">Commande non livré</h3>
            </div>
            <div class="modal-body">
                <div id="div_info"></div>
                <form class="form-horizontal" method="POST" action="{{ route('order.notdelivery') }}">
                    {{csrf_field()}}
                    <input type="hidden" name="order_id" id="n_order_id">
                    <input type="hidden" name="delivery_order_id" id="n_delivery_order_id">
                    <div class="form-group">
                        <label class="label-control">Motif de la non livraison</label>
                        <textarea class="form-control" required rows="5" name="obs"></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success" type="submit">Confirmer la non livraison</button>
                        <button class="btn btn-default" type="reset">Annuler</button>
                    </div>
                </form>
            </div>
     
            <div class="modal-footer">
                <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Quitter</button>
            </div>
             
        </div>
    </div>
</div>
        <!--/ vendor javascripts -->



{{-- @section('custom-script') --}}
<script type="text/javascript">
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
    $('#raty4').raty({
        readOnly: true,
        score: 5,
        number:1,
        hints : ['Urgent'],
        starOn: 'fa fa-star text-orange'
    });

    function getDeliveryTourOrderInfos (order_id,delivery_tour_order_id,order,firstname,lastname) {
       $('#n_order_id').val(order_id)
       $('#n_delivery_order_id').val(delivery_tour_order_id)
       console.log(order_id)
       console.log(delivery_tour_order_id)
       var html = '<h2>Commande #'+order+'</h2>';
            html+= '<h4>Client : '+firstname+' '+lastname+'</h4>';
       $('#div_info').html(html)
    }

    function getDeliveryTourOrderInfos2 (order_id,delivery_tour_order_id,order,firstname,lastname) {
       $('#order_id').val(order_id)
       $('#delivery_order_id').val(delivery_tour_order_id)
       console.log(order_id)
       console.log(delivery_tour_order_id)
       var html = '<h2>Commande #'+order+'</h2>';
            html+= '<h4>Client : '+firstname+' '+lastname+'</h4>';
       $('#div_info2').html(html)
    }

    $("#confirm_delivery").click(function(e){
      e.preventDefault();
      $.ajax({
               url: "/order/confirmdelivery",
               type : "POST",
               data : $('#fileupload').serialize(),
               dataType:'html',
               success :function(html)
               {
                location.reload();               
                },
                error: function(){
                   $('.confirmation_message_div').html("<p class='alert alert-danger'>Erreur interne du serveur</p>"); 
               }

           })

    });
</script>

<script>
    $(window).load(function(){

        $('.widget-todo .todo-list li .checkbox').on('change', function() {
            var todo = $(this).parents('li');

            if (todo.hasClass('completed')) {
                todo.removeClass('completed');
            } else {
                todo.addClass('completed');
            }
        });


        /*
         * jQuery File Upload Plugin JS Example 8.9.1
         * https://github.com/blueimp/jQuery-File-Upload
         *
         * Copyright 2010, Sebastian Tschan
         * https://blueimp.net
         *
         * Licensed under the MIT license:
         * http://www.opensource.org/licenses/MIT
         */

        /* global $, window */

        $(function () {
            'use strict';

            // Initialize the jQuery File Upload widget:
            $('#fileupload').fileupload({
                // Uncomment the following to send cross-domain cookies:
                xhrFields: {withCredentials: true},
                url: '/back/assets/js/vendor/file-upload/server/php/'
            });

            // Enable iframe cross-domain access via redirect option:
            $('#fileupload').fileupload(
                    'option',
                    'redirect',
                    window.location.href.replace(
                            /\/[^\/]*$/,
                            '/back/assets/js/vendor/file-upload/cors/result.html?%s'
                    )
            );

            if (window.location.hostname === 'blueimp.github.io') {
                // Demo settings:
                $('#fileupload').fileupload('option', {
                    url: '//jquery-file-upload.appspot.com/',
                    // Enable image resizing, except for Android and Opera,
                    // which actually support image resizing, but fail to
                    // send Blob objects via XHR requests:
                    disableImageResize: /Android(?!.*Chrome)|Opera/
                            .test(window.navigator.userAgent),
                    maxFileSize: 5000000,
                    acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
                });
                // Upload server status check for browsers with CORS support:
                if ($.support.cors) {
                    $.ajax({
                        url: '//jquery-file-upload.appspot.com/',
                        type: 'HEAD'
                    }).fail(function () {
                        $('<div class="alert alert-danger"/>')
                                .text('Upload server currently unavailable - ' +
                                new Date())
                                .appendTo('#fileupload');
                    });
                }
            } else {
                // Load existing files:
                $('#fileupload').addClass('fileupload-processing');
                $.ajax({
                    // Uncomment the following to send cross-domain cookies:
                    //xhrFields: {withCredentials: true},
                    url: $('#fileupload').fileupload('option', 'url'),
                    dataType: 'json',
                    context: $('#fileupload')[0]
                }).always(function () {
                    $(this).removeClass('fileupload-processing');
                }).done(function (result) {
                    $(this).fileupload('option', 'done')
                            .call(this, $.Event('done'), {result: result});
                });
            }

        });



    });
</script> 


{{-- @stop--}}

