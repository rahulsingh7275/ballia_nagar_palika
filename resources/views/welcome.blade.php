<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>DMS Document Management System</title>

    <link href="{{asset('assets/frontend/css/landing/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/landing/style.css')}}">
    <link rel="shortcut icon" href="{{asset('/assets/frontend/images/favicon.png')}}" type="image/x-icon">
    <link href="{{asset('/assets/frontend/css/materialize.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/frontend/css/style.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/frontend/css/style-mob.css')}}" rel="stylesheet" />

    <style>
        :root {
            color-scheme: light;
            font-family: 'Poppins', sans-serif;
            color: #0f172a;
            background: #f3f7fb;
        }
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            min-height: 100vh;
            background: #eff4fb;
        }
        a {
            text-decoration: none;
            color: inherit;
        }
        .topbar {
            background: #ffffff;
            border-bottom: 1px solid rgba(148, 163, 184, 0.15);
            padding: 18px 0;
        }
        .topbar h4 {
            margin: 0;
            font-size: 1.05rem;
            font-weight: 600;
            letter-spacing: 0.02em;
            color: #0f172a;
        }
        .hero {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: calc(100vh - 70px);
        }
        .hero-left {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }
        .panel {
            width: 100%;
            max-width: 640px;
            background: rgba(255, 255, 255, 0.98);
            border-radius: 28px;
            box-shadow: 0 28px 80px rgba(15, 23, 42, 0.12);
            padding: 40px;
            position: relative;
            overflow: hidden;
        }
        .panel::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 180px;
            height: 180px;
            background: rgba(59, 130, 246, 0.12);
            border-radius: 50%;
            pointer-events: none;
        }
        .panel::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -20px;
            width: 160px;
            height: 160px;
            background: rgba(16, 185, 129, 0.12);
            border-radius: 50%;
            pointer-events: none;
        }
        .panel h1 {
            font-size: clamp(2rem, 3vw, 3rem);
            line-height: 1.05;
            margin: 0 0 18px;
            letter-spacing: -0.02em;
        }
        .panel p.lead {
            font-size: 1rem;
            color: #475569;
            margin-bottom: 28px;
            max-width: 520px;
        }
        .actions {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 28px;
        }
        .action-card {
            background: #ffffff;
            border: 1px solid rgba(148, 163, 184, 0.18);
            border-radius: 22px;
            padding: 28px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 16px;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            min-height: 190px;
        }
        .action-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 24px 45px rgba(15, 23, 42, 0.16);
        }
        .action-icon {
            width: 72px;
            height: 72px;
            border-radius: 18px;
            background: #f8fafc;
            display: grid;
            place-items: center;
            box-shadow: inset 0 0 0 1px rgba(148, 163, 184, 0.14);
        }
        .action-icon img {
            max-width: 48px;
            max-height: 48px;
        }
        .action-card p {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
            color: #0f172a;
        }
        .note-box {
            border-radius: 20px;
            padding: 18px 20px;
            background: #f8fafc;
            border: 1px solid rgba(148, 163, 184, 0.18);
            color: #334155;
            text-align: center;
            font-size: 0.95rem;
        }
        .hero-right {
            position: relative;
            overflow: hidden;
            min-height: 100%;
        }
        .hero-right::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("https://bmiimaging.com/wp-content/uploads/2024/07/iStock-1647734399-1200x750.jpg") center/cover no-repeat;
            filter: blur(0px);
            transform: scale(1.05);
            opacity: 0.95;
        }
        .hero-right::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(15, 23, 42, 0.58) 0%, rgba(15, 23, 42, 0.08) 60%);
        }
        .hero-sidepanel {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 40px;
            color: #ffffff;
        }
        .hero-sidepanel h3 {
            font-size: clamp(2rem, 3vw, 2.6rem);
            margin: 0 0 18px;
            line-height: 1.05;
        }
        .hero-sidepanel p {
            font-size: 1rem;
            line-height: 1.8;
            max-width: 460px;
            margin: 0;
            color: rgba(255, 255, 255, 0.9);
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-top: 32px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 999px;
            padding: 12px 18px;
            color: #f8fafc;
            font-weight: 600;
            width: fit-content;
        }
        .site-footer {
            padding: 20px 0;
            text-align: center;
            color: #64748b;
            font-size: 0.95rem;
            background: transparent;
        }
        .site-footer strong {
            color: #0f172a;
        }
        @media (max-width: 1100px) {
            .hero {
                grid-template-columns: 1fr;
            }
            .hero-right {
                order: -1;
                min-height: 420px;
            }
        }
        @media (max-width: 720px) {
            .hero-left,
            .hero-right {
                padding: 24px;
            }
            .panel {
                padding: 28px;
                border-radius: 24px;
            }
            .actions {
                grid-template-columns: 1fr;
            }
            .hero-sidepanel {
                padding: 28px;
            }
        }
    </style>

    <script src="https://www.google.com/recaptcha/api.js?render=6Lc_WLUfAAAAALifvZW6ZwDhGBRysm0n1pptXY4g"></script>
</head>
<body>

    <section class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h4>Document Management System</h4>
                </div>
            </div>
        </div>
    </section>

    <div class="hero">
        <div class="hero-left">
            <div class="panel">
                <h1>Welcome to DMS<span style="color:#2563eb;">.</span></h1>
                <p class="lead">A modern document management experience for users and departments—secure, simple, and fully responsive.</p>

                <div class="actions">
                    <a href="{{ url('login') }}" class="action-card">
                        <span class="action-icon">
                            <img src="{{asset('assets/frontend/css/landing/university.png')}}" alt="User Icon">
                        </span>
                        <p>User</p>
                    </a>
                    <a href="{{ url('login') }}" class="action-card">
                        <span class="action-icon">
                            <img src="{{asset('assets/frontend/css/landing/affiliate.jpg')}}" alt="Department Icon">
                        </span>
                        <p>Department</p>
                    </a>
                </div>

                <div class="note-box">
                    Note: For any query, call or WhatsApp us at <a href="tel:+91000000000">+91 00000 00000</a> between 10:00 AM and 5:00 PM or email <a href="mailto:dsmnru.help@gmail.com">dsmnru.help@gmail.com</a>.
                </div>
            </div>
        </div>

        <div class="hero-right">
            <div class="hero-sidepanel">
                <h3>Smart document flow for your team</h3>
                <p>Track approvals, manage records, and access documents from one central dashboard. The DMS interface is designed to keep the user journey fast, modern, and friendly.</p>
                <span class="hero-badge">Single source of truth</span>
            </div>
        </div>
    </div>

    <footer class="site-footer">
        <p>Copyright © 2021-22. All Rights Reserved - Document Management System</p>
        <p>Powered by <strong>Staqo World Pvt Ltd.</strong></p>
    </footer>

</body>
</html>	