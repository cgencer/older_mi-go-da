@if ($errors->any())
    <div class="alert alert-danger migoda-alert alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <div class="mg-section mg-group">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@else
    @if (session()->has('success'))
        <div class="alert alert-success migoda-alert alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <div class="mg-section mg-group">
                {{session('success')}}
            </div>
        </div>
    @endif
    @if (session()->has('warning'))
        <div class="alert alert-warning migoda-alert alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <div class="mg-section mg-group">
                {{session('warning')}}
            </div>
        </div>
    @endif
    @if (session()->has('info'))
        <div class="alert alert-info migoda-alert alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <div class="mg-section mg-group">
                {{session('info')}}
            </div>
        </div>
    @endif
@endif
