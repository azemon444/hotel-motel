@extends('layouts.app')
@section('title', 'Privacy Policy | Sardar Catering Amsterdam')
@section('description', 'How Sardar Catering collects, uses and protects your personal data when you book or contact us.')
@section('content')
<section class="page-header"><div class="container"><h1>Privacy Policy</h1><p>How we handle the personal data you share with us.</p></div></section>

<section class="section"><div class="container" style="max-width:760px;line-height:1.7">
    <h2 style="font-size:20px;margin-top:0">1. Data we collect</h2>
    <p>When you book or contact us we collect your name, email address, phone number, booking dates, suite type and any requests you send. Payment card details are handled directly by Stripe and are not stored on our servers.</p>

    <h2 style="font-size:20px">2. How we use it</h2>
    <p>We use your data to confirm and manage your booking, respond to enquiries and meet our legal and accounting obligations. We do not sell your data.</p>

    <h2 style="font-size:20px">3. Sharing</h2>
    <p>We share data only with service providers who help us operate: Stripe for payments and our hosting provider for the website. These providers process data on our instructions.</p>

    <h2 style="font-size:20px">4. Retention</h2>
    <p>Booking records are kept for as long as required by Dutch tax and accounting rules. Contact enquiries are kept only as long as needed to handle your request.</p>

    <h2 style="font-size:20px">5. Cookies</h2>
    <p>We use a session cookie to keep your booking form working and to secure the site. We do not use advertising cookies.</p>

    <h2 style="font-size:20px">6. Your rights</h2>
    <p>Under the GDPR you may request access to, correction of or deletion of your personal data, and you may object to certain processing. Contact us to exercise these rights.</p>

    <h2 style="font-size:20px">7. Contact</h2>
    <p>Email <a href="mailto:contact@bdgss.com">contact@bdgss.com</a> or call <a href="tel:+31686099826">+31 6 8609 9826</a>.</p>
    <p style="font-size:13px;color:var(--text-muted)">Last updated: {{ date('F Y') }}</p>
</div></section>
@endsection
