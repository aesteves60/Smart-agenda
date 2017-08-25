			<div class="clear"></div>
		</main>
		
		<footer id="footer" class="page-footer">

			<div class="row">
				<div class="s12 col text_center">
					<p>© Copyright <time datetime="<?= date('Y'); ?>"></time><?= date('Y'); ?>. Tous droits réservés. </p>
				</div>
			</div>
			
		</footer>        

	</div>

	<div class="clear"></div>

	<?php if(isset($popups) && is_array($popups)) { foreach ($popups as $popup) { echo $popup; } } ?>
	
	<link rel="stylesheet" href="<?= asset_url(); ?>libs/font-awesome/css/font-awesome.css">

</body>
</html>