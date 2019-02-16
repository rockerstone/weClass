@extends("welcome")

@section('content')
<form action="{{route('OrgCreation')}}" method="post">
	@csrf
	组织名称<input type="text" name="org_name" value="{{old("org_name")}}"><br>
	用户名	<input type="text" name="username" value="{{old("username")}}"><br>
	邮箱    <input type="text" name="email" value="{{old("email")}}"><br>
	密码	<input type="password" name="password"><br>
	重复密码<input type="password" name="repassword"><br>
	<input type="submit">
</form>

@if ($errors->any())
	<ul id="errors">
		@foreach($errors->all() as $error)
			<li>{{$error}}</li>
		@endforeach
	</ul>
@endif
@endsection