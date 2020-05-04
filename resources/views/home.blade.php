@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <!-- view users will see when logged in-->
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <!-- allow users to add an item-->
                    @if(Auth::user()->role ==0)
                    <a href="/items/create" class="btn btn-primary">Add Item</a>
                    <!-- allow admin to access Requests table-->
                    @else()
                    <a href="/requests" class="btn btn-primary">view Request </a>

                    @endif
                    <br>
                    <br>
                    <!-- allow users to access the items they created in the dashboard-->
                    @if(Auth::user()->role ==0)
                    <h3>Your Item Posts</h3>
                    @if(count($items)>0)
                    <table class="table ">
                        <tr>
                            <th> id</th>
                            <th> Category</th>
                            <th> Date Found </th>
                            <th> Color </th>
                            <th></th>
                        </tr>
                        @foreach($items as $item)
                        <tr>
                            <td> {{$item->id}} </td>
                            <td> {{$item->category }} </td>
                            <td> {{$item->date_found}} </td>
                            <td> {{$item->color}} </td>

                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Options
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="/items/{{$item->id}}">View More</a>

                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    @else
                    <p>You have no posts</P>
                    @endif
                    @else
                    <h5>you are logged in!</h5>
                    @endif
                </div>
            </div>
        </div>
        @if (Auth::user()->role==0)
    <div class="col-md-4 float-right" >
        <div class="card">
            <div class="card-header">User Details</div>
            <div class="card-body">
                @if($user= Auth::user())
                <b>Name: </b> {{$user['name'] }} <br />
                <b>Email Address: </b> {{$user['email'] }}<br />
                <b>Role: </b>
                @if($role = $user->role==1)
                Admin
                @else
                User
                @endif
                <br />
                <b>Joined: </b>{{$user['created_at']}} <br />
            </div>
        </div>
        <br>
        @endif
        @endif
    </div>
    </div>
</div>
    @endsection