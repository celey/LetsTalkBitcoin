    
        <div id="footer">
            <div class="content-width">
                <div class="footer-segment">
					<div class="tagline">
						<?= $this->displayBlock('footer-info') ?>
					</div>
					<small>
						<?= $this->displayBlock('footer-tagline') ?>
					</small>
                </div>
                <div class="footer-segment">
					<?= $this->displayMenu('footer-1') ?>
					<?= $this->displayMenu('footer-2') ?>
					 <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
        </div>

        <script src="<?= THEME_URL ?>/scripts/vendor.js"></script>
        <script src="<?= THEME_URL ?>/scripts/app.js"></script>
    </body>
</html>
