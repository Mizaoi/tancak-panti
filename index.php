<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SI-TANCAK PANTI</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="style/navbar.css">
    <link rel="stylesheet" href="style/home.css">
    
    <style>
        /* Mengatur jenis tulisan untuk seluruh halaman */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #1a3326;
            overflow-x: hidden;
        }
    </style>
</head>
<body>

    <?php include 'components/navbar.php'; ?>

    <?php include 'pages/home.php'; ?>
    
    <?php include 'components/footer.php'; ?>

    <script src="js/navbar.js"></script>
    <script src="js/home.js"></script>

</body>
</html>