// Start Change Active Navbar Link
let navbarLink = document.querySelectorAll('.navbar-link');
let lastActive = document.querySelector('.navbar-link.active');
navbarLink.forEach(element => {
  element.addEventListener('click', function () {  
    lastActive.classList.remove('active');
    element.classList.add('active');
  })
});
// Stop Active Navbar Link

// Update Perpage - Start
let selectPerPage = document.querySelector('#select-per-page');

selectPerPage.addEventListener("change", function () {
  document.querySelector('.form-per-page').submit();
})
// Update Perpage - End
