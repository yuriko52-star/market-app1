@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/success.css') }}">
@endsection
@section('content')
<div class="content">
    @php
        $status = request()->get('status');
         $payment_method = request()->get('payment_method');
    @endphp
    <h1>
        @if($payment_method === 'konbini' && $status ==='pending')
            支払い待ち
        @else
            決済成功！
        @endif
    </h1>
    @if($payment_method === 'konbini' && $status==='pending')
    <p>コンビニでのお支払いが完了すると、処理が完了します。</p>
    <p>お支払い完了後、しばらくするとご注文が確定します。</p>
    @else
    <p>ご購入ありがとうございました。</p>
    @endif


    <a href="/mypage" class="">マイページへ戻る</a>
</div>
@endsection
