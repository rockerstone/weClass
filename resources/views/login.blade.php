@extends("welcome")

@section('content')
<form action="{{route('Login&Logout')}}" method="post">
	@csrf
	<input type="hidden" name="log" value="in">
	用户名<input type="text" name="username" value="{{old("username")}}"><br>
	密码	  <input type="password" name="password"><br>
	<input type="submit">
</form>
<a href={{route("OrgCreationF")}}>注册</a>
@if ($errors->any())
	<ul id="errors">
		@foreach($errors->all() as $error)
			<li>{{$error}}</li>
		@endforeach
	</ul>
@endif

@endsection