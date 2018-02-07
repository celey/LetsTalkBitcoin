<?php
include(THEME_PATH.'/inc/header.php');
?>
        <div id="top-background" class="full-height">
            <div class="gradient">
                <!-- HEAD SECTION -->
                <div id="details">
                    <div id="details-logo"></div>
                    <div id="details-content">
                        <div><img src="<?= THEME_URL ?>/images/icons/coins.png"><?= $this->displayBlock('home-action-1') ?></div>
                        <div><img src="<?= THEME_URL ?>/images/icons/medal.png"><?= $this->displayBlock('home-action-2') ?></div>
                        <div><img src="<?= THEME_URL ?>/images/icons/hub.png"><?= $this->displayBlock('home-action-3') ?></div>
                        <div><img src="<?= THEME_URL ?>/images/icons/conference.png"><?= $this->displayBlock('home-action-4') ?></div>
                        <div><img src="<?= THEME_URL ?>/images/icons/github.png"><?= $this->displayBlock('home-action-5') ?></div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
       <!-- <div class="section-header"><?= $this->displayBlock('home-intro-header') ?></div> -->
        <div class="home-intro" style="padding-top: 30px; padding-bottom: 30px;">
			<?= $this->displayBlock('home-intro') ?>
        </div>
       <!-- <div class="vertical-container">
            <div class="content-width">
				<?= $this->displayBlock('intro-block-1') ?>
				<?= $this->displayBlock('intro-block-2') ?>
				<?= $this->displayBlock('intro-block-3') ?>
                <div class="clearfix"></div>
            </div>
        </div> -->
        <a name="services"></a>
        <div class="vertical-container gradient">
            <h2 class="section-header">Core Services</h2>
            <div class="content-width">
                <div class="swap-box">
                    <h3><i class="fa fa-cogs"></i> XChain <span>Server Wallet API</span></h3>
                    <div class="line-separator"></div>
                    <p class="swap-description">
						Server wallet and blockchain monitoring API for the Bitcoin and Counterparty protocols.
						Serves as the backend infrastructure for Tokenly services.
                    </p>
                    <div class="line-separator"></div>
                    <a href="https://github.com/tokenly/xchain" target="_blank">Go to Github <div class="icon-next"></div></a>
                </div>	
                <div class="swap-box">
                    <h3><i class="fa fa-key"></i> Tokenpass<span>Token Controlled Access</span></h3>
                    <div class="line-separator"></div>
                    <p class="swap-description">
						Global accounts system for interaction within the Tokenly ecosystem.
                    </p>
                    <div class="line-separator"></div>
                    <a href="https://accounts.tokenly.com" target="_blank">Register Account <div class="icon-next"></div></a>
                </div>                    	
                <div class="swap-box">
                    <h3><i class="fa fa-exchange"></i> SwapBot <span>Automated Sales</span></h3>
                    <div class="line-separator"></div>
                    <p class="swap-description">
						Fully automated user agents which can sell (or buy!) tokens 24/7 in exchange for bitcoin or other types of tokens.
                    </p>
                    <div class="line-separator"></div>
                    <a href="https://swapbot.tokenly.com" target="_blank">Create your Swapbot <div class="icon-next"></div></a>
                </div>
                <div class="clearfix"></div> 
                <div class="swap-box">
                    <h3><i class="fa fa-shopping-cart"></i> TokenSlot <span>Payment Processing</span></h3>
                    <div class="line-separator"></div>
                    <p class="swap-description">
						Accept bitcoin or tokens as payment in your website or application.<br> (contact us for API access)
                    </p>
                    <div class="line-separator"></div>
                    <a href="https://slots.tokenly.com" target="_blank">View API Docs <div class="icon-next"></div></a>
                </div>               
                <div class="swap-box coming-soon">
                    <h3><i class="fa fa-code-fork"></i> BitSplit <span>Distribution & Payment Routing</span></h3>
                    <div class="line-separator"></div>
                    <p class="swap-description">
						Mass distribute Counterparty tokens and create automated payment routing addresses for advanced use cases.
                    </p>
                    <div class="line-separator"></div>
                    <a href="#" target="_blank">Distribute Tokens <br>(coming soon)</a>
                </div>
                <div class="swap-box coming-soon">
                    <h3><i class="fa fa-plus"></i> Token Registrar <span>Enhanced Token Data</span></h3>
                    <div class="line-separator"></div>
                    <p class="swap-description">
						Easily register tokens and attach additional data to them.
                    </p>
                    <div class="line-separator"></div>
                    <a href="#" target="_blank">Register a Token <br>(coming soon)</a>
                </div>              
				<div class="clearfix"></div>   
			</div>
            <h2 class="section-header">Our Products &amp; Apps</h2>
            <div class="content-width">			
                <div class="swap-box">
                    <h3><i class="fa fa-btc"></i> Tokenly Pockets <span>Multi-purpose Bitcoin Wallet</span></h3>
                    <div class="line-separator"></div>
                    <p class="swap-description">
						User friendly, easy to use Counterparty compatible Chrome extension wallet with value added services.
                    </p>
                    <div class="line-separator"></div>
                    <a href="http://pockets.tokenly.com" target="_blank">Download Wallet <div class="icon-next"></div></a>
                </div>          
                <div class="swap-box">
                    <h3><i class="fa fa-shopping-bag"></i> Tend <span>Token Redemption</span></h3>
                    <div class="line-separator"></div>
                    <p class="swap-description">
						Easily list your products, services, or digital downloads for sale and accept 
						a variety of payment options such as bitcoin, tokens, alt-coins and credit cards.
                    </p>
                    <div class="line-separator"></div>
                    <a href="https://redeem.tokenly.com" target="_blank">Redeem Tokens <div class="icon-next"></div></a>
                </div>      
                <div class="swap-box">
                    <h3><i class="fa fa-users"></i> Tokenly CMS <span>Community Platform</span></h3>
                    <div class="line-separator"></div>
                    <p class="swap-description">
						Blog, forum and content management platform designed to integrate with Tokenly tools
						and use cryptocurrency natively.
                    </p>
                    <div class="line-separator"></div>
                    <a href="https://github.com/tokenly/tokenly-cms" target="_blank">Go to Github <div class="icon-next"></div></a>
                </div>                               
                <div class="clearfix"></div>    				 
                <div class="swap-box coming-soon">
                    <h3><i class="fa fa-gavel"></i> Token Auctions <span>Sell Tokens to the Highest Bidder</span></h3>
                    <div class="line-separator"></div>
                    <p class="swap-description">
						Token to token auction house with unique bidding system.
                    </p>
                    <div class="line-separator"></div>
                    <a href="#" target="_blank">Start an Auction<br> (coming soon)</a>
                </div>        
                <div class="swap-box coming-soon">
                    <h3><i class="fa fa-music"></i> Tokenly Music <span>Tokenized Albums</span></h3>
                    <div class="line-separator"></div>
                    <p class="swap-description">
						Artists create Digital Album tokens granting purchasers perpetual, transferable 
						streaming access to their music in any app or website integrating the TokenlyMusic API.
                    </p>
                    <div class="line-separator"></div>
                    <a href="#" target="_blank">(coming soon)<br><br></a>
                </div>          
                <div class="swap-box">
                    <h3><i class="fa fa-lightbulb-o"></i> Crowdfunding <span>Swappable Backer Rewards</span></h3>
                    <div class="line-separator"></div>
                    <p class="swap-description">
						Crowdfunding campaigns give their backers swappable super-powered Rewards Tokens instead
						 of promises.  When the product is ready, backers redeem their token instead of paying with a credit card.
                    </p>
                    <div class="line-separator"></div>
                    <a href="https://bnktothefuture.com/pitches/2749/_tokenly-connecting-crowdfunding-and-cryptocurrency.html" target="_blank">Learn More <div class="icon-next"></div></a>
                </div>                                      
                <div class="clearfix"></div>  
                              
            </div>
        </div>

        <h2 class="section-header">Our team</h2>
        <div class="vertical-container team-container">
            <div class="team-member adam">
                <div class="avatar"></div>
                <div class="name">Adam B. Levine</div>
                <div class="position">Founder &amp; CEO</div>
            </div>
            <div class="team-member nick">
                <div class="avatar"></div>
                <div class="name">Nick Rathman</div>
                <div class="position">Co-Founder &amp; Chief Architect</div>
            </div>
            <div class="team-member devon">
                <div class="avatar"></div>
                <div class="name">Devon Weller</div>
                <div class="position">Co-Founder &amp; CTO</div>
            </div>
            <div class="team-member steven">
                <div class="avatar"></div>
                <div class="name">Steven Levine</div>
                <div class="position">Co-Founder &amp; CFO</div>
            </div>
            <div class="clearfix"></div>
        </div>
		<a name="contact"></a>
        <div class="vertical-container mail-container gradient">
            <div class="content-width mail-segment">
                <!-- <div class="mail-box green-box"></div> -->
                <h3>Contact Us</h3>
                <div class="email-icon"></div>
                <div class="mail-content">
                    Curious about possibilities?<br>
                    <b>Leave us your email!</b><br>
					<!-- Begin MailChimp Signup Form -->
					<div id="mc_embed_signup">
						<form action="//letstalkbitcoin.us7.list-manage.com/subscribe/post?u=f21fc8790958eb3fe1e1bf164&amp;id=08aaa7d0e2" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
							<div id="mc_embed_signup_scroll">
								<input type="text" value="" name="EMAIL" class="email" id="mce-EMAIL" required>
								<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
								<div style="position: absolute; left: -5000px;">
									<input type="text" name="b_f21fc8790958eb3fe1e1bf164_08aaa7d0e2" tabindex="-1" value="">
								</div>
								<input type="submit" value="" name="subscribe" id="mc-embedded-subscribe" class="icon-next">
							</div>
						</form>
					</div>

					<!--End mc_embed_signup-->

                    
					<p>
						Or email us at <a href="mailto:team@tokenly.com">team@tokenly.com</a>
					</p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
<?php
include(THEME_PATH.'/inc/footer.php');
?>
