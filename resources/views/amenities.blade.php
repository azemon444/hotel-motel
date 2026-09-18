@extends('layouts.app')
@section('title', 'Amenities & Services | Sardar Catering Amsterdam')
@section('content')
<section class="page-header" style="position:relative;overflow:hidden"><div style="position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=1600&q=80') center/cover;opacity:.18"></div><div class="container" style="position:relative"><h1>Amenities & Services</h1><p>Free breakfast, Social Hour, Pantry 24h, 24/7 fitness and laundry.</p><p style="font-size:11px;opacity:.7;margin-top:8px">Hours are shown in CET. Facilities are open daily unless noted.</p></div></section>

<section class="section"><div class="container">
    <div class="amenities-layout">
        <div>
            <h3 style="font-size:11px;font-weight:800;letter-spacing:1px;text-transform:uppercase;color:var(--primary);margin-bottom:12px"><i class="fas fa-utensils"></i> Eat & Drink</h3>
            <div class="grid grid-3" style="gap:16px">
                <div class="service-card"><div class="service-icon"><i class="fas fa-mug-hot"></i></div><h4>Free Breakfast Buffet</h4><p>A hot buffet with coffee and tea, included with every stay.</p><small style="font-weight:700;color:var(--primary)">Mon-Fri 6:30-10:00 • Sat-Sun 6:30-10:30 • Living Room</small><img src="https://images.unsplash.com/photo-1504754524776-8f4f37790ca0?w=400&q=80" style="border-radius:8px;margin-top:12px;height:120px;object-fit:cover;width:100%" alt="Breakfast"></div>
                <div class="service-card" style="border:2px solid var(--primary)"><div class="service-icon" style="background:var(--primary);color:white"><i class="fas fa-glass-cheers"></i></div><h4>Social Hour — On Us</h4><p>Complimentary appetizers and drinks, a chance to meet other guests mid-week.</p><small style="font-weight:700;color:var(--accent)">Mon, Wed, Thu 17:00-18:00 • Free</small><img src="https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?w=400&q=80" style="border-radius:8px;margin-top:12px;height:120px;object-fit:cover;width:100%" alt="Social"></div>
                <div class="service-card"><div class="service-icon"><i class="fas fa-shopping-basket"></i></div><h4>The Pantry 24h</h4><p>Groceries, snacks and microwave meals, day and night. Swipe your room key to enter.</p><small>24 Hours • Lobby</small><img src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=400&q=80" style="border-radius:8px;margin-top:12px;height:120px;object-fit:cover;width:100%" alt="Pantry"></div>
            </div>
            <h3 style="font-size:11px;font-weight:800;letter-spacing:1px;text-transform:uppercase;color:var(--primary);margin:32px 0 12px"><i class="fas fa-bed"></i> Stay & Comfort</h3>
            <div class="grid grid-3" style="gap:16px">
                <div class="service-card"><div class="service-icon"><i class="fas fa-utensils"></i></div><h4>Kitchenette in Every Suite</h4><p>Full fridge/freezer, two-burner stovetop, microwave, cookware, dining for 2-5.</p><img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=400&q=80" style="border-radius:8px;margin-top:12px;height:120px;object-fit:cover;width:100%" alt="Kitchen"></div>
                <div class="service-card"><div class="service-icon"><i class="fas fa-tshirt"></i></div><h4>Free Laundry 24/7</h4><p>Free self-service laundry, daily light touch-ups and a weekly full service with linen change.</p><small>12:00 AM - 11:59 PM • Free detergent</small><img src="https://images.unsplash.com/photo-1566665797739-1674de7a421a?w=400&q=80" style="border-radius:8px;margin-top:12px;height:120px;object-fit:cover;width:100%" alt="Laundry"></div>
                <div class="service-card"><div class="service-icon"><i class="fas fa-wifi"></i></div><h4>High-Speed Wi-Fi Free</h4><p>300 Mbps throughout the hotel and suites, for streaming and work.</p><small>Free • No code</small></div>
                <div class="service-card"><div class="service-icon"><i class="fas fa-parking"></i></div><h4>On-site Parking</h4><p>Covered self-parking, €25 per day, with 2 accessible spaces. Reserve in advance.</p><small>€25/day • Book ahead</small></div>
                <div class="service-card"><div class="service-icon"><i class="fas fa-bath"></i></div><h4>Bath & Comfort</h4><p>Walk-in shower or bath/shower combo, luxury linens, blackout curtains, safe, iron.</p></div>
                <div class="service-card"><div class="service-icon"><i class="fas fa-snowflake"></i></div><h4>Climate & Work</h4><p>A/C & heating, workspace desk, 43" TV, USB charging, blackout + soundproof.</p></div>
            </div>
            <h3 style="font-size:11px;font-weight:800;letter-spacing:1px;text-transform:uppercase;color:var(--primary);margin:32px 0 12px"><i class="fas fa-dumbbell"></i> Relax & Move</h3>
            <div class="grid grid-3" style="gap:16px">
                <div class="service-card"><div class="service-icon"><i class="fas fa-dumbbell"></i></div><h4>24/7 Fitness Center</h4><p>Treadmills, cross trainers, bikes, free weights, mats, multi-gym.</p><small>00:00-23:59 daily</small><img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=400&q=80" style="border-radius:8px;margin-top:12px;height:120px;object-fit:cover;width:100%" alt="Fitness"></div>
                <div class="service-card"><div class="service-icon"><i class="fas fa-bicycle"></i></div><h4>Bike Hire & Trails</h4><p>Bicycles at reception, hiking/biking trails nearby. Helmets available.</p></div>
                <div class="service-card"><div class="service-icon"><i class="fas fa-concierge-bell"></i></div><h4>Living Room Courtyard</h4><p>A bright courtyard lobby to work, relax and connect, with free tea and coffee all day.</p><img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400&q=80" style="border-radius:8px;margin-top:12px;height:120px;object-fit:cover;width:100%" alt="Lobby"></div>
                <div class="service-card"><div class="service-icon"><i class="fas fa-print"></i></div><h4>Business Corner</h4><p>Printing, scanning, copying at reception + meeting room 12 pax 41m².</p></div>
                <div class="service-card"><div class="service-icon"><i class="fas fa-store"></i></div><h4>Grocery Nearby</h4><p>Albert Heijn is a 3-minute walk and Foodhallen is 5 minutes away; The Pantry saves you the trip.</p></div>
                <div class="service-card"><div class="service-icon"><i class="fas fa-paw"></i></div><h4>Pet Friendly on Request</h4><p>Small pets are allowed on request for €15 per night; advance notice required.</p></div>
            </div>
        </div>
        <div style="position:sticky;top:90px;display:flex;flex-direction:column;gap:16px">
            <div style="background:white;border:1px solid var(--border);border-radius:12px;padding:20px">
                <h4 style="font-weight:700;margin-bottom:12px"><i class="fas fa-clock"></i> Hours at a Glance</h4>
                <table style="width:100%;font-size:13px;border-collapse:collapse"><tr><td style="padding:8px 0;border-bottom:1px solid var(--border)">Breakfast Mon-Fri</td><td style="text-align:right;font-weight:700">06:30-10:00</td></tr><tr><td style="padding:8px 0;border-bottom:1px solid var(--border)">Breakfast Sat-Sun</td><td style="text-align:right;font-weight:700">06:30-10:30</td></tr><tr><td style="padding:8px 0;border-bottom:1px solid var(--border)">Social Hour</td><td style="text-align:right;font-weight:700">Mon/Wed/Thu 17-18</td></tr><tr><td style="padding:8px 0;border-bottom:1px solid var(--border)">Pantry</td><td style="text-align:right;font-weight:700">24h</td></tr><tr><td style="padding:8px 0;border-bottom:1px solid var(--border)">Laundry</td><td style="text-align:right;font-weight:700">00-23:59</td></tr><tr><td style="padding:8px 0">Fitness</td><td style="text-align:right;font-weight:700">24h</td></tr></table>
                <a href="{{ route('booking') }}" class="btn btn-primary btn-block" style="margin-top:16px">Check Rates from €89</a>
            </div>
            <div style="background:rgba(26,54,93,.06);border:1px solid rgba(26,54,93,.12);border-radius:12px;padding:20px">
                <h4 style="font-weight:700;margin-bottom:8px"><i class="fas fa-universal-access"></i> Accessibility</h4>
                <ul style="font-size:13px;color:var(--text-light);line-height:1.8">
                    <li>Wheelchair accessible rooms • Lift to all floors</li>
                    <li>Accessible bathrooms: grab bars, roll-in showers, handheld hose, emergency cord, tall toilet, transfer seat</li>
                    <li>Public restrooms accessible • Reception desk 112cm • Elevator door 90cm</li>
                    <li>2 accessible parking spaces</li>
                </ul>
            </div>
            <div style="background:white;border:1px solid var(--border);border-radius:12px;overflow:hidden"><img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&q=80" style="height:160px;object-fit:cover;width:100%" alt="View"><div style="padding:16px"><h4 style="font-weight:700">Need help?</h4><p style="font-size:13px;color:var(--text-light)">Ask reception for bike rental, museum tickets, or group catering.</p><a href="tel:+31686099826" class="btn btn-outline btn-sm" style="margin-top:8px"><i class="fas fa-phone"></i> Call Reception</a></div></div>
        </div>
    </div>
</div></section>

    <section class="section section-alt"><div class="container" style="text-align:center"><h3 style="font-weight:700;margin-bottom:8px">Included in every stay</h3><p style="color:var(--text-light);font-size:14px">Free breakfast, Wi-Fi, laundry, fitness, Pantry access, Social Hour and weekly housekeeping.</p><a href="{{ route('booking') }}" class="btn btn-primary btn-lg" style="margin-top:16px">View Availability</a></div></section>
@endsection
