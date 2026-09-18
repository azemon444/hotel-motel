@extends('layouts.app')
@section('title', 'Contact | Sardar Catering Amsterdam')
@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Contact Us</h1>
            <p>We're here to help with bookings, inquiries, and more.</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="section">
        <div class="container">
            <div class="contact-grid">
                <div class="contact-info-side">
                    <h2>Get in Touch</h2>
                    <p>Have a question about our accommodations or want to make a booking? Reach out to us through any
                        of the following channels.</p>

                    <div class="contact-items">
                        <div class="contact-item">
                            <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div>
                                <h4>Address</h4>
                                <p>Ladogameerhof 174<br>1060RE Amsterdam<br>Netherlands</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon"><i class="fas fa-phone"></i></div>
                            <div>
                                <h4>Phone</h4>
                                <p><a href="tel:+31686099826">+31 6 8609 9826</a></p>
                                <p class="small">Available Mon-Sun, 8AM-10PM CET</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                            <div>
                                <h4>Email</h4>
                                <p><a href="mailto:contact@bdgss.com">contact@bdgss.com</a></p>
                                <p class="small">A member of our team will get back to you</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon"><i class="fas fa-id-card"></i></div>
                            <div>
                                <h4>Business Registration</h4>
                                <p>Business registration details withheld.</p>
                            </div>
                        </div>
                    </div>

                    <div class="business-hours">
                        <h4><i class="fas fa-clock"></i> Business Hours</h4>
                        <ul>
                            <li><span>Monday - Friday</span><span>8:00 AM - 10:00 PM</span></li>
                            <li><span>Saturday</span><span>9:00 AM - 8:00 PM</span></li>
                            <li><span>Sunday</span><span>9:00 AM - 6:00 PM</span></li>
                        </ul>
                    </div>
                </div>

                <div class="contact-form-side">
                    <h2>Send Us a Message</h2>
                    <form class="contact-form" id="contactForm" novalidate>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="firstName">First Name *</label>
                                <input type="text" id="firstName" name="firstName" required
                                    aria-describedby="firstName-error">
                                <span id="firstName-error" class="form-error" role="alert"></span>
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name *</label>
                                <input type="text" id="lastName" name="lastName" required
                                    aria-describedby="lastName-error">
                                <span id="lastName-error" class="form-error" role="alert"></span>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" id="email" name="email" required aria-describedby="email-error">
                                <span id="email-error" class="form-error" role="alert"></span>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="tel" id="phone" name="phone">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject *</label>
                            <select id="subject" name="subject" required aria-describedby="subject-error">
                                <option value="">Select a subject</option>
                                <option value="general">General Inquiry</option>
                                <option value="booking">Booking Question</option>
                                <option value="group">Group Reservation</option>
                                <option value="cancellation">Cancellation Request</option>
                                <option value="refund">Refund Request</option>
                                <option value="complaint">Feedback / Complaint</option>
                                <option value="other">Other</option>
                            </select>
                            <span id="subject-error" class="form-error" role="alert"></span>
                        </div>
                        <div class="form-group">
                            <label for="message">Message *</label>
                            <textarea id="message" name="message" rows="5" required
                                aria-describedby="message-error"></textarea>
                            <span id="message-error" class="form-error" role="alert"></span>
                        </div>
                        <input type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true"
                            style="position:absolute;left:-9999px;width:1px;height:1px;overflow:hidden">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="section section-alt">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">Our Location</span>
                <h2 class="section-title">Find Us in Amsterdam</h2>
            </div>
            <div class="map-container">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2435.8!2d4.84!3d52.34!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c609c3c1b3c3d7%3A0x0!2sAmsterdam!5e0!3m2!1sen!2snl!4v1700000000000"
                    width="100%" height="400" style="border:0; border-radius: 12px;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade" title="Sardar Catering location in Amsterdam">
                </iframe>
            </div>
            <div class="location-cards">
                <div class="location-card">
                    <i class="fas fa-train"></i>
                    <h4>Public Transport</h4>
                    <p>Multiple tram and bus stops within a 5-minute walk. Amsterdam Centraal Station is 10 minutes away by tram.</p>
                </div>
                <div class="location-card">
                    <i class="fas fa-plane"></i>
                    <h4>Airport</h4>
                    <p>Amsterdam Airport Schiphol is 20 minutes by train or 30 minutes by car.</p>
                </div>
                <div class="location-card">
                    <i class="fas fa-car"></i>
                    <h4>Parking</h4>
                    <p>Covered on-site parking is €25/day; a public garage is a 3-minute walk away.</p>
                </div>
            </div>
        </div>
    </section>

@endsection
