<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QR Code Generator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .box {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            width: 360px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,.1);
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 15px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px 18px;
            border: none;
            border-radius: 6px;
            background: #007bff;
            color: #fff;
            cursor: pointer;
            font-size: 15px;
            margin-top: 10px;
        }
        button:hover {
            background: #0056b3;
        }
        img {
            margin-top: 20px;
            border: 1px solid #ddd;
            padding: 8px;
            background: #fff;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>QR Code Generator</h2>

    <form method="post">
        <input type="url" name="url" placeholder="Enter URL (https://...)" required>
        <button type="submit">Generate QR</button>
    </form>

    <?php if (!empty($_POST['url'])): 
        $url = trim($_POST['url']);
    ?>
        <img src="qr.php?data=<?php echo urlencode($url); ?>" alt="QR Code">

        <form action="download.php" method="post">
            <input type="hidden" name="data" value="<?php echo htmlspecialchars($url); ?>">
            <button type="submit">⬇ Download QR</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
