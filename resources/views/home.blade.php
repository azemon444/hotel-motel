@extends('layouts.app')
@section('title', 'Sardar Catering Amsterdam | Extended-Stay Suites')
@section('content')
<!-- Hero -->
<section class="hero hero-longstay" id="overview">
    <div class="swiper hero-swiper" id="heroSwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><div class="hero-bg" style="background-image: url('https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=1920&q=80')"></div></div>
            <div class="swiper-slide"><div class="hero-bg" style="background-image: url('https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1920&q=80')"></div></div>
            <div class="swiper-slide"><div class="hero-bg" style="background-image: url('https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=1920&q=80')"></div></div>
            <div class="swiper-slide"><div class="hero-bg" style="background-image: url('https://images.unsplash.com/photo-1590490360182-c33d57733427?w=1920&q=80')"></div></div>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
        <div class="hero-overlay"></div>
        <div class="container" style="position:absolute;inset:0;display:flex;align-items:center;z-index:2;pointer-events:none">
            <div class="hero-content" style="pointer-events:auto">
                <span class="hero-eyebrow">Amsterdam West</span>
                <h1 class="hero-title">Longer-stay Suites<br>in the heart of Amsterdam</h1>
                <p class="hero-desc">A short walk from Vondelpark and the city centre, our 101 suites have fully equipped kitchenettes, free Wi-Fi and breakfast, and everything you need to settle in for a week or a month.</p>
                <div class="hero-buttons">
                    <a href="{{ route('booking') }}" class="btn btn-primary btn-lg"><i class="fas fa-calendar-check"></i> View Rates & Availability</a>
                    <a href="{{ route('suites') }}" class="btn btn-outline-white btn-lg">Explore Suites <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="hero-trust">
                    <span><i class="fas fa-utensils"></i> Kitchenette in every suite</span>
                    <span><i class="fas fa-mug-hot"></i> Breakfast included</span>
                    <span><i class="fas fa-shield-alt"></i> Free cancellation 48h</span>
                    <span><i class="fas fa-wifi"></i> Free Wi-Fi 300 Mbps</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Availability search bar -->
<section class="search-bar" id="searchBar">
    <div class="container">
        <form class="search-form" id="searchForm">
            <div class="search-field">
                <label><i class="far fa-calendar"></i> Check-in</label>
                <input type="text" id="searchCheckin" placeholder="Add date" readonly>
            </div>
            <div class="search-field">
                <label><i class="far fa-calendar"></i> Check-out</label>
                <input type="text" id="searchCheckout" placeholder="Add date" readonly>
            </div>
            <div class="search-field">
                <label><i class="fas fa-user"></i> Guests & Rooms</label>
                <div class="guest-stepper">
                    <button type="button" onclick="stepGuests(-1)"><i class="fas fa-minus"></i></button>
                    <span id="searchGuests">2 Guests, 1 Room</span>
                    <button type="button" onclick="stepGuests(1)"><i class="fas fa-plus"></i></button>
                </div>
                <input type="hidden" id="searchGuestsVal" value="2">
                <input type="hidden" id="searchRoomsVal" value="1">
            </div>
            <div class="search-field">
                <label><i class="fas fa-tag"></i> Promo Code</label>
                <input type="text" id="promoCode" placeholder="Optional">
            </div>
            <button type="submit" class="btn btn-primary btn-search">View Prices <i class="fas fa-arrow-right"></i></button>
        </form>
        <p style="text-align:center;font-size:11px;color:var(--text-muted);margin-top:10px;">Book direct for our best available rate. No booking fee. <a href="{{ route('offers') }}" style="color:var(--primary);font-weight:700">See offers →</a></p>
    </div>
</section>

<!-- Trust + Ratings Bar -->
<section style="background:#f8fafc;border-bottom:1px solid var(--border);padding:14px 0;">
    <div class="container" style="display:flex;gap:24px;justify-content:center;flex-wrap:wrap;font-size:12px;font-weight:600;color:var(--text-light)">
        <span><i class="fas fa-check-circle" style="color:var(--success)"></i> Free breakfast 6:30-10:30</span>
        <span><i class="fas fa-check-circle" style="color:var(--success)"></i> Kitchenette in every suite</span>
        <span><i class="fas fa-check-circle" style="color:var(--success)"></i> 24/7 fitness & laundry free</span>
        <span><i class="fas fa-check-circle" style="color:var(--success)"></i> Social Hour Mon/Wed/Thu</span>
        <span><i class="fas fa-check-circle" style="color:var(--success)"></i> The Pantry 24h</span>
    </div>
</section>

<!-- Amenities Icon Bar - 8 icons -->
<section class="amenities-bar" id="amenities">
    <div class="container">
        <div class="amenities-bar-grid">
            <div class="amenity-item"><i class="fas fa-parking"></i><span>On-site<br>Parking €25</span></div>
            <div class="amenity-item"><i class="fas fa-dumbbell"></i><span>24/7<br>Fitness</span></div>
            <div class="amenity-item"><i class="fas fa-wifi"></i><span>Free<br>Wi-Fi 300M</span></div>
            <div class="amenity-item"><i class="fas fa-utensils"></i><span>Kitchenette<br>in Suite</span></div>
            <div class="amenity-item"><i class="fas fa-coffee"></i><span>Free<br>Breakfast</span></div>
            <div class="amenity-item"><i class="fas fa-tshirt"></i><span>Free<br>Laundry</span></div>
            <div class="amenity-item"><i class="fas fa-bicycle"></i><span>Bike<br>Hire</span></div>
            <div class="amenity-item"><i class="fas fa-concierge-bell"></i><span>24h<br>Reception</span></div>
        </div>
        <div style="text-align:center; margin-top:18px;display:flex;gap:12px;justify-content:center">
            <a href="{{ route('amenities') }}" class="btn btn-outline btn-sm">View all amenities <i class="fas fa-chevron-right"></i></a>
            <a href="{{ route('photos') }}" class="btn btn-sm" style="background:white;border:1px solid var(--border)">View photos <i class="fas fa-camera"></i></a>
        </div>
    </div>
</section>

<!-- Ideal for Long Stays -->
<section class="section" id="suites">
    <div class="container">
        <div class="split-grid">
            <div class="split-content">
                <span class="section-badge">Feel at Home</span>
                <h2 class="section-title" style="text-align:left;">Ideal for long stays</h2>
                <p>Whether you're relocating or on holiday, each suite has a kitchenette and a separate living area, so you can settle in rather than just check in. Free high-speed Wi-Fi, a hot breakfast buffet each morning and free tea and coffee all day in the Living Room courtyard.</p>
                <p>Every suite has a kitchenette with a full fridge-freezer, stovetop and microwave, plus The Pantry for essentials around the clock.</p>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin:20px 0;">
                    <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=400&q=80" style="border-radius:12px;height:140px;object-fit:cover" alt="Kitchen">
                    <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=400&q=80" style="border-radius:12px;height:140px;object-fit:cover" alt="Living">
                </div>
                <ul class="check-list">
                    <li><i class="fas fa-check"></i> Spacious suites with separate living areas & workspace</li>
                    <li><i class="fas fa-check"></i> Free laundry & weekly housekeeping + linen change</li>
                    <li><i class="fas fa-check"></i> Social Hour – complimentary drinks & bites Mon/Wed/Thu 17-18h</li>
                </ul>
                <a href="{{ route('amenities') }}" class="btn btn-outline" style="margin-top:20px;">Explore Amenities</a>
            </div>
            <div class="split-image">
                <div class="swiper" style="height:420px;border-radius:12px;overflow:hidden">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=80" style="height:420px;width:100%;object-fit:cover" alt="Living Room"></div>
                        <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1582719508461-905c673771fd?w=800&q=80" style="height:420px;width:100%;object-fit:cover" alt="Lobby"></div>
                        <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1504754524776-8f4f37790ca0?w=800&q=80" style="height:420px;width:100%;object-fit:cover" alt="Breakfast"></div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <div class="image-caption"><strong>The Living Room</strong> – a bright courtyard lobby to work, relax and connect, with free coffee all day</div>
            </div>
        </div>
    </div>
</section>

<!-- Suites Teaser -->
<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <span class="section-badge">Our Suites</span>
            <h2 class="section-title">Designed for everyday living</h2>
            <p class="section-desc">Whether you're relocating or on holiday, kitchenettes and living areas help you live, not just stay. <a href="{{ route('suites') }}" style="color:var(--primary);font-weight:700">View all suites & compare →</a></p>
        </div>
        <div class="grid grid-3">
            <div class="card suite-card">
                <div class="card-image">
                    <div class="swiper suite-swiper"><div class="swiper-wrapper"><div class="swiper-slide"><img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=600&q=80" alt="Studio"></div><div class="swiper-slide"><img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=600&q=80" alt="Studio Kitchen"></div></div><div class="swiper-pagination"></div></div>
                    <span class="card-badge">Studio • 28m² • 2 Guests</span>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Studio Suite</h3>
                    <p class="card-desc">Open-plan with queen bed, workspace & kitchenette (fridge/freezer, stovetop, microwave).</p>
                    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px"><span style="background:var(--bg-alt);padding:4px 8px;border-radius:12px;font-size:11px;font-weight:600">Kitchenette</span><span style="background:var(--bg-alt);padding:4px 8px;border-radius:12px;font-size:11px;font-weight:600">Workspace</span><span style="background:var(--bg-alt);padding:4px 8px;border-radius:12px;font-size:11px;font-weight:600">Flat TV 43"</span></div>
                    <div class="card-footer"><div class="price"><span class="price-from">From</span> <span class="price-amount">&euro;89</span><span class="price-per">/night</span></div><a href="{{ route('suites') }}" class="btn btn-sm btn-primary">Details & Photos</a></div>
                </div>
            </div>
            <div class="card suite-card featured" style="border:2px solid var(--accent)">
                <div class="card-image">
                    <div class="swiper suite-swiper"><div class="swiper-wrapper"><div class="swiper-slide"><img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?w=600&q=80" alt="One Bedroom"></div><div class="swiper-slide"><img src="https://images.unsplash.com/photo-1502672023488-70e25813eb80?w=600&q=80" alt="Living"></div><div class="swiper-slide"><img src="https://images.unsplash.com/photo-1486304873000-235643847519?w=600&q=80" alt="Dining"></div></div><div class="swiper-pagination"></div></div>
                    <span class="card-badge badge-popular">Most Popular • 38m²</span>
                </div>
                <div class="card-body">
                    <h3 class="card-title">One-Bedroom Suite</h3>
                    <p class="card-desc">Separate bedroom, living with sofa bed, dining & full kitchenette. For extended stays.</p>
                    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px"><span style="background:rgba(229,62,62,.1);padding:4px 8px;border-radius:12px;font-size:11px;font-weight:700;color:var(--accent)">Separate Bedroom</span><span style="background:var(--bg-alt);padding:4px 8px;border-radius:12px;font-size:11px;font-weight:600">Sofa bed</span><span style="background:var(--bg-alt);padding:4px 8px;border-radius:12px;font-size:11px;font-weight:600">Kitchen</span></div>
                    <div class="card-footer"><div class="price"><span class="price-from">From</span> <span class="price-amount">&euro;119</span><span class="price-per">/night</span></div><a href="{{ route('suites') }}" class="btn btn-sm btn-primary">Details & Photos</a></div>
                </div>
            </div>
            <div class="card suite-card">
                <div class="card-image">
                    <div class="swiper suite-swiper"><div class="swiper-wrapper"><div class="swiper-slide"><img src="https://images.unsplash.com/photo-1564078516393-cf04bd966897?w=600&q=80" alt="Two Bedroom"></div><div class="swiper-slide"><img src="https://images.unsplash.com/photo-1519710164239-da123dc03ef4?w=600&q=80" alt="Bedroom2"></div></div><div class="swiper-pagination"></div></div>
                    <span class="card-badge badge-group">Family • 52m² • 5 Guests</span>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Two-Bedroom Suite</h3>
                    <p class="card-desc">Two bedrooms, living room, kitchenette & 2 bathrooms. For families & groups.</p>
                    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px"><span style="background:var(--bg-alt);padding:4px 8px;border-radius:12px;font-size:11px;font-weight:600">2 Bedrooms</span><span style="background:var(--bg-alt);padding:4px 8px;border-radius:12px;font-size:11px;font-weight:600">2 Baths</span><span style="background:var(--bg-alt);padding:4px 8px;border-radius:12px;font-size:11px;font-weight:600">Living 22m²</span></div>
                    <div class="card-footer"><div class="price"><span class="price-from">From</span> <span class="price-amount">&euro;159</span><span class="price-per">/night</span></div><a href="{{ route('suites') }}" class="btn btn-sm btn-primary">Details & Photos</a></div>
                </div>
            </div>
        </div>
        <div style="text-align:center; margin-top:28px;"><a href="{{ route('suites') }}" class="btn btn-primary btn-lg">View All Suites</a></div>
    </div>
</section>

<!-- Offers -->
<section class="section" id="offers">
    <div class="container">
        <div class="section-header"><span class="section-badge">Offers & Packages</span><h2 class="section-title">Stay longer, save more</h2></div>
        <div class="grid grid-3">
            <div class="offer-card" style="position:relative;overflow:hidden"><img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=400&q=80" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:.08" alt=""><div style="position:relative"><div class="offer-icon"><i class="fas fa-mug-hot"></i></div><h4>Free Breakfast Included</h4><p>Hot & healthy buffet daily, included in every stay. No extra cost.</p><span class="offer-time">6:30-10:00 Mon-Fri • 6:30-10:30 Sat-Sun • Living Room</span><a href="{{ route('offers') }}" class="btn btn-outline btn-sm" style="margin-top:12px">See Offer</a></div></div>
            <div class="offer-card highlight" style="position:relative;overflow:hidden"><img src="https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?w=400&q=80" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:.06" alt=""><div style="position:relative"><div class="offer-icon" style="background:var(--accent);color:white"><i class="fas fa-glass-cheers"></i></div><h4>Social Hour — On Us</h4><p>Complimentary appetizers & drinks. Meet fellow travelers mid-week.</p><span class="offer-time">Mon, Wed, Thu 17:00-18:00 • Free</span><a href="{{ route('offers') }}" class="btn btn-primary btn-sm" style="margin-top:12px">Join Us</a></div></div>
            <div class="offer-card" style="position:relative;overflow:hidden"><img src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=400&q=80" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:.08" alt=""><div style="position:relative"><div class="offer-icon"><i class="fas fa-percentage"></i></div><h4>Extended Stay 15% Off</h4><p>Stay 7+ nights & save 15%. Free laundry + late check-out.</p><span class="offer-time">7+ nights • Save €120 avg</span><a href="{{ route('offers') }}" class="btn btn-outline btn-sm" style="margin-top:12px">Claim Offer</a></div></div>
        </div>
        <div class="grid grid-3" style="margin-top:16px">
            <div class="offer-card"><div class="offer-icon"><i class="fas fa-shopping-basket"></i></div><h4>The Pantry 24h</h4><p>Groceries, snacks & essentials without leaving the hotel.</p><span class="offer-time">Lobby • Swipe room key</span></div>
            <div class="offer-card"><div class="offer-icon"><i class="fas fa-parking"></i></div><h4>Parking €25/day</h4><p>Covered on-site, 2 accessible spaces. Reserve in advance.</p><span class="offer-time">Limited • Reserve</span></div>
            <div class="offer-card"><div class="offer-icon"><i class="fas fa-users"></i></div><h4>Group 3+ Suites</h4><p>Teams & families — kitchenettes keep costs low.</p><span class="offer-time">Contact for quote</span></div>
        </div>
    </div>
</section>

<!-- Local Area -->
<section class="section section-alt" id="local">
    <div class="container">
        <div class="section-header"><span class="section-badge">Local Area</span><h2 class="section-title">Explore Amsterdam like a local</h2><p class="section-desc">Vondelpark is an 8-minute walk, the canals are 12 minutes by bike and Central Station is 10 minutes by tram.</p></div>
        <div class="split-grid reverse">
            <div class="split-image">
                <div class="swiper" style="height:420px;border-radius:12px;overflow:hidden"><div class="swiper-wrapper"><div class="swiper-slide"><img src="https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=800&q=80" style="height:420px;width:100%;object-fit:cover" alt="Canals"></div><div class="swiper-slide"><img src="https://images.unsplash.com/photo-1538688525198-9b88f6f53126?w=800&q=80" style="height:420px;width:100%;object-fit:cover" alt="Vondelpark"></div><div class="swiper-slide"><img src="https://images.unsplash.com/photo-1494526585095-c41746248156?w=800&q=80" style="height:420px;width:100%;object-fit:cover" alt="Jordaan"></div></div><div class="swiper-pagination"></div></div>
            </div>
            <div class="split-content">
                <h3>Heart of city, home for longer</h3>
                <p>Quiet residential streets but central. Cycle to Jordaan, walk to Foodhallen, tram to Museumplein.</p>
                <div class="local-list">
                    <div class="local-item"><i class="fas fa-tree"></i><div><strong>Vondelpark</strong><span>8 min walk • cycling, cafes, theatre</span><small style="color:var(--success)">★ Must see</small></div></div>
                    <div class="local-item"><i class="fas fa-landmark"></i><div><strong>Museumplein</strong><span>Rijksmuseum, Van Gogh — 15 min tram 1</span></div></div>
                    <div class="local-item"><i class="fas fa-water"></i><div><strong>Canal Ring UNESCO</strong><span>12 min cycle • Jordaan & 9 Streets</span></div></div>
                    <div class="local-item"><i class="fas fa-train"></i><div><strong>Central Station</strong><span>10 min tram • 15 min cycle</span></div></div>
                    <div class="local-item"><i class="fas fa-plane"></i><div><strong>Schiphol</strong><span>20 min from Sloterdijk • Direct sprinter</span></div></div>
                    <div class="local-item"><i class="fas fa-shopping-bag"></i><div><strong>Foodhallen Oud-West</strong><span>5 min walk • Food hall & bars</span></div></div>
                </div>
                <a href="{{ route('local-area') }}" class="btn btn-outline" style="margin-top:20px;"><i class="fas fa-map-marker-alt"></i> Open Map & Distances</a>
            </div>
        </div>
    </div>
</section>

<!-- Gallery teaser -->
<section class="section" id="photos">
    <div class="container">
        <div class="section-header"><span class="section-badge">Gallery</span><h2 class="section-title">Take a look inside</h2><p class="section-desc">Tap any image to view it full size. <a href="{{ route('photos') }}" style="color:var(--primary);font-weight:700">View all →</a></p></div>
        <div class="gallery-grid" id="homeGallery">
            <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=400&q=80" alt="Exterior" data-idx="0">
            <img src="https://images.unsplash.com/photo-1582719508461-905c673771fd?w=400&q=80" alt="Suite" data-idx="1">
            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400&q=80" alt="Kitchenette" data-idx="2">
            <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?w=400&q=80" alt="Bedroom" data-idx="3">
            <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=400&q=80" alt="Kitchen" data-idx="4">
            <img src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=400&q=80" alt="Living" data-idx="5">
            <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=400&q=80" alt="Fitness" data-idx="6">
            <img src="https://images.unsplash.com/photo-1502672023488-70e25813eb80?w=400&q=80" alt="Suite2" data-idx="7">
        </div>
        <div style="text-align:center;margin-top:20px"><a href="{{ route('photos') }}" class="btn btn-primary">View all photos <i class="fas fa-images"></i></a></div>
    </div>
</section>
<div class="lightbox" id="lightbox"><button class="lightbox-close" onclick="closeLightbox()" aria-label="Close"><i class="fas fa-times"></i></button><button class="lightbox-prev" onclick="navLightbox(-1)"><i class="fas fa-chevron-left"></i></button><img id="lbImg" alt=""><button class="lightbox-next" onclick="navLightbox(1)"><i class="fas fa-chevron-right"></i></button><div class="lightbox-counter" id="lbCounter"></div></div>

<!-- Why stay longer -->
<section class="section section-alt" id="why">
    <div class="container">
        <div class="section-header"><span class="section-badge">Why Stay Longer</span><h2 class="section-title">Designed for the long stay</h2><p class="section-desc">Everything below is included with your booking.</p></div>
        <div class="grid grid-3">
            <div class="offer-card"><div class="offer-icon"><i class="fas fa-utensils"></i></div><h4>Cook your own meals</h4><p>A kitchenette with a full fridge-freezer, stovetop and microwave in every suite.</p></div>
            <div class="offer-card"><div class="offer-icon"><i class="fas fa-tshirt"></i></div><h4>Free laundry</h4><p>Self-service laundry open around the clock, plus weekly housekeeping and linen change.</p></div>
            <div class="offer-card"><div class="offer-icon"><i class="fas fa-dumbbell"></i></div><h4>Stay in your routine</h4><p>A 24/7 fitness room, fast Wi-Fi and a workspace in every suite.</p></div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="section" id="faq">
    <div class="container" style="max-width:900px">
        <div class="section-header"><span class="section-badge">FAQ</span><h2 class="section-title">Before you book</h2></div>
        <div class="faq-list" id="faqList">
            @foreach([['How much is parking?','Self-parking €25/day, covered, 2 accessible spaces. Reserve ahead — limited. No shuttle.'],['Can I cancel for full refund?','Standard rate free cancel until 48h before check-in. Check your rate conditions. Non-refundable saves 20% but prepay.'],['Is breakfast free? When?','Free with every stay: 6:30-10:00 Mon-Fri, 6:30-10:30 Sat-Sun in Living Room. Hot & healthy.'],['Is there a shuttle?','No. Central Station 10 min by tram, Schiphol 20 min by train via Sloterdijk.'],['Check-in / out?','Check-in 15:00, check-out 11:00. Early/late on request subject to availability.'],['Laundry & fitness?','Free self-laundry 12AM-11:59PM daily. Fitness 24/7 cardio, weights, mats, multi-gym.'],['Accessible rooms?','Yes — wheelchair accessible, lift to all floors, grab bars, roll-in showers, handheld hose, emergency cord.'],['Grocery?','The Pantry 24h on-site + free tea/coffee all day. Albert Heijn 3 min walk.']] as $f)
            <div class="faq-item" style="cursor:pointer" onclick="this.classList.toggle('open')"><h4 style="display:flex;justify-content:space-between;align-items:center">{{ $f[0] }} <i class="fas fa-chevron-down" style="font-size:11px;opacity:.5"></i></h4><p style="margin-top:8px">{{ $f[1] }}</p></div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="container">
        <h2>Ready to feel at home?</h2>
        <p>Check availability — best rate when you book direct. Pay at hotel or prepay & save.</p>
        <div class="cta-buttons">
            <a href="{{ route('booking') }}" class="btn btn-white btn-lg"><i class="fas fa-calendar-check"></i> Check Availability from €89</a>
            <a href="tel:+31686099826" class="btn btn-outline-white btn-lg"><i class="fas fa-phone"></i> +31 6 8609 9826</a>
        </div>
        <p style="font-size:12px;opacity:.7;margin-top:16px">A kitchenette in every suite, free laundry, and free cancellation up to 48 hours on flexible rates.</p>
    </div>
</section>
@endsection

@push('scripts')
<script>
let guests=2, rooms=1;
function stepGuests(d){ guests=Math.max(1,Math.min(8,guests+d)); document.getElementById('searchGuests').textContent=guests+' Guests, '+rooms+' Room'+(rooms>1?'s':''); document.getElementById('searchGuestsVal').value=guests; }
const ci=document.getElementById('searchCheckin'), co=document.getElementById('searchCheckout');
if(ci&&co&&window.flatpickr){ const t=new Date(); t.setDate(t.getDate()+1); const a=new Date(); a.setDate(a.getDate()+2); flatpickr(ci,{minDate:'today',defaultDate:'today',dateFormat:'Y-m-d',onChange:(d)=>{ if(d[0]) co._flatpickr.set('minDate', new Date(d[0].getTime()+86400000)); }}); flatpickr(co,{minDate:t,defaultDate:a,dateFormat:'Y-m-d'}); }
document.getElementById('searchForm')?.addEventListener('submit', e=>{ e.preventDefault(); const checkin=ci.value, checkout=co.value; if(!checkin||!checkout){ alert('Select check-in & check-out'); return; } const promo=document.getElementById('promoCode').value; sessionStorage.setItem('searchDates', JSON.stringify({checkin, checkout, guests, rooms, promo})); window.location.href="{{ route('booking') }}"; });
// Sub-nav spy
const subNav=document.getElementById('subNav'); if(subNav){ window.addEventListener('scroll',()=>{ subNav.classList.toggle('active', scrollY>500);}); document.querySelectorAll('.sub-nav-inner a').forEach(a=>{ a.addEventListener('click',e=>{ if(a.hash){ e.preventDefault(); document.querySelector(a.hash)?.scrollIntoView({behavior:'smooth',block:'start'}); }})}); }
// Lightbox
let lbIdx=0; const lb=document.getElementById('lightbox'), lbImg=document.getElementById('lbImg'), lbCounter=document.getElementById('lbCounter'); const galImgs=[...document.querySelectorAll('#homeGallery img')].map(i=>i.src);
function openLightbox(i){ lbIdx=i; lbImg.src=galImgs[i]; lbCounter.textContent=(i+1)+' / '+galImgs.length; lb.classList.add('active'); }
function closeLightbox(){ lb.classList.remove('active'); }
function navLightbox(d){ lbIdx=(lbIdx+d+galImgs.length)%galImgs.length; openLightbox(lbIdx); }
document.querySelectorAll('#homeGallery img').forEach((img,i)=>img.addEventListener('click',()=>openLightbox(i)));
lb?.addEventListener('click',e=>{ if(e.target===lb) closeLightbox(); });
document.addEventListener('keydown',e=>{ if(!lb.classList.contains('active')) return; if(e.key==='Escape') closeLightbox(); if(e.key==='ArrowLeft') navLightbox(-1); if(e.key==='ArrowRight') navLightbox(1); });
</script>
@endpush
