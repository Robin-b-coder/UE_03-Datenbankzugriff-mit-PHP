// Book Search/Filter
function filterBooks(searchTerm) {
    const filter = searchTerm.toLowerCase();
    const items = document.querySelectorAll('#bookList li');
    items.forEach(item => {
        item.style.display = item.textContent.toLowerCase().includes(filter) ? '' : 'none';
    });
}
// Sticky Navbar
function setStickyNavbar(threshold) {
    const nav = document.getElementById('mainNav');
    if (window.scrollY > threshold) {
        nav.classList.add('sticky-nav', 'shadow');
    } else {
        nav.classList.remove('sticky-nav', 'shadow');
    }
}

// Beispiel für Event-Listener mit den Funktionen
window.addEventListener('scroll', function () {
    setStickyNavbar(50);
});

document.getElementById('searchInput').addEventListener('input', function () {
    filterBooks(this.value);
});

// Get the button:
let mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}


// Carousel is handled by Bootstrap

/*Aufgabe 4: Fügen Sie Javascript-Funktionen hinzu. (mindestens 3) (15 PKT)

Hinweis: Die Funktionen sollten einen gewissen Umfang haben. Versuchen Sie das
gelernte aus der 2.Klasse anzuwenden und fügen Sie für Ihr Unternehmen sinnvolle
Funktionen ein. (z.B. Filter, Dynamische Suche, Sticky Menue usw.)*/