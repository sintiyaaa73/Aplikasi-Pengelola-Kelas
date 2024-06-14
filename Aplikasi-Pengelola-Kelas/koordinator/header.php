<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Informasi Kelas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .header {
            background-color: #373A40;
            padding: 20px;
        }
        .isi-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo h1 {
            margin: 0;
            font-size: 40px;
            color: #DC5F00;
        }
        .menu-atas ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .menu-atas ul li {
            margin-right: 50px;
        }
        .menu-atas ul li:last-child {
            margin-right: 0;
            font-size: 50px;
        }
        .menu-atas ul li a {
            color: #DC5F00;
            font-size: 25px;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .menu-atas ul li a i {
            margin-bottom: 5px;
        }
        .menu-atas ul li a:hover {
            color: #FFF;
        }
        .column {
            text-align: center;
            margin-top: 700px;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="isi-header">    
            <div class="logo">
                <h1>Fakultas Vokasi</h1>
            </div>
            <div class="menu-atas">
                <ul>
                    <li><a href="index.php"><i class="fas fa-home"></i>Dashboard</a></li>
                    <li><a href="ruangan data.php"><i class="fas fa-door-open"></i> Ruangan</a></li>
                    <li><a href="ruangan terpilih.php"><i class="fas fa-door-closed"></i> Ruangan Terpilih </a></li>
                    <li><a href="profile.php"><i class="fas fa-user"></i> Profile</a></li>
                </ul>
            </div>
        </div>
    </header>