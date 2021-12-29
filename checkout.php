<?php

require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

print_r($_SESSION);

$lista_carrito = array();

if ($productos != null) {
    foreach ($productos as $clave => $cantidad) {
        $sql = $con->prepare("SELECT id, nombre, precio, descuento, $cantidad AS cantidad FROM productos WHERE id=? AND activo=1");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
    }
}

//Lineas para pruebas

//session_destroy();
//print_r($_SESSION);

?>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Online</title>

    <!-- CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="css/estilos.css" rel="stylesheet">
</head>

<body>
    <!-- Barra de Navegacion-->
    <header>
    <div class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="#" class="navbar-brand">
                <strong>Tienda Online</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarHeader">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="#" class="nav-link active">Catalogo</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Contacto</a>
                    </li>
                </ul>

                <a href="carrito.php" class="btn btn-primary">
                    Carrito<span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
                </a>
            </div>
        </div>
    </div>
    </header>

    <!-- Contenido -->
    <main>
        <div class="container">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        
                        if ($lista_carrito == null) {
                            echo '<tr><td colspan="5" class="text-center"><b>Lista vacia</b></td></tr>';
                        } else {
                            $total=0;
                            foreach ($lista_carrito as $producto) {
                                $_id = $producto['id'];
                                $nombre = $producto['nombre'];
                                $precio = $producto['precio'];
                                $cantidad = $producto['cantidad'];
                                $descuento = $producto['descuento'];
                                $precio_desc = $precio - (($precio * $descuento) / 100);
                                $subtotal = $cantidad * $precio_desc;
                                $total += $subtotal;
                        ?>
                        
                                <tr>
                                    <td> <?php echo $nombre; ?></td>
                                    <td> <?php echo number_format($precio_desc, 2, '.',',') . MONEDA; ?></td>
                                    <td>
                                        <input type="number" min="1" max="10" step="1" value="<?php echo $cantidad ?>" size="5" id="cantidad_<?php echo $_id; ?>" onchange="">
                                    </td>
                                    <td> 
                                        <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]">
                                            <?php echo number_format($subtotal, 2, '.',',') . MONEDA; ?>
                                        </div>
                                    </td>
                                    <td><a href="#" id="eliminar" class="btn btn-warning btn-sm" data-bs-id="<?php echo $_id; ?>" data-bs-toogle="modal" data-bs-target="eliminaModal">Eliminar</a></td>
                                </tr>
                            <?php } ?>
                                <tr>
                                    <td colspan="3"></td>
                                    <td colspan="2">
                                        <p class="h3" id="total"><?php number_format($total_desc, 2, '.',',') . MONEDA; ?></p>
                                    </td>
                                </tr>
                    </tbody>
                        <?php } ?>
                </table>
            </div>
        </div>
    </main>

    <!--Scripts -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script>
        function addProducto(id, token) {
            let url= 'clases/carrito.php'
            let formData= new FormData()
            formData.append('id', id)
            formData.append('token', token)

            fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'
            }).then(response => response.json())
            .then(data => {
                if(data.ok) {
                    let elemento = document.getElementById("num_cart")
                    elemento.innerHTML = data.numero
                }
            })
        }
    </script>

</body>
</html>