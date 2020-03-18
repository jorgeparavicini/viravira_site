<?php
function buildLogin(string $error = null)
{
    ?>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <h1>Login</h1>
    <div class="login">
        <?php
        if ($error !== null) {
            echo "<p class='error'>$error</p>";
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']) ?>" method="post">
            <label for="username"><i class="fas fa-user"></i></label>
            <input id="username" type="text" name="username" placeholder="Username" required>
            <label for="password"><i class="fas fa-lock"></i></label>
            <input id="password" type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>
    </div>
    <?php
}

?>

