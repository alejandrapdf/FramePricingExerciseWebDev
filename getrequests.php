<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Frame Price Estimator</title>
</head>
<body>
<div>

    <?php
    $password = strip_tags(isset($_POST["password"]) ? $_POST["password"] : "");
    $correctPass = "WannaTellMeHow";
    $passwordErr = "";

    if($password != $correctPass) {

        if($_SERVER["REQUEST_METHOD"]==="POST") {
        $passwordErr = "Incorrect password. Please try again!";
        }
        ?>
        <form action="getrequests.php" method="post">

            <p><b><?php echo $passwordErr; ?></b></p>
            <p>Enter password to access database:<input type ="text" name="password" value = "<?php echo $password; ?>"/></p>
            <p><input type="submit" /></p>
        </form>


        <?php
    }

    else {


        //Connect to MySQL
        $host = "devweb2021.cis.strath.ac.uk";
        $user = "gtb19141";//your username
        require_once "password.php";
        $pass = get_password();//your MySQL password
        $dbname = $user;
        $conn = new mysqli($host, $user, $pass, $dbname);



        if ($conn->connect_error) {
            die("Connection failed : " . $conn->connect_error); //FIXME remove once working.
        }

        //Issue the query
        $sql = "SELECT * FROM `framingDatabase`";
        $result = $conn->query($sql);

        if (!$result) {
            die("Query failed " . $conn->error); //FIXME remove once working.
        }

        //Handle the results
        $result->data_seek(0); // set the pointer back to the beginning to loop through data again

        echo "<hr>\n";

        echo "<table>\n";
        echo "<tr>\n";
        echo "<td><b>Width</b></td>\n";
        echo "<td><b>Height</b></td>\n";
        echo "<td><b>Postage</b></td>\n";
        echo "<td><b>Email</b></td>\n";
        echo "<td><b>Price (ex VAT)</b></td>\n";
        echo "<td><b>Requested</b></td>\n";


        $todayDate = strtotime(date("Y-m-d H:i:s"));

        if ($result->num_rows > 0) {

            echo "<tr>\n";
            while ($row = $result->fetch_assoc()) {

                $bold = "";
                $boldEnd = "";
                $timestamp = strtotime($row["requested"]);

                $diff = (($todayDate - $timestamp)/60/60/24);

                if($row["postage"] == "economy" && ($diff > 7) ) {
                        $bold = "<b>";
                        $boldEnd = "</b>";
                }
                elseif($row["postage"] == "nextday" && ($diff > 1)){
                    $bold = "<b>";
                    $boldEnd = "</b>";
                }
                elseif($row["postage"] == "rapid" && ($diff > 3)){
                    $bold = "<b>";
                    $boldEnd = "</b>";
                }

                echo "<td>$bold".$row["width"]."$boldEnd</td>\n";
                echo "<td>$bold".$row["height"]."$boldEnd</td>\n";
                echo "<td>$bold".$row["postage"]."$boldEnd</td>\n";
                echo "<td>$bold".$row["email"] ."$boldEnd</td>\n";
                echo "<td>$bold".$row["price"] ."$boldEnd</td>\n";
                echo "<td>$bold".$row["requested"]."$boldEnd</td>\n";
                echo "</tr>\n";
            }
            echo "</table>\n";
        }

        //Disconnect
        $conn->close();


    }

    ?>
</div>
</body>
</html>