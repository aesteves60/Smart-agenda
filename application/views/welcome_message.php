<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Smart Agenda</title>
</head>
<body>

<!-- Notification -->
<div class="row">
			<?php 
				if(isset($notification) && $notification != NULL){

					if(is_array($notification) && !isset($notification['class'])){
						$i = 0;
						foreach ($notification as $notif) {
							echo '
								<div class="s12 col">
									<div id="alert-box-'.$i.'" class="alert-box '.$notif['class'].'" '.($notif == NULL ? 'style="display: none;"' : '' ).'>
										<p style="margin: 0">'.$notif['message'].'</p>
										<i class="fa fa-times close" onclick="removeBlock(\'alert-box-'.$i.'\')"></i>
									</div>
								</div>
							';
							$i++;
						}
					} else {
						echo '
							<div class="s12 col">
								<div id="alert-box" class="alert-box '.$notification['class'].'" '.($notification == NULL ? 'style="display: none;"' : '' ).'>
									<p style="margin: 0">'.$notification['message'].'</p>
									<i class="fa fa-times close" onclick="removeBlock(\'alert-box\')"></i>
								</div>
							</div>
						';
					}
				} 
			?>
		</div>
<!-- /Notification -->


</body>
</html>