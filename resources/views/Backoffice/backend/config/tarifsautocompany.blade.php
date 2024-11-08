@extends('Backoffice.layouts.app')
@section("content")
<div class="page page-shop-single-order">
    <div class="pageheader">
        <h2>Tarifs {{$compagnie->compname}}</h2>

        <div class="page-bar">

            <ul class="page-breadcrumb">
                <li>
                    <a href="{{route('spaceDashboard')}}"><i class="fa fa-home"></i> MONASSURANCE.CI</a>
                </li>
                <li>
                    <a href="#">Automobile</a>
                </li>
                <li>
                    <a href="{{route('companyPage')}}">Compagnies</a>
                </li>
                <li>
                    <a href="#">Tarifs</a>
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
	
        <div class="pagecontent">
            <div class="add-nav">
                <div class="nav-heading">
                    <h3><strong class="text-greensea">{{$compagnie->compname}}</strong></h3>
                    <span class="controls pull-right">
                      <img src="/images/assureurs/{{$compagnie->complogo}}">
                    </span>
                </div>
                <div role="tabpanel">

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#details" aria-controls="details" role="tab" data-toggle="tab">Tarifs</a></li>
                                </ul>

                                <div class="tab-content">
                                    <!-- tab in tabs -->
                                    <div role="tabpanel" class="tab-pane active" id="details">
                                        <!-- row -->
                                        <div class="row">
                                            <!-- col -->
                                            <div class="col-md-12">
                                                <!-- tile -->
                                                <section class="tile time-simple">
                                                    <!-- tile body -->
                                                    <div class="tile-body p-0">
                                                        <div class="table-responsive">
                                                            <table class="table table-hover table-striped">
                                                                <thead>
                                                                <tr>
                                                                    <th>Code</th>
                                                                    <th>Garantie</th>
                                                                    <th>Franchise</th>
                                                                    <th>Somme garantie</th>
                                                                    <th>Tarif/Taux Annuel</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($tarifs as $t)
                                                                <tr>
                                                                    <td>{{$t->codeguar}}</td>
                                                                    <td>{{$t->titleguar}}</td>
                                                                    <td>
                                                                        <input type="text" class="form-control" value="{{ isset($t->franchise) ? $t->franchise : '' }}">
                                                                    </td>
                                                                    
                                                                    <td>                    
                                                                        <input type="text" class="form-control" value="{{ isset($t->sommegarantie) ? $t->sommegarantie : '' }}">
                                                                        
                                                                    </td>
                                                                    <td>
                                                                    
                                                                    <div class="input-group">
                                                                        {{-- <input type="number" class="form-control" value="{{$t->cost}}"> --}}
                                                                        <span class="input-group-addon bootstrap-touchspin-postfix">
                                                                       {{-- <!-- @if($t->cost<1)
                                                                        %
                                                                        @else
                                                                        CFA
                                                                        @endif--> --}}
                                                                        </span>
                                                                    </div>
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
                                            <!-- /col -->
                                        </div>
                                        <!-- /row -->

                                    </div>
                                </div>
                            </div>
                        </div>
	</div>
</div>

@endsection
@section('header-script')

<link href="{{asset('css/sweetalert/sweetalert.css')}}" rel="stylesheet">
@endsection

@section('footer-script')

<script src="{{asset('js/vendors/sweetalert/sweetalert.min.js')}}"></script>
@endsection
@section('custom-script')

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
@endsection