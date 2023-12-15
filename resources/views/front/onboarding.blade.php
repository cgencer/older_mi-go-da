@extends('front.layouts.master')
@section('head') @livewireStyles @endsection
@section('title') onboarding Migoda... @endsection
@section('body')
    <div class="d-flex justify-content-center pull-right">
	@horizontal([
		'route' => 'f.onboarding', 
		'pull_right' => false, 
		'left_class' => 'col-5', 
		'right_class' => 'col-7'
	])
	@livewire('country-search', ['request' => $request])
	@unless (Auth::check()) PLEASE LOGIN FIRST! @endunless
	email: @auth {{ $request['email'] }} @endauth
	@livewire('hotel-search', ['request' => $request])
	@close
	@if($link!=='')<br /><a href="{{ $link }}">Please continue to Stripe onboarding proccess...</a>@endisset
	</div>
	<div class="d-flex justify-content-center">
		<h2>Required information:</h2>
		<ul>
		@foreach($minSpecs as $i => $spec)
			<li>{{ $spec }}</li>
		@endforeach
		</ul>
	</div>
	<div class="d-flex justify-content-center">
		<h2>Optional information:</h2>
		<ul>
		@foreach($addSpecs as $i => $spec)
			<li>{{ $spec }}</li>
		@endforeach
		</ul>
	</div>
@endsection
@section('javascripts') @livewireScripts @endsection
