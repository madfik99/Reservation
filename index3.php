<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Page Not Found</title>
  <style>
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      overflow: hidden;
    }

    body {
      font-family: Arial, sans-serif;
    }

    .container {
      position: relative;
      width: 100%;
      height: 100vh;
      background-size: cover;
      background-position: center;
    }

    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      background: radial-gradient(
        circle 350px at 50% 50%,
        rgba(0,0,0,0) 0%,
        rgba(0,0,0,0.9) 100%
      );
      transition: background-position 0.05s ease;
    }

    .content {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      color: white;
      text-align: center;
      z-index: 2;
    }

    .content h1 {
      font-size: 3em;
      margin-bottom: 0.5em;
    }

    .content p {
      font-size: 1.5em;
    }

    .content a {
      margin-top: 20px;
      display: inline-block;
      padding: 10px 20px;
      background-color: #fff;
      color: #000;
      text-decoration: none;
      border-radius: 5px;
    }

    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap');

.glitch-wrapper {
  display: flex;
  align-items: center;
  justify-content: center;
  background: transparent;
}


.glitch-text {
  font-family: 'Montserrat', sans-serif;
  font-size: 3rem;
  color: #fff;
  position: relative;
  text-transform: uppercase;
  letter-spacing: 2px;
  animation: glitch-skew 1s infinite linear alternate-reverse;
}

.glitch-text::before,
.glitch-text::after {
  content: attr(data-text);
  position: absolute;
  top: 0;
  left: 0;
  opacity: 0.8;
  color: white;
  background: transparent;
  overflow: hidden;
  pointer-events: none;
}

.glitch-text::before {
  color: #ff00c1;
  z-index: -1;
  transform: translate(-2px, 0);
  animation: glitch-top 1s infinite linear alternate-reverse;
}

.glitch-text::after {
  color: #00fff9;
  z-index: -2;
  transform: translate(2px, 0);
  animation: glitch-bottom 1s infinite linear alternate-reverse;
}

@keyframes glitch-skew {
  0% { transform: skew(0deg); }
  20% { transform: skew(-2deg); }
  40% { transform: skew(2deg); }
  60% { transform: skew(-1deg); }
  80% { transform: skew(1deg); }
  100% { transform: skew(0deg); }
}

@keyframes glitch-top {
  0% { clip-path: inset(0 0 80% 0); transform: translate(-2px, -2px); }
  50% { clip-path: inset(0 0 40% 0); transform: translate(2px, 2px); }
  100% { clip-path: inset(0 0 80% 0); transform: translate(-2px, -2px); }
}

@keyframes glitch-bottom {
  0% { clip-path: inset(80% 0 0 0); transform: translate(2px, 2px); }
  50% { clip-path: inset(50% 0 0 0); transform: translate(-2px, -2px); }
  100% { clip-path: inset(80% 0 0 0); transform: translate(2px, 2px); }
}


  </style>
</head>
<body>
  <div class="container" id="bgContainer">
    <div class="overlay" id="spotlight"></div>
    <div class="content">
      <div class="glitch-wrapper">
        <h1 class="glitch-text" data-text="Page not found">Page not found</h1>
      </div>
     <div><p>Hmm, the page you were looking for doesn’t seem to exist anymore.</p></div>
     <div><a href="/index2.php">Back to Home</a></div> 
    </div>
  </div>

  <script>
    const images = [
      'https://images.unsplash.com/photo-1494587351196-bbf5f29cff42?w=1600&auto=format&fit=crop&q=60',
      'https://images.unsplash.com/photo-1506744038136-46273834b3fb?w=1600&auto=format&fit=crop&q=60',
      'https://images.unsplash.com/photo-1470770841072-f978cf4d019e?w=1600&auto=format&fit=crop&q=60',
      'https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0?w=1600&auto=format&fit=crop&q=60',
      'https://images.unsplash.com/photo-1506765515384-028b60a970df?w=1600&auto=format&fit=crop&q=60',
      'https://images.unsplash.com/photo-1592079927444-590c17e87f28?w=1600&amp;dpr=2&amp;auto=format&amp;fit=crop&amp;q=60'
    ];

    

    const randomImage = images[Math.floor(Math.random() * images.length)];
    const container = document.getElementById('bgContainer');
    container.style.backgroundImage = `url('${randomImage}')`;

    document.addEventListener('mousemove', (e) => {
    const x = e.clientX;
    const y = e.clientY;
    spotlight.style.background = `radial-gradient(circle 250px at ${x}px ${y}px, rgba(0,0,0,0) 0%, rgba(0,0,0,0.9) 100%)`;
    });

    document.addEventListener('mouseleave', () => {
    spotlight.style.background = `rgba(0,0,0,0.9)`;
    });

  </script>
</body>
</html>
