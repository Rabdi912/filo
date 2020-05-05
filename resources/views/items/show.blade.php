@extends('layouts.app')
@section('content')
<!--ensures that the admin cannot request an item -->
@if(!Auth::user()->role==1)
<a href="{{ route('requests', $item['id']) }}" class="btn btn-primary float-right">Request</a>
@endif
<!--the view the user will see when viewing item details -->
<br>
<br>
<center><h1>Found Item</h1></center>
<br>
<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
<!-- carousel for mutilple images-->
<?php 
$image=$item['cover_image'];
$image =ltrim($image);
if($image == ""){ ?>
<!-- if users do not upload image then upload auto image-->
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
    <center>
        <div class="card-header">Display Description </div>
    </center>
    <div class="card-body">
        <table class="table table-hover">
            <!-- Display associated data for specified item -->
            <tr>
                <th> id</th>
                <td> {{$item->id}} </td>
            </tr>
            <tr>
                <th> Category</th>
                <td> {{$item->category }} </td>
            </tr>
            <tr>
                <th> Date Found </th>
                <td> {{$item->date_found}} </td>
            </tr>
            <tr>
                <th> Color </th>
                <td> {{$item->color}} </td>
            </tr>
            <tr>
                <th> Location </th>
                <td> {{$item->location}} </td>
            </tr>
            <tr>
                   <!-- using !! helps parse the html used by ck-editor -->
                <th> Description </th>
                <td> {!!$item->description!!} </td>
            </tr>
    </div>
</div>

</table>
<small>Added on {{$item->created_at}} by {{$item->user->name}}</small>
<!--Checks if user is admin; only allows admin to delete and edit items -->
@if(!Auth::guest())
@if(Auth::user()->role==1)
<hr>
<a href="{{ route('edit', $item['id'])}}" class="btn btn-primary">Edit</a>
<a type="button" class="btn btn-danger float-right"
href="{{ route('destroy',  $item['id']) }}">Delete</a>
@endif
@endif
@endsection