<?php

//OMAR************************************************************************
// !!!!         LAST UPDATED 04/05/22 11:42 PM




//receives data values from fetch and stores in variables...
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$lastName2 = $_POST['lastName2'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$address = $_POST['address'];
$locker = $_POST['locker'];


/*
//database information[LOCAL]
$servername = "localhost:3306";
$username = "root";
$password = "password";
$database = "userdatabase";
*/
//database information[HOSTING]

$servername = "localhost";
$username = "ectomor6_wp71";
$password = "19930507oD!";
$database = "dbpqgzoegdwitg";


//connecting to database...
$conn = new mysqli($servername, $username, $password, $database);

//first query to see if the email submitted is already in our database...

    $sql = "SELECT * FROM users WHERE email= ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s",$email);
//executing query...
    $stmt->execute();
    $result = $stmt->get_result(); //gets result object and stores it in variable...
    $rows = mysqli_num_rows($result); //gets number of rows of object and stores in variable...
    $stmt->close(); //close stmt object

    if($rows > 0){ //if rows are greater than 0 it means an email is already in the db...
        echo "false";
    }else{//if not, then store user with new query....
        $sql2 = "INSERT INTO users (firstname, lastname, lastname2, phone, email, address, locker)
                    VALUES (?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql2);
        $stmt->bind_param("sssssss", $firstName, $lastName, $lastName2, $phone, $email, $address, $locker);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();
        if($result === false){ //if execution returns 'false' an error happened...
                echo "false";
            }else{//if returns 'true' it was successful...
                echo "true";

                //LAST UPDATED APRIL 6   9:03 PM     *****************
                    //sending email
$bodyMessage = '<body style="background-color: #ffffff; color: #00002f; text-align: center">
            
<pre>Buenas tardes '.$firstName.', soy Ruth, CEO de PaMi Tierra Envíos. ¡Felicidades por la adquisición de tu casillero!


Con este casillero, ahora puedes comprar en las tiendas online de EE. UU. como si tú mismo vivieras allí. Eso significa que puedes disfrutar de todos los beneficios que los compradores americanos disfrutan...

    - Consigue productos 100% auténticos.

    - Acceso a productos de edición limitada, no disponible
    s en ningún otro lugar (solo en EE. UU.).

    - Acceso anticipado a productos meses antes de que lleguen a Colombia.

    - Oportunidad de participar en el famoso Viernes Negro (Black Friday), en el que los descuentos pueden llegar hasta el 70%.

    - Ventas mensuales imbatibles con numerosos productos.

    - Consigue los precios más bajos en tus marcas favoritas.

¿Y la mejor parte?


No tienes que preocuparte de nada más que comprar... nosotros nos encargamos de las tasas de importación, el papeleo, la recepción, el embalaje, la entrega, etc.


¡Ahora eres libre! Eres libre de tener que pagar en exceso, eres libre de estar sometido a límites de compras y eres libre de tener que hacer largas búsquedas de productos que, a menudo, se convierten en una decepción.


Ahora, sé que la percepción de comprar por Internet en otro país puede ser un poco intimidante, pero yo te aseguro que es supersimple y seguro.


Tanto es así, que cientos de nuestros clientes, de diferentes edades, ya lo están haciendo. Además, siempre estamos disponibles para ayudarte y guiarte a través de todo el proceso utilizando la red social WhatsApp.


Así que empecemos. </pre><h3>Proceso de compra<h3><p> Para completar con éxito tu primera compra, necesitarás 3 cosas.

1) Un método de pago: una tarjeta de crédito, una tarjeta prepago, o una aplicación de pago como PayPal o NEQUI

2) La dirección de tu casillero: 5401 NW 102 AVE, Ste 139, Sunrise, FL, 33351

3) El número de tu casillero: '.$locker.' </p><h4>Haz click <a href="https://pamitierraenvios.com">aquí</a> para ver todos los pasos en detalle</h4>
</body>';





                $to = $email;
                $subject = 'Bienvenido a PaMiTierra Envios :)!';
                $message = $bodyMessage;

                $headers = "From: PaMiTierra Envios<pamitierraenvios@gmail.com>\r\n";
                $headers .= "Reply-To: pamitierraenvios@gmail.com\r\n";
                $headers .= "Content-type: text/html\r\n";

                 $mailResult = mail($to, $subject, $message, $headers);
                    echo $mailResult.'emailsentsuccessfully';

        }
    }

