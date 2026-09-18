@extends('layouts.app')
@section('title', 'Offers & Packages | Sardar Catering Amsterdam')
@section('content')
<section class="page-header" style="position:relative;overflow:hidden"><div style="position:absolute;inset:0;background:linear-gradient(135deg, var(--primary), var(--primary-dark));opacity:.95"></div><div style="position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=1600&q=80') center/cover;mix-blend-mode:overlay;opacity:.25"></div><div class="container" style="position:relative"><h1>Offers & Packages</h1><p>Save up to 20% when you book direct, with flexible cancellation on selected rates and special pricing for longer stays and groups.</p><div style="margin-top:16px;display:inline-flex;background:rgba(255,255,255,.14);padding:6px 14px;border-radius:20px;font-size:11px;font-weight:700;gap:8px;align-items:center"><i class="fas fa-tag"></i> Use your promo code at checkout</div></div></section>

<section class="section"><div class="container">
    <div class="grid grid-3">
        <div class="pricing-card" style="overflow:hidden;position:relative"><div style="position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=600&q=80') center/cover;opacity:.06"></div><div style="position:relative"><div class="pricing-header"><span style="background:#e6fffa;color:#234e52;font-size:11px;font-weight:800;padding:4px 10px;border-radius:20px">Most Booked</span><h3 style="margin-top:8px">Extended Stay 15% Off</h3><p class="pricing-subtitle">For stays of 7 nights or more, with kitchenette and free laundry</p></div><div class="pricing-amount"><span class="currency">&euro;</span><span class="amount">75</span><span class="period">from / night • save 15% • Studio was €89 → €75</span></div><img src="https://images.unsplash.com/photo-1502672023488-70e25813eb80?w=400&q=80" style="height:120px;object-fit:cover;width:100%;border-radius:8px;margin-bottom:12px" alt="Offer"><ul class="pricing-features"><li><i class="fas fa-check"></i> 7 to 30 nights • Free laundry & weekly linen</li><li><i class="fas fa-check"></i> Free cancel 48h before arrival</li><li><i class="fas fa-check"></i> Breakfast + Social Hour + Pantry included</li><li><i class="fas fa-check"></i> Late check-out on request</li></ul><a href="{{ route('booking') }}" class="btn btn-primary btn-block">Book 7+ Nights • Save 15%</a><p style="font-size:11px;color:var(--text-muted);text-align:center;margin-top:8px">Avg save €105 on 7 nights one-bed • Code: STAY7</p></div></div>

        <div class="pricing-card pricing-featured" style="position:relative"><div class="pricing">Limited Time • Save 20%</div><div style="position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600&q=80') center/cover;opacity:.05;border-radius:12px"></div><div style="position:relative"><div class="pricing-header"><h3>Advance Purchase</h3><p class="pricing-subtitle">Book 14 days ahead and prepay to save</p></div><div class="pricing-amount"><span class="currency">&euro;</span><span class="amount">71</span><span class="period">from / night • save 20% • Studio was €89 → €71</span></div><img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=400&q=80" style="height:120px;object-fit:cover;width:100%;border-radius:8px;margin-bottom:12px" alt="Advance"><ul class="pricing-features"><li><i class="fas fa-check"></i> Book 14+ days ahead • Prepay at booking</li><li><i class="fas fa-check"></i> Breakfast included • Non-refundable</li><li><i class="fas fa-check"></i> Change date allowed (fee €25) • 48h</li></ul><a href="{{ route('booking') }}" class="btn btn-primary btn-block" style="background:var(--accent);border-color:var(--accent)">Book Advance • Save 20%</a><p style="font-size:11px;color:var(--text-muted);text-align:center;margin-top:8px">Code: ADVANCE20</p></div></div>

        <div class="pricing-card" style="overflow:hidden;position:relative"><div style="position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1564078516393-cf04bd966897?w=600&q=80') center/cover;opacity:.06"></div><div style="position:relative"><div class="pricing-header"><h3>Group & Family • 3+ Suites</h3><p class="pricing-subtitle">For teams, families and relocations</p></div><div class="pricing-amount"><span class="currency">&euro;</span><span class="amount">139</span><span class="period">Two-Bed per night • up to 5 guests • Save 12%</span></div><img src="https://images.unsplash.com/photo-1431540015161-0bf868a2d407?w=400&q=80" style="height:120px;object-fit:cover;width:100%;border-radius:8px;margin-bottom:12px" alt="Group"><ul class="pricing-features"><li><i class="fas fa-check"></i> Two-Bed 52m² • 2 baths • Kitchenette</li><li><i class="fas fa-check"></i> Parking €25/day • Meeting room 41m² • 12 pax</li><li><i class="fas fa-check"></i> Catering + bike tours on request</li></ul><a href="{{ route('groups') }}" class="btn btn-outline btn-block">Request Group Quote</a><p style="font-size:11px;color:var(--text-muted);text-align:center;margin-top:8px">3+ suites • Custom invoice • Pay by bank</p></div></div>
    </div>

    <div class="offers-grid">
        <div style="background:white;border:1px solid var(--border);border-radius:12px;padding:20px;display:flex;gap:12px;align-items:center"><i class="fas fa-percentage" style="width:44px;height:44px;background:rgba(229,62,62,.1);color:var(--accent);border-radius:50%;display:flex;align-items:center;justify-content:center"></i><div><h4 style="font-weight:700">Direct Booking Perks</h4><p style="font-size:13px;color:var(--text-light)">Book direct for our best available rate, a free late check-out where available and Social Hour priority.</p></div></div>
        <div style="background:var(--primary);color:white;border-radius:12px;padding:20px;display:flex;gap:12px;align-items:center"><i class="fas fa-tag" style="width:44px;height:44px;background:rgba(255,255,255,.15);border-radius:50%;display:flex;align-items:center;justify-content:center"></i><div><h4 style="font-weight:700">First stay? Take 10% off</h4><p style="font-size:13px;opacity:.8">Use code <strong>WELCOME10</strong> at checkout on any suite. No sign-up needed.</p><button type="button" class="btn btn-sm" onclick="copyWelcome10()" style="background:white;color:var(--primary)"><i class="fas fa-copy"></i> Copy code</button></div></div>
    </div>
    <p class="pricing-note">All offers exclude 7% city tax. Flexible rates can be cancelled free up to 48 hours before arrival; Advance Purchase is non-refundable and Extended Stay requires 7 or more consecutive nights. See rate conditions at checkout. <a href="{{ route('booking') }}" style="color:var(--primary);font-weight:700">Check which rate saves you most →</a></p>
</div></section>
@endsection
@push('scripts')
<script>
function copyWelcome10() {
    const code = 'WELCOME10';
    const done = () => showToast('Code ' + code + ' copied — apply it at checkout.');
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(code).then(done).catch(done);
    } else {
        const ta = document.createElement('textarea');
        ta.value = code;
        ta.style.position = 'fixed';
        ta.style.opacity = '0';
        document.body.appendChild(ta);
        ta.select();
        try { document.execCommand('copy'); } catch (e) {}
        document.body.removeChild(ta);
        done();
    }
}
</script>
@endpush
