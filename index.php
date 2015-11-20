<?php 
	$str = file_get_contents('settings/settings.json');
	$json = json_decode($str, true);

	if(!in_array($_SERVER['REMOTE_ADDR'], $json["allowed_ips"]) && !in_array($_SERVER["HTTP_X_FORWARDED_FOR"], $json["allowed_ips"])) {
	    header("Location: not_allowed.php"); //redirect
	    exit();
	} 
?>
<html>
	<head>
		<title>MONITOR</title>
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
	</head>
	<body>
		<div id="header">
			Sistema di monitoraggio delle risorse
		</div>
		<div id="content">
			<input type="hidden" id="timeout" value="<?php echo $json["timeout"]; ?>" />
			<?php foreach($json["sections"] as $title => $contents) :?>
				<div class="section">
					<div class="title"><?php echo $title; ?></div>
					<div class="content">
					<?php foreach($contents as $content) :?>
						<div class="row">
							<div class="cell name"><?php echo $content["name"]; ?></div>
							<?php 
								$output = shell_exec($content["script"]); 
								$status = preg_match("/" . $content["expected"] . "/", $output);
							?>
							<div class="cell"><div class="status <?php echo $status ? "ok" : "ko";?>"></div></div>
						</div>
					<?php endforeach;?>
					</div>
				</div>
			<?php endforeach;?>
		</div>
		<div id="remaining-time"><?php echo $json["timeout"] / 1000; ?></div>
		<script src="js/script.js"></script>
	</body>
</html>
