// Header scroll effect
const header = document.getElementById('header');
if (header) {
    window.addEventListener('scroll', () => {
        header.classList.toggle('scrolled', window.scrollY > 50);
    });
}

// Mobile menu toggle
const mobileToggle = document.getElementById('mobileToggle');
const mainNav = document.getElementById('mainNav');
if (mobileToggle && mainNav) {
    mobileToggle.addEventListener('click', () => {
        const isOpen = mainNav.classList.toggle('open');
        mobileToggle.classList.toggle('active', isOpen);
        mobileToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && mainNav.classList.contains('open')) {
            mainNav.classList.remove('open');
            mobileToggle.classList.remove('active');
            mobileToggle.setAttribute('aria-expanded', 'false');
            mobileToggle.focus();
        }
    });
}

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        if (href === '#' || href === '#main-content') return;
        e.preventDefault();
        const target = document.querySelector(href);
        if (target) {
            const headerHeight = document.querySelector('.header').offsetHeight;
            const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - headerHeight;
            window.scrollTo({ top: targetPosition, behavior: 'smooth' });
            if (mainNav) mainNav.classList.remove('open');
            if (mobileToggle) {
                mobileToggle.classList.remove('active');
                mobileToggle.setAttribute('aria-expanded', 'false');
            }
        }
    });
});

// Contact form handling
const contactForm = document.getElementById('contactForm');
if (contactForm) {
    contactForm.querySelectorAll('input, select, textarea').forEach(field => {
        field.addEventListener('input', () => {
            field.removeAttribute('aria-invalid');
            const errorEl = document.getElementById(`${field.name}-error`);
            if (errorEl) errorEl.textContent = '';
        });
    });

    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const data = Object.fromEntries(formData);
        let isValid = true;

        this.querySelectorAll('.form-error').forEach(el => el.textContent = '');
        this.querySelectorAll('[aria-invalid]').forEach(el => el.removeAttribute('aria-invalid'));

        if (!data.firstName) {
            showFieldError('firstName', 'First name is required');
            isValid = false;
        }
        if (!data.lastName) {
            showFieldError('lastName', 'Last name is required');
            isValid = false;
        }
        if (!data.email) {
            showFieldError('email', 'Email is required');
            isValid = false;
        } else {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(data.email)) {
                showFieldError('email', 'Please enter a valid email address');
                isValid = false;
            }
        }
        if (!data.subject) {
            showFieldError('subject', 'Please select a subject');
            isValid = false;
        }
        if (!data.message) {
            showFieldError('message', 'Message is required');
            isValid = false;
        }

        if (!isValid) return;

        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Sending...';
        submitBtn.disabled = true;

        fetch('/api/contact', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ ...data, source: 'contact' })
        })
            .then(response => response.json().then(body => ({ ok: response.ok, body })))
            .then(({ ok, body }) => {
                if (!ok) throw new Error(body.message || 'Something went wrong');
                showToast('Thank you! Your message has been sent. We will get back to you.');
                this.reset();
            })
            .catch(() => {
                showToast('Sorry, we could not send your message. Please try again.', 'error');
            })
            .finally(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
    });
}

// Group quote form handling
document.querySelectorAll('.groups-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const data = Object.fromEntries(new FormData(this));
        const messageParts = [];
        if (data.dates) messageParts.push(`Dates: ${data.dates}`);
        if (data.suites) messageParts.push(`Suites: ${data.suites}`);
        if (data.message) messageParts.push(data.message);

        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Sending...';
        submitBtn.disabled = true;

        fetch('/api/contact', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({
                firstName: data.firstName,
                email: data.email,
                subject: 'group',
                source: 'groups',
                website: data.website || '',
                message: messageParts.join('\n')
            })
        })
            .then(response => response.json().then(body => ({ ok: response.ok, body })))
            .then(({ ok, body }) => {
                if (!ok) throw new Error(body.message || 'Something went wrong');
                showToast('Quote requested! We will reply within 4 hours.');
                this.reset();
            })
            .catch(() => {
                showToast('Sorry, we could not send your request. Please try again.', 'error');
            })
            .finally(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
    });
});

function showFieldError(fieldName, message) {
    const field = document.querySelector(`[name="${fieldName}"]`);
    const errorEl = document.getElementById(`${fieldName}-error`);
    if (field) field.setAttribute('aria-invalid', 'true');
    if (errorEl) errorEl.textContent = message;
}

function showToast(message, type = 'success') {
    const existing = document.querySelector('.toast');
    if (existing) existing.remove();

    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.style.background = type === 'error' ? '#e53e3e' : '#38a169';

    const icon = document.createElement('i');
    icon.className = `fas fa-${type === 'error' ? 'exclamation-circle' : 'check-circle'}`;
    toast.appendChild(icon);

    toast.appendChild(document.createTextNode(' ' + message));

    document.body.appendChild(toast);

    setTimeout(() => toast.classList.add('show'), 10);
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 400);
    }, 5000);
}

function initSwipers() {
    if (typeof Swiper === 'undefined') return;

    const hero = document.querySelector('#heroSwiper');
    if (hero && !hero.swiper) {
        new Swiper(hero, {
            loop: true,
            autoplay: { delay: 5000, disableOnInteraction: false },
            pagination: { el: '#heroSwiper .swiper-pagination', clickable: true },
            navigation: { nextEl: '#heroSwiper .swiper-button-next', prevEl: '#heroSwiper .swiper-button-prev' }
        });
    }

    document.querySelectorAll('.split-image .swiper:not([id])').forEach(el => {
        if (!el.swiper) {
            new Swiper(el, {
                loop: true,
                autoplay: { delay: 4000, disableOnInteraction: false },
                pagination: { el: el.querySelector('.swiper-pagination'), clickable: true }
            });
        }
    });

    document.querySelectorAll('.card .swiper.suite-swiper').forEach(el => {
        if (!el.swiper) {
            new Swiper(el, {
                loop: true,
                autoplay: { delay: 4000, disableOnInteraction: false },
                pagination: { el: el.querySelector('.swiper-pagination'), clickable: true }
            });
        }
    });

    const reviews = document.querySelector('#reviewsSwiper');
    if (reviews && !reviews.swiper) {
        new Swiper(reviews, {
            loop: true,
            autoplay: { delay: 3500, disableOnInteraction: false },
            pagination: { el: '#reviewsSwiper .swiper-pagination', clickable: true },
            slidesPerView: 1,
            spaceBetween: 16,
            breakpoints: {
                768: { slidesPerView: 2, spaceBetween: 16 },
                1024: { slidesPerView: 3, spaceBetween: 20 }
            }
        });
    }

    document.querySelectorAll('.suite-swiper').forEach(el => {
        if (!el.swiper) {
            new Swiper(el, {
                loop: true,
                autoplay: { delay: 4000, disableOnInteraction: false },
                pagination: { el: el.querySelector('.swiper-pagination'), clickable: true },
                navigation: {
                    nextEl: el.querySelector('.swiper-button-next'),
                    prevEl: el.querySelector('.swiper-button-prev')
                }
            });
        }
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSwipers);
} else {
    initSwipers();
}
