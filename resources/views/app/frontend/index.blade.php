@extends('layouts.frontend.master')

@section("title")
    monassurance.ci :: 1er comparateur d'assurance en côte d'Ivoire
@endsection

@section("custom-styles")
    <link rel="stylesheet" type="text/css" href="{{asset('css/custom.css')}}">
@endsection

@section("custom-scripts")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.5/jquery.bxslider.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$('#travel-ads').modal({show: true});
		$('.carousel-client').bxSlider({
			auto: true,
		    slideWidth: 234,
		    minSlides: 2,
		    maxSlides: 5,
		    controls: false
		});
	var timelineBlocks = $('.cd-timeline-block'),
		offset = 0.8;

	//hide timeline blocks which are outside the viewport
	hideBlocks(timelineBlocks, offset);

	//on scolling, show/animate timeline blocks when enter the viewport
	$(window).on('scroll', function(){
		(!window.requestAnimationFrame)
			? setTimeout(function(){ showBlocks(timelineBlocks, offset); }, 100)
			: window.requestAnimationFrame(function(){ showBlocks(timelineBlocks, offset); });
	});

	function hideBlocks(blocks, offset) {
		blocks.each(function(){
			( $(this).offset().top > $(window).scrollTop()+$(window).height()*offset ) && $(this).find('.cd-timeline-img, .cd-timeline-content').addClass('is-hidden');
		});
	}

	function showBlocks(blocks, offset) {
		blocks.each(function(){
			( $(this).offset().top <= $(window).scrollTop()+$(window).height()*offset && $(this).find('.cd-timeline-img').hasClass('is-hidden') ) && $(this).find('.cd-timeline-img, .cd-timeline-content').removeClass('is-hidden').addClass('bounce-in');
		});
	}
});

document.addEventListener("DOMContentLoaded", function(){
		Typed.new(".element", {
			strings: ["<span class='color-default'>Economisez</span> jusqu’à 50% sur votre assurance", "<span class='color-default'>Comparez</span> plusieurs devis d’assurance et faites votre choix","Faites-vous <span class='color-default'>livrer</span> 7jr/7 " , "Soyez rassurés, tout est <span class='color-default'>géré</span>"],
			typeSpeed: 10,
			loop:true

		});
	});
</script>

@endsection

@section('content')

	@include("layouts.frontend.utils.slider-1")

	@include("layouts.frontend.utils.services-parallax")

	@include("layouts.frontend.utils.how-to-timeline")

@endsection
@if( strtotime(date("Y-m-d")) < strtotime("2018-04-01") )
	@include('layouts.frontend.utils.travel-ads-popup')
@endif
