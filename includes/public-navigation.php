<?php
$currentPage = basename($_SERVER['PHP_SELF'] ?? '');
$currentPage = $currentPage === 'contact.php' ? 'contact_guest.php' : $currentPage;
$navigationItems = [
    'index.php' => 'Home',
    'analytics.php' => 'Analytics',
    'faq.php' => 'FAQ',
    'contact_guest.php' => 'Contact',
    'about.php' => 'About',
];
?>
<nav class="public-site-nav" aria-label="Main navigation">
    <div class="public-site-nav-inner">
        <?php foreach ($navigationItems as $href => $label) { ?>
            <a href="<?php echo htmlspecialchars($href, ENT_QUOTES, 'UTF-8'); ?>"
               <?php echo $currentPage === $href ? 'aria-current="page"' : ''; ?>>
                <?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>
            </a>
        <?php } ?>
        <?php if (isset($_SESSION['logged']) && $_SESSION['logged'] === 'True') { ?>
            <?php if (($_SESSION['priviledges'] ?? '') === 'Teacher') { ?>
                <a class="public-site-nav-workspace" href="teachers/dashboard.php">My workspace</a>
            <?php } else { ?>
                <a class="public-site-nav-workspace" href="users/dashboard.php">My workspace</a>
            <?php } ?>
        <?php } ?>
    </div>
</nav>
