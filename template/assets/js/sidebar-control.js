// Sidebar Control
document.addEventListener('DOMContentLoaded', function() {
    // Helper function to check if element is a menu item
    function isMenuItem(element) {
        return element.matches('.sidebar-menu a') || 
               element.matches('.sidebar-menu li') || 
               element.matches('.treeview-menu a');
    }

    const body = document.querySelector('body');
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const mainSidebar = document.querySelector('.main-sidebar');
    const menuItems = document.querySelectorAll('.sidebar-menu a:not(.sidebar-toggle)');
    const overlay = document.createElement('div');
    overlay.className = 'sidebar-overlay';
    document.body.appendChild(overlay);

    // Handle clicks on the sidebar
    document.querySelector('.main-sidebar').addEventListener('click', function(e) {
        const clickedElement = e.target;
        
        // If clicked element is a menu item or its child
        if (isMenuItem(clickedElement) || clickedElement.closest('.sidebar-menu a')) {
            if (window.innerWidth <= 768) {
                // Small delay to allow the click to register
                setTimeout(() => {
                    closeSidebar();
                }, 150);
            }
        }
    });

    // Initialize sidebar state from localStorage
    const sidebarState = localStorage.getItem('sidebarState');
    if (sidebarState === 'collapsed') {
        body.classList.add('sidebar-collapse');
    }

    // Toggle sidebar
    sidebarToggle.addEventListener('click', function(e) {
        e.preventDefault();
        toggleSidebar();
    });

    // Close sidebar when clicking overlay
    overlay.addEventListener('click', function() {
        closeSidebar();
    });

    // Close sidebar on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && body.classList.contains('sidebar-open')) {
            closeSidebar();
        }
    });

    // Handle window resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (window.innerWidth > 768 && body.classList.contains('sidebar-open')) {
                closeSidebar();
            }
        }, 250);
    });

    function toggleSidebar() {
        if (window.innerWidth <= 768) {
            // Mobile behavior
            if (body.classList.contains('sidebar-open')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        } else {
            // Desktop behavior
            body.classList.toggle('sidebar-collapse');
            localStorage.setItem('sidebarState', body.classList.contains('sidebar-collapse') ? 'collapsed' : 'expanded');
        }
    }

    function openSidebar() {
        body.classList.add('sidebar-open');
        overlay.style.display = 'block';
        setTimeout(() => {
            overlay.style.opacity = '1';
        }, 10);
    }

    function closeSidebar() {
        body.classList.remove('sidebar-open');
        overlay.style.opacity = '0';
        setTimeout(() => {
            overlay.style.display = 'none';
        }, 300);

        // If there are any open submenus, close them
        const activeTreeviews = document.querySelectorAll('.sidebar-menu .treeview.active');
        activeTreeviews.forEach(treeview => {
            if (window.innerWidth <= 768) {
                treeview.classList.remove('active');
            }
        });
    }

    // Handle swipe gestures on mobile
    let touchStartX = 0;
    let touchEndX = 0;
    
    document.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
    }, false);
    
    document.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    }, false);
    
    function handleSwipe() {
        const swipeThreshold = 100;
        const diff = touchEndX - touchStartX;
        
        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0 && !body.classList.contains('sidebar-open')) {
                // Swipe right, open sidebar
                openSidebar();
            } else if (diff < 0 && body.classList.contains('sidebar-open')) {
                // Swipe left, close sidebar
                closeSidebar();
            }
        }
    }
});
