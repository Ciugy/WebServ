<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple HTML Template</title>
</head>
<body>
    <h1>Welcome to My Simple HTML Page</h1>
    <p>    
        <?
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        echo "User-Agent: " . $userAgent;
        ?>
    </p>

</body>
</html>