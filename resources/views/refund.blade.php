@extends('layouts.app')
@section('title', 'Refund Policy | Sardar Catering Amsterdam')
@section('description', 'Cancellation windows and refund rules for bookings at Sardar Catering in Amsterdam.')
@section('content')
<section class="page-header"><div class="container"><h1>Refund Policy</h1><p>How cancellations and refunds work for our rates.</p></div></section>

<section class="section"><div class="container" style="max-width:760px;line-height:1.7">
    <h2 style="font-size:20px;margin-top:0">Standard rate</h2>
    <p>Cancellations made at least 48 hours before check-in are refunded in full. Cancellations inside 48 hours are charged for the first night.</p>

    <h2 style="font-size:20px">Non-refundable rate</h2>
    <p>Non-refundable bookings are charged in full at the time of booking and cannot be refunded, including for early departure or no-show.</p>

    <h2 style="font-size:20px">How refunds are paid</h2>
    <p>Approved refunds are returned to the original card through Stripe. Depending on your bank, it can take 5 to 10 business days for the amount to appear.</p>

    <h2 style="font-size:20px">Changes</h2>
    <p>Date changes are treated as a new booking and are subject to availability and the rate at the time of the change.</p>

    <h2 style="font-size:20px">Exceptional circumstances</h2>
    <p>If a stay cannot go ahead for reasons on our side, we will offer an alternative or a full refund. Travel disruptions outside our control are handled under the terms of your rate.</p>

    <h2 style="font-size:20px">How to request</h2>
    <p>Email <a href="mailto:contact@bdgss.com">contact@bdgss.com</a> with your booking reference, or call <a href="tel:+31686099826">+31 6 8609 9826</a>.</p>
    <p style="font-size:13px;color:var(--text-muted)">Last updated: {{ date('F Y') }}</p>
</div></section>
@endsection
