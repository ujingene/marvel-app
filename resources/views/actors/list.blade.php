@extends('layouts.app')

@section('content')
	<div class="container mx-auto">
		<style>
		  body {background:gray !important;}
		</style>

		<div class="heading text-center font-bold text-2xl m-5 text-gray-100">
			Marvel Comic Characters
		</div>

		<div class="holder mx-auto w-10/12 grid sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-4">

			@foreach($characters as $key => $character)
				<!-- each -->
				<div class="each mb-10 m-2 shadow-lg border-gray-800 bg-gray-100 relative">
				    <img 
				    	class="md:w-full h-56" 
				    	src="{{$character['thumbnail']['path'] . '.' . $character['thumbnail']['extension']}}" 
				    	alt="" 
				    />
				    <div class="info-box text-xs flex p-1 font-semibold text-gray-500 bg-gray-300">
				    	<span 
				    		class="mr-1 p-1 px-2 font-bold">
				    			{{count($character['comics'])}} Comics
				    	</span>
				        <span 
				        	class="mr-1 p-1 px-2 font-bold border-l border-gray-400">
				        		{{count($character['series'])}}  Series
				        </span>
				      	<span 
				      		class="mr-1 p-1 px-2 font-bold border-l border-gray-400">
				      			{{count($character['stories'])}}  Stories
				      	</span>
				    </div>
				    <div class="desc p-4 text-gray-800">
				    	<a class="title font-bold block">{{$character['name']}}</a>
				      	<span class="description text-sm block py-2 border-gray-400 mb-2">{{$character['description']}}</span>
				    </div>
			  	</div>
			  <!-- each -->
			@endforeach

		</div>

		<div class="row">
            <div class="col-md-12">
                {{ $characters->links('pagination::tailwind') }}
            </div>
        </div>
	</div>

@endsection