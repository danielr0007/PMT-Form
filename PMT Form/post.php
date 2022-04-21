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
$bodyMessage = '<body style="background-color: #ffffff; color: #00002f; text-align: left">
            
<pre>Bienvenido(a) '.$firstName.', Soy Daniel, CEO de Pamitierraenvios. ¡Felicitaciones por la adquisición de tu casillero!


Tu número de casillero es: '.$locker.'


Anota ese número, ya que lo necesitaras para hacer tus compras en EEUU desde Colombia.


Abajo tienes un enlace que te llevara al PDF que tiene la dirección del casillero y los pasos para hacer tu primera compra.


Cualquier pregunta estamos disponibles vía WhatsApp o email; estamos aquí para ayudarte.


Whatsapp: +1 954 682 2058

</pre>

</p><h4>Haz click <a href="https://drive.google.com/file/d/1z_xK5uDUXLdsqDo0k0Fu_mmhl12Me0b_/view?usp=sharing">aquí</a> para ver todos los pasos en detalle</h4>
</body>';





                $to = $email;
                $subject = 'Bienvenido(a) a PaMiTierraEnvios!';
                $message = $bodyMessage;

                $headers = "From: PaMiTierra Envios<pamitierraenvios@gmail.com>\r\n";
                $headers .= "Reply-To: pamitierraenvios@gmail.com\r\n";
                $headers .= "Content-type: text/html\r\n";

                 $mailResult = mail($to, $subject, $message, $headers);
                    echo $mailResult.'emailsentsuccessfully';

        }
    }


