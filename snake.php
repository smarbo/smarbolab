<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/snakestyle.css">
    <title>Snakee</title>
</head>
<body>
    <a href="app.php" style="color: white; font-size: 40px; font-family: 'Raleway', sans-serif; text-decoration: none;">Back to App</a>
    <div id="gameContainer">
        <canvas id="gameBoard" width="500" height="500"></canvas>
        <div id="scoreText">0</div>
        <button id="resetBtn">Play</button>
    </div>
    <h1>Mods</h1>
    <div id="mods-box">
        <input type="number" placeholder="Game Speed" id="gameSpeed" class="mod-input" style="margin-top: 20px;">
        <input type="text" placeholder="Snake Color" id="snakeColor" class="mod-input">
        <input type="text" placeholder="Food Color" id="foodColor" class="mod-input">
        <input type="text" placeholder="Snake Outline Color" id="snakeBorder" class="mod-input">
        <button id="submitMods" type="button">Update</button>
    </div>
    
    
    <script src="scripts/snake.js"></script>
</body>
</html>