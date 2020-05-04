@extends('layouts.app')
@section('content')
<br>
<br>
<!-- this is a view the user will see when requesting an item-->
<center><h1>Found Item</h1></center>
<br>
<!-- carousel for mutilple images-->
<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
	<?php 
	$image=$item['cover_image'];
	$image =ltrim($image);
	//if users do not upload image then upload auto image
	if($image == ""){ ?>
	<img style= "width:100%"src="../storage/cover_images/noimage.jpg">
	<?php } 
	// show mutiple images or an image in a carousel
	else{
		$new = explode(" ",$image);?>
		@foreach ($new as $n)
		<div data-target="#carouselExampleIndicators" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></div>
		@endforeach
		<div class="carousel-inner" role="listbox">
			@foreach( $new as $n )
			<div class="carousel-item {{ $loop->first ? 'active' : '' }}">
			 <center><img class="d-block img-fluid"  src="{{asset('../storage/cover_images/'.$n)}}"></center>
			</div>
			@endforeach
		  </div>
		  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		  </a>
		  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		  </a>
		</div><?php }?>
		<br>
<div class="card">
	<!-- view the information of item that is requested, so users can access the item they requestsed -->
	<center>
		<div class="card-header">Request Item </div>
	</center>
	<div class="card-body">
		<table class="table table-hover">
			<tr>
				<th> id</th>
				<td> {{$item['id']}} </td>
			</tr>
			<tr>
				<th> Category</th>
				<td> {{$item['category'] }} </td>
			</tr>
			<tr>
				<th> Date Found </th>
				<td> {{$item['date_found']}} </td>
			</tr>
			<tr>
				<th> Color </th>
				<td> {{$item['color']}} </td>
			</tr>
			<tr>
				<th> Location </th>
				<td> {{$item['location']}} </td>
			</tr>
			<tr>
				<!-- using !! helps parse the html used -->
				<th> Description </th>
				<td> {!!$item['description']!!} </td>
			</tr>
	</div>
</div>

</table>
<small>Added by: {{$user['name']}}</small>
<!-- Form to allow user to request an item-->
<form method="POST" action="{{route('requests',$item['id']) }}" enctype="multipart/form-data">
	<!-- CSRF Token -->
	@csrf
	<div class="form-group row">
		<label for="reason" class="col-md-12 col-form-label text-md-center">Reason</label>
		<div class="col-md-12">
			<input id="reason" type="text" class="form-control" name="reason">
		</div>
	</div>
	<div class="form-group row">
		<div class="col-md-12">
			<input id="submit" type="submit" class="form-control">
		</div>
	</div>
</form>

@endsection