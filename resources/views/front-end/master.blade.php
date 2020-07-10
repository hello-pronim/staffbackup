@extends('master')
@push('stylesheets')

@endpush

@section('header')
	@if (file_exists(resource_path('views/extend/includes/header.blade.php')))
		@include('extend.includes.header')
	@else
		@if (\Request::is('register'))
			@include('components.header.regiter-header')
		@else
			@include('includes.header')
		@endif
	@endif
@endsection

@section('main')
@stack('stylesheets')
<main id="wt-main" class="wt-main wt-innerbgcolor wt-haslayout {{ !empty($body_class) ? $body_class : '' }}">
	@yield('content')
</main>

@endsection

@section('footer')
	@if (file_exists(resource_path('views/extend/front-end/includes/footer.blade.php')))
		@include('extend.front-end.includes.footer')
	@else
		@if (\Request::is('register'))
			@include('components.footer.register-footer')
		@else
			@include('front-end.includes.footer')
		@endif
	@endif
@endsection

@push('scripts')
@stack('scripts')
@endpush
