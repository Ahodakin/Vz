@extends('Backoffice.layouts.app')
@section("content")
<div class="page page-ui-portlets">
    <div class="pageheader">
        <h2>Configuration Taux de reduction <span></span></h2>
        <div class="page-bar">

            <ul class="page-breadcrumb">
                <li>
                    <a href="{{route('spaceDashboard')}}"><i class="fa fa-home"></i> AROLI ASSURANCE</a>
                </li>
                <li>
                <a href="#.">Nos taux</a>
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
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-custom" id="basic">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Description</th>
                                                        <th>Taux</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody> 
                                                    @foreach($auto_reduction as  $key => $ar)
                                                        <tr>
                                                            <td>{{++$key}}</td>
                                                            <td>{{$ar->desc_reduction}}</td>
                                                            <td>{{$ar->rate}}</td>
                                                            <td>
                                                                <button onclick="getReductionById({{$ar->id}})" class="btn btn-primary mb-10" data-toggle="modal" data-target="#splash" data-options="splash-2 splash-ef-15"><i class="glyphicon glyphicon-edit"></i> Modifier</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
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
                <h3 class="modal-title custom-font">Modifier Taux reduction</h3>
            </div>
            <div class="text-center">
                <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4>Ce taux sera appliqué à toute les compagnies d'assurances</h4>
                </div>
            </div>
            <form class="form-horizontal" method="post" action="{{route('editAutoReduction')}}">
            <div class="modal-body">
                
                    {{csrf_field()}}
                    {{-- <input type="hidden" name="idred" id="idred" readonly> --}}
                    <input type="hidden" name="idred" value="{{ $auto_reduction->first()->id ?? '' }}">


                    <div class="form-group">
                        <label for="rate" class="col-sm-4 control-label" id="desc_rate"></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="rate" name="rate" placeholder="Taux de reduction">
                        </div>
                    </div>
                    <!--<div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <label class="checkbox checkbox-custom">
                                <input type="checkbox" name="enabled" id="enabled"><i></i>
                                Appliquer ce taux à toutes les compagnies?
                            </label>
                        </div>
                    </div>-->
               
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
function getReductionById (id_red) {
     $.get("/admin/reductionrate/"+id_red, function(data) {
        if(data!='0'){

        var d = JSON.parse(data);
        $('#idred').val(d.id);
        $('#rate').val(d.rate);
        $('#desc_rate').html(d.desc_reduction);
        }else{
        $('#idred').val("");
        $('#rate').val("");
        $('#desc_rate').html("");
        }
     })
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
