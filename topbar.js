document.addEventListener("DOMContentLoaded", () => {
    const avatarButton = document.querySelector(".avatar-button")
    const dropdownMenu = document.getElementById("dropdown-menu")
  
    function toggleDropdown() {
      const expanded = avatarButton.getAttribute("aria-expanded") === "true" || false
      avatarButton.setAttribute("aria-expanded", !expanded)
      dropdownMenu.classList.toggle("show")
    }
  
    avatarButton.addEventListener("click", toggleDropdown)
  
    document.addEventListener("click", (event) => {
      if (!avatarButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
        avatarButton.setAttribute("aria-expanded", "false")
        dropdownMenu.classList.remove("show")
      }
    })
  
    // Close dropdown when Escape key is pressed
    document.addEventListener("keydown", (event) => {
      if (event.key === "Escape" && dropdownMenu.classList.contains("show")) {
        avatarButton.setAttribute("aria-expanded", "false")
        dropdownMenu.classList.remove("show")
        avatarButton.focus()
      }
    })
  })
  
  