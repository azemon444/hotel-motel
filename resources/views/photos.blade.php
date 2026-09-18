@extends('layouts.app')
@section('title', 'Photo Gallery | Sardar Catering Amsterdam')
@section('content')
<section class="page-header"><div class="container"><h1>Photo Gallery</h1><p>Suites, kitchenettes, living spaces, fitness, breakfast and the Amsterdam neighbourhood.</p></div></section>
<section class="section"><div class="container">
    <div class="filter-pills" id="photoFilters">
        <button class="filter-pill active" data-cat="all" onclick="filterPhotos('all',this)">All</button>
        <button class="filter-pill" data-cat="suites" onclick="filterPhotos('suites',this)">Suites</button>
        <button class="filter-pill" data-cat="kitchen" onclick="filterPhotos('kitchen',this)">Kitchenettes</button>
        <button class="filter-pill" data-cat="living" onclick="filterPhotos('living',this)">Living Room</button>
        <button class="filter-pill" data-cat="fitness" onclick="filterPhotos('fitness',this)">Fitness & Laundry</button>
        <button class="filter-pill" data-cat="food" onclick="filterPhotos('food',this)">Breakfast & Pantry</button>
        <button class="filter-pill" data-cat="local" onclick="filterPhotos('local',this)">Amsterdam</button>
    </div>
    <div class="photo-grid" id="grid">
        <img data-cat="suites" src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800&q=80" alt="Exterior Night">
        <img data-cat="living" src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=80" alt="Lobby and living area">
        <img data-cat="suites" src="https://images.unsplash.com/photo-1582719508461-905c673771fd?w=800&q=80" alt="Studio Suite">
        <img data-cat="suites" src="https://images.unsplash.com/photo-1590490360182-c33d57733427?w=800&q=80" alt="One Bedroom">
        <img data-cat="suites" src="https://images.unsplash.com/photo-1564078516393-cf04bd966897?w=800&q=80" alt="Two Bedroom Suite">
        <img data-cat="local" src="https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=800&q=80" alt="Amsterdam Canals">
        <img data-cat="suites" src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=800&q=80" alt="Studio Suite">
        <img data-cat="kitchen" src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=800&q=80" alt="Kitchenette">
        <img data-cat="fitness" src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=800&q=80" alt="Fitness Center">
        <img data-cat="living" src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=800&q=80" alt="Living Room">
        <img data-cat="suites" src="https://images.unsplash.com/photo-1502672023488-70e25813eb80?w=800&q=80" alt="Suite Detail">
        <img data-cat="food" src="https://images.unsplash.com/photo-1504754524776-8f4f37790ca0?w=800&q=80" alt="Breakfast Buffet">
        <img data-cat="local" src="https://images.unsplash.com/photo-1519710164239-da123dc03ef4?w=800&q=80" alt="Canal Houses">
        <img data-cat="living" src="https://images.unsplash.com/photo-1486304873000-235643847519?w=800&q=80" alt="Dining and living area">
        <img data-cat="suites" src="https://images.unsplash.com/photo-1552321554-5fefe8c9ef14?w=800&q=80" alt="Bathroom Suite">
        <img data-cat="living" src="https://images.unsplash.com/photo-1449844908441-8829872d2607?w=800&q=80" alt="Courtyard">
        <img data-cat="local" src="https://images.unsplash.com/photo-1538688525198-9b88f6f53126?w=800&q=80" alt="Vondelpark">
        <img data-cat="local" src="https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?w=800&q=80" alt="Amsterdam Street">
        <img data-cat="kitchen" src="https://images.unsplash.com/photo-1556911220-e15b29be8c8f?w=800&q=80" alt="Kitchenette detail">
        <img data-cat="suites" src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=800&q=80" alt="Suite Living">
        <img data-cat="living" src="https://images.unsplash.com/photo-1566665797739-1674de7a421a?w=800&q=80" alt="Lounge Area">
        <img data-cat="suites" src="https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?w=800&q=80" alt="Double Bed">
        <img data-cat="local" src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&q=80" alt="View Amsterdam">
        <img data-cat="suites" src="https://images.unsplash.com/photo-1484154218962-a197022b5858?w=800&q=80" alt="Apartment View">
        <img data-cat="suites" src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=800&q=80" alt="Guest room">
        <img data-cat="suites" src="https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=800&q=80" alt="Bath Modern">
        <img data-cat="living" src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=800&q=80" alt="Living area with workspace">
        <img data-cat="local" src="https://images.unsplash.com/photo-1494526585095-c41746248156?w=800&q=80" alt="Amsterdam Evening">
        <img data-cat="food" src="https://images.unsplash.com/photo-1551218808-94e220e084d2?w=800&q=80" alt="Coffee Pantry">
        <img data-cat="fitness" src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=800&q=80" alt="Gym Weights">
        <img data-cat="kitchen" src="https://images.unsplash.com/photo-1490818387583-1baba5e638af?w=800&q=80" alt="Fully equipped kitchenette">
        <img data-cat="suites" src="https://images.unsplash.com/photo-1522199710521-72d69614c702?w=800&q=80" alt="Meeting Table">
        <img data-cat="local" src="https://images.unsplash.com/photo-1467269204594-9661b134dd2b?w=800&q=80" alt="Rijksmuseum">
        <img data-cat="fitness" src="https://images.unsplash.com/photo-1540497077202-7c8a3999166f?w=800&q=80" alt="Laundry">
        <img data-cat="local" src="https://images.unsplash.com/photo-1480714378408-67cf0d13bc1b?w=800&q=80" alt="Amsterdam Bikes">
        <img data-cat="fitness" src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=800&q=80" alt="Fitness studio">
    </div>
    <p style="text-align:center;color:var(--text-muted);font-size:13px;margin-top:20px">Tap any photo to view it full size.</p>
</div></section>
<div class="lightbox" id="lightbox"><button class="lightbox-close" onclick="closeLB()" aria-label="Close"><i class="fas fa-times"></i></button><button class="lightbox-prev" onclick="navLB(-1)"><i class="fas fa-chevron-left"></i></button><img id="lbImg" alt=""><button class="lightbox-next" onclick="navLB(1)"><i class="fas fa-chevron-right"></i></button><div class="lightbox-counter" id="lbCounter"></div></div>
@endsection
@push('scripts')
<script>
let idx=0; const imgs=[...document.querySelectorAll('#grid img')]; const lb=document.getElementById('lightbox'), lbImg=document.getElementById('lbImg'), c=document.getElementById('lbCounter');
function visible(){ return imgs.filter(i=>i.style.display!=='none'); }
function openLB(i){ const v=visible(); const real=v[i]; idx=imgs.indexOf(real); updateLB(); lb.classList.add('active'); }
function updateLB(){ const v=visible(); const vi=v.indexOf(imgs[idx]); if(vi===-1) return; lbImg.src=imgs[idx].src.replace('w=800','w=1600'); c.textContent=(vi+1)+' / '+v.length+' • '+imgs[idx].alt; }
function closeLB(){ lb.classList.remove('active'); }
function navLB(d){ const v=visible(); if(!v.length) return; let vi=v.indexOf(imgs[idx]); vi=(vi+d+v.length)%v.length; idx=imgs.indexOf(v[vi]); updateLB(); }
imgs.forEach((im,i)=> im.addEventListener('click',()=>{ idx=i; updateLB(); lb.classList.add('active'); }));
lb.addEventListener('click',e=>{ if(e.target===lb) closeLB(); });
document.addEventListener('keydown',e=>{ if(!lb.classList.contains('active')) return; if(e.key==='Escape') closeLB(); if(e.key==='ArrowLeft') navLB(-1); if(e.key==='ArrowRight') navLB(1); });
let touchX=0; lbImg.addEventListener('touchstart',e=>touchX=e.touches[0].clientX); lbImg.addEventListener('touchend',e=>{ const dx=e.changedTouches[0].clientX-touchX; if(Math.abs(dx)>50) navLB(dx<0?1:-1); });
function filterPhotos(cat,btn){ document.querySelectorAll('#photoFilters .filter-pill').forEach(b=>b.classList.remove('active')); btn.classList.add('active'); imgs.forEach(img=>{ img.style.display=(cat==='all'||img.dataset.cat===cat)?'':'none'; }); if(lb.classList.contains('active') && imgs[idx].style.display==='none') closeLB(); }
// hash open e.g. #kitchen handles the suite "View gallery" buttons (#studio/#onebed/#twobed)
if(location.hash){ let cat=location.hash.slice(1); const map={'studio':'suites','onebed':'suites','twobed':'suites','accessible':'suites'}; cat=map[cat]||cat; const b=document.querySelector(`#photoFilters [data-cat="${cat}"]`); if(b){ filterPhotos(cat,b); const g=document.getElementById('grid'); if(g) g.scrollIntoView({behavior:'smooth',block:'start'}); } }
</script>
@endpush
