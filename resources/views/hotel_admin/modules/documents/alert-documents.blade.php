
    @php
        $user = Auth::guard('user')->user();
        $hotel = \App\Models\Hotels::where('user_id', $user->id)->get()->first();

        $insurance = \App\Models\Documents::where('userID', $user->id)->where('type', 3)->count();
        $commercial = \App\Models\Documents::where('userID', $user->id)->where('type', 2)->count();
        $migodaService = \App\Models\Documents::where('userID', $user->id)->where('type', 1)->count();

        @endphp
        @if ($hotel->is_verified == 0)
        <div class="notification-docs">
            <div class="alert alert-default">
                    <span>{!! trans('txt.hotel_acconunt_alert_title') !!} <br>
                    <ul>
                        <li><i class="fa {{ $commercial >= 1 ? 'fa-check-circle file-success' : 'fa-times-circle file-failed' }} "></i> {!! trans('txt.hotel_account_alert_first') !!} </li>
                        <li><i class="fa {{ $insurance >= 1 ? 'fa-check-circle file-success' : 'fa-times-circle file-failed' }}"></i> {!! trans('txt.hotel_account_alert_second') !!} </li>
                        <li><i class="fa {{ $migodaService >= 1 ? 'fa-check-circle file-success' : 'fa-times-circle file-failed' }}"></i> {!! trans('txt.hotel_account_alert_third') !!} </li>
                    </ul>
                    {!! trans('txt.hotel_account_alert_last_title') !!}  </span>
            </div>
        </div>
    @endif
