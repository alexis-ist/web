<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
  <!-- animaciones css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link rel="stylesheet" href="css/main.css">
  <title>SegundaOportunidad- Comida Rescatada</title>
</head>

<body>

  <!--  INICIO DEL HEADER -->
  <header id="header" class="custom-header">
    <div class="top-bar">
      <div class="top-bar-container">
        <div class="top-bar-left">
          <a href="https://wa.me/593983412281?text=Hola%2C%20quiero%20ordenar%20comida" class="whatsapp-link"
            title="WhatsApp" target="_blank">
            +593 98 341 2281
          </a>
          <span class="email">pedidos@SegundaOportunidad.com</span>
          <span class="address">
            Entrega en toda la ciudad de Quito - Ecuador
          </span>
        </div>
        <div class="top-bar-right">
          <div class="social-links-header">
            <a href="https://www.facebook.com/profile.php?id=61581635670315" title="Facebook" class="social-icon"
              target="_blank"><i class="fa-brands fa-facebook"></i></a>
            <a href="https://wa.me/593983412281?text=Hola%2C%20quiero%20ordenar%20comida" title="WhatsApp"
              class="social-icon" target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
            <a href="#" title="TikTok" class="social-icon" target="_blank"><i class="fa-brands fa-tiktok"></i></a>
          </div>
        </div>
      </div>
    </div>

    <div class="header-container">
      <a href="index.html" class="logo">
        <img src="public/img_index/logoSegundaOportunidad.png" alt="Logo" />
        <h1 class="titleLogo">SegundaOportunidad</h1>
      </a>
      <div class="search-bar-container" id="searchBar">
        <form action="#" method="get" class="search-form">
          <input type="text" name="query" placeholder="Buscar productos..." class="search-input">
          <button type="submit" class="search-button">
            <i class="fa-solid fa-magnifying-glass"></i> </button>
        </form>
      </div>
      <nav class="navmenu">
        <ul>
          <li><a href="index.php" class="active">INICIO</a></li>
          <li><a href="#" onclick="cargarFormulario('comida.php')">Comidas</a></li>
          <li><a href="#" onclick="cargarFormulario('frutas.php')">Frutas</a></li>
          <li><a href="#" onclick="cargarFormulario('panaderia.php')">Panadería</a></li>
          <li><a href="pedidos.html">Contacto</a></li>
          <li><a class="btn-cuenta" href="#" id="btnCuenta">Registra tu Negocio</a></li>
        </ul>
        <span class="mobile-nav-toggle">☰</span>
      </nav>
    </div>
  </header>

  <div id="vista-principal">
    <!--  FIN DEL HEADER -->
    <main class="main">
      <!-- Hero Section -->
      <section id="hero" class="hero-section">
        <div class="hero-container">
          <div class="slider-background">
            <img src="https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?w=1920&h=1080&fit=crop" class="slide activar" alt="Comida deliciosa">
            <img src="https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?w=1920&h=1080&fit=crop" alt="Platos rescatados" class="slide">
            <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=1920&h=1080&fit=crop" alt="Comida saludable" class="slide">
            <img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=1920&h=1080&fit=crop" alt="Entrega a domicilio" class="slide">
            <img src="https://www.cucinare.tv/wp-content/uploads/2021/05/Frutas.jpg" alt="Frutas" class="slide">
            <img src="https://www.finedininglovers.com/es/sites/g/files/xknfdk1706/files/styles/im_landscape_100/public/2021-10/tipos-de-frutas%C2%A9iStock.jpg.webp?itok=iSVVtY5m" alt="Frutas" class="slide">
            <img src="https://www.frutamare.com/wp-content/uploads/2020/03/frutas.jpg.webp" alt="Frutas" class="slide">
            <img src="https://zonales.quito.gob.ec/wp-content/uploads/PANADERIA-PRINCIPAL-1-828x548-1.jpg" alt="Panaderia" class="slide">
            <img src="https://www.revistaialimentos.com/uploads/news-pictures/pphoto-3750.jpeg" alt="Panaderia" class="slide">
            <img src="https://proingra.com/wp-content/uploads/2020/12/17-Dic-Articulo_Opcion-1.jpg" alt="Panaderia" class="slide">


          </div>
          <div class="overlay"></div>

          <!-- Contenido principal -->
          <div class="hero-content-wrapper">
            <!-- Sección izquierda del hero -->

            <div class="hero-content">
              <h1 class="hero-tittle" data-aos="fade-up" data-aos-delay="100" data-aos-duration="900">CERO DESPERDICIO, MAS OPORTUNIDADES</h1>

              <!-- Mensaje personalizado -->
              <p class="hero-highlight" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
                Convierte lo que sobra en lo que todos quieren.<br />
                <strong>Une a negocios con excedentes y a clientes que buscan precios irresistibles.</strong>
              </p>
              <p class="hero-lema" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                <strong>Menos desperdicio, más sabor, más ahorro.</strong>
              </p>

              <!-- Botones de llamada a la acción -->
              <div class="cta-buttons">
                <a href="#pedidos" class="btn btn-primary" onclick="document.getElementById('btnCuenta').click();" data-aos="zoom-in" data-aos-delay="400" data-aos-duration="1000">Iniciar Sesion</a>
                <a href="#menu" class="btn btn-secondary" onclick="cargarFormulario('comida.php')" data-aos="zoom-in" data-aos-delay="500" data-aos-duration="1000">Ver Ofertas</a>
              </div>
            </div>
            <!-- Fin sección izquierda -->

          </div>
          <!-- Fin del contenido principal -->
        </div>
      </section>
      <!-- /Hero Section -->
      <!-- ABOUT Section -->
      <section class="about-section">
        <div class="about-container">

          <div class="about-content-clientes">
            <!-- Imagen simulando app -->
            <div class="about-image" data-aos="zoom-in" data-aos-delay="100" data-aos-duration="800">
              <img src="public/img_index/clientes.jpg" alt="Cliente usando app">
            </div>

            <!-- Descripción -->
            <div class="description">
              <h4 class="about-subtitle" data-aos="fade-down" data-aos-delay="200" data-aos-duration="500">PARA CLIENTES</h4>
              <h2 class="about-title" data-aos="fade-up" data-aos-delay="300" data-aos-duration="600">
                Gasta menos <span>aprovechando</span> las mejores ofertas en tus tiendas de siempre.
              </h2>
              <p class="about-content" data-aos="fade" data-aos-delay="400" data-aos-duration="500">
                Ahorra mientras disfrutas de lo mejor en frutas, comida y panadería. Encuentra ofertas irresistibles cerca de ti en <strong>SegundaOportunidad</strong>.
                y dale más valor a cada compra.
              </p>

              <ul class="steps-list">
                <li class="step-item" data-aos="fade-left" data-aos-delay="500" data-aos-duration="500"><span>01</span>Explora productos frescos a precios únicos.</li>
                <li class="step-item" data-aos="fade-left" data-aos-delay="600" data-aos-duration="800"><span>02</span>Compra lo que te gusta.</li>
                <li class="step-item" data-aos="fade-left" data-aos-delay="1000" data-aos-duration="500"><span>03</span>Pasa por tu pedido en el local.</li>
              </ul>
              <div class="about-content-btn">
                <a id="btnCuentaCliente" href="#" class="about-btn" data-aos="flip-up" data-aos-delay="600" data-aos-duration="500">Soy Cliente</a>
              </div>


            </div>

          </div>
          <div class="about-content-negocios">
            <!-- Descripción -->
            <div class="description">
              <h4 class="about-subtitle" data-aos="fade-down" data-aos-delay="200" data-aos-duration="500">PARA NEGOCIOS</h4>
              <h2 class="about-title" data-aos="fade-up" data-aos-delay="300" data-aos-duration="600">
                <span>Genera ingresos</span> con lo que no vendiste.
              </h2>
              <p class="about-content" data-aos="fade" data-aos-delay="400" data-aos-duration="500">
                ¿Por qué desechar productos de calidad cuando puedes transformarlos en oportunidades? Convierte tus excedentes en ingresos adicionales y atrae nuevos clientes.<strong>SegundaOportunidad</strong> te ofrece un espacio para dar salida a lo que no vendiste, convirtiendo pérdidas en ganancias en minutos.
              </p>

              <ul class="steps-list">
                <li class="step-item" data-aos="fade-right" data-aos-delay="500" data-aos-duration="600"><span>01</span>Registro rápido y sencillo.</li>
                <li class="step-item" data-aos="fade-right" data-aos-delay="700" data-aos-duration="600"><span>02</span>Sin tarifas fijas (solo comisión por venta).</li>
                <li class="step-item" data-aos="fade-right" data-aos-delay="900" data-aos-duration="600"><span>03</span>Impulso para pequeños negocios.</li>
              </ul>
              <div class="about-content-btn">
                <a href="#" class="about-btn" data-aos="flip-up" data-aos-delay="600" data-aos-duration="500" onclick="document.getElementById('btnCuenta').click();">Acceso Negocios</a>
              </div>
            </div>
            <!-- Imagen simulando app -->
            <div class="about-image" data-aos="zoom-in" data-aos-delay="100" data-aos-duration="800">
              <img src="public/img_index/negocios.jpg" alt="Cliente usando app">
            </div>

          </div>
        </div>
      </section>

      <section class="rectangulo-flotante">
        <div class="contenedor-rectangulo">
          <h2 class="rectangulo-title" data-animate="animate__fadeInDown" data-animate-exit="animate__fadeOutUp">Por qué empezar a vender con SegundaOportunidad?</h2>
          <div class="benefits">
            <div class="benefit-item uno">
              <h3 class="benefit-title" data-animate="animate__rotateInUpLeft">1. Comienza a vender al instante</h3>
              <p class="benefit-p" data-animate="animate__fadeInDown" data-animate-delay="700"
                data-animate-duration="700">
                <strong>Registre</strong> su negocio en<strong> minutos,</strong> espere la verificación del moderador y comience a vender de inmediato.
              </p>
            </div>
            <div class="benefit-item dos">
              <h3 class="benefit-title" data-animate="animate__rotateInUpLeft">2. Vende lo que sobra, crece tu negocio</h3>
              <p class="benefit-p" data-animate="animate__fadeInDown" data-animate-delay="800"
                data-animate-duration="800">
                Estoy aquí para ayudarte a vender lo que sobra y hacer crecer tu negocio.
              </p>
            </div>
            <div class="benefit-item uno">
              <h3 class="benefit-title" data-animate="animate__rotateInUpLeft">3. Pagos solo por resultados</h3>
              <p class="benefit-p" data-animate="animate__fadeInDown" data-animate-delay="1000"
                data-animate-duration="1000">
                Regístrese sin compromisos.<strong>Publique</strong> productos sobrantes cuando quiera y empiece a crecer su negocio de inmediato.
              </p>
            </div>
          </div>
          <div class="rectangulo-btn" data-animate="animate__bounce">
            <a href="#" class="boton-descarga" onclick="document.getElementById('btnCuenta').click();">Registrarse</a>

          </div>
        </div>
      </section>

      <section class="local-type-section">
        <div class="local-type-container">
          <!-- Fila superior -->
          <div class="local-type-row">
            <!-- Restaurantes -->
            <div class="local-type-card comida" data-aos="zoom-in-right" data-aos-delay="300">
              <h3 class="local-type-title" data-animate="animate__rotateInUpLeft" data-animate-delay="1100"
                data-animate-duration="1100">Restaurantes</h3>
              <p class="local-type-p">
                Ayudamos a los restaurantes a transformar excedentes en oportunidades: desde platos sobrantes al final del día, hasta productos cercanos a su fecha de consumo.
              </p>
              <div class="img-type-container cont-img-comida">
                <img class="local-type-img" src="public/img_index/comida.jpg" alt="Restaurantes">
              </div>
            </div>

            <!-- Panaderías -->
            <div class="local-type-card panaderia" data-aos="zoom-in-left" data-aos-delay="400">
              <h3 class="local-type-title" data-animate="animate__rotateInUpLeft" data-animate-delay="1100"
                data-animate-duration="1100">Panadería y panateleria</h3>
              <p class="local-type-p">
                Mantén tus pasteles, sándwiches y panes sin desperdiciar.Ofrece tus sobrantes al final del día o al día siguiente y haz que lleguen a más clientes.
              </p>
              <div class="img-type-container">
                <img class="local-type-img" src="public/img_index/panaderia.png" alt="Café y panaderías">
              </div>
            </div>
          </div>

          <!-- Fila inferior -->
          <div class="local-type-colum">
            <!-- Frutas -->
            <div class="local-type-card frutas" data-aos="fade-up" data-aos-delay="500">
              <h3 class="local-type-title" data-animate="animate__rotateInUpLeft" data-animate-delay="1200"
                data-animate-duration="1200">Frutas</h3>
              <p class="local-type-p">
                Aprovecha las frutas maduras y de temporada con SegundaOportunidad. Perfectas para jugos, postres y mucho más, brindando opciones frescas y saludables a precios bajos.
              </p>
              <div class="img-type-container">
                <img class="local-type-img" src="public/img_index/frutas.jpg" alt="Frutas">
              </div>
            </div>
          </div>

        </div>
      </section>
      <!-- TIPS Section -->
      <section class="tips-section">
        <div class="tips-container">
          <div class="tip-card" data-aos="fade-up" data-aos-delay="100" data-aos-duration="600">
            <img src="public/img/blender.png" alt="Smoothie">
            <h3>Agregue fruta madura al smoothie</h3>
            <p>Si tiene frutas y verduras frescas que están madurando, agréguelas a su batido matutino.</p>
          </div>
          <div class="tip-card" data-aos="fade-up" data-aos-delay="200" data-aos-duration="600">
            <img src="public/img/list.png" alt="Lista">
            <h3>Haz una lista</h3>
            <p>Mientras planifica las comidas, haga una lista para no comprar de más.</p>
          </div>
          <div class="tip-card" data-aos="fade-up" data-aos-delay="300" data-aos-duration="600">
            <img src="public/img/freeze.png" alt="Congelar">
            <h3>Congelar, congelar, congelar</h3>
            <p>No olvides marcar la fecha en que lo cocinaste y lo congelaste.</p>
          </div>
          <div class="tip-card" data-aos="fade-up" data-aos-delay="400" data-aos-duration="600">
            <img src="public/img/store.png" alt="Almacene">
            <h3>Almacene sus alimentos correctamente</h3>
            <p>Almacenar bien tus alimentos te dará más tiempo para usarlos.</p>
          </div>
          <div class="tip-card" data-aos="fade-up" data-aos-delay="500" data-aos-duration="600">
            <img src="public/img/soup.png" alt="Caldo">
            <h3>Haz un caldo de verduras</h3>
            <p>Las cáscaras y tallos de verduras son una excelente base de caldo.</p>
          </div>
          <div class="tip-card" data-aos="fade-up" data-aos-delay="600" data-aos-duration="600">
            <img src="public/img/peel.png" alt="Cáscaras">
            <h3>Guarde sus cáscaras de papa</h3>
            <p>Las cáscaras pueden tener una segunda vida como papas fritas.</p>
          </div>
          <div class="tip-card" data-aos="fade-up" data-aos-delay="700" data-aos-duration="600">
            <img src="public/img/freshen.png" alt="Aromas">
            <h3>Refresca tu hogar</h3>
            <p>Rodajas de naranja seca y canela son fragantes y biodegradables.</p>
          </div>
        </div>
      </section>
      <!-- /TIPS Section -->
      <!-- ..........Ofertas Section......... -->
      <!-- <section class="daily-offers-section">
          <div class="container">
            <h2 class="section-title" data-aos="fade-up">Ofertas del Día</h2>
            <div class="offers-grid">
              Tarjeta de producto 
              <div class="offer-card" data-aos="zoom-in" data-aos-delay="100">
                <img src="https://images.unsplash.com/photo-1604908177522-f6e25191a53b" alt="Pan artesanal">
                <div class="offer-info">
                  <h3>Pan artesanal integral</h3>
                  <p>Horneado hoy, perfecto para sandwiches o tostadas.</p>
                  <div class="price">
                    <span class="original-price">$2.00</span>
                    <span class="discounted-price">$1.00</span>
                  </div>
                  <a href="#pedidos" class="btn-order">Pedir ahora</a>
                </div>
              </div>

              <div class="offer-card" data-aos="zoom-in" data-aos-delay="200">
                <img src="https://images.unsplash.com/photo-1600628422011-1be3a1a97b86" alt="Verduras mixtas">
                <div class="offer-info">
                  <h3>Verduras mixtas</h3>
                  <p>Ideal para sopas o salteados. Frescas y listas para cocinar.</p>
                  <div class="price">
                    <span class="original-price">$4.00</span>
                    <span class="discounted-price">$2.50</span>
                  </div>
                  <a href="#pedidos" class="btn-order">Pedir ahora</a>
                </div>
              </div>

               Puedes duplicar más tarjetas aquí
            </div>
          </div>
        </section> -->

      <!-- /Ofertas Section -->
      <!-- FOOTER -->
      <footer id="footer" class="custom-footer">
        <div class="footer-top">
          <div class="footer-row">
            <div class="footer-col about">
              <a href="index.html" class="footer-logo">
                <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=100&h=100&fit=crop&crop=center" alt="Logo" class="logo-footer" />
                <span class="sitename">SegundaOportunidad</span>
              </a>
              <div class="footer-contact">
                <p>Centro de Quito, Ecuador</p>
                <p>Entrega en toda la ciudad</p>
                <p><strong>Teléfono:</strong> + 593 99 998 6376</p>
                <p><strong>Email:</strong> pedidos@SegundaOportunidad.com</p>
                <p><strong>Horario:</strong> Lun-Dom 10:00-22:00</p>
              </div>
              <div class="social-links-footer">
                <a href="https://www.facebook.com/profile.php?id=61581635670315" title="Facebook" target="_blank"><i class="fa-brands fa-facebook"></i></a>
                <a href="#" title="TikTok" class="social-icon" target="_blank"><i class="fa-brands fa-tiktok"></i></a>
                <a href="https://wa.me/593983412281?text=Hola%2C%20quiero%20ordenar%20comida" title="WhatsApp" target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
              </div>
            </div>

            <div class="footer-col links">
              <h4>Enlaces Rápidos</h4>
              <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="#" onclick="cargarFormulario('comida.php')">Ofertar Comida</a></li>
                <li><a href="#" onclick="cargarFormulario('frutas.php')">Ofertar Fruteria </a></li>
                <li><a href="#" onclick="cargarFormulario('panaderia.php')">Ofertar Panaderia</a></li>
                <li><a onclick="document.getElementById('btnCuenta').click();">Registrarse</a></li>
              </ul>
            </div>

            <div class="footer-col links">
              <h4>Compromiso</h4>
              <ul>
                <li><a href="#">Calidad Garantizada</a></li>
                <li><a href="#">Ofertas Reales</a></li>
                <li><a href="#">Seguridad en las Compras</a></li>
                <li><a href="#">Términos de Servicio</a></li>
                <li><a href="#">Política de Privacidad</a></li>
              </ul>
            </div>
          </div>
        </div>

        <div class="footer-bottom">
          <p>
            © <span>Copyright</span><strong class="sitename"> SegundaOportunidad 2025</strong> - Rescatando comida, salvando el planeta
          </p>
        </div>
      </footer>
      <!-- FIN FOOTER -->
    </main>
  </div>
  <!-- MODAL PERSONALIZADO LOGIN -->
  <div id="modalLogin" class="custom-modal">
    <div class="custom-modal-content">
      <span class="custom-close">&times;</span>
      <!-- <div id="loginContainer">Cargando...</div> -->
      <iframe id="loginFrame" src=""></iframe>
      <!-- <iframe src="store/login.php"></iframe> -->
    </div>
  </div>

  <div id="vista-formulario" class="vista-formulario-locales">
    <iframe id="formularioFrame" style="width:100%; height:100%; border:none;"></iframe>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script src="js/main.js"></script>

</body>

</html>