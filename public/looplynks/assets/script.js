window.addEventListener('load', () => {
  // Check if preloader has been shown before in this session
  if (!sessionStorage.getItem('preloaderShown')) {
    // Mark as shown for this session
    sessionStorage.setItem('preloaderShown', 'true');

    const vline = document.getElementById('vline');
    const leftCurtain = document.getElementById('left-curtain');
    const rightCurtain = document.getElementById('right-curtain');
    const preloader = document.getElementById('preloader');
    const logo = document.getElementById('logoo');
    const page = document.getElementById('page');
    const header = document.getElementById('site-header');

    function finalizePreloader() {
      preloader.style.pointerEvents = 'none';
      document.body.style.overflow = 'auto';
      if (header) header.classList.remove('hidden');
      if (page) {
        page.classList.remove('invisible');
        page.classList.add('opacity-100');
      }
      setTimeout(() => { preloader.remove(); }, 2000);
    }

    // Animation sequence
    setTimeout(() => {
      logo.classList.remove('opacity-0');
      logo.classList.add('logo-scale');
    }, 100);

    setTimeout(() => {
      vline.classList.remove('opacity-100');
      vline.classList.add('opacity-100');
    }, 2000);

    setTimeout(() => {
      logo.classList.add('opacity-0');
      logo.classList.remove('logo-scale');
    }, 1550);

    setTimeout(() => {
      leftCurtain.classList.add('animate-curtain-left');
      rightCurtain.classList.add('animate-curtain-right');
      vline.classList.add('opacity-0');
      vline.classList.remove('opacity-100');
    }, 2400);

    setTimeout(() => {
      preloader.style.transition = 'opacity .2s ease';
      preloader.style.opacity = '1';
      finalizePreloader();
    }, 2600);

    setTimeout(() => {
      vline.classList.remove('opacity-0');
      vline.classList.add('h-full');
      setTimeout(() => {
        vline.querySelector('div').classList.add('animate-line-draw');
      }, 1000);
    }, 1800);
  } else {
    // If preloader was already shown, remove it immediately
    const preloader = document.getElementById('preloader');
    if (preloader) preloader.remove();
    const page = document.getElementById('page');
    const header = document.getElementById('site-header');
    if (header) header.classList.remove('hidden');
    if (page) {
      page.classList.remove('invisible');
      page.classList.add('opacity-100');
    }

    document.body.style.overflow = 'auto';
  }


  // Sticky header show on scroll
  const stickyHeader = document.getElementById('sticky-header');
  const stickyMenuBtn = document.getElementById('sticky-menu-btn');
  const stickyDropdownMenu = document.getElementById('sticky-dropdown-menu');
  const mobileMenu = document.getElementById('mobile-menu');
  const menuBtn = document.getElementById('mobile-menu-btn');
  const mobileMenuClose = document.getElementById('mobile-menu-close');
  let menuOpen = false;
  let stickyDropdownOpen = false;

  window.addEventListener('scroll', () => {
    if (window.scrollY > 80) {
      stickyHeader.classList.remove('hidden');
    } else {
      stickyHeader.classList.add('hidden');
      closeStickyDropdown();
    }
  });

  // Hamburger open/close logic for both sticky and main header
  function openMobileMenu() {
    mobileMenu.classList.remove('opacity-0', 'pointer-events-none');
    mobileMenu.classList.add('opacity-100');
    menuOpen = true;
    menuBtn.classList.add('hidden');
    if (stickyMenuBtn) stickyMenuBtn.classList.add('hidden');
    mobileMenuClose.classList.remove('hidden');
  }
  function closeMobileMenu() {
    mobileMenu.classList.add('opacity-0', 'pointer-events-none');
    mobileMenu.classList.remove('opacity-100');
    menuOpen = false;
    menuBtn.classList.remove('hidden');
    if (stickyMenuBtn) stickyMenuBtn.classList.remove('hidden');
    mobileMenuClose.classList.add('hidden');
  }
  function openStickyDropdown() {
    stickyDropdownMenu.classList.remove('hidden');
    stickyDropdownOpen = true;
  }
  function closeStickyDropdown() {
    stickyDropdownMenu.classList.add('hidden');
    stickyDropdownOpen = false;
  }


  menuBtn.addEventListener('click', () => {
    if (menuOpen) {
      closeMobileMenu();
    } else {
      openMobileMenu();
    }
  });
  if (stickyMenuBtn) {
    stickyMenuBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      if (stickyDropdownOpen) {
        closeStickyDropdown();
      } else {
        openStickyDropdown();
      }
    });
  }
  mobileMenuClose.addEventListener('click', closeMobileMenu);

  // Close menu when clicking outside
  document.addEventListener('click', (e) => {
    if (menuOpen && !mobileMenu.contains(e.target) && !menuBtn.contains(e.target) && (!stickyMenuBtn || !stickyMenuBtn.contains(e.target))) {
      closeMobileMenu();
    }
    if (stickyDropdownOpen && stickyDropdownMenu && !stickyDropdownMenu.contains(e.target) && !stickyMenuBtn.contains(e.target)) {
      closeStickyDropdown();
    }
  });
  // Prevent click inside menu from closing
  mobileMenu.addEventListener('click', (e) => {
    e.stopPropagation();
  });
  // Prevent click inside sticky dropdown from closing
  if (stickyDropdownMenu) {
    stickyDropdownMenu.addEventListener('click', (e) => {
      e.stopPropagation();
    });
  }
  // Add close button event for sticky dropdown
  const stickyDropdownClose = document.getElementById('sticky-dropdown-close');
  if (stickyDropdownClose) {
    stickyDropdownClose.addEventListener('click', closeStickyDropdown);
  }
  

  // Initialize GSAP and ScrollTrigger

  gsap.registerPlugin(ScrollTrigger);

  const cardsContainer = document.getElementById('cardsContainer');
  const hiddenCards = document.querySelectorAll('.event-card.initially-hidden');
  const allCards = document.querySelectorAll('.event-card');
  const cardsBgHeading = document.querySelector('.cards-bg-heading');
  // Remove sectionTitle logic since heading should be fixed and not animated

  // Create floating elements
  function createFloatingElements() {
    const container = document.getElementById('floatingElements');
    for (let i = 0; i < 50; i++) {
      const element = document.createElement('div');
      element.className = 'floating-element';
      element.style.left = Math.random() * 100 + '%';
      element.style.top = Math.random() * 100 + '%';
      element.style.animationDelay = Math.random() * 6 + 's';
      element.style.animationDuration = (Math.random() * 4 + 4) + 's';
      container.appendChild(element);
    }
  }

  // Initialize floating elements
  createFloatingElements();

  let revealed = false;
  ScrollTrigger.create({
    trigger: '.event-cards-section',
    start: 'top top',
    end: 'bottom bottom',
    pin: '.cards-wrapper',
    scrub: 1,
    onUpdate: (self) => {
      const progress = self.progress;
      const maxScroll = cardsContainer.scrollWidth - window.innerWidth;
      const scrollAmount = progress * maxScroll;


      cardsContainer.style.transform = `translateX(-${scrollAmount}px)`;


      cardsBgHeading.style.position = 'fixed';
      cardsBgHeading.style.top = '50%';
      cardsBgHeading.style.left = '50%';
      cardsBgHeading.style.transform = 'translate(-50%, -50%)';
      cardsBgHeading.style.opacity = `${1 - progress * 0.2}`;
      cardsBgHeading.style.scale = '1';


      if (progress > 0.05 && !revealed) {
        gsap.to(hiddenCards, {
          opacity: 1,
          y: 0,
          x: 0,
          duration: 0.8,
          stagger: 0.15,
          ease: 'power2.out',
          overwrite: true
        });
        revealed = true;
      }
    }
  });

  // Enhanced card hover effects
  allCards.forEach(card => {
    card.addEventListener('mouseenter', () => {
      gsap.to(card, {
        scale: 1.05,
        y: -15,
        rotationY: 5,
        duration: 0.4,
        ease: 'power2.out'
      });
    });
    card.addEventListener('mouseleave', () => {
      gsap.to(card, {
        scale: 1,
        y: 0,
        rotationY: 0,
        duration: 0.4,
        ease: 'power2.out'
      });
    });
  });

  // Initialize Swiper for the carousel

  const swiper = new Swiper(".mySwiper", {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true, // Enable infinite loop
    autoplay: {
      delay: 2000,
      disableOnInteraction: false,
    },
    breakpoints: {
      768: {
        slidesPerView: 2,
      },
    },
  });


});