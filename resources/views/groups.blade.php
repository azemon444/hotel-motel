@extends('layouts.app')
@section('title', 'Groups & Meetings | Sardar Catering Amsterdam')
@section('content')
<section class="page-header"><div class="container"><h1>Groups & Events</h1><p>A 41m² meeting room for up to 12 guests, group rates from 3+ suites, pantry catering, team activities and payment by invoice.</p><p style="font-size:11px;opacity:.7;margin-top:8px">Direct contact: +31 6 8609 9826 • contact@bdgss.com • We reply within 4 hours</p></div></section>
<section class="section"><div class="container">
    <div class="split-grid">
        <div class="split-content">
            <span class="section-badge">Meetings & Stays</span>
            <h2 class="section-title" style="text-align:left;">The Boardroom</h2>
            <p>One flexible meeting room with natural light, courtyard view, Wi-Fi, projector & flipchart. Ideal for workshops, offsites, project kick-offs & training. Same building as suites — walk to bed after work.</p>
            <div class="groups-gallery">
                <img src="https://images.unsplash.com/photo-1431540015161-0bf868a2d407?w=400&q=80" style="border-radius:8px;height:140px;object-fit:cover" alt="Boardroom"><img src="https://images.unsplash.com/photo-1522199710521-72d69614c702?w=400&q=80" style="border-radius:8px;height:140px;object-fit:cover" alt="Meeting2">
            </div>
            <ul class="check-list">
                <li><i class="fas fa-check"></i> 41m² • Boardroom 12 • Classroom 10 • Theatre 12 • U-shape 10</li>
                <li><i class="fas fa-check"></i> 85" 4K screen, click-share, flipchart, whiteboard included</li>
                <li><i class="fas fa-check"></i> Super-fast Wi-Fi 300M + wired • Print/scan at reception</li>
                <li><i class="fas fa-check"></i> Catering: breakfast included, lunch €22 p.p., coffee break €6, Social Hour free Mon/Wed/Thu</li>
                <li><i class="fas fa-check"></i> Group suites from €75/night (7+ nights) • Kitchenettes keep meal costs low</li>
            </ul>
            <div style="display:flex;gap:12px;margin-top:20px;flex-wrap:wrap"><a href="{{ route('contact') }}" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Request Group Quote in 4h</a><a href="tel:+31686099826" class="btn btn-outline"><i class="fas fa-phone"></i> Call Groups</a></div>
            <p style="font-size:11px;color:var(--text-muted);margin-top:8px"><i class="fas fa-info-circle"></i> Day hire €280 • Half day €170 • AV included • Parking €25/day</p>
        </div>
        <div class="split-image"><img src="https://images.unsplash.com/photo-1431540015161-0bf868a2d407?w=800&q=80" alt="Meeting"><div class="image-caption"><strong>The boardroom seats 12, with natural light, a courtyard view and day hire from €280.</strong></div></div>
    </div>

    <div class="groups-features">
        <div class="location-card" style="text-align:left;padding:20px"><i class="fas fa-users" style="color:var(--primary)"></i><h4 style="text-align:left">Group Stays 3+ Suites</h4><p style="text-align:left">Teams, relocations and family events can book 3 or more suites and save 12%, with invoicing and flexible cancellation. The two-bedroom suite sleeps up to 5, and every suite has a kitchenette, which keeps meal costs down.</p><a href="{{ route('contact') }}" style="color:var(--primary);font-weight:700;font-size:13px">Check group rate →</a></div>
        <div class="location-card" style="text-align:left;padding:20px"><i class="fas fa-utensils" style="color:var(--primary)"></i><h4 style="text-align:left">Catering & Coffee</h4><p style="text-align:left">Breakfast is included for all guests, coffee and tea are free all day, and Social Hour runs Mon/Wed/Thu 17-18h. The Pantry is open 24 hours, and lunch can be arranged on request.</p></div>
        <div class="location-card" style="text-align:left;padding:20px"><i class="fas fa-bicycle" style="color:var(--primary)"></i><h4 style="text-align:left">Team Activities</h4><p style="text-align:left">We can arrange a 2.5-hour Jordaan bike tour (€29 pp), a 1-hour canal cruise (€19), a Foodhallen tasting or museum tickets. Ask us for a package.</p><img src="https://images.unsplash.com/photo-1480714378408-67cf0d13bc1b?w=400&q=80" style="border-radius:8px;height:100px;object-fit:cover;width:100%;margin-top:8px" alt="Bike"></div>
    </div>

    <div class="groups-cta">
        <div>
            <h3 style="font-weight:700;margin-bottom:8px">Get group rate in 4 hours</h3>
            <p style="font-size:13px;color:var(--text-light)">Tell us your dates, how many suites you need and your meeting requirements. We'll reply within 4 hours during business hours with our best group price and invoice option.</p>
            <form class="contact-form groups-form" data-source="groups" style="margin-top:16px">
                <input type="text" name="firstName" placeholder="Company / Name" required style="padding:10px;border:1px solid var(--border);border-radius:8px">
                <input type="email" name="email" placeholder="Email" required style="padding:10px;border:1px solid var(--border);border-radius:8px">
                <input type="text" name="dates" placeholder="Dates (e.g. 12-19 Sep)" required style="padding:10px;border:1px solid var(--border);border-radius:8px">
                <select name="suites" style="padding:10px;border:1px solid var(--border);border-radius:8px"><option>3-5 suites</option><option>6-10 suites</option><option>10+ suites</option></select>
                <textarea name="message" placeholder="Meeting need? (e.g. 12 pax boardroom 2 days + lunch)" rows="2" style="grid-column:1/-1;padding:10px;border:1px solid var(--border);border-radius:8px"></textarea>
                <input type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true" style="position:absolute;left:-9999px;width:1px;height:1px;overflow:hidden">
                <button class="btn btn-primary" style="grid-column:1/-1">Send Request</button>
            </form>
        </div>
        <div><img src="https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=600&q=80" style="border-radius:12px;height:320px;object-fit:cover;width:100%" alt="Group Stay"><p style="font-size:11px;color:var(--text-muted);text-align:center;margin-top:8px">One building: sleep, meet, eat — all suites at the same address</p></div>
    </div>
</div></section>
@endsection
