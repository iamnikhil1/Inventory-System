// JavaScript for handling CRM, CMS, and Settings submenu toggles
document.addEventListener('DOMContentLoaded', () => {
    const crmMenu = document.getElementById('crmMenu');
    const crmSubmenu = document.getElementById('crm-submenu');

    const cmsMenu = document.getElementById('cmsMenu');
    const cmsSubmenu = document.getElementById('cms-submenu');

    const settingsMenu = document.getElementById('settingsMenu');
    const settingsSubmenu = document.getElementById('settings-submenu');

    // Toggle CRM submenu
    crmMenu.addEventListener('click', (e) => {
        e.preventDefault(); // Prevent default anchor behavior
        crmSubmenu.classList.toggle('open'); // Show/hide the CRM submenu
        // Close other submenus
        cmsSubmenu.classList.remove('open');
        settingsSubmenu.classList.remove('open');
    });

    // Toggle CMS submenu
    cmsMenu.addEventListener('click', (e) => {
        e.preventDefault(); // Prevent default anchor behavior
        cmsSubmenu.classList.toggle('open'); // Show/hide the CMS submenu
        // Close other submenus
        crmSubmenu.classList.remove('open');
        settingsSubmenu.classList.remove('open');
    });

    // Toggle Settings submenu
    settingsMenu.addEventListener('click', (e) => {
        e.preventDefault(); // Prevent default anchor behavior
        settingsSubmenu.classList.toggle('open'); // Show/hide the Settings submenu
        // Close other submenus
        crmSubmenu.classList.remove('open');
        cmsSubmenu.classList.remove('open');
    });

    // Close submenus when clicking outside (optional)
    document.addEve
