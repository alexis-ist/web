document.addEventListener('DOMContentLoaded', function () {
  const mobileNavToggle = document.querySelector('.mobile-nav-toggle');
  const navMenu = document.querySelector('.navmenu ul');
  if (mobileNavToggle && navMenu) {
    mobileNavToggle.addEventListener('click', function () {
            navMenu.classList.toggle('active');

            // Cambiar icono del menú
            if (navMenu.classList.contains('active')) {
                mobileNavToggle.innerHTML = '✕';
            } else {
                mobileNavToggle.innerHTML = '☰';
            }
        });
        // Cerrar menú al hacer click en un enlace
        const navLinks = document.querySelectorAll('.navmenu a');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('active');
                mobileNavToggle.innerHTML = '☰';
            });
        });
            // Cerrar menú al hacer click fuera
    document.addEventListener('click', function (event) {
      // Si el click no fue dentro de navmenu NI en el botón
      if (
        navMenu.classList.contains('active') &&
        !navMenu.contains(event.target) &&
        !mobileNavToggle.contains(event.target)
      ) {
        navMenu.classList.remove('active');
        mobileNavToggle.innerHTML = '☰';
      }
    });
  }
  const header = document.getElementById('header');
    let lastScrollTop = 0;

    window.addEventListener('scroll', () => {
        const scrollTop = window.scrollY;

        // Aplica sombra si el scroll pasó de 50px
        if (scrollTop > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }

        // Oculta al bajar, muestra al subir solo hace escrol al index
        if (!header.classList.contains("secciones")) {
    if (scrollTop > lastScrollTop) {
      header.classList.add('hide');
    } else {
      header.classList.remove('hide');
    }
  }

        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    });
/*  cambia estilo de TODO el header */
  document.querySelectorAll(".navmenu a").forEach(link => {
    link.addEventListener("click", () => {
      // quitar la clase antes de aplicar
      header.classList.remove("secciones");

      if (
        link.textContent.includes("Comidas") ||
        link.textContent.includes("Frutas") ||
        link.textContent.includes("Panadería")
      ) {
        header.classList.add("secciones");
      }
    });
  });
    
});

//EFECTO DE CAMBIO DE IMAGENES DEN EL HERO
const slides = document.querySelectorAll('.slider-background .slide');
let currentIndex = 0;

setInterval(() => {
  slides[currentIndex].classList.remove('activar');
  currentIndex = (currentIndex + 1) % slides.length;
  slides[currentIndex].classList.add('activar');
}, 7000);



// ANIMACION CUANDO SE HACE SCROLL
AOS.init({
  duration: 1000,   // duración de la animación en milisegundos
  once: false,      // animar solo una vez al hacer scroll
  easing: 'ease-in-out',
});
//animaciones con animation.css
// ANIMACIONES CON ANIMATE.CSS
document.addEventListener("DOMContentLoaded", () => {
  const elementos = document.querySelectorAll("[data-animate]");

  const observer = new IntersectionObserver((entradas) => {
    entradas.forEach((entrada) => {
      const el = entrada.target;
      const anim = el.dataset.animate;
      // Leer delay y duración desde atributos
      const delay = el.dataset.animateDelay || 0;
      const duration = el.dataset.animateDuration || 1000;

      if (entrada.isIntersecting) {
        // Reinicia animación
        el.classList.remove(anim);
        void el.offsetWidth; // force reflow
        el.classList.add("animate__animated", anim);
        // Aplicar tiempos personalizados de Animate.css
        el.style.setProperty("--animate-delay", `${delay}ms`);
        el.style.setProperty("--animate-duration", `${duration}ms`);
      } else {
        // Quita animación al salir para que se repita
        el.classList.remove("animate__animated", anim);
      }
    });
  }, {
    threshold: 0.2,     // visible al menos un 20%
    rootMargin: '0px 0px -50px 0px' // trigger un poco antes
  });

  elementos.forEach((el) => observer.observe(el));
});

//CODIGO PARA HACER EL MODAL 
// Abrir modal al hacer clic en "MI CUENTA" NEGOCIOS
document.getElementById('btnCuenta').addEventListener('click', function (e) {
  e.preventDefault();

  const modal = document.getElementById('modalLogin');
  const iframe = document.getElementById('loginFrame');

  // Cargar login.php en el iframe solo cuando se abre el modal
  iframe.src = 'store/login.php';

  // Mostrar modal
  modal.style.display = 'block';
});

document.getElementById('btnCuentaCliente').addEventListener('click',function(e){
  e.preventDefault();
  const modalCliente = document.getElementById('modalLogin');
  const iframe =document.getElementById('loginFrame');
  iframe.src = 'store/login_comprador.php';
  modalCliente.style.display ='block';
});

// Cerrar modal con la "X"
document.querySelector('.custom-close').addEventListener('click', function () {
  document.getElementById('modalLogin').style.display = 'none';
});

// Cerrar modal al hacer clic fuera
window.addEventListener('click', function (e) {
  const modal = document.getElementById('modalLogin');
  if (e.target === modal) {
    modal.style.display = 'none';
  }
});
//ceerrar con la techa ESC
window.addEventListener("keydown", function (e) {
  if (e.key === "Escape") {
    const modal = document.getElementById('modalLogin');

    modal.style.display = 'none';
    document.getElementById('loginFrame').src = ""; // limpiar iframe
  }
});
//  Escuchar mensajes que vengan del iframe hijo al presionar el boton añadir carrito
window.addEventListener("message", function (event) {
  if (event.data && event.data.action === "openLogin") {
    const modal = document.getElementById('modalLogin');
    const iframe = document.getElementById('loginFrame');

    // Solo recargo el login cuando viene del hijo
    iframe.src = 'store/login_comprador.php';
    modal.style.display = 'block';
  }
  //eschuca el messaje cunado presiono el esc
  if (event.data && event.data.action === "closeLogin") {
    const modal = document.getElementById('modalLogin');
    modal.style.display = 'none';
    document.getElementById('loginFrame').src = ""; // limpiar iframe
  }
});



/////////////////////////////
// CARGAR FORMULARIO DE LOCALES
function cargarFormulario(pagina) {
  // Oculta TODO el contenido del index
  document.getElementById('vista-principal').style.display = 'none';

  // Muestra solo el contenedor del iframe
  const vistaFormulario = document.getElementById('vista-formulario');
  vistaFormulario.style.display = 'block';

  // Carga la página seleccionada en el iframe
  const iframe = document.getElementById('formularioFrame');
  iframe.src = 'page/' + pagina; // Ajusta la ruta si tus PHP están en otra carpeta

  // Mostrar la barra de búsqueda
  const searchBar = document.getElementById("searchBar");
  if (searchBar) {
    searchBar.style.display = "block";
  }
}


