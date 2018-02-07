<?php
namespace Tags;
use UI, Util;
class BandGContact
{
	public $params = array();
	
	public function display()
	{
		if(posted()){
			try{
				$output =  $this->submitForm();
			}
			catch(\Exception $e){
				$output = $this->showFormError($e->getMessage());
			}
			
			return $output;
		}
		else{
			return $this->showForm();
		}
	
	}
	
	private function showFormError($err = '')
	{		
		$output = '<p><strong>Error: '.$err.'</strong></p>';
		$output .= $this->showForm();
		
		return $output;
		
	}
	
	private function showForm()
	{
		$form = $this->getForm();
		require_once(SITE_PATH.'/resources/recaptchalib.php');
		ob_start();
		?>
		
		<?= $form->display() ?>
		
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
		
	}
	
	private function getForm()
	{
		$form = new UI\Form;
		
		$name = new UI\Textbox('name');
		$name->setLabel('Your Name: *');
		$name->addAttribute('required');
		$form->add($name);		
		
		$email = new UI\Textbox('email');
		$email->setLabel('Email Address: *');
		$email->addAttribute('required');
		$form->add($email);
		
		$subject = new UI\Textbox('subject');
		$subject->setLabel('Subject:');
		$form->add($subject);		
		
		$readAnswer = new UI\Radio('readAnswer');
		$readAnswer->addOption('yes', 'Yes');
		$readAnswer->addOption('no', 'No');
		$readAnswer->setLabel('Would you like us to answer this question on the show?');
		$form->add($readAnswer);
		
		$message = new UI\Textarea('message');
		$message->setLabel('Message: *');
		$message->addAttribute('required');
		$form->add($message);
		
		
		return $form;
		
	}
	
	private function submitForm()
	{
		/*require_once(SITE_PATH.'/resources/recaptchalib.php');
		$resp = recaptcha_check_answer (CAPTCHA_PRIV,
										$_SERVER["REMOTE_ADDR"],
										$_POST["recaptcha_challenge_field"],
										$_POST["recaptcha_response_field"]);

		if(!$resp->is_valid) {
			throw new \Exception('Captcha invalid!');
		}
		* */
		
		$form = $this->getForm();
		$data = $form->grabData();
		
		$req = array('email', 'name', 'message');
		foreach($req as $required){
			if(!isset($data[$required]) OR trim($data[$required]) == ''){
				throw new \Exception(ucfirst($required).' required');
			}
			$data[$required] = htmlentities(strip_tags($data[$required]));
		}
		
		if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
			throw new \Exception('Please enter a valid email address');
		}
		if(!isset($this->params['email'])){
			$this->params['email'] = 'nickrathman@gmail.com';
		}
		
		$subject = 'Bitcoins and Gravy Contact Request';
		if(isset($data['subject']) AND trim($data['subject']) != ''){
			$subject .= ' - '.$data['subject'];
		}
		
		$mail = new Util\Mail;
		$mail->addTo($this->params['email']);
		$mail->addBCC('nrathman@ironcladtech.ca');
		$mail->setSubject($subject);
		$mail->setFrom('noreply@letstalkbitcoin.com');
		
		$readAnswer = 'No';
		if(isset($data['readAnswer']) AND $data['readAnswer'] == 'yes'){
			$readAnswer = 'Yes';
		}
		
		$body = '<p>A contact request has come in from bitcoinsandgravy.com. See below:</p>';
		$body .= markdown($data['message']);
		$body .= '<ul>
					<li><strong>Email:</strong> '.$data['email'].'</li>
					<li><strong>Name:</strong> '.$data['name'].'</li>
					<li><strong>Read response to this on show?:</strong> '.$readAnswer.'</li>
					<li><strong>IP:</strong> '.$_SERVER['REMOTE_ADDR'].'</li>
					</ul>';
		
		$mail->setHTML($body);
		
		$send = $mail->send();
		if(!$send){
			throw new \Exception('Error sending contact request, please try again');
		}
		
		$output = '<p><Strong>Thank you for contacting us!</strong></p>';
		
		return $output;
		
	}

}
