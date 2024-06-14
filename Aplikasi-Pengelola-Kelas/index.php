<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Options</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body style="background: url('image/vokasi.png') no-repeat center center fixed; background-size: cover;">
    <div class="index">
    <div class="container">
        <h1>Pilih Login</h1>
        <form method="post">
            <button type="submit" name="role" value="admin" class="button">
                <i class="fas fa-user-shield"></i> Admin
            </button>
            <button type="submit" name="role" value="koordinator" class="button">
                <i class="fas fa-user-tie"></i> Koordinator
            </button>
        </form>
    </div>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $role = $_POST['role'];
        if ($role == 'admin') {
            header('Location: login-admin.php');
        } elseif ($role == 'koordinator') {
            header('Location: login-koordinator.php');
        }
        exit();
    }
    ?>
</body>
</html>
