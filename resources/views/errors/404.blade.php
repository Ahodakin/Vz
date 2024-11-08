<?php $active = ""; ?>
@extends('layouts.frontend.master')

@section("title")
monassurance.ci :: 404 Not Found.
@endsection

@section("custom-styles")

@endsection

@section("custom-scripts")
<style type="text/css">
	.error404 {
	    background: url(../images/parallax/404.png) no-repeat center top;

	    height: 403px;
	    position: relative;
	}
</style>

@endsection

@section('content')

<section class="subpage-header">
	<div class="container">
		<div class="site-title clearfix">
			<h2>Ressource introuvable</h2>
			<ul class="breadcrumbs">
				<li><a href="/">Accueil</a></li>
				<li>Erreur 404</li>
			</ul>
		</div>
		<a href="{{route('home')}}" class="btn btn-primary get-in-touch" data-text="Page d'acceuil"><i class="fa fa-home"></i>Page d'acceuil</a>
	</div>
</section>

<!-- DIFFERENT SERVICES -->
<div class="error404" style="margin-top:30px">

</div><!-- / DIFFERENT SERVICES -->





@endsection
