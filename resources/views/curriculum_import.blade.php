@extends("welcome")

@section('content')
<form action="{{route('CurImport')}}" method="post">
	@csrf
	组织代码<input type="text" name="org_code" value="{{old("org_code")}}"><br>
	学号	<input type="text" name="stuid" value="{{old("stuid")}}"><br>
	密码	<input type="password" name="stupwd"><br>
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