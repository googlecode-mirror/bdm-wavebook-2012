	<!-- Corps du site -->
    <script type="text/javascript">
	$(document).ready(function()
	{
		
	//Mode 1 : par formulaire
	$("#form_choose").click(function() {
			 // Affichage de la vue
			 $("#register_form").attr('action','<?php echo url('home/register_validation'); ?>');
			 $("#modular").html('<div class="control-group upload"><label class="control-label" for="avatar">Votre image de profil</label><div class="controls"><input type="file" name="file_1" id="avatar" /><button type="button" class="btn btn-mini btn-warning" id="add_field"><i class="icon-plus icon-white"></i></button></div></div>');
		
				// Ajout dynamique de nouveau champs d'upload (inscription)
				$("button#add_field").click(function (){
				var nb = $('div.upload').length;
				
				if(nb < 5)
					$('div.upload:eq('+(nb-1)+')').after('<div class="control-group upload"><label class="control-label" for="avatar'+(nb+1)+'">Autre image de profil</label><div class="controls"><input type="file" name="file_'+(nb+1)+'" id="avatar'+(nb+1)+'" /></div></div>');
				});
		
	});

	//Mode 2 : par webcam (prises multiples)
	$("#webcam_choose").click(function() 
		{
			var uniq_hash = '<?php $seed = 'JvKnrQWPsfuhffdfAuH'; $hash = sha1(uniqid($seed . mt_rand(), true)); echo substr($hash, 0, 10); ?>';
			var numCapture = 0;
			var tabCapture = new Array();
			tabCapture[0] = null;
			tabCapture[1] = null;
			tabCapture[2] = null;
			tabCapture[3] = null;
			
			// Affichage de la vue
			 $("#register_form").attr('action','<?php echo url('home/register_validation_with_cam'); ?>');
			 $("#modular").html('<div id="status"></div><div><div id="cam"></div><table id="capture_zone"><tr><td><div class="capture_elem"></div></td><td><div class="capture_elem"></div></td></tr><tr><td><div class="capture_elem"></div></div></td><td><div class="capture_elem"></div></td></tr></table><div style="clear:both;"></div> <p><button type="button" class="btn btn-info" onClick="webcam.configure()">Configuration...</button> &nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-info" onClick="webcam.snap()">Capturer maintenant</button><input type="text" name="url_capture" id="url_capture" style="visibility: hidden;" /></p>');
	
			// Configuration de la capture
			webcam.set_api_url('<?php echo base_url() . './assets/upload.php?uniq_hash='; ?>' + uniq_hash + numCapture);
			webcam.set_quality(100);
			webcam.set_shutter_sound(true, '<?php echo url('assets/docs/shutter.mp3'); ?>');
			webcam.set_swf_url('<?php echo url('assets/docs/webcam.swf'); ?>');
		
			// Mise en place de la webcam
			$('#cam').html(webcam.get_html(280,210,640,480));
		
			// Callbacks
			// Callback après une capture
			webcam.set_hook('onComplete', function(response){
				//reset de la webcam
				webcam.reset();
				
				//notification et affichage de la photo dans le bon elemeent
				tabCapture[numCapture] = response;
				$('#status').html('<div class="alert alert-success">Capture '+(numCapture+1)+' uploadée !<button type="button" class="close" data-dismiss="alert">x</button></div>');
				$('table#capture_zone div:eq('+numCapture+')').html('<img src="<?php echo base_url() . '../Base_de_donnees/tmp/'; ?>'+response+'" alt="Votre capture" title="Votre capture" />');
				
				//configuration de la prochaine capture
				numCapture++; numCapture = numCapture % 4;
				webcam.set_api_url('<?php echo base_url() . './assets/upload.php?uniq_hash='; ?>' + uniq_hash + '0');
				for(var i = 0; i < tabCapture.length; i++)
				{
					if(tabCapture[i] == null)
					{
							numCapture = i;
							break;
					}
				}
				webcam.set_api_url('<?php echo base_url() . './assets/upload.php?uniq_hash='; ?>' + uniq_hash + numCapture);
			});
		
			// Callback après une erreur
			webcam.set_hook('onError', function(response){
				$('#status').html('<div class="alert alert-error"><strong>Erreur:</strong> ' + response + '<button type="button" class="close" data-dismiss="alert">x</button></div>');
			});
			
			// Callbacks pour la suppression d'une capture
			$('table#capture_zone div:eq(0)').click(function(){ if(tabCapture[0] != null) { tabCapture[0] = null; numCapture = 0; }});
			$('table#capture_zone div:eq(1)').click(function(){ if(tabCapture[1] != null) { tabCapture[1] = null; numCapture = 1; }});
			$('table#capture_zone div:eq(2)').click(function(){ if(tabCapture[2] != null) { tabCapture[2] = null; numCapture = 2; }});
			$('table#capture_zone div:eq(3)').click(function(){ if(tabCapture[3] != null) { tabCapture[3] = null; numCapture = 3; }});
			$('table#capture_zone div').click(function() { 
				webcam.set_api_url('<?php echo base_url() . './assets/upload.php?uniq_hash='; ?>' + uniq_hash + numCapture); 
				if($('table#capture_zone div:eq('+numCapture+')').html() != '')
				{
					$('table#capture_zone div:eq('+numCapture+')').html('');
					$('#status').html('<div class="alert alert-warning">Capture '+(numCapture+1)+' supprimée !<button type="button" class="close" data-dismiss="alert">x</button></div>');
				}	
			});

			//Callback avant la validation du formulaire
			 $("#register_form").submit(function() 
			 {
				var textURL = "";
				var nb = 0;
				for(var i = 0; i < tabCapture.length; i++)
				{
					if(tabCapture[i] != null)
					{
						if(nb > 0)
							textURL += ',';
							
						textURL += tabCapture[i];
						nb++;
					}
				}
				$('#url_capture').val(textURL);
				
				if(textURL == "")
				{
					$('#status').html('<div class="alert alert-error"><strong>Erreur:</strong> Au moins une capture est attendue !<button type="button" class="close" data-dismiss="alert">x</button></div>');
					return false;
				}
				else
				{
					return true;
				}
			 });

		});
	});
    </script>
    <section id="corps">
		<div class="row">
		  <div class="span8">
			  <h1>Inscription sur WaveBook</h1>
			  <p><strong>Information:</strong> Votre mot de passe et votre image de profil seront utilisés par le système d'authentification du site. Merci de choisir un avatar reconnaisable et de type : <em><?php echo str_replace("|",", ",Upload::$image_file_extension); ?></em></p>
			  <hr/>
			  <div class="btn-group" style="text-align:right;" data-toggle="buttons-radio" style="">
				<button type="button" id="form_choose" class="btn btn-inverse active">Par formulaire</button>
			 	<button type="button" id="webcam_choose" class="btn btn-inverse">Par webcam</button>
			  </div>
			  <hr/>
			  <form class="form-horizontal" id="register_form" action="<?php echo url('home/register_validation'); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
				   <div class="control-group">
					<label class="control-label" for="name">Votre nom</label>
					<div class="controls">
						<input type="text" id="name" name="name" placeholder="Nom" value="<?php echo set_value('name'); ?>" />
					</div>
				   </div>
				     <div class="control-group">
					<label class="control-label" for="vorname">Votre prénom</label>
					<div class="controls">
						<input type="text" id="vorname" name="vorname" placeholder="Prénom" value="<?php echo set_value('vorname'); ?>" />
					</div>
				   </div>
				  <div class="control-group">
					<label class="control-label" for="email">Votre Email</label>
					<div class="controls">
					  <input type="text" id="email" name="email" placeholder="Email" value="<?php echo set_value('email'); ?>" />
					</div>
				  </div>
				  <div class="control-group">
					<label class="control-label" for="password">Votre mot de passe</label>
					<div class="controls">
					  <input type="text" name="password" id="password" placeholder="Mot de passe" value="<?php echo set_value('password'); ?>" />
					  <input style="width: 30px; height:30px;border: 4px;background-color:transparent" id="mic" x-webkit-speech />
					</div>
				  </div>
				  <div id="modular">
					  <div class="control-group upload">
						<label class="control-label" for="avatar">Votre image de profil</label>
						<div class="controls">
						  <input type="file" name="file_1" id="avatar" />
						  <button type="button" class="btn btn-mini btn-warning" id="add_field"><i class="icon-plus icon-white"></i></button>
						</div>
					  </div>
				  </div>
				  <div class="control-group">
					<label class="control-label" for="sexe">Votre sexe</label>
					<div class="controls">
						<input type="radio" name="sexe" id="sexe" value="Homme"  <?php echo set_radio('sexe', 'Homme', TRUE); ?> /> Homme<br/>
						<input type="radio" name="sexe" value="Femme" <?php echo set_radio('sexe', 'Femme');?> /> Femme
					</div>
				   </div>
				     <div class="control-group">
					<div class="controls">
						<input type="checkbox" name="cgu" id="cgu" value="1" /> J'ai lu, compris et j'accepte les <a href="<?php echo base_url() . 'assets/docs/Charte.pdf'; ?>" target="_blank">termes et conditions</a>.<br/>
					</div>
				   </div>
				   <div class="control-group">
					<div class="controls">
					  <button type="submit" class="btn btn-primary">S'inscrire</button>
					</div>
				  </div>
				</form>
		  </div>
		  
		  <div class="span4">
			<div style="padding-left:10px;">
				<h3>Une vaste communautée</h3>
				<p><span class="label">WaveBook</span> compte déjà plusieurs milliers d'utilisateurs ayant partagé des millions de fichiers ! A qui le tour ?</p>
				<p>
					<?php
						for($i = 0; $i < count($ruser); $i++)
						{
								$list_avatars = Avatar::getAvatarsByUserId($ruser[$i]->id);
								echo '<img src="'. $list_avatars[0]->getMiniatureLink().'" class="img-polaroid avatar-little" alt="'.$ruser[$i]->vorname .' '.$ruser[$i]->name . ' est sur Wavebook !" title="'.$ruser[$i]->vorname .' '.$ruser[$i]->name . '  est sur Wavebook !" \> ';
						}
					?>
				</p>
			</div>
		  </div>
		</div>
    </section>
