	
	<!-- Zone de notifications -->
	<section id="notifications">
	<?php
		//Notification d'erreur diverses
		if($this->session->userdata('notif_err') != NULL)
		{
			echo $this->session->userdata('notif_err');
			$this->session->set_userdata('notif_err', NULL);	
		}

		//Notification de réussite
		if($this->session->userdata('notif_ok') != NULL)
		{
			echo $this->session->userdata('notif_ok');
			$this->session->set_userdata('notif_ok', NULL);	
		}
		
		//Notification d'erreur de formulaire
		echo validation_errors();

	?>	
	</section>
