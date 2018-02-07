 <div class="main-section" id="about">
                <div class="row">
                    <div class="small-centered medium-11 columns">
						<div class="login">
							<h2>Login</h2>
							<?php
							if($loginMessage != ''){
								echo '<p class="error">'.$loginMessage.'</p>';
							}
							$loginForm->remove('rememberMe');
							?>
							<?= $loginForm->display() ?>
						</div>

                    </div>
                </div>
            </div>
