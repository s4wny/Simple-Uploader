<?php if(isset($error)): ?>
    <h3 class="error">Ajajaj, här blev det lite fel.</h3>
    <ul class="error">
	    <?php foreach($error as $errCode => $errMess) : ?>
		    <li><?=$errMess?></li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>

<form action="upload.php" method="post" enctype="multipart/form-data" action="">
	<input type="hidden" name="MAX_FILE_SIZE" value="104857600" />
	
	<label class="LabelHolder">
	    <p id="uploadText">Välj en fil</p>
        <input type="file" name="file" id="choosefile" onChange="changeUploadText(getFilename(this.id))" />
	</label>
    
	<br />
    <input type="submit" name="submit" id="uploadFile" value="Ladda upp" />
</form>
