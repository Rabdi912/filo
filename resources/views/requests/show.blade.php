@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="card">
			<div class="card-header">
				<!-- view the admin will see when request has been made -->
				<center><h1>Requested Items</h1></center>
			</div>
			<div class="content">
				<!-- Show details of requested item. -->
					<table class="table table-responsive">
						<tr>
							<th>Category</th>
							<th>Item Details</th>
							<th>Reason</th>
							<th>Requestee Name</th>
							<th>Requestee Email</th>
							<th>Decision </th>
							<th>Actions</th>
						</tr>
						<!-- For loop of all requested item. -->
						@foreach($items as $item)
						<tr>
							<td>{{$itemsRequested[$item['id']]['category']}}</td>
							<td> <a href="{{action('ItemsController@show', $item['item_id'])}}" class="btn btn-primary">Details</a> </td>
							<td >{{$item['reason']}}</td>
							<td>{{$usersRequested[$item['id']]['name']}}</td>
							<td>{{$usersRequested[$item['id']]['email']}}</td>
							<!-- status of request -->
							@if($item['accept'] == 1)
							<td>Approved</td>
							@elseif ($item['accept'] == -1)
							<td>Declined</td>
							@else
							<td>No Decision Made</td>
							@endif
							<!--form to allow admin to make a decision -->
							@if($item['accept'] == 0)
							<td>

								<form method="post" action=" {{ route('requestsTable', ['id'=>$item['id']] ) }}">
									<button type="submit" value=declined >Declined</button>
									<button type="submit" value=access name=accept >accept</button>
									@csrf
								</form>
							</td>
							<!-- if request has been made allow admin to remove the request from the table  -->
							@else
							<td><form action="{{action('UserRequestsController@destroy', $item['id'])}}" method="post" enctype="multipart/form-data">
									@csrf
									<input name="_method" type="hidden" value="DELETE" />
									<button type="submit" class="btn btn-danger">Delete</a>
									</form>
							</td>
							@endif
							<td></td>
						</tr>
						@endforeach
					</table>
					{{$items->links()}}
				@csrf
			</div>
		</div>

	</div>
</div>
@endsection