<?php
include('includes/database_connection.php');
$systemconfig = mysqli_query($DB, "SELECT * FROM settings WHERE id='1'");
$SYS_logo = 'abra-gov-seal.png';
$SYS_name = 'CID Learning Analytics';
$AB_title = 'SDO ABRA CID LEARNING ANALYTICS';

if (mysqli_num_rows($systemconfig) > 0) {
    $settings = mysqli_fetch_assoc($systemconfig);
    $SYS_logo = $settings['SYS_logo'] ?: $SYS_logo;
    $SYS_name = $settings['SYS_name'] ?: $SYS_name;
    $AB_title = $settings['AB_title'] ?: $AB_title;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#142738">
    <meta name="description" content="A learning analytics platform supporting data-informed decisions across the Schools Division of Abra.">
    <title>About - <?php echo htmlspecialchars($SYS_name, ENT_QUOTES, 'UTF-8'); ?></title>

    <link rel="stylesheet" href="style/css/bootstrap.min.css">
    <script defer src="style/js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style/myStyle.css">
    <link rel="stylesheet" href="style/page-refresh.css?v=2">
    <link rel="stylesheet" href="style/about-page.css">
    <link rel="stylesheet" href="style/app-polish.css?v=6">
    <link rel="icon" type="image/jpg" href="images/<?php echo rawurlencode(basename($SYS_logo)); ?>">
</head>

<?php include 'includes/modals.php'; ?>

<body class="about-page">
    <?php include 'includes/page-loader.php'; ?>
    <?php include('includes/navbarTop.php'); ?>
    <?php include('includes/public-navigation.php'); ?>

    <main>
        <section class="about-hero" aria-labelledby="aboutHeroTitle">
            <div class="about-hero-inner">
                <div class="about-hero-copy">
                    <div class="about-eyebrow">
                        <span class="about-eyebrow-mark" aria-hidden="true"></span>
                        Schools Division of Abra
                    </div>
                    <h1 id="aboutHeroTitle">
                        Better insight.<br>
                        <span>Brighter learning.</span>
                    </h1>
                    <p class="about-hero-description">
                        A clearer view of learner progress—bringing school data, assessment results, and practical insights together to support better decisions.
                    </p>
                    <div class="about-hero-actions">
                        <a class="about-button about-button-primary" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
                            <i class="fas fa-arrow-right" aria-hidden="true"></i>
                            Sign in to your workspace
                        </a>
                        <a class="about-text-link" href="#platform">
                            Explore the platform <i class="fas fa-long-arrow-alt-down" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="about-trust-note">
                        <div class="about-trust-avatars" aria-hidden="true">
                            <span><i class="fas fa-school"></i></span>
                            <span><i class="fas fa-user-tie"></i></span>
                            <span><i class="fas fa-chart-line"></i></span>
                        </div>
                        <p>Built to support schools, teachers, and education leaders</p>
                    </div>
                </div>

                <div class="about-hero-visual" aria-label="Decorative 3D learning analytics dashboard illustration" role="img">
                    <div class="about-visual-glow"></div>
                    <div class="about-orbit about-orbit-one"></div>
                    <div class="about-orbit about-orbit-two"></div>
                    <div class="about-orbit-dot about-orbit-dot-one"></div>
                    <div class="about-orbit-dot about-orbit-dot-two"></div>
                    <div class="about-float-card about-float-card-top">
                        <span class="about-float-icon"><i class="fas fa-chart-line"></i></span>
                        <span><strong>Progress, made visible</strong><small>Insights that move learning forward</small></span>
                    </div>
                    <div class="about-dashboard-model">
                        <div class="about-model-side"></div>
                        <div class="about-model-face">
                            <div class="about-model-heading">
                                <span><i class="fas fa-layer-group"></i> Learning overview</span>
                                <span class="about-model-period">THREE TERMS</span>
                            </div>
                            <div class="about-model-stat">
                                <div><small>LEARNER PROGRESS</small><strong>Every learner matters</strong></div>
                                <span class="about-model-trend"><i class="fas fa-arrow-up"></i> Track</span>
                            </div>
                            <div class="about-model-chart" aria-hidden="true">
                                <div class="about-chart-guides"><i></i><i></i><i></i></div>
                                <svg viewBox="0 0 440 145" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="aboutChartFill" x1="0" x2="0" y1="0" y2="1">
                                            <stop offset="0%" stop-color="#5da6a2" stop-opacity=".27"/>
                                            <stop offset="100%" stop-color="#5da6a2" stop-opacity="0"/>
                                        </linearGradient>
                                    </defs>
                                    <path d="M0 116 C48 107 55 83 100 92 S154 113 197 73 S253 89 291 55 S349 74 385 34 S420 38 440 16 L440 145 L0 145 Z" fill="url(#aboutChartFill)"/>
                                    <path d="M0 116 C48 107 55 83 100 92 S154 113 197 73 S253 89 291 55 S349 74 385 34 S420 38 440 16" fill="none" stroke="#4d9995" stroke-width="4" stroke-linecap="round"/>
                                    <circle cx="291" cy="55" r="5" fill="#d1a94c" stroke="#fff" stroke-width="3"/>
                                    <circle cx="440" cy="16" r="5" fill="#4d9995" stroke="#fff" stroke-width="3"/>
                                </svg>
                                <div class="about-chart-labels"><span>TERM 1</span><span>TERM 2</span><span>TERM 3</span></div>
                            </div>
                            <div class="about-model-footer">
                                <span><i class="about-dot about-dot-teal"></i> Learning trends</span>
                                <span><i class="about-dot about-dot-gold"></i> Progress signals</span>
                            </div>
                        </div>
                    </div>
                    <div class="about-seal-card">
                        <img src="images/abra-gov-seal.png" alt="">
                        <span><small>PROUDLY SERVING</small><strong>Abra schools</strong></span>
                        <i class="fas fa-check-circle" aria-hidden="true"></i>
                    </div>
                    <div class="about-float-card about-float-card-bottom">
                        <span class="about-float-mini-chart" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i></span>
                        <span><strong>Data with purpose</strong><small>One community, shared progress</small></span>
                    </div>
                </div>
            </div>
            <div class="about-hero-bottom" aria-hidden="true">
                <span></span>
                <small>DATA-INFORMED · LEARNER-CENTERED · BUILT FOR ABRA</small>
                <span></span>
            </div>
        </section>

        <section class="about-platform" id="platform" aria-labelledby="platformTitle">
            <div class="about-section-heading">
                <span class="about-section-kicker">A shared view of learning</span>
                <h2 id="platformTitle"><?php echo htmlspecialchars($AB_title, ENT_QUOTES, 'UTF-8'); ?></h2>
                <p>
                    Welcome to the CID Learning Analytics Platform of the Schools Division of Abra. We bring essential education data into one place, helping school communities understand progress and plan their next steps with confidence.
                </p>
            </div>

            <div class="about-feature-grid">
                <article class="about-feature-card">
                    <span class="about-feature-icon about-feature-icon-teal"><i class="fas fa-database" aria-hidden="true"></i></span>
                    <span class="about-feature-number">01 / CONNECT</span>
                    <h3>One connected picture</h3>
                    <p>Bring learner profiles, grades, assessment results, teacher information, and school data into a more useful view.</p>
                </article>
                <article class="about-feature-card">
                    <span class="about-feature-icon about-feature-icon-gold"><i class="fas fa-chart-pie" aria-hidden="true"></i></span>
                    <span class="about-feature-number">02 / UNDERSTAND</span>
                    <h3>Insights you can act on</h3>
                    <p>Explore trends and decision-support insights that help educators identify needs and shape timely interventions.</p>
                </article>
                <article class="about-feature-card">
                    <span class="about-feature-icon about-feature-icon-blue"><i class="fas fa-users" aria-hidden="true"></i></span>
                    <span class="about-feature-number">03 / IMPROVE</span>
                    <h3>Progress, together</h3>
                    <p>Give school leaders and teachers a clear, approachable way to review information and focus on learner outcomes.</p>
                </article>
            </div>

            <div class="about-cta-panel">
                <div class="about-cta-emblem"><img src="images/abra-gov-seal.png" alt=""></div>
                <div class="about-cta-copy">
                    <span class="about-section-kicker">Your school’s next step starts here</span>
                    <h2>Turn information into meaningful action.</h2>
                    <p>Sign in to explore the workspace available to your role.</p>
                </div>
                <a class="about-button about-button-light" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
                    Open your workspace <i class="fas fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
        </section>
    </main>

    <?php include('footer.php'); ?>
</body>
</html>
