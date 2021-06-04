<div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary p-2 mb-3">
        <a class="navbar-brand">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            
            <li>
              <a class="nav-link {{ $current == "home" ? 'active' : null }}" href="/">Home </a>
            </li>

            <li>
                <a class="nav-link {{ $current == "produtos" ? 'active' : null }}" href="/produtos">Produtos</a>
            </li>

            <li>
                <a class="nav-link {{ $current == "categorias" ? 'active' : null }}" href="/categorias">Categorias</a>
            </li>

          </ul>
        </div>
      </nav>

</div>
