<?php
$pixel = $_GET['pixel'] ?? '';
if ($pixel) {
?>
    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
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
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '<?= $pixel ?>');
        fbq('track', 'PageView');
        fbq('track', 'ViewContent');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=<?= $pixel ?>&ev=PageView&noscript=1" /></noscript>


    <script>
        function dispararEvento() {
            fbq('track', 'Purchase');
        }

        if (typeof(Storage) !== "undefined") {
            let pageCount = localStorage.getItem('pageCount');

            if (!pageCount) {
                pageCount = 0;
            }

            pageCount++;

            localStorage.setItem('pageCount', pageCount);

            if (pageCount == 2) {
                dispararEvento();
            }
        } else {
            console.log("localStorage não é suportado neste navegador.");
        }
    </script>

    <!-- End Meta Pixel Code -->
<?php
}
?>