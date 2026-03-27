
document.addEventListener('DOMContentLoaded', () => {

  const preloader = document.getElementById('preloader');


  if (typeof lottie !== 'undefined' && document.getElementById('lottie-loader')) {
    lottie.loadAnimation({
      container:  document.getElementById('lottie-loader'),
      renderer:   'svg',
      loop:       true,
      autoplay:   true,
      path:       'https://assets9.lottiefiles.com/packages/lf20_jbb6jwx1.json'
    });
  }

  window.addEventListener('load', () => {
    setTimeout(() => {
      preloader?.classList.add('hide');
    }, 800);
  });

  const header = document.getElementById('siteHeader');

  const updateHeader = () => {
    if (window.scrollY > 30) {
      header?.classList.add('scrolled');
      header?.classList.remove('at-top');
    } else {
      header?.classList.remove('scrolled');
      header?.classList.add('at-top');
    }
  };

  header?.classList.add('at-top');
  window.addEventListener('scroll', updateHeader, { passive: true });
  updateHeader();

  const menuToggle = document.getElementById('menuToggle');
  const nav        = document.getElementById('nav');

  menuToggle?.addEventListener('click', () => {
    nav?.classList.toggle('active');
  });

  document.addEventListener('click', (e) => {
    if (!menuToggle?.contains(e.target) && !nav?.contains(e.target)) {
      nav?.classList.remove('active');
    }
  });

  nav?.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      nav.classList.remove('active');
    });
  });

  const form      = document.getElementById('pickupForm');
  const submitBtn = document.getElementById('submitBtn');

  if (form && submitBtn) {
    form.addEventListener('submit', () => {
      if (form.checkValidity()) {
        const btnText   = submitBtn.querySelector('.btn-text');
        const btnLoader = submitBtn.querySelector('.btn-loader');
        submitBtn.disabled    = true;
        if (btnText)   btnText.style.display   = 'none';
        if (btnLoader) btnLoader.style.display = 'inline';
      }
    });
  }

  const qty = document.querySelector('input[name="quantity"]');
  if (qty) {
    qty.addEventListener('input', () => {
      if (parseFloat(qty.value) < 1) qty.value = 1;
    });
  }

  document.querySelectorAll('.pickup-alert').forEach(el => {
    setTimeout(() => {
      el.style.transition = 'opacity 0.5s ease, max-height 0.5s ease, margin 0.5s ease, padding 0.5s ease';
      el.style.opacity    = '0';
      el.style.maxHeight  = '0';
      el.style.overflow   = 'hidden';
      el.style.margin     = '0';
      el.style.padding    = '0';
      setTimeout(() => el.remove(), 500);
    }, 6000);
  });

});