<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN AND REGISTER</title>
    <style>
        /* --- CSS STYLES --- */
        :root {
            --primary-grad: linear-gradient(135deg, #00f2ff, #7000ff);
            --bg-color: #0a0a0a;
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
            --text-color: #ffffff;
            --input-bg: rgba(0, 0, 0, 0.3);
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: var(--bg-color);
            /* Subtle background grid for tech feel */
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 30px 30px;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-color);
        }

        .container {
            background: var(--glass-bg);
            backdrop-filter: blur(10px); /* The "Frosted Glass" effect */
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            padding: 40px;
            width: 350px;
            box-shadow: 0 0 40px rgba(112, 0, 255, 0.1);
            text-align: center;
        }

        /* Logo Positioning */
        .logo-container {
            margin-bottom: 20px;
            animation: float 6s ease-in-out infinite;
        }

        /* Toggle Buttons (Login vs Register) */
        .toggle-box {
            display: flex;
            justify-content: space-around;
            margin-bottom: 30px;
            border-bottom: 1px solid var(--glass-border);
            padding-bottom: 10px;
        }

        .toggle-btn {
            background: none;
            border: none;
            color: #888;
            font-size: 16px;
            cursor: pointer;
            padding: 10px 20px;
            transition: 0.3s;
            font-weight: bold;
        }

        .toggle-btn.active {
            color: #fff;
            text-shadow: 0 0 10px rgba(0, 242, 255, 0.8);
            border-bottom: 2px solid #00f2ff;
        }

        /* Form Inputs */
        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 12px;
            color: #aaa;
            letter-spacing: 1px;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            box-sizing: border-box; /* Ensures padding doesn't break width */
            border: 1px solid #333;
            border-radius: 6px;
            background: var(--input-bg);
            color: #fff;
            outline: none;
            transition: 0.3s;
        }

        /* The Neon Glow on Focus */
        .input-group input:focus {
            border-color: #00f2ff;
            box-shadow: 0 0 8px rgba(0, 242, 255, 0.3);
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 6px;
            background: var(--primary-grad);
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-submit:hover {
            opacity: 0.9;
            box-shadow: 0 0 20px rgba(112, 0, 255, 0.4);
            transform: translateY(-1px);
        }

        /* Hiding/Showing Forms */
        .form-box {
            display: none;
            animation: fadein 0.5s;
        }
        
        .form-box.active {
            display: block;
        }

        /* Animations */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        @keyframes fadein {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="container">
    
    <div class="logo-container">
        <svg width="80" height="80" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <linearGradient id="mainGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" style="stop-color:#00f2ff;stop-opacity:1" />
                    <stop offset="100%" style="stop-color:#7000ff;stop-opacity:1" />
                </linearGradient>
                <linearGradient id="darkGradient" x1="0%" y1="100%" x2="100%" y2="0%">
                    <stop offset="0%" style="stop-color:#5a00d1;stop-opacity:1" />
                    <stop offset="100%" style="stop-color:#00c8d4;stop-opacity:1" />
                </linearGradient>
                <filter id="glow" x="-20%" y="-20%" width="140%" height="140%">
                    <feGaussianBlur stdDeviation="2.5" result="coloredBlur" />
                    <feMerge>
                        <feMergeNode in="coloredBlur" />
                        <feMergeNode in="SourceGraphic" />
                    </feMerge>
                </filter>
            </defs>
            <g filter="url(#glow)">
                <path d="M100 40 L150 65 L100 90 L50 65 Z" fill="url(#mainGradient)" />
                <path d="M150 65 L150 115 L100 140 L100 90 Z" fill="url(#darkGradient)" />
                <path d="M50 65 L100 90 L100 140 L50 115 Z" fill="url(#mainGradient)" opacity="0.9" />
                <path d="M100 90 L100 140" stroke="white" stroke-width="1" stroke-opacity="0.3" />
                <path d="M100 90 L150 65" stroke="white" stroke-width="1" stroke-opacity="0.3" />
                <path d="M100 90 L50 65" stroke="white" stroke-width="1" stroke-opacity="0.3" />
            </g>
        </svg>
    </div>

    <div class="toggle-box">
        <button id="login-btn" class="toggle-btn active" onclick="showLogin()">LOGIN</button>
        <button id="register-btn" class="toggle-btn" onclick="showRegister()">REGISTER</button>
    </div>

    <div id="login-form" class="form-box active">
        <div class="input-group">
            <label>EMAIL</label>
            <input type="email" placeholder="user@example.com">
        </div>
        <div class="input-group">
            <label>PASSWORD</label>
            <input type="password" placeholder="••••••••">
        </div>
        <button class="btn-submit">LOGIN</button>
    </div>

    <div id="register-form" class="form-box">
        <div class="input-group">
            <label>USERNAME</label>
            <input type="text" placeholder="Desired Username">
        </div>
        <div class="input-group">
            <label>EMAIL</label>
            <input type="email" placeholder="user@example.com">
        </div>
        <div class="input-group">
            <label>PASSWORD</label>
            <input type="password" placeholder="Create Password">
        </div>
        <button class="btn-submit">REGISTER</button>
    </div>

</div>

<script>
    // Simple JavaScript to handle the toggle
    function showLogin() {
        document.getElementById('login-form').classList.add('active');
        document.getElementById('register-form').classList.remove('active');
        document.getElementById('login-btn').classList.add('active');
        document.getElementById('register-btn').classList.remove('active');
    }

    function showRegister() {
        document.getElementById('register-form').classList.add('active');
        document.getElementById('login-form').classList.remove('active');
        document.getElementById('register-btn').classList.add('active');
        document.getElementById('login-btn').classList.remove('active');
    }
</script>

</body>
</html>