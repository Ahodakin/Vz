@extends('Backoffice.layouts.app')

@section("content")
<div class="page page-tables-datatables">

    <div class="pageheader">
       
        <h2>Gérer mes Clients <span></h2>

        <div class="page-bar">

            <ul class="page-breadcrumb">
                <li>
            <a href="{{route('spaceDashboard')}}"><i class="fa fa-home"></i> AROLI ASSURANCE</a>
                </li>
                <li>
                    <a href="#">Gérer mes clients</a>
                </li>
                <li>
                    <a href="#">Mes clients</a>
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
                    <h1 class="custom-font"><strong>Mes CLIENTS</strong></h1>
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
                <div class="tile-body">
                    <div class="row">
                        <div class="col-md-6"><div id="tableTools"></div></div>
                        <div class="col-md-6"><div id="colVis"></div></div>
                    </div>
                    <table class="table table-custom" id="advanced-usage">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Prenoms</th>
							<th>Contact</th>
                            <th>Genre</th>
                            <th>E-mail</th>											
                            <th>Naissance</th>
                            <th>Nombre de commande</th>
                            <th>Date enregistrement</th>
							<th>Action</th>
                        </tr>
                        </thead>
						 <tbody>



                          @foreach($clients as $key=> $client)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $client->user->firstname}}</td>
						        <td>{{ $client->user->lastname}}</td>
                                <td>{{ $client->user->contact}}</td>
                                <td>{{ ($client->user->gender=="H")? "Homme":"Femme"}}</td>
                                <td>{{ $client->user->email}}</td>
                                <td>{{ date("d/m/Y",strtotime($client->user->dob)) }}</td>
                                <td>{{ $client->nb_quote}}</td>
                                <td>{{ date("d/m/Y H:i:s",strtotime($client->user->created_at)) }}</td>
							     <td>      										
                                    <a href="{{route('client.detail',['id'=>$client->user->id])}}" class="btn btn-success"> <i class="glyphicon glyphicon-list"></i> Détails</a>										
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
                

@section('custom-script')
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title custom-font">Supprimer le client</h3>
            </div>
            <div class="modal-body">
            <input type="hidden" name="id" id="id_div" value="">
                   <div class="form-group">
                                    <label for="message">Justification: </label>
                                    <textarea class="form-control" rows="6" name="message" id="message" placeholder="Pour quelle raison voulez-vous supprimer ce client?" required></textarea>
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
         <!-- ===============================================
        ============== Page Specific Scripts ===============
        ================================================ -->
        <script>
            $(window).load(function(){


         $(".del").click(function(){
            // alert('helffflo');
               //e.preventDefault();
                      //alert('hello');
                      var href = $(this).attr("id");
                      //alert(href)
                    $('#id_div').val(href);
                       
                     
                        });


             $("#del_btn").click(function(){
                var id = $("#id_div").val();
                var cause = $("#message").val();
                //alert(id);
                //alert(cause);
                     $.get(id, function(data)
                        {   
                          alert(data); 
                            
                          $(".message_div").html('<span class="alert alert-success">client supprimer avec succès</span>');                
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
                    "sSwfPath": "/back/assets/js/vendor/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
                });

                $(tt.fnContainer()).insertAfter('#tableTools');
                //*initialize responsive datatable


           
          

            });
        </script>
        <!--/ Page Specific Scripts -->


@stop

