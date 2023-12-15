@extends('front.layouts.master')@php
    $logged = \Illuminate\Support\Facades\Auth::check();
    if($logged){
        $user = \Illuminate\Support\Facades\Auth::user();
    }
    $app_locale = \Illuminate\Support\Facades\App::getLocale();
@endphp
@section('title') {{trans('txt.link_terms')}} @parent @endsection
@section('body')
    <div class="content-page  middle-wrapper">
        <div class="content-header">
            <div class="content-header-inner mg-section  mg-group">
                <div class="mg-col mg-span_12_of_12">
                    &nbsp;<h1>Terms and Conditions</h1>
                </div>
            </div>
        </div>
        <div class="content mg-section mg-group">
            <div class="mg-col mg-span_12_of_12">
                &nbsp;<h2>Terms and Conditions</h2>
                <p>Lorem ipsum dolor sit amet, mel erat munere eu, vis ei exerci equidem molestiae. Esse aperiam complectitur te quo, ne has intellegat temporibus, dolorem percipitur vel ex. No eos nominavi concludaturque. Case reque iracundia ne eum, dicat commune dissentias an sea, noster voluptaria percipitur sit ut. Autem intellegat pro ut, cu mei cetero eripuit fierent, eos id hinc purto soleat.</p>
                <p>In dicit homero sit, mea in vide voluptaria. Ei pri odio posidonium. Alii adhuc insolens ea eam, ne pro summo nominavi efficiendi. Mei facete conceptam mediocritatem id. Affert doming eam ut, doctus invidunt cu ius, an movet soluta vix. Ne ius malorum epicuri.</p>
                <p>Choro eirmod dissentiet ne vix, ius in unum tollit. Vix cu soleat deserunt, mea inani invenire scripserit ei. Ea vel virtute deleniti urbanitas, quaeque accusam in ius, referrentur suscipiantur ut eum. Illum detraxit assentior sit te. Usu affert indoctum id, at mel dolorum graecis. Quo in vidit intellegam reprehendunt, ad his facer possim dissentiet.</p>
                <p>At duo mediocrem voluptatum disputando, affert graeci aliquam at cum. No sit dico consequuntur, mei tation homero assentior eu. Ne his quodsi oportere liberavisse, eripuit deterruisset id mea. No per tollit habemus. Malorum prodesset mel no. Eum no diam aperiam. Deserunt suscipiantur nam ei, mel te solum menandri.</p>
                <p>Minim putant nec ne, pericula vituperata vis et. Salutatus theophrastus ea has, omnium accumsan an eum. At porro augue conceptam mea. Vis ei sumo legere omittantur, oblique alienum menandri ne quo.</p>
                <p>Utinam reprimique ut pro, vel in vitae primis adipisci. Error feugait ut qui, an mel timeam assueverit. At quo mutat elitr maluisset, mucius eripuit euripidis ad pro, ex mel eius voluptua. Modo scaevola ponderum eos ad. Est illum sonet semper ei, id vel graece splendide, quodsi audire an vis.</p>
                <p>Amet principes argumentum eos et, per tale alia dictas et. Ut sea facer salutatus temporibus, modo oblique iuvaret ei pri. Prodesset argumentum at mea, nec ea aperiam epicurei. Sit fierent copiosae te. An iriure molestiae constituam sit, per no prima maluisset contentiones.</p>
            </div>
        </div>
    </div>
@endsection
