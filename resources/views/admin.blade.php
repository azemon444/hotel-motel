<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="csrf-token" content="{{ csrf_token() }}"><meta name="robots" content="noindex, nofollow"><link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}"><link rel="stylesheet" href="{{ asset('css/styles.css') }}"><link rel="stylesheet" href="{{ asset('css/admin.css') }}"><link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"><title>Admin | Sardar Catering Amsterdam</title></head><body class="admin-body">
<!-- Login Form -->
    <div id="loginForm" class="login-box">
        <div class="icon">
            <i class="fas fa-lock"></i>
        </div>
        <h2>Admin Login</h2>
        <div id="errorMsg" class="error-msg" style="display: none;"></div>
        <input type="password" id="password" placeholder="Enter admin password" aria-label="Admin password">
        <button type="button" onclick="login()">Login</button>
    </div>

    <!-- Admin Panel -->
    <div id="adminPanel" class="admin-wrapper" style="display: none;">
        <div class="admin-header">
            <h1><i class="fas fa-chart-line"></i> Payment Dashboard</h1>
            <div class="stats">
                <div class="stat-box">
                    <div class="number" id="statTotal">0</div>
                    <div class="label">Total Bookings</div>
                </div>
                <div class="stat-box">
                    <div class="number" id="statPaid">0</div>
                    <div class="label">Paid</div>
                </div>
                <div class="stat-box">
                    <div class="number" id="statPending">0</div>
                    <div class="label">Pending</div>
                </div>
                <div class="stat-box">
                    <div class="number" id="statFailed">0</div>
                    <div class="label">Failed</div>
                </div>
                <div class="stat-box">
                    <div class="number" id="statRefunded">0</div>
                    <div class="label">Refunded</div>
                </div>
                <div class="stat-box">
                    <div class="number" id="statRevenue">€0</div>
                    <div class="label">Revenue</div>
                </div>
            </div>
            <button class="btn-logout" onclick="logout()">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </div>

        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <button class="filter-tab active" onclick="filterBookings('all', event)">
                <i class="fas fa-list"></i> All <span class="count" id="countAll">0</span>
            </button>
            <button class="filter-tab" onclick="filterBookings('paid', event)">
                <i class="fas fa-check-circle"></i> Paid <span class="count" id="countPaid">0</span>
            </button>
            <button class="filter-tab" onclick="filterBookings('pending', event)">
                <i class="fas fa-clock"></i> Pending <span class="count" id="countPending">0</span>
            </button>
            <button class="filter-tab" onclick="filterBookings('failed', event)">
                <i class="fas fa-times-circle"></i> Failed <span class="count" id="countFailed">0</span>
            </button>
            <button class="filter-tab" onclick="filterBookings('refunded', event)">
                <i class="fas fa-undo"></i> Refunded <span class="count" id="countRefunded">0</span>
            </button>
            <button class="filter-tab" onclick="filterBookings('cancelled', event)">
                <i class="fas fa-ban"></i> Cancelled <span class="count" id="countCancelled">0</span>
            </button>
        </div>

        <!-- Bookings Container -->
        <div class="bookings-container">
            <div id="bookingsList" class="no-bookings">
                <i class="fas fa-spinner fa-spin"></i>
                <p>Loading bookings...</p>
            </div>
        </div>
    </div>

    <script>
        let csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
        let allBookings = [];
        let currentFilter = 'all';

        async function login() {
            const password = document.getElementById('password').value;
            const errorDiv = document.getElementById('errorMsg');

            try {
                const response = await fetch("{{ route('admin.bookings') }}", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ password })
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    if (data.token) csrfToken = data.token;
                    document.getElementById('loginForm').style.display = 'none';
                    document.getElementById('adminPanel').style.display = 'block';
                    loadBookings();
                } else {
                    errorDiv.textContent = data.error || 'Invalid password';
                    errorDiv.style.display = 'block';
                }
            } catch (error) {
                errorDiv.textContent = 'Connection error';
                errorDiv.style.display = 'block';
            }
        }

        async function logout() {
            await fetch("{{ route('admin.bookings') }}", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ logout: true })
            });
            location.reload();
        }

        async function loadBookings() {
            try {
                const response = await fetch("{{ route('admin.bookings') }}");
                const bookings = await response.json();
                
                if (bookings.error) {
                    location.reload();
                    return;
                }
                
                allBookings = bookings;
                updateStats();
                renderBookings();
                
            } catch (error) {
                document.getElementById('bookingsList').innerHTML = 
                    '<div class="no-bookings"><i class="fas fa-exclamation-triangle"></i><p>Error loading bookings</p></div>';
            }
        }

        function updateStats() {
            const total = allBookings.length;
            const paid = allBookings.filter(b => b.payment.status === 'paid').length;
            const pending = allBookings.filter(b => b.payment.status === 'pending').length;
            const failed = allBookings.filter(b => b.payment.status === 'failed').length;
            const refunded = allBookings.filter(b => b.payment.status === 'refunded').length;
            const revenue = allBookings
                .filter(b => b.payment.status === 'paid' || b.payment.status === 'refunded')
                .reduce((sum, b) => sum + ((b.payment.amount || 0) - (b.payment.refunded_amount || 0)), 0);
            
            document.getElementById('statTotal').textContent = total;
            document.getElementById('statPaid').textContent = paid;
            document.getElementById('statPending').textContent = pending;
            document.getElementById('statFailed').textContent = failed;
            document.getElementById('statRefunded').textContent = refunded;
            document.getElementById('statRevenue').textContent = '€' + revenue.toFixed(2);
            
            document.getElementById('countAll').textContent = total;
            document.getElementById('countPaid').textContent = paid;
            document.getElementById('countPending').textContent = pending;
            document.getElementById('countFailed').textContent = failed;
            document.getElementById('countRefunded').textContent = refunded;
            document.getElementById('countCancelled').textContent = 
                allBookings.filter(b => b.payment.status === 'cancelled').length;
        }

        function filterBookings(filter, event) {
            currentFilter = filter;
            
            document.querySelectorAll('.filter-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            if (event && event.currentTarget) {
                event.currentTarget.classList.add('active');
            }
            
            renderBookings();
        }

        function renderBookings() {
            const container = document.getElementById('bookingsList');
            
            let filtered = allBookings;
            if (currentFilter !== 'all') {
                filtered = allBookings.filter(b => b.payment.status === currentFilter);
            }
            
            if (filtered.length === 0) {
                container.innerHTML = '<div class="no-bookings"><i class="fas fa-inbox"></i><p>No bookings found</p></div>';
                return;
            }
            
            // Sort by date, newest first
            filtered.sort((a, b) => new Date(b.date) - new Date(a.date));
            
            container.innerHTML = `
                <table class="bookings-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Guest</th>
                            <th>Room</th>
                            <th>Amount</th>
                            <th>Payment ID</th>
                            <th>Status</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${filtered.map((b, idx) => `
                            <tr class="booking-row" data-idx="${idx}">
                                <td>${escapeHtml(b.payment.created || b.date)}</td>
                                <td>
                                    <strong>${escapeHtml(b.customer.name)}</strong><br>
                                    <small style="color: #64748b;">${escapeHtml(b.customer.email)}</small><br>
                                    <small style="color: #94a3b8;">${escapeHtml(b.customer.phone || 'N/A')}</small>
                                </td>
                                <td>
                                    ${escapeHtml(b.booking.roomName)}<br>
                                    <small style="color: #64748b;">
                                        ${b.booking.checkin ? escapeHtml(b.booking.checkin) + ' to ' + escapeHtml(b.booking.checkout) : 'N/A'}
                                    </small>
                                </td>
                                <td>
                                    <strong>${escapeHtml(b.payment.currency)} ${(b.payment.amount || 0).toFixed(2)}</strong>
                                    ${b.payment.subtotal ? `<br><small style="color: #64748b;">Sub: €${b.payment.subtotal.toFixed(2)} + Tax: €${b.payment.tax.toFixed(2)}</small>` : ''}
                                </td>
                                <td>
                                    <small style="font-family: monospace; font-size: 12px;">
                                        ${escapeHtml(b.payment.payment_intent || 'N/A')}
                                    </small>
                                </td>
                                <td>
                                    <span class="status-badge status-${escapeHtml(b.payment.status)}">
                                        <i class="fas fa-${getStatusIcon(b.payment.status)}"></i>
                                        ${escapeHtml(b.payment.status)}
                                    </span>
                                    ${b.payment.failure_code ? `<br><small style="color: #991b1b;">${escapeHtml(b.payment.failure_code)}</small>` : ''}
                                </td>
                                <td>
                                    <button class="expand-btn" onclick="toggleDetails(this, ${idx})">
                                        <i class="fas fa-chevron-down"></i> View
                                    </button>
                                </td>
                            </tr>
                            <tr class="booking-details" id="details-${idx}">
                                <td colspan="7">
                                    ${renderBookingDetails(b)}
                                </td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            `;
        }

        function getStatusIcon(status) {
            const icons = {
                'paid': 'check-circle',
                'pending': 'clock',
                'failed': 'times-circle',
                'refunded': 'undo',
                'cancelled': 'ban',
                'disputed': 'exclamation-triangle',
                'requires_action': 'question-circle'
            };
            return icons[status] || 'circle';
        }

        function toggleDetails(btn, idx) {
            const detailsRow = document.getElementById(`details-${idx}`);
            const isActive = detailsRow.classList.contains('active');
            
            // Close all other details
            document.querySelectorAll('.booking-details').forEach(row => {
                row.classList.remove('active');
            });
            document.querySelectorAll('.expand-btn').forEach(button => {
                button.innerHTML = '<i class="fas fa-chevron-down"></i> View';
            });
            
            if (!isActive) {
                detailsRow.classList.add('active');
                btn.innerHTML = '<i class="fas fa-chevron-up"></i> Hide';
            }
        }

        function renderBookingDetails(booking) {
            const payment = booking.payment;
            const history = booking.payment_history || [];
            
            let html = `
                <div class="details-grid">
                    <!-- Customer Details -->
                    <div class="detail-section">
                        <h4><i class="fas fa-user"></i> Customer Details</h4>
                        <div class="detail-row">
                            <span class="label">Name</span>
                            <span class="value">${escapeHtml(booking.customer.name)}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Email</span>
                            <span class="value">${escapeHtml(booking.customer.email)}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Phone</span>
                            <span class="value">${escapeHtml(booking.customer.phone || 'N/A')}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">IP Address</span>
                            <span class="value">${escapeHtml(history[0]?.ip || 'N/A')}</span>
                        </div>
                    </div>
                    
                    <!-- Booking Details -->
                    <div class="detail-section">
                        <h4><i class="fas fa-bed"></i> Booking Details</h4>
                        <div class="detail-row">
                            <span class="label">Booking ID</span>
                            <span class="value" style="font-family: monospace; font-size: 12px;">${escapeHtml(booking.id)}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Room Type</span>
                            <span class="value">${escapeHtml(booking.booking.roomName)}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Check-in</span>
                            <span class="value">${escapeHtml(booking.booking.checkin || 'N/A')}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Check-out</span>
                            <span class="value">${escapeHtml(booking.booking.checkout || 'N/A')}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Nights</span>
                            <span class="value">${escapeHtml(String(booking.booking.nights || 'N/A'))}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Guests</span>
                            <span class="value">${escapeHtml(String(booking.booking.guests || 'N/A'))}</span>
                        </div>
                        ${booking.booking.requests ? `
                        <div class="detail-row">
                            <span class="label">Special Requests</span>
                            <span class="value">${escapeHtml(booking.booking.requests)}</span>
                        </div>
                        ` : ''}
                    </div>
                    
                    <!-- Payment Details -->
                    <div class="detail-section">
                        <h4><i class="fas fa-credit-card"></i> Payment Details</h4>
                        <div class="detail-row">
                            <span class="label">Amount</span>
                            <span class="value" style="font-size: 18px; color: #1e293b;">${escapeHtml(payment.currency)} ${(payment.amount || 0).toFixed(2)}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Subtotal</span>
                            <span class="value">€${(payment.subtotal || 0).toFixed(2)}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Tax (7%)</span>
                            <span class="value">€${(payment.tax || 0).toFixed(2)}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Amount Received</span>
                            <span class="value">${payment.amount_received != null ? '€' + payment.amount_received.toFixed(2) : 'N/A'}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Stripe Fee</span>
                            <span class="value">${payment.stripe_fee != null ? '€' + payment.stripe_fee.toFixed(2) : 'N/A'}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Net Payout</span>
                            <span class="value">${payment.net_amount != null ? '€' + payment.net_amount.toFixed(2) : 'N/A'}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Refunded</span>
                            <span class="value">${payment.refunded_amount > 0 ? '€' + payment.refunded_amount.toFixed(2) + ' (' + escapeHtml(payment.refund_status || '') + ')' : '€0.00'}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Payment Intent</span>
                            <span class="value" style="font-family: monospace; font-size: 11px;">${escapeHtml(payment.payment_intent || 'N/A')}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Stripe Status</span>
                            <span class="value">${escapeHtml(payment.stripe_status || 'N/A')}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Payment Method</span>
                            <span class="value">${escapeHtml(payment.payment_method || 'N/A')}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Card</span>
                            <span class="value">${payment.card_brand ? escapeHtml(payment.card_brand.toUpperCase()) + ' •••• ' + escapeHtml(payment.card_last4 || '') : 'N/A'}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Charge ID</span>
                            <span class="value" style="font-family: monospace; font-size: 11px;">${escapeHtml(payment.stripe_charge_id || 'N/A')}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Receipt</span>
                            <span class="value">${payment.receipt_url ? `<a href="${escapeHtml(payment.receipt_url)}" target="_blank" rel="noopener">View receipt <i class="fas fa-external-link-alt"></i></a>` : 'N/A'}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Stripe</span>
                            <span class="value">${payment.dashboard_url ? `<a href="${escapeHtml(payment.dashboard_url)}" target="_blank" rel="noopener">Open in Dashboard <i class="fas fa-external-link-alt"></i></a>` : 'N/A'}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Created</span>
                            <span class="value">${escapeHtml(payment.created)}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Last Updated</span>
                            <span class="value">${escapeHtml(payment.updated || payment.created)}</span>
                        </div>
                    </div>
                </div>
            `;
            
            // Error Details (if failed)
            if (payment.status === 'failed' && payment.failure_message) {
                html += `
                    <div class="error-box" style="margin-top: 16px;">
                        <h5><i class="fas fa-exclamation-circle"></i> Payment Failure Details</h5>
                        <p><strong>Error:</strong> ${escapeHtml(payment.failure_message)}</p>
                        ${payment.failure_code ? `<p><strong>Code:</strong> ${escapeHtml(payment.failure_code)}</p>` : ''}
                        ${payment.failure_decline_code ? `<p><strong>Decline Code:</strong> ${escapeHtml(payment.failure_decline_code)}</p>` : ''}
                    </div>
                `;
            }
            
            // Refunds
            if ((payment.refunds || []).length > 0) {
                html += `
                    <div class="detail-section" style="margin-top: 16px;">
                        <h4><i class="fas fa-undo"></i> Refunds</h4>
                        <div class="payment-history">
                            ${payment.refunds.map(r => `
                                <div class="history-item">
                                    <div class="history-dot info"></div>
                                    <div class="history-content">
                                        <div class="history-message">€${(r.amount || 0).toFixed(2)} ${escapeHtml(r.currency || '')} ${r.status ? '• ' + escapeHtml(r.status) : ''}</div>
                                        <div class="history-time">${escapeHtml(r.id || 'N/A')}${r.reason ? ' • ' + escapeHtml(r.reason) : ''}${r.created ? ' • ' + escapeHtml(r.created) : ''}</div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
            }

            // Payment History
            if (history.length > 0) {
                html += `
                    <div class="detail-section" style="margin-top: 16px;">
                        <h4><i class="fas fa-history"></i> Payment History</h4>
                        <div class="payment-history">
                            ${history.map(h => `
                                <div class="history-item">
                                    <div class="history-dot ${h.status === 'paid' ? 'success' : h.status === 'failed' ? 'error' : h.status === 'pending' ? 'pending' : 'info'}"></div>
                                    <div class="history-content">
                                        <div class="history-message">
                                            ${escapeHtml(h.message)}
                                            ${h.code ? `<span class="history-code">${escapeHtml(h.code)}</span>` : ''}
                                            ${h.decline_code ? `<span class="history-code">${escapeHtml(h.decline_code)}</span>` : ''}
                                        </div>
                                        <div class="history-time">
                                            ${escapeHtml(h.timestamp)}
                                            ${h.ip ? ` • IP: ${escapeHtml(h.ip)}` : ''}
                                            ${h.stripe_event ? ` • Event: ${escapeHtml(h.stripe_event)}` : ''}
                                        </div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
            }
            
            return html;
        }

        function escapeHtml(text) {
            if (text === null || text === undefined) return 'N/A';
            const div = document.createElement('div');
            div.textContent = String(text);
            return div.innerHTML;
        }

        document.getElementById('password').addEventListener('keypress', (e) => {
            if (e.key === 'Enter') login();
        });

        // Check if already logged in
        fetch("{{ route('admin.bookings') }}").then(r => {
            if (r.ok) {
                document.getElementById('loginForm').style.display = 'none';
                document.getElementById('adminPanel').style.display = 'block';
                loadBookings();
            }
            // If not ok, login form remains visible (correct behavior)
        }).catch(() => {
            // Network error - leave login form visible
        });
    </script>
<script src="{{ asset('js/script.js') }}"></script></body></html>