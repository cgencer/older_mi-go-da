@if (Session::has('alert'))
    @php
        $alert = Session::get('alert');
switch($alert['status']){
case 'error':
    $class="danger";
    break;
    case 'danger':
    $class="danger";
    break;
    case 'warning':
    $class="warning";
    break;
    case 'success':
    $class="success";
    break;
    default:$class="alert5";break;
}
    @endphp
    <div class="alert alert-{{$class}}">
        {{ @$alert['message']}}
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <div> {{ $error }}</div>
        @endforeach
    </div>
@endif
