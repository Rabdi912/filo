 <!-- Checks the errors array that is created when validation failed-->
@if(count($errors)>0)
@foreach($errors->all() as $error)
<div class="alert alert-danger">
    {{$error}}
</div>
@endforeach
@endif
 <!-- Checks for session success -->
@if(session('success'))
<div class="alert alert-success">
    {{session('success')}}
</div>
@endif
 <!-- Checks for session error -->
@if(session('error'))
<div class="alert alert-danger">
    {{session('error')}}
</div>
@endif