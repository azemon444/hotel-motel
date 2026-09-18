@extends('layouts.app')
@section('title', 'Terms of Service | Sardar Catering Amsterdam')
@section('description', 'The terms that apply when you book and stay at Sardar Catering apartments in Amsterdam.')
@section('content')
<section class="page-header"><div class="container"><h1>Terms of Service</h1><p>These terms apply to every booking made through this website.</p></div></section>

<section class="section"><div class="container" style="max-width:760px;line-height:1.7">
    <h2 style="font-size:20px;margin-top:0">1. Bookings</h2>
    <p>A booking is confirmed once payment is received and you receive a confirmation reference. Rates are per suite per night in euros and include breakfast, VAT and the city tax shown at checkout.</p>

    <h2 style="font-size:20px">2. Payment</h2>
    <p>Card payments are processed by Stripe. We never store your full card number on our servers. The total shown on the payment page is the amount charged.</p>

    <h2 style="font-size:20px">3. Cancellation</h2>
    <p>Standard rates may be cancelled free of charge until 48 hours before check-in. Non-refundable rates are charged in full at the time of booking. See our <a href="{{ route('refund') }}">Refund Policy</a> for details.</p>

    <h2 style="font-size:20px">4. Arrival and departure</h2>
    <p>Check-in is from 15:00 and check-out is by 11:00. Early check-in and late check-out are subject to availability.</p>

    <h2 style="font-size:20px">5. Your stay</h2>
    <p>Please respect quiet hours and other guests. The number of guests must not exceed the number stated in your booking. Smoking is not permitted indoors. Damage caused during your stay may be charged.</p>

    <h2 style="font-size:20px">6. Liability</h2>
    <p>We take reasonable care of our premises and guests. We are not liable for indirect losses or for events outside our reasonable control. Nothing in these terms limits rights you have under Dutch law.</p>

    <h2 style="font-size:20px">7. Governing law</h2>
    <p>These terms are governed by the laws of the Netherlands. Disputes are subject to the competent court in Amsterdam.</p>

    <h2 style="font-size:20px">8. Contact</h2>
    <p>Questions? Email <a href="mailto:contact@bdgss.com">contact@bdgss.com</a> or call <a href="tel:+31686099826">+31 6 8609 9826</a>.</p>
    <p style="font-size:13px;color:var(--text-muted)">Last updated: {{ date('F Y') }}</p>
</div></section>
@endsection
