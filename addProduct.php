<?php
	session_start();
	if ($_SESSION["Type"] != "admin") {
		header('location:login.php');
		exit();
	}

	require_once "config.php";

	if (isset($_POST["addProduct"])) {
		$productName = $_POST["productName"];
		$category = $_POST["category"];
		$stock = $_POST["stock"];
		$price = $_POST["price"];
		$discount = isset($_POST["discount"]) ? $_POST["discount"] : 0;
		$width = isset($_POST["width"]) ? $_POST["width"] : 0;
		$weight = isset($_POST["weight"]) ? $_POST["weight"] : 0;
		$height = isset($_POST["height"]) ? $_POST["height"] : 0;

		$filename = date("d_m_y_h_i_s") . "_" . basename($_FILES["image"]["name"]);
		$target_dir = "images/home/";
		$target_file = $target_dir . $filename;

		if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
			$sql = "INSERT INTO products (P_Name, Category, Stock, Price, Discount, Image, Height, Width, Weight)
					VALUES ('$productName', '$category', '$stock', '$price', '$discount', '$target_file', '$height', '$width', '$weight')";
			$result = mysqli_query($dbhandle, $sql);

			if ($result) {
				echo "Insert successful";
			} else {
				echo "Insert failed";
			}
		} else {
			echo "File upload failed";
		}
	}
?>

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Home | E-Shopper</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/prettyPhoto.css" rel="stylesheet">
	<link href="css/price-range.css" rel="stylesheet">
	<link href="css/animate.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
	<link rel="shortcut icon" href="images/ico/favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head>
<body>
	<?php include('header.php'); ?> <!--header-->

	</br>

	<div class="container body-content">
		<div class="row panel">
			<div class="col-lg-3 ">
				<?php include('adminMenu.php'); ?> <!--Admin Menu-->
			</div>
			<div class="col-lg-9 ">
				<div class="col-md-7 col-md-offset-3">
					<div class="login-panel panel panel-default animated bounceInRight">
						<div class="panel-heading">
							<h3 class="panel-title">Add Product</h3>
						</div>
						<div class="panel-body">
							<form enctype="multipart/form-data" role="form" method="POST" action="#">
								<fieldset>
									<div class="form-group">
										Product Name
										<input class="form-control" name="productName" type="text" value="" required />
									</div>

									<div class="form-group">
										Category
										<select name="category" class="form-control" required>
											<?php
											$sql = mysqli_query($dbhandle, "SELECT Name FROM categories ORDER BY Name");
											while ($row = mysqli_fetch_array($sql)) {
												echo '<option value="' . $row['Name'] . '">' . $row['Name'] . '</option>';
											}
											?>
										</select>
									</div>

									<div class="form-group">
										Stock
										<input class="form-control" name="stock" type="number" value="" required />
									</div>

									<div class="form-group">
										Price
										<input class="form-control" name="price" type="number" value="" required />
									</div>

									<div class="form-group">
										Discount
										<input class="form-control" name="discount" type="number" value="0" />
									</div>

									<div class="form-group">
										Weight
										<input class="form-control" name="weight" type="number" value="0" />
									</div>

									<div class="form-group">
										Width
										<input class="form-control" name="width" type="number" value="0" />
									</div>

									<div class="form-group">
										Height
										<input class="form-control" name="height" type="number" value="0" />
									</div>

									<label class="btn btn-default" for="my-file-selector">
										<input id="my-file-selector" name="image" id="image" type="file" style="display:none;" required />
										Product Photo
									</label>

									<input type="submit" class="btn btn-primary btn-block" value="Add Product" name="addProduct" />

								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include('footer.php'); ?> <!--Footer-->
</body>
</html>
