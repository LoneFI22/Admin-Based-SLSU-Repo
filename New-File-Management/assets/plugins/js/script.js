document.addEventListener("DOMContentLoaded", function() {
    var url = window.location.pathname;
    var filename = url.substring(url.lastIndexOf('/') + 1);
    var menuLinks = document.querySelectorAll('.side-menu a');
    
    menuLinks.forEach(function(link) {
        var linkHref = link.getAttribute('href');
        if (filename === linkHref) {
            // Remove 'active' class from all links
            menuLinks.forEach(function(link) {
                link.parentElement.classList.remove('active');
            });
            // Set 'active' class for the current link
            link.parentElement.classList.add('active');
        }
    });
});

const menuBar = document.querySelector('.content nav .bx.bx-menu');
const sideBar = document.querySelector('.sidebar');

menuBar.addEventListener('click', () => {
    sideBar.classList.toggle('close');
});

window.addEventListener('resize', () => {
    if (window.innerWidth < 768) {
        sideBar.classList.add('close');
    } else {
        sideBar.classList.remove('close');
    }
});