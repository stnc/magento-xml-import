<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <title>Login</title>
</head>
<body>
<form name="input" action="" method="post">
    <label for="username">Username:</label><input type="text" value="<?= $_POST["username"] ?>" id="username"
                                                  name="username"/>
    <label for="password">Password:</label><input type="password" value="" id="password" name="password"/>
    <div class="error"><?= $errorMsg ?></div>
    <input type="submit" value="Home" name="sub"/>
</form>
</body>
</html>
