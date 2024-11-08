@extends('Backoffice.layouts.app')
@section("content")
<div class="page page-ui-portlets">
    <div class="pageheader">
        <h2>Configuration Autre tarifs <span></span></h2>
        <div class="page-bar">

            <ul class="page-breadcrumb">
                <li>
                    <a href="{{route('spaceDashboard')}}"><i class="fa fa-home"></i> MONASSURANCE.CI</a>
                </li>
                <li>
                <a href="#.">Autres tarifs</a>
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

        @if(\Illuminate\Support\Facades\Session::has('error'))
            <div class="text-center container w-420">
                <div class="alert alert-danger alert-dismissable">
                    <h4><p align="center">{{\Illuminate\Support\Facades\Session::get('error')}}</p></h4>
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
                                        <form class="form-horizontal" action="{{route('editAutoReglementaryOther')}}" method="post" style="padding:20px">
                                            {{csrf_field()}}
                                                <div class="row">
                                                    <div class="form-group{{ $errors->has('autotaux') ? ' has-error' : '' }} col-sm-12">
                                                        <label for="first-name">Taux Automobile</label>
                                                        <input type="number" class="form-control" id="autotaux"  name="autotaux" value="{{$config->autotaux}}">
                                                        @if ($errors->has('autotaux'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('autotaux') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group{{ $errors->has('fga') ? ' has-error' : '' }} col-sm-12">
                                                        <label for="last-name">FGA</label>
                                                        <input type="number" class="form-control" id="fga" name="fga" value="{{$config->fga}}">
                                                        @if ($errors->has('fga'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('fga') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                 <div class="row">
                                                    <div class="form-group{{ $errors->has('cedeao') ? ' has-error' : '' }} col-sm-12">
                                                        <label for="last-name">Prime CEDEAO</label>
                                                        <input type="number" class="form-control" id="cedeao" name="cedeao" value="{{$config->cedeao}}">
                                                        @if ($errors->has('cedeao'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('cedeao') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                              

                                                <div class="row">
                                                    <div class="form-group{{ $errors->has('default_redcom') ? ' has-error' : '' }} col-sm-12">
                                                        <label for="last-name">Reduction exceptionnelle automatique (FCFA)</label>
                                                        <input type="number" class="form-control" id="default_redcom" name="default_redcom" value="{{$config->default_redcom}}">
                                                        @if ($errors->has('default_redcom'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('default_redcom') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label class="checkbox checkbox-custom" style="color:red">
                                                                <input type="checkbox" name="enabled_max_discount" id="enabled_max_discount" {{($config->active_max_discount==1)?'checked':''}}><i></i>
                                                                Activer maximum de réduction (Commercialle, Permis, Cat. socio-pro)
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <button type="submit" class="btn btn-success btn-ef btn-ef-3 btn-ef-3c mb-10">Enregistrer
                                                             <i class="fa fa-arrow-right"></i></button>
                                                            <button type="reset" class="btn btn-danger btn-ef btn-ef-3 btn-ef-3c mb-10">Annuler</button>
                                                        </div>
                                                    </div>
                                                </div>

                                        </form>
 

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
<script type="text/javascript">

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