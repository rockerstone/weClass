@extends("welcome")

@section('content')
    @for($week=1;$week<=20;$week++)
        第{{$week}}周<br>
        <table border="1"><tbody>
            <tr>
                <th scope="col"></th>
                <th scope="col">星期一</th>
                <th scope="col">星期二</th>
                <th scope="col">星期三</th>
                <th scope="col">星期四</th>
                <th scope="col">星期五</th>
                <th scope="col">星期六</th>
                <th scope="col">星期日</th>
            </tr>
        @for($time=1;$time<=10;$time++)
            <tr>
                <th scope="col">{{$time}}</th>
            @for($day=1;$day<=7;$day++)
                    <td>{{$data[$week][$day][$time]==0?"空":""}}</td>
            @endfor
            </tr>
        @endfor
        </tbody></table>
    @endfor
@endsection