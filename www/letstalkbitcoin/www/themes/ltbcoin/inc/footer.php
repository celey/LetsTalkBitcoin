        <footer>
            <div class="row">
                <div class="columns">
					<?= $this->displayBlock('footer-links') ?>
                </div>
            </div>
        </footer>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?= THEME_URL ?>/js/vendor/jquery-1.11.0.min.js"><\/script>')</script>
        <script src="<?= THEME_URL ?>/js/foundation.min.js"></script>
        <script src="<?= THEME_URL ?>/js/foundation/foundation.topbar.js"></script>
        <script src="<?= THEME_URL ?>/js/plugins.js"></script>
        <script src="<?= THEME_URL ?>/js/main.js"></script>
        <script type="text/javascript" src="<?= SITE_URL ?>/resources/tinymce/js/tinymce/tinymce.min.js"></script>
        <script>$(document).foundation();</script>
        <script>
        $('#main-nav').onePageNav({
            currentClass: 'current',
            changeHash: true,
            scrollSpeed: 750,
            scrollThreshold: 1,
            filter: '',
            easing: 'swing'
        });
        
        $(document).ready(function(){
			window.siteURL = '<?= SITE_URL ?>'
			tinymce.baseURL = window.siteURL + '/resources/tinymce/js/tinymce';
			tinymce.init({selector:'#html-editor', skin: 'light', plugins: 'anchor,hr,image,link,media,table,lists,code', forced_root_block: false,
				extended_valid_elements : "a[class|name|href|target|title|onclick|rel],script[type|src],iframe[src|style|width|height|scrolling|marginwidth|marginheight|frameborder],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name]"}
			);

			tinymce.baseURL = window.siteURL + '/resources/tinymce/js/tinymce';
			tinymce.init({selector:'#mini-editor', skin: 'light', plugins: 'anchor,link,lists', forced_root_block: false,
			extended_valid_elements : "a[class|name|href|target|title|onclick|rel],script[type|src],iframe[src|style|width|height|scrolling|marginwidth|marginheight|frameborder],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name]"});
			
		});
        </script>
        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
        (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
        e=o.createElement(i);r=o.getElementsByTagName(i)[0];
        e.src='//www.google-analytics.com/analytics.js';
        r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
        ga('create','UA-XXXXX-X');ga('send','pageview');
        </script>
    </body>
    </html>
