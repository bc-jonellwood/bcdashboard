<?php
// Created: 2024/09/26 14:26:01
// Last modified: 2024/10/01 15:51:49
// session_start();
// include "./components/header.php"
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <link rel="stylesheet" href="styles/theme.css">
    <link rel="stylesheet" href="styles/custom.css">
</head>

<body>
    <div class="confetti" id="confetti"></div>
    <div>
        <h1>Success!</h1>
        <p>Your submission was successful.</p>
    </div>

    <script>
        // Function to create confetti effect
        function createConfetti() {
            const colors = ['#FFC700', '#FF3D00', '#FF6F00', '#D50000', '#00C853', '#00B0FF', '#6200EA'];
            const confettiContainer = document.getElementById('confetti');

            for (let i = 0; i < 100; i++) {
                const confettiPiece = document.createElement('div');
                confettiPiece.style.position = 'absolute';
                confettiPiece.style.width = '10px';
                confettiPiece.style.height = '10px';
                confettiPiece.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                confettiPiece.style.opacity = Math.random();
                confettiPiece.style.left = Math.random() * 100 + 'vw';
                confettiPiece.style.top = Math.random() * 100 + 'vh';
                confettiPiece.style.transform = `rotate(${Math.random() * 360}deg)`;
                confettiContainer.appendChild(confettiPiece);

                // Animate confetti falling
                setTimeout(() => {
                    confettiPiece.style.transition = 'transform 3s ease-in';
                    confettiPiece.style.transform += ' translateY(100vh)';
                }, 0);
            }
        }

        // Redirect after 2 seconds
        setTimeout(() => {
            try {
                window.location.href = 'index.php';
            } catch (error) {
                console.error('Redirection failed:', error);
            }
        }, 3000);

        // Start confetti effect
        createConfetti();
    </script>
</body>

</html>

<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: var(--bg);
        font-family: Arial, sans-serif;
        text-align: center;
    }

    h1 {
        color: #4CAF50;
        font-size: 2.5em;
    }

    p {
        font-size: 1.2em;
        color: #555;
    }

    .confetti {
        position: absolute;
        width: 100%;
        height: 100%;
        pointer-events: none;
        overflow: hidden;
    }
</style>