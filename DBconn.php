
    <?php
    // DB details
    $servername = "";
    $username = "";
    $password = "";
    $dbname = "todolist";
    
    $connstr = getenv("MYSQLCONNSTR_MySqlDB");    
    
    //Parse the above environment variable to retrieve username, password and hostname.
    foreach ($_SERVER as $key => $value) 
    {
        if (strpos($key, "MYSQLCONNSTR_") !== 0) 
        {
            continue;
        }
        $servername = preg_replace("/^.*Data Source=(.+?);.*$/", "\\1", $value);
        $username = preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $value);
        $password = preg_replace("/^.*Password=(.+?)$/", "\\1", $value);
        break;
    }

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
       
    ?>