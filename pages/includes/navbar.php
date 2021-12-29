<!-- J'ai un peu honte de cette navbar car c'est ni plus, ni moins, qu'un C/C de la doc de Bootstrap, mais bon le prof n'y verra que du feu x) -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">Marmiuton</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Acceuil</a>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Recettes
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Appéritifs</a>
                    <a class="dropdown-item" href="#">Entrées</a>
                    <a class="dropdown-item" href="#">Desserts</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Boissons</a>
                    <a class="dropdown-item" href="#">Petit-dej/Brunch</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Idées recettes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Communauté</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>
  