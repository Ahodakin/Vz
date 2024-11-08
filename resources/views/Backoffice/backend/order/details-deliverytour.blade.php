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
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
        </div>
        <!-- /col -->
    </div>
    <!-- /row -->
    @endif
    <div class="add-nav">
        <div class="nav-heading">
            <h3>Tournée : {{$delivery_tour->title}} | <strong class="text-greensea">#{{$delivery_tour->tour_number}}</strong></h3><br/>
            <h5>Livreur : <strong class="text-greensea">{{$delivery_tour->deliveryman->firstname}} {{$delivery_tour->deliveryman->lastname}}</strong></h5>
            @if($delivery_tour->delivery_tour_status==0)
                <div class="alert alert-info alert-dismissable"><h5>La tournée de livraison n'a pas encore demarré. Contactez le gestionnaire d'exploitation.</h5></div>
            @endif
        </div>

        <div role="tabpanel">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#details" aria-controls="details" role="tab" data-toggle="tab">Details</a></li>
                <li role="presentation" class=""><a href="#checklist" aria-controls="checklist" role="tab" data-toggle="tab">Ma checklist</a></li>
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
                                                <th>Adresse de livraison</th>
                                                <th>Nom & Prénoms</th>
                                                <th>Contact</th>
                                                <th>Type contrat</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th>Tournée</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($prospects as $key => $prospect)
                                            
                                                <tr>
                                                    <td>{{++$key}}</td>
                                                    <td><a data-toggle="tooltip" title="Voir détails" href="{{route('devis.details',['id'=>$prospect->qid,'aid'=>$prospect->aid])}}">{{ $prospect->number_n}}</a></td>
                                                    <td>{{ $prospect->delivery_location}}</td>
                                                    <td>{{ $prospect->user->firstname}}</td>
                                                    <td>{{ $prospect->user->lastname}}</td>
                                                    <td>{{ $prospect->user->contact}}</td>
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
                                                    <td>
                                                           {!! get_commande_status($prospect->status) !!}
                                                    </td>
                                                    <td>{{ date("d/m/Y H:i:s", strtotime($prospect->date_created))}}</td>
                                                    <td>
                                                        @if(isOrderSetToDeliveryTour($prospect->qid))
                                                        <label data-toggle="tooltip" title="N° de la tournée" class="label label-{{(getDeliveryTourStatus($prospect->qid)->delivery_tour_status==0)?'warning':'success'}}">{{getDeliveryNumberForOrder($prospect->qid)->tour_number}}</label>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($prospect->delivery_status==0)
                                                            @if($delivery_tour->delivery_tour_status==0)
                                                                <label class="label label-info">La tournée de livraison n'a pas encore demarré</label>
                                                            @else
                                                            <a data-toggle="modal" data-target="#modal_confirm_delivery" title="Livré" href="javascript:;" onclick="getDeliveryTourOrderInfos2({{$prospect->delivery_status}}, {{$prospect->order_id}},{{$prospect->id_delivery_tour_order}},'{{$prospect->number_n}}', '{{htmlentities(addslashes($prospect->firstname))}}', '{{htmlentities(addslashes($prospect->lastname))}}')" class="btn btn-success"> <i class="fa fa-truck"></i> </a> 
                                                            <a data-toggle="modal" onclick="getDeliveryTourOrderInfos({{$prospect->order_id}},{{$prospect->id_delivery_tour_order}},'{{$prospect->number_n}}', '{{$prospect->firstname}}', '{{$prospect->lastname}}')" data-target="#modal_not_delivery" title="Non livré" href="javascript:;" class="btn btn-warning"> <i class="glyphicon glyphicon-warning-sign"></i> </a> 
                                                            @endif
                                                        @elseif($prospect->delivery_status==1)
                                                            <label class="label label-success">Livrée</label>

                                                            <a data-toggle="modal" data-target="#modal_confirm_delivery" title="Telecharger images" href="javascript:;" onclick="getDeliveryTourOrderInfos2({{$prospect->delivery_status}},{{$prospect->order_id}},{{$prospect->id_delivery_tour_order}},'{{$prospect->number_n}}', '{{htmlentities(addslashes($prospect->firstname))}}', '{{htmlentities(addslashes($prospect->lastname))}}')" class="btn btn-info"> <i class="fa fa-download"></i> </a> 
                                                        @else
                                                            <label class="label label-danger">Non Livrée</label>

                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach  
                                            @if(sizeof($prospects_voyage)>0)
                                                @foreach($prospects_voyage as $key => $prospect)
                                                    @if($prospect->status==5) <?php $i=$i+1; ?> @endif
                                                    <tr>
                                                        <td>{{++$key}}</td>
                                                        <td><a data-toggle="tooltip" title="Voir détails" href="{{route('devis.voyage.details',['id'=>$prospect->qid,'aid'=>$prospect->assur_voy_id])}}">{{ $prospect->number_n}}</a></td>
                                                        <td>{{ $prospect->delivery_location}}</td>
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

                                                        <td>
                                                               {!! get_commande_status($prospect->status) !!}
                                                        </td>
                                                        <td>{{ date("d/m/Y H:i:s", strtotime($prospect->created_at))}}</td>
                                                        
                                                        <td>
                                                            @if(isOrderSetToDeliveryTour($prospect->qid))
                                                            <label data-toggle="tooltip" title="N° de la tournée" class="label label-{{(getDeliveryTourStatus($prospect->qid)->delivery_tour_status==0)?'warning':'success'}}">{{getDeliveryNumberForOrder($prospect->qid)->tour_number}}</label>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($prospect->delivery_status==0)
                                                                @if($delivery_tour->delivery_tour_status==0)
                                                                    <label class="label label-info">La tournée de livraison n'a pas encore demarré</label>
                                                                @else
                                                                <a data-toggle="modal" data-target="#modal_confirm_delivery" title="Livré" href="javascript:;" onclick="getDeliveryTourOrderInfos2({{$prospect->delivery_status}}, {{$prospect->order_id}},{{$prospect->id_delivery_tour_order}},'{{$prospect->number_n}}', '{{htmlentities(addslashes($prospect->firstname))}}', '{{htmlentities(addslashes($prospect->lastname))}}')" class="btn btn-success"> <i class="fa fa-truck"></i> </a> 
                                                                <a data-toggle="modal" onclick="getDeliveryTourOrderInfos({{$prospect->order_id}},{{$prospect->id_delivery_tour_order}},'{{$prospect->number_n}}', '{{$prospect->firstname}}', '{{$prospect->lastname}}')" data-target="#modal_not_delivery" title="Non livré" href="javascript:;" class="btn btn-warning"> <i class="glyphicon glyphicon-warning-sign"></i> </a> 
                                                                @endif
                                                            @elseif($prospect->delivery_status==1)
                                                                <label class="label label-success">Livrée</label>

                                                                <a data-toggle="modal" data-target="#modal_confirm_delivery" title="Telecharger images" href="javascript:;" onclick="getDeliveryTourOrderInfos2({{$prospect->delivery_status}},{{$prospect->order_id}},{{$prospect->id_delivery_tour_order}},'{{$prospect->number_n}}', '{{htmlentities(addslashes($prospect->firstname))}}', '{{htmlentities(addslashes($prospect->lastname))}}')" class="btn btn-info"> <i class="fa fa-download"></i> </a> 
                                                            @else
                                                                <label class="label label-danger">Non Livrée</label>

                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach 
                                            @endif
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

                <div role="tabpanel" class="tab-pane" id="checklist">
                    <!-- tile -->

                    <div class="col-md-7">  
                        <section class="tile widget-todo" fullscreen="isFullscreen04" ng-controller="TodoWidgetCtrl">

                            <!-- tile header -->
                            <div class="tile-header dvd dvd-btm">
                                <h1 class="custom-font"><strong>Todo </strong>List</h1>
                                <ul class="controls">
                                    <li class="dropdown">

                                        <a role="button" tabindex="0" class="dropdown-toggle settings" data-toggle="dropdown">
                                            <i class="fa fa-cog"></i>
                                            <i class="fa fa-spinner fa-spin"></i>
                                        </a>

                                        <ul class="dropdown-menu pull-right with-arrow animated littleFadeInUp">
                                            <li>
                                                <a role="button" tabindex="0" class="tile-toggle">
                                                    <span class="minimize"><i class="fa fa-angle-down"></i>&nbsp;&nbsp;&nbsp;Minimize</span>
                                                    <span class="expand"><i class="fa fa-angle-up"></i>&nbsp;&nbsp;&nbsp;Expand</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a role="button" tabindex="0" class="tile-refresh">
                                                    <i class="fa fa-refresh"></i> Refresh
                                                </a>
                                            </li>
                                            <li>
                                                <a role="button" tabindex="0" class="tile-fullscreen">
                                                    <i class="fa fa-expand"></i> Fullscreen
                                                </a>
                                            </li>
                                        </ul>

                                    </li>
                                    <li class="remove"><a role="button" tabindex="0" class="tile-close"><i class="fa fa-times"></i></a></li>
                                </ul>
                            </div>
                            <!-- /tile header -->

                            <!-- tile body -->                        
                            <div class="tile-body lined-paper">
                                <ul class="todo-list list-unstyled">
                                    <li>
                                        <div class="view">
                                            <label class="checkbox checkbox-custom m-0 text-muted inline">
                                                <input type="checkbox"><i></i>
                                            </label>
                                            <span>Vérifier les informations de la carte grise</span>
                                            <a role="button" tabindex="0" class="text-danger remove-todo pull-right">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="view">
                                            <label class="checkbox checkbox-custom m-0 text-muted inline">
                                                <input type="checkbox"><i></i>
                                            </label>
                                            <span>Scanner la carte grise</span>
                                            <a role="button" tabindex="0" class="text-danger remove-todo pull-right">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="view">
                                            <label class="checkbox checkbox-custom m-0 text-muted inline">
                                                <input type="checkbox"><i></i>
                                            </label>
                                            <span>Faire signer le contrat d'assurance</span>
                                            <a role="button" tabindex="0" class="text-danger remove-todo pull-right">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="view">
                                            <label class="checkbox checkbox-custom m-0 text-muted inline">
                                                <input type="checkbox"><i></i>
                                            </label>
                                            <span>Scanner le contrat signé</span>
                                            <a role="button" tabindex="0" class="text-danger remove-todo pull-right">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="view">
                                            <label class="checkbox checkbox-custom m-0 text-muted inline">
                                                <input type="checkbox"><i></i>
                                            </label>
                                            <span>Remettre le contrat et la police d'assurance au client</span>
                                            <a role="button" tabindex="0" class="text-danger remove-todo pull-right">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="view">
                                            <label class="checkbox checkbox-custom m-0 text-muted inline">
                                                <input type="checkbox"><i></i>
                                            </label>
                                            <span>Encaisser l'argent</span>
                                            <a role="button" tabindex="0" class="text-danger remove-todo pull-right">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="view">
                                            <label class="checkbox checkbox-custom m-0 text-muted inline">
                                                <input type="checkbox"><i></i>
                                            </label>
                                            <span>Photographier le véhicule assuré</span>
                                            <a role="button" tabindex="0" class="text-danger remove-todo pull-right">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="view">
                                            <label class="checkbox checkbox-custom m-0 text-muted inline">
                                                <input type="checkbox"><i></i>
                                            </label>
                                            <span>Remercier le client</span>
                                            <a role="button" tabindex="0" class="text-danger remove-todo pull-right">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!-- /tile body -->
                        </section>
                    </div>
                    <div class="col-md-5"></div>
                    <!-- /tile -->
                </div>
            </div>
        </div>
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>

<script>

new DataTable('#table1');

</script>
@endsection
                
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
                    <div class="form-group" id="obs_div">
                        <label class="label-control">Observations</label>
                        <textarea class="form-control" rows="3" name="obs"></textarea>
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
                    <hr/>
                    <div class="form-group">
                        <button class="btn btn-success" id="confirm_delivery" type="button">Confirmer la livraison</button>
                    </div>
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
              {{-- <script id="template-upload" type="text/x-tmpl">
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
              </script> --}}

            <!-- The template to display files available for download -->
            {{-- <script id="template-download" type="text/x-tmpl">
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
            </script> --}}
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

@section('custom-script')
<script type="text/javascript">
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
       
       var html = "<h2>Commande #"+order+"</h2>";
            html+= "<h4>Client : "+firstname+" "+lastname+"</h4>";
       $('#div_info').html(html)
    }

    function getDeliveryTourOrderInfos2 (delivery_status,order_id,delivery_tour_order_id,order,firstname,lastname) {
       $('#order_id').val(order_id)
       $('#delivery_order_id').val(delivery_tour_order_id)
       
       var html = "<h2>Commande #"+order+"</h2>";
        html+= "<h4>Client : "+firstname+" "+lastname+"</h4>";

        if(delivery_status==1){
            $('#obs_div').hide()
            $('#confirm_delivery').hide()
        }else{
            $('#obs_div').show()
            $('#confirm_delivery').show()
        }

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

           

        });



    });
</script>


@stop

