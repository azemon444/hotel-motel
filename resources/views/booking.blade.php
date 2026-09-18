@extends('layouts.app')
@section('title', 'Book Your Stay | Sardar Catering Amsterdam')
@section('content')


    <!-- Page Header Modern -->
    <section class="page-header" style="position:relative;overflow:hidden">
        <div style="position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1600&q=80') center/cover;opacity:.18"></div>
        <div class="container" style="position:relative">
            <h1>Book Your Stay</h1>
            <p>Free cancellation on flexible rates. Pay at the hotel, or prepay and save 20%. Every suite has a kitchenette and breakfast is included.</p>
            <div style="margin-top:12px;display:flex;gap:8px;justify-content:center;flex-wrap:wrap;font-size:11px;font-weight:700"><span style="background:rgba(255,255,255,.18);padding:6px 12px;border-radius:20px"><i class="fas fa-shield-alt"></i> Free cancel 48h</span><span style="background:rgba(255,255,255,.18);padding:6px 12px;border-radius:20px"><i class="fas fa-lock"></i> Stripe Secure</span><span style="background:rgba(255,255,255,.18);padding:6px 12px;border-radius:20px"><i class="fas fa-star"></i> Free breakfast</span></div>
        </div>
    </section>
    <div class="container" style="padding:16px 20px 0">
        <div style="display:flex;gap:8px;justify-content:center;align-items:center;font-size:11px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:var(--text-muted);background:white;border:1px solid var(--border);padding:10px;border-radius:20px;max-width:520px;margin:0 auto">
            <span style="background:var(--primary);color:white;width:22px;height:22px;border-radius:50%;display:flex;align-items:center;justify-content:center">1</span> Dates & Suite <span style="opacity:.3">—</span> <span style="background:var(--border);width:22px;height:22px;border-radius:50%;display:flex;align-items:center;justify-content:center">2</span> Guest <span style="opacity:.3">—</span> <span style="background:var(--border);width:22px;height:22px;border-radius:50%;display:flex;align-items:center;justify-content:center">3</span> Pay Secure
        </div>
    </div>

    <!-- Booking Section -->
    <section class="section">
        <div class="container">
            <div class="booking-layout" id="bookingContent">

                <!-- Booking Form -->
                <div class="booking-form-card">
                    <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 24px;">Select Suite</h2>
                    <p style="font-size:13px; color:var(--text-muted); margin-bottom:16px;"><i class="fas fa-utensils"></i> All suites include a kitchenette, free Wi-Fi, breakfast and weekly housekeeping.</p>

                    <div style="background:rgba(26,54,93,.06);border:1px dashed rgba(26,54,93,.2);border-radius:12px;padding:14px;display:flex;gap:12px;align-items:center;margin-bottom:20px"><img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=120&q=80" style="width:84px;height:64px;object-fit:cover;border-radius:8px" alt="Hotel"><div style="font-size:12px;line-height:1.5"><strong>Sardar Catering • Amsterdam West</strong><br><span style="color:var(--text-muted)"><i class="fas fa-map-marker-alt"></i> Ladogameerhof 174 · breakfast included · kitchenette</span><br><a href="{{ route('photos') }}" style="color:var(--primary);font-weight:700">View photos →</a></div></div>
                    <form id="bookingForm">
                        <!-- Promo Code -->
                        <div style="display:flex;gap:8px;margin-bottom:16px"><input type="text" id="promoInput" placeholder="Promo code (e.g. ADVANCE20, STAY7, WELCOME10)" style="flex:1;padding:10px 14px;border:1px solid var(--border);border-radius:20px;font-size:13px;font-weight:600"><button type="button" onclick="applyPromo()" class="btn btn-outline btn-sm">Apply</button></div>
                        <p id="promoMsg" style="font-size:12px;font-weight:700;margin:-8px 0 16px;display:none"></p>
                        <!-- Room Selection -->
                        <div class="room-option selected" data-room="studio" data-price="89" onclick="selectRoom(this)">
                            <input type="radio" name="room" value="studio" checked>
                            <div class="room-option-radio"></div>
                            <div class="room-option-info">
                                <div class="room-option-name">Studio Suite • 28m²</div>
                                <div class="room-option-desc">Queen bed, kitchenette, workspace – 2 guests max</div>
                            </div>
                            <div class="room-option-price">&euro;89<small>/night</small></div>
                        </div>
                        <div class="room-option" data-room="onebed" data-price="119" onclick="selectRoom(this)">
                            <input type="radio" name="room" value="onebed">
                            <div class="room-option-radio"></div>
                            <div class="room-option-info">
                                <div class="room-option-name">One-Bedroom Suite • 38m²</div>
                                <div class="room-option-desc">Separate bedroom, living area + full kitchenette – 3 guests</div>
                            </div>
                            <div class="room-option-price">&euro;119<small>/night</small></div>
                        </div>
                        <div class="room-option" data-room="twobed" data-price="159" onclick="selectRoom(this)">
                            <input type="radio" name="room" value="twobed">
                            <div class="room-option-radio"></div>
                            <div class="room-option-info">
                                <div class="room-option-name">Two-Bedroom Suite • 52m²</div>
                                <div class="room-option-desc">2 bedrooms, living room, kitchenette – 5 guests max</div>
                            </div>
                            <div class="room-option-price">&euro;159<small>/night</small></div>
                        </div>
                        <div class="room-option" data-room="custom" data-price="0" onclick="selectRoom(this)">
                            <input type="radio" name="room" value="custom">
                            <div class="room-option-radio"></div>
                            <div class="room-option-info">
                                <div class="room-option-name">Custom Amount</div>
                                <div class="room-option-desc">Pay a custom amount (deposit, parking €25/day, etc.)</div>
                            </div>
                            <div class="room-option-price">&euro;0.50<small>min</small></div>
                        </div>

                        <!-- Custom Amount Input (hidden by default) -->
                        <div id="customAmountSection"
                            style="display: none; margin-top: 16px; padding: 16px; background: var(--bg-alt); border-radius: var(--radius); border: 1px solid var(--border);">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label for="customAmount">Enter Amount (EUR) *</label>
                                <input type="number" id="customAmount" name="customAmount" min="0.50" max="10000"
                                    step="0.01" placeholder="Enter amount in EUR"
                                    style="font-size: 18px; font-weight: 600;">
                                <small style="color: var(--text-muted);">Minimum €0.50</small>
                            </div>
                        </div>

                        <!-- Dates (hidden for custom amount) -->
                        <div id="datesSection">
                            <h2 style="font-size: 20px; font-weight: 700; margin: 32px 0 16px;">Select Dates</h2>
                            <div class="form-row-3">
                                <div class="form-group">
                                    <label for="checkin">Check-in Date *</label>
                                    <input type="date" id="checkin" name="checkin" required>
                                </div>
                                <div class="form-group">
                                    <label for="checkout">Check-out Date *</label>
                                    <input type="date" id="checkout" name="checkout" required>
                                </div>
                                <div class="form-group">
                                    <label for="nights">Nights</label>
                                    <input type="number" id="nights" name="nights" value="1" min="1" max="30" readonly
                                        style="background: var(--bg-alt); cursor: not-allowed;">
                                </div>
                            </div>
                        </div>

                        <!-- Guests (hidden for custom amount) -->
                        <div id="guestsSection">
                            <h2 style="font-size: 20px; font-weight: 700; margin: 32px 0 16px;">Guests</h2>
                            <div class="form-group">
                                <label>Number of Guests</label>
                                <div class="guest-counter">
                                    <button type="button" onclick="changeGuests(-1)">-</button>
                                    <span id="guestCount">2</span>
                                    <button type="button" onclick="changeGuests(1)">+</button>
                                </div>
                                <input type="hidden" id="guests" name="guests" value="2">
                            </div>
                        </div>

                        <!-- Guest Details -->
                        <h2 style="font-size: 20px; font-weight: 700; margin: 32px 0 16px;">Guest Details</h2>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="firstName">First Name *</label>
                                <input type="text" id="firstName" name="firstName" required>
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name *</label>
                                <input type="text" id="lastName" name="lastName" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone *</label>
                                <input type="tel" id="phone" name="phone" required>
                            </div>
                        </div>

                        <!-- Special Requests -->
                        <div class="form-group">
                            <label for="requests">Special Requests</label>
                            <textarea id="requests" name="requests" rows="3"
                                placeholder="Any dietary requirements, accessibility needs, or other requests..."></textarea>
                        </div>

                        <!-- Terms Acceptance -->
                        <div class="form-group" style="margin-top: 16px;">
                            <label
                                style="display: flex; align-items: flex-start; gap: 10px; cursor: pointer; font-weight: 400;">
                                <input type="checkbox" id="terms" name="terms" required
                                    style="width: auto; margin-top: 3px;">
                                <span style="font-size: 13px; color: var(--text-light); line-height: 1.5;">
                                    I agree to the <a href="{{ route('terms') }}" target="_blank"
                                        style="color: var(--primary); font-weight: 500;">Terms of Service</a>,
                                    <a href="{{ route('privacy') }}" target="_blank"
                                        style="color: var(--primary); font-weight: 500;">Privacy Policy</a>, and
                                    <a href="{{ route('refund') }}" target="_blank"
                                        style="color: var(--primary); font-weight: 500;">Refund Policy</a>. *
                                </span>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg btn-block" id="submitBtn"
                            style="margin-top: 8px;">
                            <i class="fas fa-lock"></i> Proceed to Payment
                        </button>

                        <div class="stripe-badge">
                            <i class="fab fa-stripe"></i> Secure payment powered by Stripe
                        </div>
                        <div class="card-logos"
                            style="display: flex; justify-content: center; gap: 12px; margin-top: 12px; opacity: 0.6;">
                            <i class="fab fa-cc-visa" style="font-size: 32px; color: #1a1f71;"></i>
                            <i class="fab fa-cc-mastercard" style="font-size: 32px; color: #eb001b;"></i>
                            <i class="fab fa-cc-amex" style="font-size: 32px; color: #006fcf;"></i>
                            <i class="fab fa-cc-apple-pay" style="font-size: 32px; color: #000;"></i>
                        </div>
                    </form>
                </div>

                <!-- Booking Summary -->
                <div class="booking-summary">
                    <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 24px;">Booking Summary</h2>
                    <div class="summary-row">
                        <span class="summary-label">Room Type</span>
                        <span class="summary-value" id="summaryRoom">Studio Suite (28m²)</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Check-in</span>
                        <span class="summary-value" id="summaryCheckin">-</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Check-out</span>
                        <span class="summary-value" id="summaryCheckout">-</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Nights</span>
                        <span class="summary-value" id="summaryNights">1</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Guests</span>
                        <span class="summary-value" id="summaryGuests">1</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Rate per night</span>
                        <span class="summary-value" id="summaryRate">&euro;89</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Subtotal</span>
                        <span class="summary-value" id="summarySubtotal">&euro;89.00</span>
                    </div>
                    <div class="summary-row" id="discountRow" style="display:none">
                        <span class="summary-label">Discount <small id="discountCode"></small></span>
                        <span class="summary-value" style="color:var(--success)" id="summaryDiscount">-€0.00</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">City tax (7%)</span>
                        <span class="summary-value" id="summaryTax">&euro;6.23</span>
                    </div>
                    <div class="summary-row total">
                        <span class="summary-label">Total</span>
                        <span class="summary-value" id="summaryTotal">&euro;95.23</span>
                    </div>

                    <div class="booking-note">
                        <i class="fas fa-info-circle"></i>
                        Free cancellation up to 48 hours before check-in. Prices include VAT. City tax of 7% applies.
                    </div>
                </div>

            </div>
        </div>
    </section>

    
    <script>
        const roomPrices = { studio: 89, onebed: 119, twobed: 159, custom: 0 };
        const roomNames = { studio: 'Studio Suite (28m²)', onebed: 'One-Bedroom Suite (38m²)', twobed: 'Two-Bedroom Suite (52m²)', custom: 'Custom Payment' };
        const promoCodes = { ADVANCE20: 0.20, STAY7: 0.15, WELCOME10: 0.10, SAVE15: 0.15 };
        let promoDiscount = 0; let promoApplied = '';
        function applyPromo(){ const v=document.getElementById('promoInput').value.trim().toUpperCase(); const msg=document.getElementById('promoMsg'); if(!v){ promoDiscount=0; promoApplied=''; msg.style.display='none'; updateSummary(); return;} if(promoCodes[v]!==undefined){ promoDiscount=promoCodes[v]; promoApplied=v; msg.textContent='✓ Applied '+v+' — '+(promoDiscount*100)+'% off subtotal'; msg.style.color='var(--success)'; msg.style.display='block'; } else { msg.textContent='✕ Invalid code. Try ADVANCE20 or STAY7'; msg.style.color='var(--accent)'; msg.style.display='block'; promoDiscount=0; promoApplied=''; } updateSummary(); }
        const CITY_TAX_RATE = 0.07;
        let currentPrice = 89;
        let guestCount = 2;
        let isCustomAmount = false;

        function selectRoom(el) {
            document.querySelectorAll('.room-option').forEach(r => r.classList.remove('selected'));
            el.classList.add('selected');
            el.querySelector('input').checked = true;
            currentPrice = parseInt(el.dataset.price);
            isCustomAmount = el.dataset.room === 'custom';

            // Show/hide sections based on room type
            document.getElementById('customAmountSection').style.display = isCustomAmount ? 'block' : 'none';
            document.getElementById('datesSection').style.display = isCustomAmount ? 'none' : 'block';
            document.getElementById('guestsSection').style.display = isCustomAmount ? 'none' : 'block';

            // Toggle required attribute for date inputs
            const checkinInput = document.getElementById('checkin');
            const checkoutInput = document.getElementById('checkout');
            if (isCustomAmount) {
                checkinInput.removeAttribute('required');
                checkoutInput.removeAttribute('required');
            } else {
                checkinInput.setAttribute('required', 'required');
                checkoutInput.setAttribute('required', 'required');
            }

            // Update summary
            if (isCustomAmount) {
                updateCustomSummary();
            } else {
                updateSummary();
            }
        }

        function changeGuests(delta) {
            guestCount = Math.max(1, Math.min(5, guestCount + delta));
            document.getElementById('guestCount').textContent = guestCount;
            document.getElementById('guests').value = guestCount;
            updateSummary();
        }

        function calculateNights() {
            const checkin = document.getElementById('checkin').value;
            const checkout = document.getElementById('checkout').value;
            if (checkin && checkout) {
                const diff = (new Date(checkout) - new Date(checkin)) / (1000 * 60 * 60 * 24);
                if (diff > 0) {
                    const nights = Math.ceil(diff);
                    document.getElementById('nights').value = nights;
                    return nights;
                }
            }
            return 1;
        }

        function updateCustomSummary() {
            const customAmount = parseFloat(document.getElementById('customAmount').value) || 0;
            const discount = customAmount * promoDiscount;
            const sub = customAmount - discount;
            const tax = sub * CITY_TAX_RATE;
            const total = sub + tax;
            const dr=document.getElementById('discountRow'); if(discount>0){ dr.style.display='flex'; document.getElementById('discountCode').textContent='('+promoApplied+')'; document.getElementById('summaryDiscount').textContent='-€'+discount.toFixed(2); } else dr.style.display='none';

            document.getElementById('summaryRoom').textContent = 'Custom Payment';
            document.getElementById('summaryCheckin').textContent = '-';
            document.getElementById('summaryCheckout').textContent = '-';
            document.getElementById('summaryNights').textContent = '-';
            document.getElementById('summaryGuests').textContent = '-';
            document.getElementById('summaryRate').innerHTML = `&euro;${customAmount.toFixed(2)}`;
            document.getElementById('summarySubtotal').innerHTML = `&euro;${sub.toFixed(2)}`;
            document.getElementById('summaryTax').innerHTML = `&euro;${tax.toFixed(2)}`;
            document.getElementById('summaryTotal').innerHTML = `&euro;${total.toFixed(2)}`;
        }

        function updateSummary() {
            if (isCustomAmount) {
                updateCustomSummary();
                return;
            }

            const nights = calculateNights();
            const selectedRoom = document.querySelector('.room-option.selected');
            const roomType = selectedRoom ? selectedRoom.dataset.room : 'studio';
            const checkin = document.getElementById('checkin').value;
            const checkout = document.getElementById('checkout').value;

            let rawSubtotal = currentPrice * nights;
            const discount = rawSubtotal * promoDiscount;
            const subtotal = rawSubtotal - discount;
            const tax = subtotal * CITY_TAX_RATE;
            const total = subtotal + tax;
            const dr=document.getElementById('discountRow'); if(discount>0){ dr.style.display='flex'; document.getElementById('discountCode').textContent='('+promoApplied+')'; document.getElementById('summaryDiscount').textContent='-€'+discount.toFixed(2); } else dr.style.display='none';

            document.getElementById('summaryRoom').textContent = roomNames[roomType]+(promoApplied?' • '+promoApplied:'');
            document.getElementById('summaryCheckin').textContent = checkin || '-';
            document.getElementById('summaryCheckout').textContent = checkout || '-';
            document.getElementById('summaryNights').textContent = nights;
            document.getElementById('summaryGuests').textContent = guestCount;
            document.getElementById('summaryRate').innerHTML = `&euro;${currentPrice}`;
            document.getElementById('summarySubtotal').innerHTML = `&euro;${subtotal.toFixed(2)}`;
            document.getElementById('summaryTax').innerHTML = `&euro;${tax.toFixed(2)}`;
            document.getElementById('summaryTotal').innerHTML = `&euro;${total.toFixed(2)}`;
        }

        // Set min date to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('checkin').min = today;
        document.getElementById('checkout').min = today;

        // Update checkout min when checkin changes
        document.getElementById('checkin').addEventListener('change', function () {
            const nextDay = new Date(this.value);
            nextDay.setDate(nextDay.getDate() + 1);
            document.getElementById('checkout').min = nextDay.toISOString().split('T')[0];

            // If checkout is before new checkin, reset it
            const checkout = document.getElementById('checkout');
            if (checkout.value && checkout.value <= this.value) {
                checkout.value = nextDay.toISOString().split('T')[0];
            }
            updateSummary();
        });

        document.getElementById('checkout').addEventListener('change', updateSummary);

        // Custom amount input listener
        document.getElementById('customAmount').addEventListener('input', updateCustomSummary);

        // Handle form submission - use sessionStorage instead of URL
        document.getElementById('bookingForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            // Validate terms checkbox
            if (!document.getElementById('terms').checked) {
                alert('Please agree to the Terms of Service, Privacy Policy, and Refund Policy.');
                return;
            }

            const submitBtn = document.getElementById('submitBtn');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            submitBtn.disabled = true;

            const selectedRoom = document.querySelector('.room-option.selected');
            const roomType = selectedRoom ? selectedRoom.dataset.room : 'studio';

            let subtotal, tax, total, nights, guests, checkin, checkout;

            if (roomType === 'custom') {
                const customAmount = parseFloat(document.getElementById('customAmount').value);
                if (!customAmount || customAmount < 0.50) {
                    alert('Please enter an amount of at least €0.50');
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    return;
                }
                const disc = customAmount * promoDiscount;
                subtotal = customAmount - disc;
                tax = subtotal * CITY_TAX_RATE;
                total = subtotal + tax;
                nights = 1;
                guests = 1;
                checkin = '';
                checkout = '';
            } else {
                nights = calculateNights();
                let raw = currentPrice * nights;
                const disc = raw * promoDiscount;
                subtotal = raw - disc;
                tax = subtotal * CITY_TAX_RATE;
                total = subtotal + tax;
                guests = guestCount;
                checkin = document.getElementById('checkin').value;
                checkout = document.getElementById('checkout').value;

                if (!checkin || !checkout) {
                    alert('Please select check-in and check-out dates');
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    return;
                }
            }

            const formData = {
                roomType,
                roomName: roomNames[roomType],
                pricePerNight: roomType === 'custom' ? subtotal : currentPrice,
                checkin,
                checkout,
                nights,
                guests,
                customAmount: roomType === 'custom' ? (parseFloat(document.getElementById('customAmount').value) || 0) : 0,
                promo: promoApplied,
                firstName: document.getElementById('firstName').value,
                lastName: document.getElementById('lastName').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                requests: document.getElementById('requests').value,
                subtotal,
                tax,
                total
            };

            try {
                // Store in sessionStorage instead of URL
                sessionStorage.setItem('bookingData', JSON.stringify(formData));
                window.location.href = "{{ route('pay') }}";
            } catch (err) {
                alert('Error: ' + err.message);
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });

        // Check for successful payment
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('success') === 'true') {
            const paymentIntentId = urlParams.get('payment_intent');

            // Sanitize payment intent ID to prevent XSS
            const sanitize = (str) => {
                const div = document.createElement('div');
                div.textContent = str;
                return div.innerHTML;
            };
            const safeId = paymentIntentId ? sanitize(paymentIntentId) : 'N/A';

            sessionStorage.removeItem('bookingData');
            document.getElementById('bookingContent').innerHTML = `
                <div style="grid-column: 1/-1; text-align: center; padding: 60px 20px;">
                    <div style="width: 80px; height: 80px; background: #38a169; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                        <i class="fas fa-check" style="color: white; font-size: 40px;"></i>
                    </div>
                    <h1 style="font-size: 28px; margin-bottom: 16px; color: var(--text);">Booking Confirmed!</h1>
                    <p style="font-size: 16px; color: var(--text-muted); margin-bottom: 8px;">Thank you for your booking. Our team will be in touch to confirm the details.</p>
                    <p style="font-size: 14px; color: var(--text-muted); margin-bottom: 24px;"><strong>Reference:</strong> ${safeId}</p>
                    <a href="{{ route('home') }}" class="btn btn-primary btn-lg">Return Home</a>
                </div>
            `;
        } else if (urlParams.get('cancelled') === 'true') {
            sessionStorage.removeItem('bookingData');
            document.getElementById('bookingContent').innerHTML = `
                <div style="grid-column: 1/-1; text-align: center; padding: 60px 20px;">
                    <div style="width: 80px; height: 80px; background: #e53e3e; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                        <i class="fas fa-times" style="color: white; font-size: 40px;"></i>
                    </div>
                    <h1 style="font-size: 28px; margin-bottom: 16px; color: var(--text);">Payment Cancelled</h1>
                    <p style="font-size: 16px; color: var(--text-muted); margin-bottom: 24px;">No charges were made.</p>
                    <a href="{{ route('booking') }}" class="btn btn-primary btn-lg">Try Again</a>
                </div>
            `;
        } else {
            // Prefill from index search widget
            try {
                const sd = JSON.parse(sessionStorage.getItem('searchDates')||'null');
                if(sd){
                    if(sd.checkin) document.getElementById('checkin').value = sd.checkin;
                    if(sd.checkout) document.getElementById('checkout').value = sd.checkout;
                    if(sd.guests){ guestCount = sd.guests; document.getElementById('guestCount').textContent=guestCount; document.getElementById('guests').value=guestCount; }
                    if(sd.promo){ document.getElementById('promoInput').value = sd.promo; applyPromo(); }
                }
            } catch(e){}
            updateSummary();
        }
    </script>
@endsection
