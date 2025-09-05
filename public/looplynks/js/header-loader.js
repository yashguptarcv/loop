class HeaderLoader {
  constructor() {
    this.loadHeader();
    this.initializeEventListeners();
    this.initializeScrollEffects();
    this.loadLucideIcons();
  }

  async loadHeader() {
    try {
        
      const response = await fetch('./components/header.html');
      const headerHTML = await response.text();
      
      // Insert header at the beginning of body
      document.body.insertAdjacentHTML('afterbegin', headerHTML);
      
      // Initialize after header is loaded
      setTimeout(() => {
        this.initializeEventListeners();
      }, 100);
    } catch (error) {
      console.error('Error loading header:', error);
    }
  }

  loadLucideIcons() {
    // Load Lucide icons if not already loaded
    if (!window.lucide) {
      const lucideScript = document.createElement('script');
      lucideScript.src = 'https://unpkg.com/lucide@latest';
      lucideScript.onload = () => {
        if (window.lucide) {
          lucide.createIcons();
        }
      };
      document.head.appendChild(lucideScript);
    }
  }

  initializeEventListeners() {
    // Get elements after header is loaded
    const stickyHeader = document.getElementById('sticky-header');
    const stickyMenuBtn = document.getElementById('sticky-menu-btn');
    const stickyDropdownMenu = document.getElementById('sticky-dropdown-menu');
    const stickyDropdownClose = document.getElementById('sticky-dropdown-close');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    
    let menuOpen = false;
    let stickyDropdownOpen = false;

    // Hamburger open/close logic for mobile menu
    const openMobileMenu = () => {
      if (mobileMenu) {
        mobileMenu.classList.remove('opacity-0', 'pointer-events-none');
        mobileMenu.classList.add('opacity-100');
        menuOpen = true;
        document.body.classList.add('overflow-hidden');
        
        // Animate hamburger to X
        if (menuBtn) {
          const spans = menuBtn.querySelectorAll('span');
          spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
          spans[1].style.opacity = '0';
          spans[2].style.transform = 'rotate(-45deg) translate(7px, -6px)';
        }
      }
    };

    const closeMobileMenu = () => {
      if (mobileMenu) {
        mobileMenu.classList.add('opacity-0', 'pointer-events-none');
        mobileMenu.classList.remove('opacity-100');
        menuOpen = false;
        document.body.classList.remove('overflow-hidden');
        
        // Reset hamburger animation
        if (menuBtn) {
          const spans = menuBtn.querySelectorAll('span');
          spans[0].style.transform = 'rotate(0) translate(0, 0)';
          spans[1].style.opacity = '1';
          spans[2].style.transform = 'rotate(0) translate(0, 0)';
        }
      }
    };

    const openStickyDropdown = () => {
      if (stickyDropdownMenu) {
        stickyDropdownMenu.classList.remove('hidden');
        stickyDropdownMenu.classList.add('flex');
        stickyDropdownOpen = true;
        document.body.classList.add('overflow-hidden');
        
        // Animate sticky hamburger to X
        if (stickyMenuBtn) {
          const spans = stickyMenuBtn.querySelectorAll('span');
          spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
          spans[1].style.opacity = '0';
          spans[2].style.transform = 'rotate(-45deg) translate(7px, -6px)';
        }
      }
    };

    const closeStickyDropdown = () => {
      if (stickyDropdownMenu) {
        stickyDropdownMenu.classList.add('hidden');
        stickyDropdownMenu.classList.remove('flex');
        stickyDropdownOpen = false;
        document.body.classList.remove('overflow-hidden');
        
        // Reset sticky hamburger animation
        if (stickyMenuBtn) {
          const spans = stickyMenuBtn.querySelectorAll('span');
          spans[0].style.transform = 'rotate(0) translate(0, 0)';
          spans[1].style.opacity = '1';
          spans[2].style.transform = 'rotate(0) translate(0, 0)';
        }
      }
    };

    // Event listeners
    if (menuBtn) {
      menuBtn.addEventListener('click', () => {
        if (menuOpen) {
          closeMobileMenu();
        } else {
          openMobileMenu();
        }
      });
    }

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

    if (mobileMenuClose) {
      mobileMenuClose.addEventListener('click', closeMobileMenu);
    }

    if (stickyDropdownClose) {
      stickyDropdownClose.addEventListener('click', closeStickyDropdown);
    }

    // Close menus when clicking outside
    document.addEventListener('click', (e) => {
      if (menuOpen && mobileMenu && !mobileMenu.contains(e.target) && !menuBtn?.contains(e.target)) {
        closeMobileMenu();
      }
      if (stickyDropdownOpen && stickyDropdownMenu && !stickyDropdownMenu.contains(e.target) && !stickyMenuBtn?.contains(e.target)) {
        closeStickyDropdown();
      }
    });

    // Prevent click inside menus from closing
    if (mobileMenu) {
      mobileMenu.addEventListener('click', (e) => {
        e.stopPropagation();
      });
    }

    if (stickyDropdownMenu) {
      stickyDropdownMenu.addEventListener('click', (e) => {
        e.stopPropagation();
      });
    }

    // Close menus on escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        closeMobileMenu();
        closeStickyDropdown();
      }
    });

    // Global functions for onclick handlers in HTML
    window.closeMobileMenu = closeMobileMenu;
    window.closeStickyDropdown = closeStickyDropdown;

    // Mobile dropdown functionality
    window.toggleMobileDropdown = () => {
      const dropdown = document.getElementById('mobileUserDropdown');
      const icon = document.getElementById('mobileDropdownIcon');
      if (dropdown && icon) {
        dropdown.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
      }
    };

    // Sticky dropdown functionality
    window.toggleDropdown = () => {
      const dropdown = document.getElementById('userDropdown');
      const icon = document.getElementById('dropdownIcon');
      if (dropdown && icon) {
        dropdown.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
      }
    };

    // Close dropdowns on outside click
    document.addEventListener('click', (e) => {
      const mobileDropdown = document.getElementById('mobileUserDropdown');
      const stickyDropdown = document.getElementById('userDropdown');
      const mobileButton = e.target.closest('button[onclick*="toggleMobileDropdown"]');
      const stickyButton = e.target.closest('button[onclick*="toggleDropdown"]');
      
      if (mobileDropdown && !mobileDropdown.contains(e.target) && !mobileButton) {
        mobileDropdown.classList.add('hidden');
        const icon = document.getElementById('mobileDropdownIcon');
        if (icon) icon.classList.remove('rotate-180');
      }
      
      if (stickyDropdown && !stickyDropdown.contains(e.target) && !stickyButton) {
        stickyDropdown.classList.add('hidden');
        const icon = document.getElementById('dropdownIcon');
        if (icon) icon.classList.remove('rotate-180');
      }
    });
  }

  initializeScrollEffects() {
    const stickyHeader = document.getElementById('sticky-header');
    let lastScrollY = window.scrollY;

    window.addEventListener('scroll', () => {
      const currentScrollY = window.scrollY;
      
      if (stickyHeader) {
        if (currentScrollY > 80) {
          stickyHeader.classList.remove('hidden');
          stickyHeader.classList.add('flex');
        } else {
          stickyHeader.classList.add('hidden');
          stickyHeader.classList.remove('flex');
          // Close sticky dropdown when scrolling to top
          if (window.closeStickyDropdown) {
            window.closeStickyDropdown();
          }
        }
      }

      lastScrollY = currentScrollY;
    });
  }
}

// Initialize header when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  new HeaderLoader();
});

// // Also initialize if DOM is already loaded
// if (document.readyState === 'loading') {
//   document.addEventListener('DOMContentLoaded', () => {
//     new HeaderLoader();
//   });
// } else {
//   new HeaderLoader();
// }
