<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Staff · Raund Raund</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap"></noscript>
    <style>
        :root {
            --dark: #2c1e10;
            --dark-soft: #3d2b1a;
            --brown: #6b4428;
            --brown-deep: #4a2f1c;
            --tan: #c4956a;
            --cream: #f7ede4;
            --cream-soft: #fdf9f5;
            --grey-beige: #9e8e7e;
            --border: rgba(44, 30, 16, 0.08);
            --border-focus: rgba(139, 94, 60, 0.35);
            --input-bg: #f2e9dd;
            --input-border: rgba(44, 30, 16, 0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
        }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
            background:
                linear-gradient(rgba(250, 243, 236, 0.86), rgba(250, 243, 236, 0.9)),
                url('{{ asset('images/hero.webp') }}') center/cover no-repeat;
        }

        .bg-blur {
            position: fixed;
            inset: 0;
            backdrop-filter: blur(2px);
            z-index: 0;
        }

        /* ===== MAIN CARD ===== */
        .login-wrapper {
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 1;
        }

        .login-card {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 28px;
            box-shadow:
                0 25px 70px rgba(44, 30, 16, 0.14),
                0 2px 6px rgba(44, 30, 16, 0.06);
            overflow: hidden;
            animation: fadeUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ===== HEADER ===== */
        .login-header {
            padding: 44px 36px 24px;
            text-align: center;
        }

        .login-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(145deg, var(--tan) 0%, var(--brown-deep) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 22px;
            color: #fff;
            box-shadow: 0 8px 24px rgba(107, 68, 40, 0.28);
        }

        .login-header h1 {
            font-family: 'Playfair Display', serif;
            color: var(--dark);
            font-size: 28px;
            font-weight: 700;
        }

        .login-header h1 span {
            color: var(--brown);
            opacity: 0.55;
        }

        .login-header p {
            color: var(--grey-beige);
            font-size: 13px;
            font-weight: 400;
            margin-top: 8px;
            line-height: 1.5;
        }

        .staff-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--cream);
            color: var(--brown);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            padding: 6px 14px;
            border-radius: 100px;
            margin-top: 14px;
        }

        /* ===== BODY ===== */
        .login-body {
            padding: 8px 36px 36px;
        }

        /* ===== FORM ===== */
        .form-group {
            margin-bottom: 18px;
        }

        .form-label-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: var(--dark-soft);
        }

        .form-label-row a {
            font-size: 12.5px;
            font-weight: 500;
            color: var(--brown);
            text-decoration: none;
        }

        .form-label-row a:hover {
            text-decoration: underline;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper .field-icon {
            position: absolute;
            left: 16px;
            color: var(--grey-beige);
            pointer-events: none;
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px 14px 44px;
            border: 1.5px solid var(--input-border);
            border-radius: 14px;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            color: var(--dark);
            background: var(--input-bg);
            outline: none;
            transition: all 0.25s ease;
        }

        .form-group input::placeholder {
            color: #b8a998;
            font-weight: 300;
        }

        .form-group input:focus {
            border-color: var(--border-focus);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(139, 94, 60, 0.08);
        }

        .toggle-pass {
            position: absolute;
            right: 14px;
            background: none;
            border: none;
            color: var(--grey-beige);
            cursor: pointer;
            padding: 4px;
            opacity: 0.6;
            transition: opacity 0.2s, color 0.2s;
            display: flex;
            align-items: center;
        }

        .toggle-pass:hover {
            opacity: 1;
            color: var(--brown);
        }

        /* ===== REMEMBER ME ===== */
        .form-options {
            display: flex;
            align-items: center;
            margin: 2px 0 26px;
        }

        .form-options label {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--grey-beige);
            font-weight: 400;
            font-size: 13px;
            cursor: pointer;
        }

        .form-options input[type="checkbox"] {
            appearance: none;
            width: 18px;
            height: 18px;
            border: 1.5px solid var(--input-border);
            border-radius: 50%;
            cursor: pointer;
            position: relative;
            background: var(--input-bg);
        }

        .form-options input[type="checkbox"]:checked {
            border-color: var(--brown);
            background: var(--brown);
        }

        .form-options input[type="checkbox"]:checked::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 6px;
            height: 6px;
            background: #fff;
            border-radius: 50%;
            transform: translate(-50%, -50%);
        }

        /* ===== BUTTON ===== */
        .btn-login {
            width: 100%;
            padding: 16px;
            background: var(--brown-deep);
            color: #fff;
            border: none;
            border-radius: 14px;
            font-size: 15px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            box-shadow: 0 6px 20px rgba(74, 47, 28, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(74, 47, 28, 0.36);
        }

        .btn-login:active {
            transform: scale(0.98) translateY(0);
        }

        .btn-login.loading {
            pointer-events: none;
            opacity: 0.85;
        }

        .btn-login.loading .btn-text {
            visibility: hidden;
        }

        .btn-login.loading::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to { transform: translate(-50%, -50%) rotate(360deg); }
        }

        /* ===== ALERT ===== */
        .alert-error {
            background: rgba(184, 70, 47, 0.06);
            color: #a04530;
            padding: 13px 16px;
            border-radius: 12px;
            font-size: 12.5px;
            margin-bottom: 20px;
            border-left: 3px solid rgba(184, 70, 47, 0.4);
            display: flex;
            align-items: flex-start;
            gap: 10px;
            line-height: 1.5;
        }

        .alert-error svg {
            margin-top: 2px;
            flex-shrink: 0;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 480px) {
            .login-body { padding: 8px 24px 30px; }
            .login-header { padding: 36px 24px 20px; }
            .login-header h1 { font-size: 24px; }
        }

        @media (prefers-reduced-motion: reduce) {
            .login-card { animation: none; opacity: 1; }
        }
    </style>
</head>
<body>

    <div class="bg-blur"></div>

    <div class="login-wrapper">
        <div class="login-card">
            <!-- HEADER -->
            <div class="login-header">
                <img src="{{ asset('images/logo.webp') }}" alt="Raund Raund" width="72" height="72" style="width:72px; height:72px; margin:0 auto 20px; display:block;">
                <h1>Raund <span>Raund</span></h1>
                <p>Masuk untuk mengakses sistem kasir &amp; operasional staff.</p>
                <div class="staff-badge">
                    <svg width="12" height="12" viewBox="0 0 512 512" fill="currentColor"><path d="M256 0c4.6 0 9.2 1 13.4 2.9L457.7 82.8c22 9.3 38.4 31 38.3 57.2c-.5 99.2-41.3 280.7-213.6 363.2c-16.7 8-36.1 8-52.8 0C57.3 420.7 16.5 239.2 16 140c-.1-26.2 16.3-47.9 38.3-57.2L242.7 2.9C246.8 1 251.4 0 256 0z"/></svg>
                    Khusus Staff
                </div>
            </div>

            <!-- BODY -->
            <div class="login-body">

                <!-- ERROR MESSAGE -->
                @if ($errors->any())
                    <div class="alert-error">
                        <svg width="15" height="15" viewBox="0 0 512 512" fill="currentColor"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>
                        <span>
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </span>
                    </div>
                @endif

                <!-- FORM -->
                <form action="{{ route('login') }}" method="POST" id="loginForm">
                    @csrf

                    <div class="form-group">
                        <div class="form-label-row">
                            <label>Email</label>
                        </div>
                        <div class="input-wrapper">
                            <svg class="field-icon" width="14" height="14" viewBox="0 0 512 512" fill="currentColor"><path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4l208 156c11.4 8.5 27 8.5 38.4 0l208-156c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 332.8c-22.8 17.1-54 17.1-76.8 0L0 176z"/></svg>
                            <input
                                type="email"
                                name="email"
                                placeholder="hello@example.com"
                                value="{{ old('email') }}"
                                required
                                autofocus
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-label-row">
                            <label>Password</label>
                            <a href="#">Forgot?</a>
                        </div>
                        <div class="input-wrapper">
                            <svg class="field-icon" width="14" height="14" viewBox="0 0 448 512" fill="currentColor"><path d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0S368 64.5 368 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z"/></svg>
                            <input
                                type="password"
                                name="password"
                                placeholder="••••••••"
                                required
                                id="passwordInput"
                            >
                            <button type="button" class="toggle-pass" onclick="togglePassword()" aria-label="Tampilkan password">
                                <svg id="iconEyeSlash" width="14" height="14" viewBox="0 0 640 512" fill="currentColor"><path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7l-99.2-77.7c33.4-27.4 60.7-62 78.7-98.9c3.3-7.9 3.3-16.7 0-24.6c-30.5-73.4-104.4-146-234.4-146c-40 0-76 6.9-108.2 19.4L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 4.6-.5 9-1.4 13.3l-95.6-75.9zM320 400c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L84.5 172.5C55.6 202.8 32.7 236.4 19.5 268.3c-3.3 7.9-3.3 16.7 0 24.6c30.5 73.4 104.4 146 234.4 146c19.7 0 38-1.7 55-4.9l-63-49.4c-3.4 .3-6.9 .4-10.4 .4z"/></svg>
                                <svg id="iconEye" width="14" height="14" viewBox="0 0 576 512" fill="currentColor" style="display:none;"><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="form-options">
                        <label>
                            <input type="checkbox" name="remember">
                            Ingat saya
                        </label>
                    </div>

                    <button type="submit" class="btn-login" id="btnLogin">
                        <span class="btn-text">Log In</span>
                    </button>
                </form>

            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const eyeSlash = document.getElementById('iconEyeSlash');
            const eye = document.getElementById('iconEye');
            if (input.type === 'password') {
                input.type = 'text';
                eyeSlash.style.display = 'none';
                eye.style.display = 'inline';
            } else {
                input.type = 'password';
                eyeSlash.style.display = 'inline';
                eye.style.display = 'none';
            }
        }

        // Loading state saat submit
        const form = document.getElementById('loginForm');
        const btn = document.getElementById('btnLogin');

        form.addEventListener('submit', function() {
            btn.classList.add('loading');
        });
    </script>
</body>
</html>