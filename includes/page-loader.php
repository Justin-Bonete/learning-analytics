<?php
$pageLoaderLogo = isset($SYS_logo) && is_string($SYS_logo) && $SYS_logo !== ''
    ? basename($SYS_logo)
    : 'abra-gov-seal.png';
?>
<script>
    document.documentElement.classList.add('has-page-loader');
</script>
<div id="page-loader" class="page-loader" role="status" aria-label="Loading page">
    <span class="page-loader-mark">
        <span class="page-loader-ring" aria-hidden="true"></span>
        <img src="images/<?php echo rawurlencode($pageLoaderLogo); ?>" alt="">
    </span>
</div>
<script>
    (function () {
        var loader = document.getElementById('page-loader');
        var startedAt = performance.now();

        function finishLoading() {
            window.setTimeout(function () {
                loader.classList.add('page-loader--leaving');
                loader.addEventListener('transitionend', function (event) {
                    if (event.target === loader && event.propertyName === 'opacity') {
                        loader.remove();
                    }
                });
                window.setTimeout(function () {
                    loader.remove();
                }, 700);
            }, Math.max(0, 320 - (performance.now() - startedAt)));
        }

        if (document.readyState === 'complete') {
            finishLoading();
        } else {
            window.addEventListener('load', finishLoading, { once: true });
        }
    })();
</script>
