@php
    $page = config('site.page');
@endphp
<div class="deposite_sidebar">
    <h4>{{__('words.balance')}} (MYR)</h4>
    <ul>
        <li>{{__('words.total')}} <span>MYR <span class="monetary">{{$_user->score}}</span></span></li>
    </ul>
</div>
<div class="deposite_sidebar deposite_sidebar2">
    <ul>
        <li class="child @if($page == 'deposit') selected @endif"><a href="{{route('web.deposit')}}">{{__('words.deposit')}}</a></li>
        <li class="child @if($page == 'withdraw') selected @endif"><a href="{{route('web.withdraw')}}">{{__('words.withdraw')}}</a></li>
        <li class="child @if($page == 'transfer') selected @endif"><a href="{{route('web.transfer')}}">{{__('words.transfer')}}</a></li>
        <li class="child @if($page == 'bank_account') selected @endif"><a href="{{route('web.bank_account')}}">{{__('words.bank_account')}}</a></li>
    </ul>
</div>