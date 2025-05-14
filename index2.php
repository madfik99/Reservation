<?php
$sizes = [
    'Grey' => 'https://media.adtorqueedge.com/new-cars/neta-my/neta-x/colours/grey.webp',
    'Black' => 'https://media.adtorqueedge.com/new-cars/neta-my/neta-x/colours/black.webp',
    'White' => 'https://media.adtorqueedge.com/new-cars/neta-my/neta-x/colours/white.webp',
    'Blue' => 'https://media.adtorqueedge.com/new-cars/neta-my/neta-x/colours/blue.webp',
    'Brown' => 'https://media.adtorqueedge.com/new-cars/neta-my/neta-x/colours/brown.webp',
];

// Default active color
$defaultSize = 'Grey';  // Ensure this matches one of the keys in $sizes
$defaultImg = $sizes[$defaultSize];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Color Selector (PHP)</title>
  <style>
    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      overflow: hidden;
    }

    body {
      font-family: Arial, sans-serif;
      text-align: center;
    }

    .container {
      position: relative;
      width: 100%;
      height: 100%;
      background: url('<?php echo $defaultImg; ?>') no-repeat center center;
      background-size: contain;
    }

    .overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    background: rgba(0, 0, 0, 0.9); /* Fully dark at first */
    transition: background-position 0.05s ease;
    }


    .content {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      color: white;
      z-index: 2;
      text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
    }

    .size-label {
      font-size: 24px;
      margin-bottom: 20px;
      font-weight: bold;
    }

    .size-picker {
      list-style: none;
      padding: 0;
      display: inline-flex;
      gap: 15px;
    }

    .size-picker li {
      display: inline-block;
    }

    .size-picker li a {
      display: block;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      cursor: pointer;
      border: 2px solid #fff;
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .size-picker li a.active {
      transform: scale(1.2);
      box-shadow: 0 0 10px rgba(0, 123, 255, 0.6);
    }

    /* Color buttons styling */
    .Grey { background-color: grey; }
    .Black { background-color: black; }
    .White { background-color: white; border: 2px solid #000; }
    .Blue { background-color: blue; }
    .Brown { background-color: brown; }

    /* Red Button matching the color button style */
    .red-button {
      display: block;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background-color: red;
      border: 2px solid #fff;
      cursor: pointer;
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .red-button.active {
      transform: scale(1.2);
      box-shadow: 0 0 10px rgba(255, 0, 0, 0.6);
    }

    .purple-button {
      display: block;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background-color: purple;
      border: 2px solid #fff;
      cursor: pointer;
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .purple-button.active {
      transform: scale(1.2);
      box-shadow: 0 0 10px rgba(128, 0, 128, 0.6);
    }


    .typing-title {
  font-size: 4rem;
  font-weight: bold;
  text-transform: uppercase;
  letter-spacing: 5px;
  color: white;
  display: inline-block;
  overflow: hidden;
  white-space: nowrap;
  border-right: 3px solid white;
  width: 0;
  animation: typeErase 4s steps(10) infinite, blinkCaret 0.75s step-end infinite;
}

.typing-title .highlight {
  color: red;
}

@keyframes typeErase {
  0% {
    width: 0;
  }
  25% {
    width: 100%;
  }
  50% {
    width: 100%;
  }
  75% {
    width: 0;
  }
  100% {
    width: 0;
  }
}

@keyframes blinkCaret {
  50% {
    border-color: transparent;
  }
  100% {
    border-color: white;
  }
}



  </style>
</head>
<body>

  <div class="container">
    <div class="overlay" id="spotlight"></div>
    <div class="content">
  <h1 class="typing-title">
    <span class="word">NETA</span><span id="colorX"> X</span>
  </h1>



  <div class="size-label" id="sizeLabel"><?php echo $defaultSize; ?></div>

  <ul class="size-picker">
    <?php foreach ($sizes as $size => $img): ?>
      <li>
        <a href="#"
           class="size-option <?php echo ($size === $defaultSize) ? 'active ' . $size : $size; ?>"
           data-size="<?php echo $size; ?>"
           data-img="<?php echo $img; ?>"
           style="background-color: <?php echo $size; ?>;">
        </a>
      </li>
    <?php endforeach; ?>
    
    <!-- Red Button that links to another page -->
    <a href="index3.php" class="red-button"></a>
    <a href="index.php" class="purple-button"></a>

  </ul>
</div>

  </div>

  <script>
    const options = document.querySelectorAll('.size-option');
    const spotlight = document.getElementById('spotlight');
    const sizeLabel = document.getElementById('sizeLabel');
    const container = document.querySelector('.container');

    options.forEach(option => {
      option.addEventListener('click', function(e) {
        e.preventDefault();

        // Remove active class from all and reset background color
        options.forEach(opt => opt.classList.remove('active'));

        // Add active to clicked
        this.classList.add('active');

        // Update background image
        const newImg = this.getAttribute('data-img');
        container.style.backgroundImage = `url('${newImg}')`;
        sizeLabel.textContent = this.getAttribute('data-size');


        // Update the color button style for active color
        const activeColor = this.getAttribute('data-size');
        options.forEach(opt => {
          if (opt.getAttribute('data-size') === activeColor) {
            opt.classList.add('active');
          } else {
            opt.classList.remove('active');
          }
        });
      });
    });

    document.addEventListener('mousemove', (e) => {
    const x = e.clientX;
    const y = e.clientY;

    // Making the light brighter by increasing opacity and tweaking the gradient size
    spotlight.style.background = `radial-gradient(circle 300px at ${x}px ${y}px, rgba(0, 0, 0, 0.0) 0%, rgba(0, 0, 0, 0.9) 100%)`;

    });

    document.addEventListener('mouseleave', () => {
    spotlight.style.background = `rgba(0,0,0,0.9)`; // Brighter dark overlay when mouse leaves
    });


    const colorX = document.getElementById('colorX');

    options.forEach(option => {
    option.addEventListener('click', function(e) {
        e.preventDefault();

        // Remove all active states
        options.forEach(opt => opt.classList.remove('active'));
        this.classList.add('active');

        const newImg = this.getAttribute('data-img');
        const selectedColor = this.getAttribute('data-size');
        container.style.backgroundImage = `url('${newImg}')`;
        sizeLabel.textContent = selectedColor;

        // Set X color and handle text shadow
        colorX.style.color = selectedColor.toLowerCase();
        if (selectedColor.toLowerCase() === 'white') {
        colorX.style.textShadow = '0 0 5px #000';
        } else if (selectedColor.toLowerCase() === 'black') {
        colorX.style.textShadow = '0 0 5px #fff';
        } else {
        colorX.style.textShadow = 'none';
        }
    });
    });


    // On page load, set the color of X to match the default color
    window.addEventListener('DOMContentLoaded', () => {
    const defaultColor = "<?php echo strtolower($defaultSize); ?>"; // e.g., 'grey'
    const colorX = document.getElementById('colorX');

    colorX.style.color = defaultColor;

    if (defaultColor === 'white') {
        colorX.style.textShadow = '0 0 5px #000';
    } else if (defaultColor === 'black') {
        colorX.style.textShadow = '0 0 5px #fff';
    } else {
        colorX.style.textShadow = 'none';
    }
    });


  </script>

</body>
</html>
