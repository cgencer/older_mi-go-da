@extends('front.layouts.master')@php
    $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();
@endphp
@section('title')
    @if ($query != '')
        {{ __('txt.searching-for-query', ['query' => $query]) }}
    @else
        {{ trans('txt.search_results_title') }}
    @endif @parent
@endsection
@section('body')
    <div class="page-destinations page-two-column">
        <div class="page-destinations-inner mg-section mg-group page-two-column-inner">
            <div class="two-column-left two-column-left-filters">
                <form id="filters-form" method="get">
                    <div class="search-input_wrapper clearfix filter_by">
                        <div class="input-text flexContainer" style="display:flex;">
                              <span class="location">
                                  <img src="{{ asset('front/assets/images/svg/location.svg') }}"/>
                              </span>
                            <input type="text" id="filter-query" name="q" class="flexyInput"
                                   placeholder="{{ trans('txt.search_destination_input')}}" value="{{ $query }}"/>
                        </div>
                    </div>
                    <h2>{{ trans('txt.filter_by')}}
                        <span class="toggle-filter" data-title-hide="{{ trans('txt.hide_filter')}}"
                              data-title-show="{{ trans('txt.show_filter')}}">({{ trans('txt.show_filter') }})</span>
                        <a id="clear_all">{{ trans('txt.clear_all')}}<span>x</span></a></h2>
                    <input type="hidden" name="page" value="{{ $current_page }}"/>
                    <h3 class="price-title filter_by">
                        <span><span
                                id="start-price-text">{{ \App\Helpers::localizedCurrency($start_price) }}</span> {{ \Illuminate\Support\Facades\Session::get('_currency_sign') }} - <span
                                id="end-price-text">{{ \App\Helpers::localizedCurrency($end_price) }}</span> {{ \Illuminate\Support\Facades\Session::get('_currency_sign') }}</span>
                        {{ trans('txt.filter_price')}}
                        <input type="hidden" name="start_price" id="start-price" value="{{ $start_price }}"/>
                        <input type="hidden" name="end_price" id="end-price" value="{{ $end_price }}"/>
                    </h3>
                    <div class="filter-list filter_by">
                        <input id="ex2" type="text" class="span2 price-slider" value=""
                               data-slider-rate="{{ \App\Helpers::localizedCurrency(1) }}"
                               data-slider-min="{{ $min_price }}" data-slider-max="{{ $max_price }}"
                               data-slider-step="5" data-slider-value="[{{ $start_price  }},{{ $end_price }}]"/>
                    </div>
                    @php
                        $singleFilterCategories = \App\Models\FeatureGroups::where('filter',1)->orderby('position','asc')->get();
                    @endphp
                    @foreach($singleFilterCategories as $singleFilterCategory)
                        <h3 class="filter_by">{{ ($singleFilterCategory->lang_key != "") ? trans('txt.'.$singleFilterCategory->lang_key) : $singleFilterCategory->name  }}</h3>
                        @php
                            $singleFilters = \App\Models\Features::where('group_id',$singleFilterCategory->id)->where('filter', 1)->get();
                        @endphp
                        <div class="filter-list filter_by">
                            <ul>
                                @foreach($singleFilters as $i => $singleFilter)
                                    <li @if ($singleFilter->type != "star") class="" @endif>
                                        <input id="{{ $singleFilterCategory->type.'_'.$singleFilter->id }}"
                                               {{ ($filters) ? ((in_array($singleFilter->id,$filters)) ? 'checked':''):'' }} value="{{ $singleFilter->id }}"
                                               type="checkbox" name="filter[]" class="faChkSqr"/>
                                        <label for="{{ $singleFilterCategory->type.'_'.$singleFilter->id }}">
                                            @if ($singleFilterCategory->type == "board_food_allowance")
                                                @php
                                                    $boardFoodExp = explode(' (', $singleFilter->name);
                                                @endphp
                                                @if (count($boardFoodExp) > 0)
                                                    {{$boardFoodExp[0]}}
                                                @endif
                                            @else
                                                {{ $singleFilter->name }}
                                            @endif
                                        </label>
                                    </li>
                                @endforeach
                                {{-- @if (count($singleFilters) > 4 && $singleFilter->type != "star")
                                    <li class="more-filter"><a href="#">{{ trans('txt.dest_f_more')}}
                                            &#x25BE;</a></li>
                                @endif --}}
                            </ul>
                        </div>
                    @endforeach
                    {!! Form::hidden('filter_on', 1, ['id' => 'filter_on']) !!}
                </form>
            </div>
            <div class="listing_wrapper two-column-right">
                <h1>
                    @if ($query != '')
                        {{ __('txt.searching-for-query', ['query' => $query]) }}
                    @else
                        {{ trans('txt.search_results_title') }}
                    @endif
                    <span id="total_records">{{ __('txt.total-matches-found', ['total' => $total_records]) }}</span>
                </h1>
                @if (\Illuminate\Support\Facades\Cookie::get('listing_notice') != 1)
                    <div class="notice" id="listing_notice">
                        <a href="#" class="notice-button listing-notice" data-cookie-id="listing_notice">x</a>
                        <ul>
                            <li>
                                {{ trans('txt.search_notice1') }}
                            </li>
                            <li>
                                {{ trans('txt.search_notice2') }}
                            </li>
                            <li>
                                {{ trans('txt.search_notice3') }}
                            </li>
                        </ul>
                    </div>
                    <div id="loader" class="resultsLoader text-center" style="display: none">
                        <img id="loading-image" src="{{ asset('front/assets/images/svg/loader.gif') }}?v=1.01"
                             width="60"/>
                        <h2 class="d-inline">Loading Results</h2>
                    </div>
                @endif
                <div class="alert alert-warning" id="alert-warning" role="alert" style="display: none">
                    {{ trans('txt.search_no_results') }}
                </div>
                <div class="hotelscard">

                </div>

                {{$hotels->onEachSide(0)->links('front.partials.pagination')}}
            </div>
        </div>
    </div>
@endsection
@section('javascripts')
    <script>

        $(document).ready(function () {
            $('#listing-wrapper').html('');

        })

        function setFilters() {
            $('.faChkSqr').attr('checked', false);
            var ajaxFilter = JSON.parse(localStorage.getItem('ajax_filters')) || [];

            $('.faChkSqr').each(function () {
                if (ajaxFilter.indexOf($(this).val()) > -1) {
                    $(this).attr('checked', true)
                }
            });

        }

        $('#clear_all').click(function () {
            localStorage.removeItem('ajax_filters');
            location.reload();
        })


        setFilters();

        var url = window.location.href.indexOf('page') > -1;
        var currentPage = localStorage.getItem('current_page') || 1;

        if (!url) {
            currentPage = 1;
        }
        localStorage.setItem('current_page', currentPage);

        getHotels();

        $(".faChkSqr").change(function (e) {
            localStorage.setItem('current_page', 1);
            var ajaxFilter = JSON.parse(localStorage.getItem('ajax_filters')) || [];
            var id = $(this).val();

            if (this.checked) {
                ajaxFilter.push(id);
            } else {
                ajaxFilter = jQuery.grep(ajaxFilter, function (value) {
                    return value != id;
                });
            }
            localStorage.setItem('ajax_filters', JSON.stringify(ajaxFilter));
            e.preventDefault();
            getHotels();
        });

        $("#filter-query").keyup(function (e) {
            e.preventDefault();
            var queryLength = $("#filter-query").val().length;
            setTimeout(() => {
                if (queryLength > 2 || queryLength == 0) {
                    getHotels();
                }
            }, 100);
        });

        $(".faChkSqr").change(function (e) {
            e.preventDefault();
            getHotels();
        });

        function getHotels() {
            var _token = $("input[name='_token']").val();
            var filter_on = $("#filter_on").val();
            var filter = $("#filters-form").serializeArray();
            var type = "ajax";
            var query = filter;
            var start_price = $('#start-price').val()
            var end_price = $('#end-price').val()
            var filter_query = $('#filter-query').val();
            var current_page = window.localStorage.getItem('current_page');

            $.ajax({
                type: 'GET',
                url: "{{route('f.destinations') }}",
                data: {
                    _token: _token,
                    filter: filter,
                    type: type,
                    filter_on: filter_on,
                    current_page: current_page,
                    page: current_page,
                    q: filter_query,
                    start_price: start_price,
                    end_price: end_price
                },
                beforeSend: function () {
                    $("#loader").show();
                    $('.hotelscard').html("");
                    $('.listing_pagination').hide();
                },
                success: function (data) {
                    $("#loader").hide();
                    $('.listing_pagination').show();

                    if (data.hotels.total_records > 0) {
                        $('#total_records').html(data.hotels.total_records + ' Matches Found')
                    } else {
                        $('#total_records').html('No Matches Found');
                        var noResult = $('#no_result').val();
                        $('.alert-warning').show();

                    }

                    history.replaceState(null, null, '?page=' + data.hotels.current_page + '');

                    var hotelsArray = "";

                    createPagination(data.hotels.total_pages, data.hotels.current_page)

                    JSON.parse(data.hotels.hotelData).forEach(hotel => {
                        var props = "";
                        hotel.properties.forEach(element => {
                            props +=
                                ' <li>'
                                + '<img src="' + element.icon + '" title="' + element.name + '"/>'
                                + '</li>'
                        });

                        if (hotel.verified == 1) {

                            hotelsArray += ' <div id="listing-wrapper" class="listing-item clearfix">'
                                + ' <div class="listing-item_left">'
                                + ' <a href="/detail/' + hotel.slug + '_' + hotel.id + '">'
                                + '<img src="' + hotel.imdImage_desktop + '" class="img-desktop" width="200" height="170">'
                                + '<img src="' + hotel.imdImage_mobile + '" class="img-mobile">'
                                + ' </a>'
                                + ' </div>'
                                + ' <div class="listing-item_middle">' + hotel.star + ' <h2>'
                                + ' <a href="' + hotel.url + '"> ' + hotel.name + '</a>'
                                + ' </h2>'
                                + ' <h3>' + hotel.city + ', ' + hotel.country + '</h3>'
                                + ' <ul class="listing-icons">'
                                + props
                                + ' </ul>'
                                + ' </div>'
                                + ' <div class="listing-item_right">'
                                + ' <div class="right-top-wrapper">'
                                + ' <div class="category">'
                                + hotel.category
                                + ' </div>'
                                + ' <div class="price">' + hotel.price + '</div>'
                                + ' </div>'
                                + ' <div class="right-middle-wrapper">'
                                + '(' + hotel.boardFood
                                + ' <br>'
                                + hotel.perPerson
                                + ' </div>'
                                + '<div class="right-bottom-wrapper ">'
                                + ' <a href="'+ hotel.wishListUrl +'"  data-hotelId="'+hotel.id+'" class="add-to-wishlist '+  (hotel.isFavourited == 1 ? "destinations-heart-color": "destinations-heart-no-color") + ' mg-primary-button destinations-wish res-icon">'
                                + ' <img class="wishlist-icon-desc" src="' + hotel.heartIcon + '">'
                                +'</a>'
                                + ' <a href="' + hotel.url + '" class="mg-tertiary-button res-button">{{ trans("txt.search_booking_button") }}'
                                + ' <img src="' + hotel.arrowIcon + '"> </a>'
                                + ' </div>'
                                + ' </div>'
                                + ' </div>'

                        }
                    });
                    if (hotelsArray.length < 12) {
                        $('.listing_pagination').hide();
                        $('#total_records').html('No Matches Found');
                    }
                    $('.hotelscard').html(hotelsArray);
                }
            });
        }

        function createPagination(total_page, current_page) {
            var prevLi = '<li class="prev ' + (current_page > 1 ? '' : 'disabled') + '"><a ' + (current_page > 1 ? 'data-page="' + (current_page - 1) + '"' : '') + ' class="paginiaton-link"><i class="fa fa-caret-left"></i></a></li>';
            var nextLi = '<li class="next ' + (current_page == total_page ? 'disabled' : '') + '"><a ' + (current_page == total_page ? '' : 'data-page="' + (Number(current_page) + 1) + '"') + ' class="paginiaton-link"><i class="fa fa-caret-right"></i></a></li>';
            var pageMore = '<li class="disabled"><span>...</span></li>';
            var bigCurrentPage = '';
            var pagesLi = '';
            var lastMorePages = '';
            var lastPages = '<li class="' + (current_page == total_page - 1 ? 'current' : '') + '"><a data-page="' + (total_page - 1) + '" class="paginiaton-link">' + (total_page - 1) + '</a></li>' +
                '<li class="' + (current_page == total_page ? 'current' : '') + '"><a data-page="' + total_page + '" class="paginiaton-link">' + total_page + '</a></li>';

            if (current_page > 4) {
                if (current_page < total_page - 1) {
                    pagesLi = '<li><a data-page="1" class="paginiaton-link">1</a></li>' +
                        '<li><a data-page="2" class="paginiaton-link">2</a></li>';
                    bigCurrentPage = '<li class="current"><a data-page="' + current_page + '" class="paginiaton-link">' + current_page + '</a></li>' + pageMore;
                } else {
                    pagesLi = '<li><a data-page="1" class="paginiaton-link">1</a></li>' +
                        '<li><a data-page="2" class="paginiaton-link">2</a></li>';

                    lastMorePages = '<li class="' + (current_page == total_page - 3 ? 'current' : '') + '"><a data-page="' + (total_page - 3) + '" class="paginiaton-link">' + (total_page - 3) + '</a></li>' +
                        '<li class="' + (current_page == total_page - 2 ? 'current' : '') + '"><a data-page="' + (total_page - 2) + '" class="paginiaton-link">' + (total_page - 2) + '</a></li>' +
                        '<li class="' + (current_page == total_page - 1 ? 'current' : '') + '"><a data-page="' + (total_page - 1) + '" class="paginiaton-link">' + (total_page - 1) + '</a></li>' +
                        '<li class="' + (current_page == total_page ? 'current' : '') + '"><a data-page="' + total_page + '" class="paginiaton-link">' + total_page + '</a></li>'

                    bigCurrentPage = '';
                    lastPages = '';

                }
            } else {
                for (var i = 1; i < total_page - 1; i++) {
                    if (i <= 4) {
                        pagesLi += '<li class="' + (i == current_page ? 'current' : '') + '"><a data-page="' + i + '" class="paginiaton-link">' + i + '</a></li>';
                    }
                }
            }
            var pagination = prevLi + pagesLi + pageMore + lastMorePages + bigCurrentPage + lastPages + nextLi;
            if (total_page < 5) {
                pagination = prevLi + pagesLi + lastPages + nextLi;
            }
            if (total_page == 1) {
                pagination = '';
            }
            $('.listing_pagination > ul').html(pagination);
            $('.listing_pagination > ul > li > a').click(function () {
                var page = $(this).data('page');
                localStorage.setItem('current_page', page);
                currentPage = page;
                getHotels();
            });
        }
    </script>
@endsection

