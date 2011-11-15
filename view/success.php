<h1 class="success">Succes</h1>
<p class="success"><?=$success?></p>

<div id="success">
    <div>
        <input type="text" value="<?=$fullUrl?>" id="fullUrl" onClick="selectAll(this.id)" />
		<p>Länk:</p>
    </div>
    <div>
        <input type="text" value="<?=$bitlyUrl?>" id="bitlyUrl" onClick="selectAll(this.id)" />
        <p>Bit.ly:</p>
    </div>
    <div>
    	<input type="text" value="<?=$tinyUrl?>" id="tinyUrl" onClick="selectAll(this.id)" />
        <p>Tinyurl:</p>
    </div>
</div>

<a class="success" href="">&rarr; Ladda upp en till fil?</a>