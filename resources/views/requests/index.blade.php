@extends('layouts.app')
@section('content')
<!--allow users to go back to items page  -->
<a href="/items/{{$item['id']}}" class="btn btn-primary">Go Back</a>
<br>
<br>
<!-- this is a view the user will see when requesting an item-->
<center><h1>Found Item</h1></center>
<br>
<img style="width:100%" src="/storage/cover_images/{{$item['cover_image']}}">
<div class="card">
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