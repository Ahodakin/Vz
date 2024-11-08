@extends('Backoffice.layouts.app')

@section("content")
<div class="page page-tables-datatables">

    <div class="pageheader">
        @if(session('message'))
        <div class="alert alert-danger">
            <strong>Felicitation!</strong> Devis generé avec succès<br><br>
        </div>
        @endif
        <h2>Gérer mes commandes <span></h2>

        <div class="page-bar">

            <ul class="page-breadcrumb">
                <li>
                <a href="{{route('spaceDashboard')}}"><i class="fa fa-home"></i> AROLI ASSURANCE</a>
                </li>
                <li>
                    <a href="#">Gérer commande</a>
                </li>
                <li>
                    <a href="">Commandes traitées</a>
                </li>
            </ul>
        </div>

    </div>

    <!-- row -->
    <div class="row">
        <!-- col -->
        <div class="col-md-12">
            <!-- tile -->
            <section class="tile">
                <!-- tile header -->
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Mes commandes</strong></h1>
                    
                </div>
                <!-- /tile header -->

                <!-- tile body -->
                <div class="tile-body">
                    <div class="row">
                        <div class="col-md-6"><div id="tableTools"></div></div>
                        <div class="col-md-6"><div id="colVis"></div></div>
                    </div>
                    <table class="table table-custom" id="advanced-usage">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>N°DEVIS</th>
                            <th>Nom</th>
                            <th>Prenoms</th>
							<th>Contact</th>
                            <th>E-mail</th>
							<th>Type contrat</th>
							<th>Status</th>
							<th>ACTION</th>
                        </tr>
                        </thead>
						 <tbody>



                          @foreach($commandes as $key=>$commande)
						    
                             
                           <tr>
                           <td>{{++$key}}</td>
                           <td>{{ $commande->number_n}}</td>
						    <td>{{ $commande->firstname}}</td>
                            <td>{{ $commande->lastname}}</td>
                            <td>{{ $commande->contact}}</td>
                            <td>{{ $commande->email}}</td>
							<td>
                                 @if($commande->product_type==1)
                                  Auto
                                @elseif($commande->product_type==3)
                                    Voyage
                                @endif

                            </td>
							<td>
                            {!! get_commande_status($commande->status) !!}


                            </td>
							
							<td>
                            
							
							 @if($commande->product_type==1)
                              <a href="{{route('devis.details',['id'=>$commande->qid,'aid'=>$commande->aid])}}" class="btn btn-success"> <i class="glyphicon glyphicon-eye-open"></i></a>
                            @elseif($commande->product_type==3)
                                <a href="{{route('devis.voyage.details',['id'=>$commande->qid,'aid'=>$commande->aid])}}" class="btn btn-success"> <i class="glyphicon glyphicon-eye-open"></i></a>
                            @endif
							</td>
						  </tr>
						  
						   @endforeach  
						  
						  
						  
						 </tbody>
                    </table>
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
<link rel="stylesheet" href="<?php echo asset('back/assets/js/vendor/datatables/css/jquery.dataTables.min.css')?>">
<link rel="stylesheet" href="<?php echo asset('back/assets/js/vendor/datatables/datatables.bootstrap.min.css')?>">
<link rel="stylesheet" href="<?php echo asset('back/assets/js/vendor/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css')?>">
<link rel="stylesheet" href="<?php echo asset('back/assets/js/vendor/datatables/extensions/Responsive/css/dataTables.responsive.css')?>">
<link rel="stylesheet" href="<?php echo asset('back/assets/js/vendor/datatables/extensions/ColVis/css/dataTables.colVis.min.css')?>">
<link rel="stylesheet" href="<?php echo asset('back/assets/js/vendor/datatables/extensions/TableTools/css/dataTables.tableTools.min.css')?>">
@stop

@section('footer-script')
<script src="<?php echo asset('back/assets/js/vendor/parsley/parsley.min.js'); ?>"></script>

<script src="<?php echo asset('back/assets/js/vendor/form-wizard/jquery.bootstrap.wizard.min.js'); ?>"></script>
<script src="<?php echo asset('back/assets/js/vendor/datatables/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo asset('back/assets/js/vendor/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js'); ?>"></script>
<script src="<?php echo asset('back/assets/js/vendor/datatables/extensions/Responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?php echo asset('back/assets/js/vendor/datatables/extensions/ColVis/js/dataTables.colVis.min.js'); ?>"></script>
<script src="<?php echo asset('back/assets/js/vendor/datatables/extensions/TableTools/js/dataTables.tableTools.min.js'); ?>"></script>
<script src="<?php echo asset('back/assets/js/vendor/datatables/extensions/dataTables.bootstrap.js'); ?>"></script>
@stop
@section('custom-script')
 <!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title custom-font">Supprimer le commande</h3>
            </div>
            <div class="modal-body">
            <input type="hidden" name="id" id="id_div" value="">
                   <div class="form-group">
                                    <label for="message">Justification: </label>
                                    <textarea class="form-control" rows="6" name="message" id="message" placeholder="Pour quelle raison voulez-vous supprimer ce commande?" required></textarea>
                                </div>
                <div class="message_div"></div>
            </div>
            <div class="modal-footer">
                <button id="del_btn" class="btn btn-success btn-ef btn-ef-3 btn-ef-3c"><i class="fa fa-arrow-right"></i> Confirmer</button>
                <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Abandonner</button>
            </div>
        </div>
    </div>
</div>
    <script>
        $(window).load(function(){
         $(".del").click(function(){
            var href = $(this).attr("id");
            $('#id_div').val(href);
        });
         $("#del_btn").click(function(){
            var id = $("#id_div").val();
            var cause = $("#message").val();
                 $.get(id, function(data)
                    {   
                      alert(data); 
                        
                      $(".message_div").html('<span class="alert alert-success">commande supprimer avec succès</span>');                
                    }
                  ); 
        });

        //initialize responsive datatable
        function stateChange(iColumn, bVisible) {
            console.log('The column', iColumn, ' has changed its status to', bVisible);
        }

        var table4 = $('#advanced-usage').DataTable({
           /* "ajax": 'assets/extras/datatables-basic.json',*/
            
            "aoColumnDefs": [
              { 'bSortable': false, 'aTargets': [ "no-sort" ] }
            ]
        });

        var colvis = new $.fn.dataTable.ColVis(table4);

        $(colvis.button()).insertAfter('#colVis');
        $(colvis.button()).find('button').addClass('btn btn-default').removeClass('ColVis_Button');

        var tt = new $.fn.dataTable.TableTools(table4, {
            sRowSelect: 'single',
            "aButtons": [
                'copy',
                'print', {
                    'sExtends': 'collection',
                    'sButtonText': 'Save',
                    'aButtons': ['csv', 'xls', 'pdf']
                }
            ],
            "sSwfPath": "assets/js/vendor/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
        });

        $(tt.fnContainer()).insertAfter('#tableTools');
        //*initialize responsive datatable

    });
</script>


@stop
      

