

<p>{{ $purchase->buyer->name }}さんが取引を完了しました。</p>
<p>商品名：{{ $purchase->item->name}}</p>
<p>マイページにログインして購入者の評価をしてください。</p>
<a href="{{ url('/chat/'.$purchase->id) }}}"  style="display:inline-block;padding:10px 20px;background:#4CAF50;color:#fff;text-decoration:none;"class="">評価する</a>

