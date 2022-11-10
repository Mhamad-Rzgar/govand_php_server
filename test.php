
<?php


// sql server

// $serverName = "DESKTOP-KCBI25R\SQLEXPRESS";
// $connectionOptions = array(
//     "Database" => "mytestdb",
//     "Uid" =>  "",
//     "PWD" =>  "HHaa1414@"
// );


//Establishes the connection
// sqlsrv_connect($serverName, $connectionOptions);


// echo sqlsrv_connect($serverName, $connectionOptions);
// // sqlServer connection in php

// if(conn){
//     echo "Connection established";
// } else{
//     echo "Connection could not be established";
//     die(print_r(sqlsrv_errors(), true));
// }


$serverName = "DESKTOP-KCBI25R\SQLEXPRESS";

$connectionOptions = [
    "Database" => "mytestdb",
    "Uid" =>  "",
    "PWD" =>  ""
];

echo strtotime(Date("Y-m-d H:i:s"));

$conn = sqlsrv_connect($serverName, $connectionOptions);
// Check connection
if (!$conn) {
    echo "</br>Connection could not be established</br>";
}
echo $conn;
// return unix timestamp split with t and z

echo strtotime(Date("Y-m-d H:i:s"));
echo "</br>";
echo date('y-m-d');