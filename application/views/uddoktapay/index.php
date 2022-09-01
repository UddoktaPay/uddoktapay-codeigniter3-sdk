<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $page_title;?></title>
</head>
<body>
	<?php echo form_open(site_url('uddoktapay/pay'));?>
    Full Name
		<input type="text" name="full_name"><br>
    Email
		<input type="text" name="email"><br>
    Amount
		<input type="text" name="amount"><br>
    User ID
		<input type="text" name="user_id"><br>
		<input type="submit" value="Submit">
	<?php form_close(); ?>
</body>
</html>