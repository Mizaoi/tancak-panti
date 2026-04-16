<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SI-TANCAK PANTI</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="style/navbar.css">
    <link rel="stylesheet" href="style/home.css">
    
    <style>
        /* Menggunakan font bawaan perangkat (System Native Fonts) sesuai arahanmu */
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
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

    <script src="js/navbar.js"></script>
    <script src="js/home.js"></script>

</body>
</html>