@extends('beautymail::templates.widgets')

@section('content')

	@include('beautymail::templates.widgets.articleStart')

		<div>
			{{$mail_content}}
		</div>

	@include('beautymail::templates.widgets.articleEnd')

@stop