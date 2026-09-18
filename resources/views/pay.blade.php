<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="csrf-token" content="{{ csrf_token() }}"><meta name="description" content="Secure Stripe checkout for your Sardar Catering Amsterdam suite booking."><link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}"><link rel="stylesheet" href="{{ asset('css/styles.css') }}"><link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"><title>Secure Checkout | Sardar Catering Amsterdam</title><script src="https://js.stripe.com/v3/"></script></head><body>
<div class="payment-wrapper">
        <div class="payment-card" id="paymentCard">
            <div class="payment-header">
                <a href="{{ route('booking') }}" class="back-link"><i class="fas fa-arrow-left"></i> Back to booking</a>
                <div class="logo">
                    <i class="fas fa-lock"></i>
                </div>
                <h1>Secure Checkout</h1>
                <p>Your payment is encrypted and secure</p>
            </div>

            <div class="payment-body">
                <div class="amount-display">
                    <span class="currency">EUR</span>
                    <span class="amount" id="paymentAmount">0.00</span>
                    <div class="period">Total amount</div>
                </div>

                <div class="booking-summary" id="paymentSummary">
                    <h3>Booking Summary</h3>
                    <div class="summary-row">
                        <span class="label">Room</span>
                        <span class="value" id="summaryRoom">-</span>
                    </div>
                    <div class="summary-row">
                        <span class="label">Dates</span>
                        <span class="value" id="summaryDates">-</span>
                    </div>
                    <div class="summary-row">
                        <span class="label">Nights</span>
                        <span class="value" id="summaryNights">-</span>
                    </div>
                    <div class="summary-row">
                        <span class="label">Guests</span>
                        <span class="value" id="summaryGuests">-</span>
                    </div>
                    <div class="summary-row">
                        <span class="label">Subtotal</span>
                        <span class="value" id="summarySubtotal">-</span>
                    </div>
                    <div class="summary-row">
                        <span class="label">City tax (7%)</span>
                        <span class="value" id="summaryTax">-</span>
                    </div>
                    <div class="summary-row total">
                        <span class="label">Total</span>
                        <span class="value" id="summaryTotal">-</span>
                    </div>
                </div>

                <!-- Stripe Error Display -->
                <div id="stripeError" class="error-display">
                    <div class="error-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h2>Payment Unavailable</h2>
                    <p id="stripeErrorMessage">Unable to load payment form. Please try again.</p>
                    <button onclick="location.reload()" class="retry-button">
                        <i class="fas fa-redo"></i> Retry
                    </button>
                </div>

                <!-- Loading State -->
                <div id="stripeLoading" style="text-align: center; padding: 40px;">
                    <div class="processing-spinner"></div>
                    <p style="color: #718096; font-size: 14px;">Loading secure payment form...</p>
                </div>

                <form id="paymentForm" style="display: none;">
                    <div class="form-section">
                        <h3>Cardholder Information</h3>
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" id="cardName" placeholder="John Smith" required>
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" id="cardEmail" placeholder="john@example.com" required>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Card Details</h3>
                        <div class="card-element-group">
                            <div class="card-element-wrapper">
                                <label>Card Number</label>
                                <div id="card-number"></div>
                            </div>
                            <div class="card-element-row">
                                <div class="card-element-wrapper">
                                    <label>Expiry Date</label>
                                    <div id="card-expiry"></div>
                                </div>
                                <div class="card-element-wrapper">
                                    <label>CVC</label>
                                    <div id="card-cvc"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="card-errors" class="card-errors"></div>

                    <button type="submit" class="pay-button" id="submitPayment">
                        <i class="fas fa-lock"></i>
                        <span>Pay Now</span>
                    </button>
                </form>

                <div class="security-info">
                    <span class="security-item"><i class="fas fa-shield-alt"></i> Secure connection</span>
                    <span class="security-item"><i class="fas fa-lock"></i> Card data handled by Stripe</span>
                    <span class="security-item"><i class="fab fa-stripe"></i> Stripe</span>
                </div>
            </div>
        </div>

        <div class="processing-overlay" id="processingOverlay">
            <div class="processing-box">
                <div class="processing-spinner"></div>
                <h3>Processing Payment...</h3>
                <p>Please wait while we secure your booking.</p>
            </div>
        </div>
    </div>

    <script>
        let stripe = null;
        let elements = null;
        let cardNumber = null;
        let cardExpiry = null;
        let cardCvc = null;
        let stripeInitialized = false;

        // Read booking data from sessionStorage
        const bookingDataStr = sessionStorage.getItem('bookingData');

        if (!bookingDataStr) {
            document.getElementById('paymentCard').innerHTML = `
                <div class="error-display active">
                    <div class="error-icon">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                    <h2>No Booking Data</h2>
                    <p>Please start from the booking page to make a payment.</p>
                    <a href="{{ route('booking') }}" class="retry-button">
                        <i class="fas fa-arrow-left"></i> Go to Booking
                    </a>
                </div>
            `;
        } else {
            initPayment(JSON.parse(bookingDataStr));
        }

        async function initPayment(bookingData) {
            const amount = bookingData.total;
            window.bookingData = bookingData;
            window.paymentAmount = amount;

            // Display amount and summary
            document.getElementById('paymentAmount').textContent = amount.toFixed(2);

            document.getElementById('summaryRoom').textContent = bookingData.roomName;

            if (bookingData.roomType === 'custom') {
                document.getElementById('summaryDates').textContent = '-';
                document.getElementById('summaryNights').textContent = '-';
                document.getElementById('summaryGuests').textContent = '-';
            } else {
                document.getElementById('summaryDates').textContent = bookingData.checkin + ' to ' + bookingData.checkout;
                document.getElementById('summaryNights').textContent = bookingData.nights;
                document.getElementById('summaryGuests').textContent = bookingData.guests;
            }

            document.getElementById('summarySubtotal').textContent = 'EUR ' + bookingData.subtotal.toFixed(2);
            document.getElementById('summaryTax').textContent = 'EUR ' + bookingData.tax.toFixed(2);
            document.getElementById('summaryTotal').textContent = 'EUR ' + bookingData.total.toFixed(2);

            document.getElementById('cardName').value = bookingData.firstName + ' ' + bookingData.lastName;
            document.getElementById('cardEmail').value = bookingData.email;

            if (amount < 0.50) {
                document.getElementById('stripeLoading').style.display = 'none';
                document.getElementById('paymentForm').style.display = 'none';
                showStripeError('Minimum payment amount is €0.50. Please go back and adjust your booking.');
                return;
            }

        function showStripeError(message) {
            document.getElementById('stripeLoading').style.display = 'none';
            document.getElementById('paymentForm').style.display = 'none';
            document.getElementById('stripeError').classList.add('active');
            document.getElementById('stripeErrorMessage').textContent = message;
        }

        async function initializeStripe() {
            if (typeof Stripe === 'undefined') {
                showStripeError('Payment system failed to load. Please disable ad blockers and refresh.');
                return false;
            }

            const pk = "{{ config('services.stripe.key') }}";
            if (!pk || pk.includes('YOUR_') || pk.includes('replace_me')) {
                showStripeError('Payment system not configured. Please contact support.');
                return false;
            }

            try {
                stripe = Stripe(pk);

                elements = stripe.elements({
                    appearance: {
                        theme: 'none',
                        variables: {
                            colorPrimary: '#667eea',
                            colorBackground: '#ffffff',
                            colorText: '#2d3748',
                            colorDanger: '#e53e3e',
                            fontFamily: 'Inter, sans-serif',
                            borderRadius: '8px',
                            spacingUnit: '4px',
                            spacingGridRow: '16px',
                        },
                        rules: {
                            '.Input': {
                                border: 'none',
                                boxShadow: 'none',
                                padding: '0',
                            },
                            '.Input:focus': {
                                border: 'none',
                                boxShadow: 'none',
                            }
                        }
                    }
                });

                cardNumber = elements.create('cardNumber', {
                    style: {
                        base: {
                            fontSize: '16px',
                            color: '#2d3748',
                            '::placeholder': { color: '#a0aec0' }
                        }
                    }
                });
                cardExpiry = elements.create('cardExpiry', {
                    style: {
                        base: {
                            fontSize: '16px',
                            color: '#2d3748',
                            '::placeholder': { color: '#a0aec0' }
                        }
                    }
                });
                cardCvc = elements.create('cardCvc', {
                    style: {
                        base: {
                            fontSize: '16px',
                            color: '#2d3748',
                            '::placeholder': { color: '#a0aec0' }
                        }
                    }
                });

                await Promise.all([
                    cardNumber.mount('#card-number'),
                    cardExpiry.mount('#card-expiry'),
                    cardCvc.mount('#card-cvc')
                ]);

                [cardNumber, cardExpiry, cardCvc].forEach(el => {
                    el.on('change', (event) => {
                        const displayError = document.getElementById('card-errors');
                        if (event.error) {
                            displayError.textContent = event.error.message;
                            displayError.style.display = 'block';
                        } else {
                            displayError.textContent = '';
                            displayError.style.display = 'none';
                        }
                    });
                });

                stripeInitialized = true;
                document.getElementById('stripeLoading').style.display = 'none';
                document.getElementById('paymentForm').style.display = 'block';
                return true;

            } catch (err) {
                console.error('Stripe init error:', err);
                showStripeError('Failed to initialize payment form: ' + err.message);
                return false;
            }
        }

        // Initialize Stripe
        await initializeStripe();
    }

    // Initialize payment is triggered from the sessionStorage check above

    async function getClientSecret(bookingData) {
            const isCustom = bookingData.roomType === 'custom';
            const response = await fetch('/api/create-payment-intent', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
                body: JSON.stringify({
                    roomType: bookingData.roomType,
                    roomName: bookingData.roomName,
                    checkin: bookingData.checkin || '',
                    checkout: bookingData.checkout || '',
                    guests: bookingData.guests || 1,
                    firstName: bookingData.firstName,
                    lastName: bookingData.lastName,
                    email: bookingData.email,
                    phone: bookingData.phone,
                    requests: bookingData.requests || '',
                    promo: bookingData.promo || '',
                    amount: isCustom ? (bookingData.customAmount || 0) : undefined
                })
            });
            const data = await response.json();
            if (data.error) {
                throw new Error(data.error);
            }
            return data;
        }

        function applyServerTotals(data) {
            document.getElementById('paymentAmount').textContent = data.amount.toFixed(2);
            document.getElementById('summarySubtotal').textContent = 'EUR ' + data.subtotal.toFixed(2);
            document.getElementById('summaryTax').textContent = 'EUR ' + data.tax.toFixed(2);
            document.getElementById('summaryTotal').textContent = 'EUR ' + data.amount.toFixed(2);
            window.paymentAmount = data.amount;
        }

        document.getElementById('paymentForm')?.addEventListener('submit', async (e) => {
            e.preventDefault();

            if (!stripeInitialized || !stripe || !cardNumber) {
                showStripeError('Payment form not ready. Please refresh the page.');
                return;
            }

            const submitBtn = document.getElementById('submitPayment');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Processing...</span>';

            try {
                const intent = await getClientSecret(window.bookingData);
                applyServerTotals(intent);
                window.paymentIntentId = intent.paymentIntentId;

                const { error, paymentIntent } = await stripe.confirmCardPayment(intent.clientSecret, {
                    payment_method: {
                        card: cardNumber,
                        billing_details: {
                            name: document.getElementById('cardName').value,
                            email: document.getElementById('cardEmail').value,
                        }
                    }
                });

                if (error) {
                    const failedIntentId = error.payment_intent?.id || window.paymentIntentId;
                    if (failedIntentId) {
                        try {
                            await fetch("{{ route('api.confirmBooking') }}?payment_intent=" + encodeURIComponent(failedIntentId), {
                                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' }
                            });
                        } catch (e) { }
                    }
                    var cardErrors = document.getElementById('card-errors');
                    cardErrors.textContent = error.message;
                    cardErrors.style.display = 'block';
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-lock"></i> <span>Pay Now</span>';
                } else {
                    document.getElementById('processingOverlay').classList.add('active');
                    try {
                        await fetch("{{ route('api.confirmBooking') }}?payment_intent=" + encodeURIComponent(paymentIntent.id), {
                            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' }
                        });
                    } catch (e) { }
                    sessionStorage.removeItem('bookingData');
                    window.location.href = "{{ route('booking') }}?success=true&payment_intent=" + encodeURIComponent(paymentIntent.id);
                }
            } catch (err) {
                var cardErrors2 = document.getElementById('card-errors');
                cardErrors2.textContent = err.message || 'Payment failed. Please try again.';
                cardErrors2.style.display = 'block';
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-lock"></i> <span>Pay Now</span>';
            }
        });
    </script>
<script src="{{ asset('js/script.js') }}"></script></body></html>