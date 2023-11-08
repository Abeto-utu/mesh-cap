<?php
require('../../db.php');
require_once('../CONTROLADOR/controladorAlmacenero.php');
session_start();

if (isset($_SESSION['username'])) {
    ($almacenero = $almaceneroModel->infoAlmacenero($_SESSION['username']));
} else {
    header("Location: ../../HOMEPAGE/VISTA/index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paquetes</title>
    <link rel="stylesheet" href="../CSS/stylesCrudPaquetes.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="shortcut icon" href="../../IMAGES/gorraBlanca.png" type="image/x-icon">
</head>

<body>
    <nav class="navbar navbar-dark bg-dark p-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="almacenero.php" id="logo"><img src="../../IMAGES/gorraBlanca.png" height="40"
                    alt="">MeshCap</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar"
                aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title text-center" id="offcanvasDarkNavbarLabel" data-i18n="menuTitle">Menú
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="almacenero.php" data-i18n="profile">Perfil</a>
                        <li class="nav-item active">
                            <a class="nav-link active" aria-current="page" href="paquetes.php" data-i18n="packages">Paquetes</a>
                        </li>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="lotes.php" data-i18n="lots">Lotes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="recolecciones.php" data-i18n="collections">Recolecciones</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="troncales.php" data-i18n="trunks">Troncales</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="entregas.php" data-i18n="deliveries">Entregas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="vehiculos.php"
                                data-i18n="vehicles">Vehiculos</a>
                        </li>
                        <li>
                            <p class="nav-link" aria-current="page" onclick="changeLanguage()" data-i18n="changeLanguage">Change language</p>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="../../HOMEPAGE/VISTA/index.php" data-i18n="logout">Salir</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <br>
        <div class="row mt-4">
            <div class="col-md-6">
                <a href="../VISTA/paquetesRegistrar.php"><button type="button" class="btn btn-secondary" data-i18n="registerPackage">Registrar paquete</button></a>
                <a href="../VISTA/paquetesEntregar.php"><button type="button" class="btn btn-secondary" data-i18n="deliverPackage">Entregar paquete</button></a>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-4" data-i18n="packagesHeading">Paquetes sin entregar</h1>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "entregarPaquete") {
                        echo '<p class="text-warning">Error al entregar paquete</p>';
                    }
                    if ($_GET["error"] == "agregarPaquete") {
                        echo '<p class="text-warning">Error al agregar paquete</p>';
                    }

                } ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" data-i18n="identifier">Identificador</th>
                            <th scope="col" data-i18n="destination">Destino</th>
                            <th scope="col" data-i18n="status">Estado</th>
                            <th scope="col" data-i18n="receipt">Recibo</th>
                            <th scope="col" data-i18n="delivery">Entrega</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        ($paquetes = $almaceneroModel->paquetesPlatafoma($almacenero['id_plataforma']));
                        $resultArray = [];
                        foreach ($paquetes as $fila) {
                            $paquete = $fila['id_paquete'];
                            $destino = $fila['destino'];
                            $estado = $fila['estado'];
                            $recibo = $fila['fecha_recibo'];
                            $entrega = $fila['fecha_entrega'];
                            if (empty($recibo)) {
                                $recibo = '-';
                            }
                            if (empty($entrega)) {
                                $entrega = '-';
                            }
                        ?>
                            <tr>
                                <td>
                                    <?php echo $paquete ?>
                                </td>
                                <td>
                                    <?php echo $destino; ?>
                                </td>
                                <td>
                                    <?php echo $estado; ?>
                                </td>
                                <td>
                                    <?php echo $recibo; ?>
                                </td>
                                <td>
                                    <?php echo $entrega; ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <a href="../VISTA/paquetesTodas.php"><button type="button" class="btn btn-secondary" data-i18n="history">Historial</button></a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"
        integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc"
        crossorigin="anonymous"></script>
    <script>
        var textStrings = {
            es: {
                profile: "Perfil",
                packages: "Paquetes",
                lots: "Lotes",
                collections: "Recolecciones",
                trunks: "Troncales",
                deliveries: "Entregas",
                changeLanguage: "Cambiar idioma",
                logout: "Salir",
                registerPackage: "Registrar paquete",
                deliverPackage: "Entregar paquete",
                packagesHeading: "Paquetes sin entregar",
                identifier: "Identificador",
                destination: "Destino",
                status: "Estado",
                receipt: "Recibo",
                delivery: "Entrega",
                history: "Historial"
            },
            en: {
                profile: "Profile",
                packages: "Packages",
                lots: "Lots",
                collections: "Collections",
                trunks: "Trunks",
                deliveries: "Deliveries",
                changeLanguage: "Change language",
                logout: "Logout",
                registerPackage: "Register Package",
                deliverPackage: "Deliver Package",
                packagesHeading: "Undelivered Packages",
                identifier: "Identifier",
                destination: "Destination",
                status: "Status",
                receipt: "Receipt",
                delivery: "Delivery",
                history: "History"
            }
        };

        function changeLanguage() {
            var htmlTag = document.getElementsByTagName('html')[0];
            var language = htmlTag.getAttribute('lang');
            if (language === 'en') {
                htmlTag.setAttribute('lang', 'es');
                updateText('es');
            } else {
                htmlTag.setAttribute('lang', 'en');
                updateText('en');
            }
        }

        function updateText(language) {
            var elements = document.querySelectorAll('[data-i18n]');
            elements.forEach(function (element) {
                var key = element.getAttribute('data-i18n');
                if (textStrings[language][key]) {
                    element.innerText = textStrings[language][key];
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            updateText('es');
        });
    </script>
</body>

</html>
