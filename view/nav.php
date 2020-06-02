<nav class="navbar navbar-dark bg-dark navbar-expand-md">
    <a class="navbar-brand" href="?action=index">eiTicky</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <?php
            if (isset($_SESSION['log'])) {
                echo '<li class="nav-item ' . ($actual == 'dashboard' ? 'active' : '') . '"><a class="nav-link" href="?action=dashboard">Dashboard</a></li>';
                echo '<li class="nav-item ' . ($actual == 'myOpenTasks' ? 'active' : '') . '"><a class="nav-link" href="?action=myOpenTasks">Mes tâches ouvertes</a></li>';
                echo '<li class="nav-item ' . ($actual == 'viewMyRequests' ? 'active' : '') . '"><a class="nav-link" href="?action=viewMyRequests">Mes demandes ouvertes</a></li>';
                echo '<li class="nav-item ' . ($actual == 'viewUnownedRequests' ? 'active' : '') . '"><a class="nav-link" href="?action=viewUnownedRequests">Demandes non affectées</a></li>';
                echo '<li class="nav-item ' . ($actual == 'viewOpenAdminRequests' ? 'active' : '') . '"><a class="nav-link" href="?action=viewOpenAdminRequests">Toutes les demandes ouvertes</a></li>';
                echo '<li class="nav-item ' . ($actual == '' ? 'active' : '') . '"><a class="nav-link" href="?action=">?</a></li>';
            } else {
                echo '<li class="nav-item ' . ($actual == 'viewOpenRequests' ? 'active' : '') . '"><a class="nav-link" href="?action=viewOpenRequests">Voir les demandes ouvertes</a></li>';
                echo '<li class="nav-item ' . ($actual == 'createRequest' ? 'active' : '') . '"><a class="nav-link" href="?action=createRequest">Créer une demande</a></li>';
                echo '<li class="nav-item ' . ($actual == 'login' ? 'active' : '') . '"><a class="nav-link" href="?action=login">Login</a></li>';
            }
            echo '<li class="nav-item ' . ($actual == 'faq' ? 'active' : '') . '"><a class="nav-link" href="?action=faq">FAQ</a></li>';
            ?>
        </ul>
        <?= isset($_SESSION['log']) ? '<a class="" href="?action=logout"><button class="btn btn-outline-warning">Logout</button></a>' : '' ?>
    </div>
</nav>