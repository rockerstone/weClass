@extends("welcome")

@section('content')
用户名{{$username}} 用户角色{{$role}}<br>
组织名称{{$name}}  组织代码{{$code}}<br>
年份{{$year}}  学期{{$term}}<br>
<form action="{{route('OrgEdit')}}" method="post">
	@csrf
	组织简介<textarea name="description">{{$description}}</textarea><br>
	<input type="submit">
</form>
<form action="{{route('Login&Logout')}}" method="post">
	@csrf
	<input type="hidden" name="log" value="out">
	<input type="submit" value="注销">
</form>

@if ($errors->any())
	<ul id="errors">
		@foreach($errors->all() as $error)
			<li>{{$error}}</li>
		@endforeach
	</ul>
@endif
<a href={{route("CurQuery")}}>课表查询</a><br>
成员名单<br>
----------------------------------<br>
@foreach($personnel as $person)
	学号：{{$person['stuid']}}<br>
	姓名：{{$person['name']}}<br>
	学院：{{$person['college']}}<br>
	专业：{{$person['major']}}<br>
	班级：{{$person['class']}}<br>
	-----------------------------<br>
@endforeach

@endsection