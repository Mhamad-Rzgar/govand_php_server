<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


// mySql
$servername = "localhost";
$username = "root";
$password = "HHaa1414@";
$dbname = "mytestdb";


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}




/// access
// https://youtu.be/OYvn8bHsxY8 configuration in php.ini file find pod and uncomment extension=php_pdo_odbc.dll
$accessDb = new PDO("odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=C:\\Users\\SherdllStore\\Desktop\\govan.accdb;Uid=;Pwd=;");
$sqlServerConn = new PDO("sqlsrv:Server=DESKTOP-KCBI25R\SQLEXPRESS;Database=mytestdb");

// install sql server - https://youtu.be/C_KeaoJ6-Gc

// oracle with odbc
$tns = "  
(DESCRIPTION =
    (ADDRESS_LIST =
        (ADDRESS = (PROTOCOL = TCP)(HOST = 127.0.0.1)(PORT = 1521))
    )
    (CONNECT_DATA =
        (SERVICE_NAME = XE)
    )
    )
        ";
$db_username = "system";
$db_password = "HHaa1414@";

$oracleConn = new PDO("oci:dbname=".$tns, $db_username, $db_password);

// if ($oracleConn) {
//     echo "Connection established";
// }




if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $imageName = $_POST['imageName'];
    $imageData = $_POST['imageData'];


    // mysql
    if(str_starts_with($_SERVER["PATH_INFO"], "/api/mysql")){
        
        

        // $postBody = file_get_contents("php://input");

        // $postBody = json_decode($postBody, true);

        
        // $imageName = $postBody["imageName"];
        // $imageData = $postBody["imageData"];

        $sql = "INSERT INTO image (imageName, imageData) VALUES ('$imageName', '$imageData')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        exit;
    }

    // access
    else if(str_starts_with($_SERVER["PATH_INFO"], "/api/access")){
            
        header('Content-Type: application/json');
        
        // $postBody = file_get_contents("php://input");

        // $postBody = json_decode($postBody, true);


        // $imageName = $postBody["imageName"];
        // $imageData = $postBody["imageData"];

        $sql = "INSERT INTO assetData (imageName, imageData) VALUES ('$imageName', '$imageData')";

        if($accessDb->query($sql)){
            echo "New record created successfully";
        }
        else{
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // sqlServer
    else if(str_starts_with($_SERVER["PATH_INFO"], "/api/sqlServer")){
            
        header('Content-Type: application/json');
        
        // $postBody = file_get_contents("php://input");

        // $postBody = json_decode($postBody, true);

        // $imageName = $postBody["imageName"];
        // $imageData = $postBody["imageData"];

        $sql = "INSERT INTO image (imageName, imageData) VALUES ('$imageName', '$imageData')";

        if($sqlServerConn->query($sql)){
            echo "New record created successfully";
        }
        else{
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // oracle
    else if(str_starts_with($_SERVER["PATH_INFO"], "/api/oracle")){
            
        header('Content-Type: application/json');
        
        // $postBody = file_get_contents("php://input");

        // $postBody = json_decode($postBody, true);

        // $imageName = $postBody["imageName"];
        // $imageData = $postBody["imageData"];


        $sql = "INSERT INTO assetData (imageName, imageData) VALUES ('$imageName', '$imageData')";

        if($oracleConn->query($sql)){
            echo "New record created successfully";
        }
        else{
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    
    else{
        http_response_code(404);
        echo "check your url";
        exit;   
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    // mysql
    if(str_starts_with($_SERVER["PATH_INFO"], "/api/mysql")){
        
        header('Content-Type: application/json');
        $sql = "SELECT * FROM mytestdb.image ORDER BY imageId DESC limit 1";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            header('Content-Type: application/json');
            echo json_encode(array('imageId' => $row["imageId"], 'imageName' => $row["imageName"], 'imageData' => $row["imageData"], "startServerTime" => Date("Y-m-d H:i:s")));
        }
        } else {
            echo "0 results";
        }
    
        exit;
    }
    // access
     else if(str_starts_with($_SERVER["PATH_INFO"], "/api/access")){
            
        header('Content-Type: application/json');
        $sql = "SELECT TOP 1 * FROM assetData ORDER BY[imageId] DESC ";
        $result = $accessDb->query($sql);

        if ($result->rowCount() < 0) {
            echo json_encode($result->fetch(PDO::FETCH_ASSOC));
        } else {
            echo "0 results";
        }

        exit;
    }
    // sqlServer
     else if(str_starts_with($_SERVER["PATH_INFO"], "/api/sqlServer")){
        header('Content-Type: application/json');
        $sql = "SELECT TOP 1 * FROM[mytestdb].[dbo].[image] ORDER BY[imageId] DESC";
        $result = $sqlServerConn->query($sql);

        if ($result->rowCount() < 0) {
            echo json_encode($result->fetch(PDO::FETCH_ASSOC));
        }
         else {
            echo "0 results";
        }

        exit;
    } 
    // oracle
    else if(str_starts_with($_SERVER["PATH_INFO"], "/api/oracle")){
        header('Content-Type: application/json');
        $sql = "SELECT * FROM assetData ORDER BY imageId DESC";
        $result = $oracleConn->query($sql);
        $data = $result->fetch(PDO::FETCH_ASSOC);
        echo json_encode(array('imageId' => $data["IMAGEID"], 'imageName' => $data["IMAGENAME"], 'imageData' => $data["IMAGEDATA"]));
        exit;
    } 
    else{
        http_response_code(404);
        echo "check your url";
        exit;   
    }
}




// $sqlServerConn = sqlsrv_connect($serverName, $connectionOptions);
// // this line need this app -> https://go.microsoft.com/fwlink/?linkid=2199011

// if ($sqlServerConn === false) {
//     die(print_r(sqlsrv_errors(), true));
// }else echo "sqlServer connected";




// if (isset($_POST['mySql'])) {
//     echo($_POST);
//     // json
//     header('Content-Type: application/json');

//     // $imageName = $_POST['imageName'];
//     // $imageData = $_POST['imageData'];

//     // $sql = "INSERT INTO image (imageName, imageData) VALUES ('$imageName', '$imageData')";

//     // if ($conn->query($sql) === TRUE) {
//     //     echo "New record created successfully";
//     // } else {
//     //     echo "Error: " . $sql . "<br>" . $conn->error;
//     // }

//     // exit;
// }

// if (isset($_GET['mySql'])) {

//     $sql = "SELECT * FROM mytestdb.image ORDER BY imageId DESC limit 1";
//     $result = $conn->query($sql);

//     if ($result->num_rows > 0) {
//     // output data of each row
//     while($row = $result->fetch_assoc()) {

//         header('Content-Type: application/json');
//         echo json_encode(array('imageId' => $row["imageId"], 'imageName' => $row["imageName"], 'imageData' => $row["imageData"]));
//     }
//     } else {
//         echo "0 results";
//     }

//     exit;
// }

 
// insert to imageName and imageData to database






// foreach(PDO::getAvailableDrivers() as $driver)
//     echo $driver, '<br>';


// echo "dlse";
//// Sample array
//$data = array("a" => "Apple", "b" => "Ball", "c" => "Cat");
//
//header("Content-Type: application/json");
//echo json_encode($data);
//


?>