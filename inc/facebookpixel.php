<?php
$pixel = isset($_GET['pixel']) ? htmlspecialchars($_GET['pixel'], ENT_QUOTES, 'UTF-8') : '';
if (!empty($pixel)):
?>
    <!-- Facebook Pixel Code -->
    <script>
        (function(pixelId) {
            ! function(f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function() {
                    n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');

            fbq('init', pixelId);
            fbq('track', 'PageView');

            function dispararEventoPurchase() {
                fbq('track', 'Purchase');
            }

            if (typeof(Storage) !== "undefined") {
                let pageCount = parseInt(localStorage.getItem('pageCount')) || 0;
                pageCount++;
                localStorage.setItem('pageCount', pageCount);
                if (pageCount === 2) dispararEventoPurchase();
            }
        })(<?= json_encode($pixel) ?>);
    </script>
    <noscript>
        <img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=<?= $pixel ?>&ev=PageView&noscript=1" />
    </noscript>
    <!-- End Facebook Pixel Code -->
<?php endif; ?>