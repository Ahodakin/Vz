@extends('layouts.frontend.master')

@section("title")
www.monassurance.ci :: Rechercher un dévis
@endsection 

@section("custom-styles")

@endsection 

@section("custom-scripts")
<script type="text/javascript">
			$(document).ready(function() {
				$("#num_devis").mask("ARO/99999999/9999");
			})
		</script>
@endsection 

@section('content')

<section class="subpage-header">
	<div class="container">
		<div class="site-title clearfix">
			<h2>Automobile</h2>
			<ul class="breadcrumbs">
				<li><a href="/">Accueil</a></li>
				<li>Rechercher un dévis Automobile</li>
			</ul>
		</div>
		<a href="{{route('page.quote.auto')}}" class="btn btn-primary get-in-touch" data-text="Demander un dévis"><i class="fa fa-file-o"></i>Demander un dévis</a>
	</div>
</section>


<!-- WHO IS BEHIND -->
            <section class="bg-blue">
				<div class="container">
					@if(Session::has('error'))
					    <div class="text-center">
					        <div class="alert alert-danger alert-dismissable">
					        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					            <h4>{{Session::get('error')}}</h4>
					        </div>
					    </div>
					@endif

					@if(Session::has('info'))
					    <div class="text-center">
					        <div class="alert alert-info alert-dismissable">
					        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					            <h4>{{Session::get('info')}}</h4>
					        </div>
					    </div>

					    @foreach($companies as $c)
					    	<div class="col-md-2">
					    		@if($quote->product_type==1)
					    		<a href="{{ route('details.quote.auto', [$quote->id, $c->id]) }}"><img src="/images/assureurs/{{ $c->complogo }}" width="60px"></a>
					    		@else
					    		<a href="{{ route('details.quote.travel', [$quote->id, $c->id]) }}"><img src="/images/assureurs/{{ $c->complogo }}" width="60px"></a>

					    		@endif
					    	</div>
					    @endforeach
					@endif

					<form method="post"  action="{{route('submit.search')}}">
					{{csrf_field()}}
					  <div class="col-md-8">
					    <div class="form-group">
					    <label class="control-label">Numéro de devis</label>
					    <input type="text" class="form-control" required name="num_devis" id="num_devis" placeholder="Entrer votre numéro de dévis">
					  </div> 
					  </div>
					  <div class="col-md-4"> 
					  <br>
					  <button type="submit" data-text="Rechercher" class="btn btn-primary get-in-touch"> <i class="fa fa-search"></i>Rechercher</button></div>
					</form>
				</div>
			</section><!-- / WHO IS BEHIND -->
	

@endsection