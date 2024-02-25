<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Frame Price Estimator</title>
</head>
<body>
<div>
    <h1>Frame Price Estimator</h1>

    <?php
    //extraction of the user input, input is checked for html tags to avoid errors
    $width = strip_tags(isset($_POST["width"]) ? $_POST["width"] : "");
    $height = strip_tags(isset($_POST["height"]) ? $_POST["height"] : "");
    $postage = isset($_POST["postage"]) ? $_POST["postage"] : "";
    $VAT = isset($_POST["vat"]);
    $receiveEmails = isset($_POST["receiveEmails"]);
    $unit = isset($_POST["unit"]) ? $_POST["unit"] : "";
    $email = strip_tags(isset($_POST["email"]) ? $_POST["email"] : "");
    $unitChecker = unitChecker($unit);
    $price = "";

    $economyCheck = "checked";
    $nextdayCheck = "";
    $rapidCheck = "";
    $VATcheck = "checked";
    $receiveEmailsCheck = "checked";

    $mmCheck = "selected";
    $cmCheck = "";
    $inchCheck = "";

    $widthErr = "";
    $heightErr = "";
    $emailErr = "";

    //conditions for error checking to work out the correct error message
    //height and width are checked to be between 0.2 and 2 m inclusive
    if($width === "" || $height === "" || !is_numeric($width) || !is_numeric($height) || (($height / $unitChecker) <= 0.2) || ($height / $unitChecker) >= 2 || ($width / $unitChecker) <= 0.2 || ($width / $unitChecker) >= 2 || (!filter_var($email, FILTER_VALIDATE_EMAIL) && $receiveEmails == "checked")) {

        //checks if form has been completed before or not
        if($_SERVER["REQUEST_METHOD"]==="POST") {

            //conditions for error messages
            if (($width === "")) {
                $widthErr = "*Please enter a value for width";
            } elseif (!is_numeric($width)) {
                $widthErr = "*Please enter a numeric width value";
                $width = $_POST["width"];
            } elseif ((($width / $unitChecker) <= 0.2 || ($width / $unitChecker) >= 2)) {
                $widthErr = "*Please enter a value between 0.2 m and 2 m";
                $width = $_POST["width"];
            }

            if (($height === "")) {
                $heightErr = "*Please enter a value for height";
            } elseif (!is_numeric($height)) {
                $heightErr = "*Please enter a numeric height value";
                $height = $_POST["height"];
            } elseif ((($height / $unitChecker) <= 0.2 || ($height / $unitChecker) >= 2)) {
                $heightErr = "*Please enter a value between 0.2 m and 2 m";
                $height = $_POST["height"];
            }

            if ($email === "" && $receiveEmails == "checked") {
                $emailErr = "*Please enter a value for email";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && $receiveEmails == "checked") {
                $emailErr = "*Please enter a valid email";
                $email = $_POST["email"];
            }

            if($VAT != "checked"){
                $VATcheck = "";
            }

            if($receiveEmails != "checked"){
                $receiveEmailsCheck = "";
            }

            if($postage == "economy"){
                $economyCheck = "checked";

            }
            elseif($postage == "rapid"){
                $rapidCheck = "checked";

            }
            else{
                $nextdayCheck = "checked";

            }

            if($unit == "mm"){
                $mmCheck = "selected";

            }
            elseif($unit == "cm"){
                $cmCheck = "selected";

            }
            else{
                $inchCheck = "selected";

            }


        }

        ?>


        <form action="framing.php" method="post">

            <p><b><?php echo $widthErr; ?></b></p>
            <p>Photo Width: <input type ="text" name="width" value = "<?php echo $width; ?>"/>
                <select name="unit" id="unit">
                    <option value="mm" <?php echo $mmCheck; ?>>mm</option>
                    <option value="cm" <?php echo $cmCheck; ?>>cm</option>
                    <option value="inch" <?php echo $inchCheck; ?>>inch</option>
                </select>
            </p>

            <p><b><?php echo $heightErr; ?></b></p>
            <p>Photo Height: <input type ="text" name="height" value = "<?php echo $height; ?>"/></p>


            <p>Postage:
                <input type="radio" id="economy" name="postage" value="economy" <?php echo $economyCheck; ?>>
                <label for="economy">Economy</label>
                <input type="radio" id="rapid" name="postage" value="rapid" <?php echo $rapidCheck; ?>>
                <label for="rapid">Rapid</label>
                <input type="radio" id="nextday" name="postage" value="nextday" <?php echo $nextdayCheck; ?>>
                <label for="nextday">Next Day</label>

            </p>

            <p><input type="checkbox" id="vat" name="vat" <?php echo $VATcheck; ?>>
                <label for="vat">Include VAT in price</label>
            </p>

            <p><b><?php echo $emailErr; ?></b></p>
            <p>Enter you email to receive a copy of the quotation: <input type ="text" name="email" value = "<?php echo $email; ?>"/></p>

            <p><input type="checkbox" id="receiveEmails" name="receiveEmails"  <?php echo $receiveEmailsCheck; ?>>
                <label for="receiveEmails">Receive mail and future information about my framing calculation</label>
            </p>

            <p><input type="submit" /></p>
        </form>


        <?php
    }

    else {

        //converts width and height to metres
        if ($unit == "mm") {
            $width = $width / 1000;
            $height = $height / 1000;
        } elseif ($unit == "inch") {
            $width = $width / 39.37;
            $height = $height / 39.37;
        } else {
            $width = $width / 100;
            $height = $height / 100;
        }


        //price calculation
        $price = price($width, $height);
        $exVatPrice = $price;
        //price calculation with VAT
        if ($VAT == "checked") {
            $price = number_format((1.2 * $price), 2);
            echo 'Your frame will cost £' . $price;
            $message = 'Your frame will cost £' . $price;

            //price calculation with delivery plus VAT on delivery
            $delivery = number_format(((1.2 * postage($width, $height, $postage))), 2);
            $price = number_format(($price + $delivery), 2);

            echo ' plus ' . $postage . ' postage of £' . $delivery . ' giving a total price of £' . $price . ' including VAT.';
            $message = $message . (' plus ' . $postage . ' postage of £' . $delivery . ' giving a total price of £' . $price . ' including VAT.');
        } else {
            //price without VAT
            echo 'Your frame will cost £' . $price;
            $message = 'Your frame will cost £' . $price;

            //price calculation with delivery
            $delivery = number_format(postage($width, $height, $postage),2);
            $price = number_format(($price + $delivery), 2);
            echo ' plus ' . $postage . ' postage of £' . $delivery;

            echo ' giving a total price of £' . $price . ' excluding VAT.';
            $message = $message . (' plus ' . $postage . ' postage of £' . $delivery . ' giving a total price of £' . $price . ' excluding VAT.');
        }

        //send email
        $link = "https://www.strath.ac.uk/";
        $subject = "Quotation";
        $message = $message . "\n\nThank you for your interest.\n\nTo place your order follow: https://devweb2021.cis.strath.ac.uk/~gtb19141/asm/index.html";

        mail($email, $subject, $message);

        //add email to database
        if($receiveEmails == "checked"){

            $dateTime = date("Y-m-d H:i:s");
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
            $sql = "INSERT INTO `framingDatabase`(`id`, `width`, `height`, `postage`, `email`, `price`, `requested`) VALUES (NULL,'$width','$height','$postage','$email','$exVatPrice','$dateTime');";

            if($conn->query($sql) === TRUE){
                $conn->insert_id;
            }
            else{
                echo "false";
                die("Error:".$sql."<br>".$conn->error);
            }

            //Disconnect
            $conn->close();
            //header();

        }
    }



    function price($width, $height){
        //converts width and height to m, calculates price from formula give, formats and rounds result to two decimal places

        return number_format( (pow( (($width) * ($height)),2) + (100 * (($width) * ($height)) ) + 6),2);
    }

    //works out postage depending on chosen method
    function postage($width, $height, $postage){
        $L = max($width,$height);

        if($postage == "economy"){
            return ((2 * $L) + 4);
        }
        elseif($postage == "rapid"){
            return ((3 * $L) + 8);
        }
        else{
            return ((5 * $L) + 12);
        }

    }


    function unitChecker($unit){

        if ($unit == "mm") {
            return 1000;
        } elseif ($unit == "inch") {
            return 39.37;
        } else {
            return 100;
        }
    }



    ?>
</div>
</body>
</html>
