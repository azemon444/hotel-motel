@extends('layouts.app')
@section('title', 'Suites | Sardar Catering Amsterdam')
@section('content')
<section class="page-header" style="position:relative;overflow:hidden">
    <div style="position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1582719508461-905c673771fd?w=1600&q=80') center/cover;opacity:.22"></div>
    <div class="container" style="position:relative"><h1>Hotel Suites</h1><p>Extended-stay suites with kitchenettes, living areas and workspace. Free breakfast. From €89 per night.</p>
        <div style="margin-top:16px;display:flex;gap:8px;justify-content:center;flex-wrap:wrap;font-size:11px;font-weight:700"><span style="background:rgba(255,255,255,.18);padding:6px 12px;border-radius:20px"><i class="fas fa-check"></i> Free cancel 48h</span><span style="background:rgba(255,255,255,.18);padding:6px 12px;border-radius:20px"><i class="fas fa-utensils"></i> Kitchenette every suite</span><span style="background:rgba(255,255,255,.18);padding:6px 12px;border-radius:20px"><i class="fas fa-tshirt"></i> Free laundry</span></div>
    </div>
</section>

<section class="section">
    <div class="container">
        <!-- Suite filters -->
        <div class="suite-controls">
            <div class="suite-filters" id="suiteFilters">
                <button class="filter-pill active" data-filter="all" onclick="filterSuites('all',this)">All Suites</button>
                <button class="filter-pill" data-filter="studio" onclick="filterSuites('studio',this)">Studio • 2 guests</button>
                <button class="filter-pill" data-filter="onebed" onclick="filterSuites('onebed',this)">One-Bed • 3 guests</button>
                <button class="filter-pill" data-filter="twobed" onclick="filterSuites('twobed',this)">Two-Bed • 5 guests</button>
                <button class="filter-pill" data-filter="accessible" onclick="filterSuites('accessible',this)"><i class="fas fa-wheelchair"></i> Accessible</button>
            </div>
            <div style="display:flex;gap:8px;align-items:center">
                <select id="sortSuites" onchange="sortSuites(this.value)" style="padding:8px 12px;border:1px solid var(--border);border-radius:20px;font-size:13px;font-weight:600"><option value="recommended">Recommended</option><option value="price-asc">Price: Low-High</option><option value="price-desc">Price: High-Low</option><option value="size-desc">Largest first</option></select>
            </div>
        </div>

        <!-- Suite cards -->
        <div id="suiteList">
        <!-- Studio -->
        <div class="suite-detail" data-type="studio" data-price="89" data-size="28">
            <div style="position:relative">
                <div class="swiper suite-swiper" style="height:380px"><div class="swiper-wrapper"><div class="swiper-slide"><img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=900&q=80" alt="Studio"></div><div class="swiper-slide"><img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=900&q=80" alt="Studio Kitchen"></div><div class="swiper-slide"><img src="https://images.unsplash.com/photo-1552321554-5fefe8c9ef14?w=900&q=80" alt="Studio Bath"></div><div class="swiper-slide"><img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=900&q=80" alt="Studio Detail"></div></div><div class="swiper-pagination"></div><div class="swiper-button-next" style="color:white"></div><div class="swiper-button-prev" style="color:white"></div></div>
                <span style="position:absolute;top:16px;left:16px;background:var(--primary);color:white;padding:6px 14px;border-radius:20px;font-size:11px;font-weight:700;z-index:2">Studio • 28m² • 2 Guests • 1 Queen</span>
            </div>
            <div>
                <h3 style="font-size:24px;font-weight:800;margin-bottom:6px">Studio Suite</h3>
                <p style="font-size:12px;color:var(--text-muted);font-weight:600;letter-spacing:.5px;text-transform:uppercase;margin-bottom:12px"><i class="fas fa-ruler-combined"></i> 28m² • Queen bed • Workspace • Kitchenette • City view</p>
                <p style="font-size:14px;color:var(--text-light);line-height:1.7">Open-plan studio with dedicated workspace, queen bed and fully equipped kitchenette (full fridge/freezer, two-burner stovetop, microwave, cookware). Ideal for solo, business & short stays. Weekly housekeeping, free laundry, Social Hour included.</p>
                <div class="suite-amenities"><span><i class="fas fa-utensils"></i> Kitchenette</span><span><i class="fas fa-wifi"></i> Wi-Fi 300M</span><span><i class="fas fa-tv"></i> 43" Flat TV</span><span><i class="fas fa-snowflake"></i> A/C</span><span><i class="fas fa-coffee"></i> Nespresso</span><span><i class="fas fa-safe"></i> Safe</span><span><i class="fas fa-tshirt"></i> Laundry free</span></div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:16px;font-size:12px;color:var(--text-muted)"><span><i class="fas fa-check" style="color:var(--success)"></i> Free breakfast</span><span><i class="fas fa-check" style="color:var(--success)"></i> 24/7 fitness</span><span><i class="fas fa-check" style="color:var(--success)"></i> Kitchenware</span><span><i class="fas fa-check" style="color:var(--success)"></i> Weekly linen change</span></div>
                <div style="display:flex;align-items:center;gap:16px;margin-top:20px;flex-wrap:wrap"><div><span style="font-size:28px;font-weight:800;color:var(--primary)">&euro;89 <small style="font-size:13px;color:var(--text-muted)">/night</small></span><br><small style="color:var(--text-muted);font-size:11px">From • City tax 7% extra • Save 15% 7+ nights → €75</small></div><a href="{{ route('booking') }}" class="btn btn-primary">Book Studio <i class="fas fa-arrow-right"></i></a><button class="compare-btn" onclick="openGallery('studio')"><i class="fas fa-images"></i> View gallery</button></div>
            </div>
        </div>

        <!-- One Bedroom Popular -->
        <div class="suite-detail reverse" data-type="onebed" data-price="119" data-size="38" style="border:2px solid var(--accent)">
            <div style="position:relative">
                <div class="swiper suite-swiper" style="height:380px"><div class="swiper-wrapper"><div class="swiper-slide"><img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?w=900&q=80" alt="One Bed"></div><div class="swiper-slide"><img src="https://images.unsplash.com/photo-1502672023488-70e25813eb80?w=900&q=80" alt="Living"></div><div class="swiper-slide"><img src="https://images.unsplash.com/photo-1486304873000-235643847519?w=900&q=80" alt="Dining"></div><div class="swiper-slide"><img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=900&q=80" alt="Kitchen2"></div><div class="swiper-slide"><img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=900&q=80" alt="Work"></div></div><div class="swiper-pagination"></div><div class="swiper-button-next" style="color:white"></div><div class="swiper-button-prev" style="color:white"></div></div>
                <span style="position:absolute;top:16px;left:16px;background:var(--accent);color:white;padding:6px 14px;border-radius:20px;font-size:11px;font-weight:800;z-index:2">★ Most Popular • One-Bed • 38m² • 3 Guests • Double + Sofa bed</span>
            </div>
            <div>
                <h3 style="font-size:24px;font-weight:800;margin-bottom:6px">One-Bedroom Suite <span style="background:var(--accent);color:white;font-size:10px;padding:4px 8px;border-radius:20px;vertical-align:middle">BEST FOR LONG STAY</span></h3>
                <p style="font-size:12px;color:var(--text-muted);font-weight:600;letter-spacing:.5px;text-transform:uppercase;margin-bottom:12px">38m² • Separate bedroom • Living 16m² • Full kitchenette • Sofa bed • Workspace</p>
                <p style="font-size:14px;color:var(--text-light);line-height:1.7">Separate bedroom with double bed, living area with sofa bed for third guest, dining table & full kitchenette. Flex from focus work to evening relax. Perfect for relocation, projects & couples staying longer. The Pantry 24h + Social Hour included.</p>
                <div class="suite-amenities"><span>Separate Bedroom</span><span>Living + Dining</span><span>Full Kitchen</span><span>Sofa bed</span><span>Workspace Desk</span><span>2 TVs 43"</span><span>Bathtub + Shower</span></div>
                <div style="display:flex;align-items:center;gap:16px;margin-top:20px;flex-wrap:wrap"><div><span style="font-size:28px;font-weight:800;color:var(--accent)">&euro;119 <small style="font-size:13px;color:var(--text-muted)">/night</small></span><br><small style="color:var(--success);font-weight:700;font-size:12px">★ 7+ nights €101 • Save 15% • Free laundry</small></div><a href="{{ route('booking') }}" class="btn btn-primary" style="background:var(--accent);border-color:var(--accent)">Book One-Bed</a><button class="compare-btn" onclick="openGallery('onebed')"><i class="fas fa-images"></i> View gallery</button></div>
                <p style="font-size:11px;color:var(--text-muted);margin-top:8px"><i class="fas fa-info-circle"></i> Choose pay at hotel or prepay & save 20% (non-refundable from €95).</p>
            </div>
        </div>

        <!-- Two Bedroom -->
        <div class="suite-detail" data-type="twobed" data-price="159" data-size="52" data-accessible="true">
            <div style="position:relative">
                <div class="swiper suite-swiper" style="height:380px"><div class="swiper-wrapper"><div class="swiper-slide"><img src="https://images.unsplash.com/photo-1564078516393-cf04bd966897?w=900&q=80" alt="Two Bed"></div><div class="swiper-slide"><img src="https://images.unsplash.com/photo-1519710164239-da123dc03ef4?w=900&q=80" alt="Bed2"></div><div class="swiper-slide"><img src="https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=900&q=80" alt="Bath2"></div><div class="swiper-slide"><img src="https://images.unsplash.com/photo-1484154218962-a197022b5858?w=900&q=80" alt="Apartment"></div><div class="swiper-slide"><img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=900&q=80" alt="Exterior"></div></div><div class="swiper-pagination"></div><div class="swiper-button-next" style="color:white"></div><div class="swiper-button-prev" style="color:white"></div></div>
                <span style="position:absolute;top:16px;left:16px;background:var(--success);color:white;padding:6px 14px;border-radius:20px;font-size:11px;font-weight:700;z-index:2">Family • Two-Bed • 52m² • 5 Guests • 2 Baths</span>
                <span style="position:absolute;bottom:16px;left:16px;background:rgba(255,255,255,.92);color:var(--primary);padding:6px 10px;border-radius:20px;font-size:10px;font-weight:700;z-index:2"><i class="fas fa-wheelchair"></i> Accessible type available</span>
            </div>
            <div>
                <h3 style="font-size:24px;font-weight:800;margin-bottom:6px">Two-Bedroom Suite</h3>
                <p style="font-size:12px;color:var(--text-muted);font-weight:600;letter-spacing:.5px;text-transform:uppercase;margin-bottom:12px">52m² • 2 bedrooms • Living 22m² • Kitchenette • 2 bathrooms • 5 max</p>
                <p style="font-size:14px;color:var(--text-light);line-height:1.7">Two separate bedrooms, spacious living room, kitchenette and two bathrooms. For families, groups & longer projects — home for up to 5. Separate WC + shower/bath, dining for 5, workspace.</p>
                <div class="suite-amenities"><span>2 Bedrooms</span><span>Living 22m²</span><span>Kitchenette</span><span>2 Bathrooms</span><span>Dining 5</span><span>Accessible</span><span>2x TV</span></div>
                <div style="display:flex;align-items:center;gap:16px;margin-top:20px;flex-wrap:wrap"><div><span style="font-size:28px;font-weight:800;color:var(--primary)">&euro;159 <small style="font-size:13px;color:var(--text-muted)">/night</small></span><br><small style="color:var(--text-muted);font-size:11px">Family rate • Group 3+ suites contact for quote</small></div><a href="{{ route('booking') }}" class="btn btn-primary">Book Two-Bed</a><button class="compare-btn" onclick="openGallery('twobed')"><i class="fas fa-images"></i> View gallery</button></div>
            </div>
        </div>
        </div>

        <div style="background:white;border:1px solid var(--border);border-radius:12px;padding:20px;display:grid;grid-template-columns:repeat(4,1fr);gap:16px;text-align:center;font-size:12px;margin-top:8px">
            <div><i class="fas fa-mug-hot" style="font-size:18px;color:var(--primary)"></i><br><strong>Free Breakfast</strong><br>6:30-10:30 daily</div>
            <div><i class="fas fa-tshirt" style="font-size:18px;color:var(--primary)"></i><br><strong>Free Laundry</strong><br>24/7 self-service</div>
            <div><i class="fas fa-dumbbell" style="font-size:18px;color:var(--primary)"></i><br><strong>24/7 Fitness</strong><br>Cardio & weights</div>
            <div><i class="fas fa-wifi" style="font-size:18px;color:var(--primary)"></i><br><strong>Free Wi-Fi</strong><br>300 Mbps</div>
            <div style="grid-column:1/-1;color:var(--text-muted);font-size:11px;border-top:1px solid var(--border);padding-top:12px;margin-top:8px">All prices exclude 7% city tax. Weekly housekeeping and linen change, Social Hour Mon/Wed/Thu 17-18h and The Pantry 24h are included. <a href="{{ route('amenities') }}" style="color:var(--primary);font-weight:700">See full amenities →</a></div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script>
function filterSuites(type,btn){ document.querySelectorAll('.suite-filters .filter-pill').forEach(b=>b.classList.remove('active')); btn.classList.add('active'); document.querySelectorAll('.suite-detail').forEach(c=>{ c.style.display=(type==='all'||c.dataset.type===type||(type==='accessible'&&c.dataset.accessible))?'grid':'none'; });}
function sortSuites(v){ const grid=document.getElementById('suiteList'); const cards=[...grid.querySelectorAll('.suite-detail')]; cards.sort((a,b)=>{ if(v==='price-asc') return a.dataset.price-b.dataset.price; if(v==='price-desc') return b.dataset.price-a.dataset.price; if(v==='size-desc') return b.dataset.size-a.dataset.size; return 0;}); cards.forEach(c=>grid.appendChild(c));}
function openGallery(t){ window.location.href="{{ route('photos') }}#"+t; }
</script>
@endpush
