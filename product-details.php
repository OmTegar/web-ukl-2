<?php
require_once "config.php";
session_start();
$id = $_GET["id"];
$sql = "SELECT * FROM products WHERE P_Id='$id'";
$result = mysqli_query($dbhandle, $sql);
$row = mysqli_fetch_array($result);

if (isset($_POST["addCart"])) {
	if ($_SESSION["Type"] == "user") {
		$id = $_GET["id"];
		$quantity = $_POST['quantity'];
		$date = date('Y-m-d');
		$amount = $row["Price"] * $quantity;
		$hargaAkhir = $row["Price"] - ($potongan = ($row["Price"] * $row["discount"]) / 100);
		$userId = $_SESSION["UserId"];
		$P_Name = $row["P_Name"];
		$address = $_SESSION["Address"];
		$phone = $_SESSION["Phone"];
		$image = $row["Image"];
		$result1 = "INSERT INTO orders(User_Id,Product_Id,P_Name,Image,Address,Phone,Quantity,Amount,Date,Status,StatusAdmin) VALUES ('$userId','$id','$P_Name','$image','$address','$phone','$quantity','$amount','$date','notChecked','notOk')";
		$sql = mysqli_query($dbhandle, $result1);

		header('location:cart.php');
	} else {
		header('location:login.php');
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Product Details | Booku.com</title>
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
<!--/head-->

<body>
	<?php include('header.php'); ?> <!--header-->

	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-12 padding-right">
					<div class="product-details"><!--product-details-->
						<div class="col-sm-3">
							<div class="view-product">
								<img src="<?php echo $row["Image"]; ?>" alt="" />
							</div>
						</div>
						<form action="#" method="POST">
							<div class="col-sm-6">
								<div class="product-information"><!--/product-information-->
									<img src="images/product-details/new.jpg" class="newarrival" alt="" />
									<h2>
										<?php echo $row["P_Name"]; ?>
									</h2>
									<p>Product ID:
										<?php echo $row["P_Id"]; ?>
									</p>
									<img src="images/product-details/rating.png" alt="" />
									<span>
										<span>
										<del>Rp.<?php echo $row["Price"];?> </del>  </br> Rp.<?php echo $hargaAkhir = $row["Price"] - ($potongan = ($row["Price"]*$row["discount"])/100);?>
										</span>
										<label>Quantity:</label>
										<input type="number" name="quantity" value="1" min="1" />
										<button type="submit" name="addCart" class="btn btn-fefault cart">
											<i class="fa fa-shopping-cart"></i>
											Add to cart
										</button>
									</span>
									<p><b>Availability:</b> In Stock</p>
									<p><b>Condition:</b> New</p>
									<p><b>Category:</b>
										<?php echo $row["Category"]; ?>
									</p>
									<p><b>Discount:</b>
										<?php echo $row["discount"] . "%"; ?>
									</p>
								</div><!--/product-information-->
							</div>
						</form>
					</div><!--/product-details-->
					<div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li><a href="#reviews" data-toggle="tab">Reviews (5)</a></li>
							</ul>
						</div>
						<div class="tab-content">
							

							<div class="tab-pane fade" id="reviews">
								<div class="col-sm-12">

									<form action="#" method="post">
										<span>
											<input type="text" placeholder="Your Name" name="nama" id="nama" />
											<input type="text" placeholder="Product Name" name="website" id="website" />
										</span>
										<textarea name="pesan" id="pesan"></textarea>
										<b>Rating: </b>
										<style>
											li {
												display: inline-block;
												color: #F0F0F0;
												text-shadow: 0 0 1px #666666;
												font-size: 20px;
											}

											.highlight,
											.selected {
												color: #F4B30A;
												text-shadow: 0 0 1px black;
											}
										</style>

										<input type="hidden" name="rating" id="rating" />
										<ul onMouseOut="resetRating();">
											<li onmouseover="highlightStar(this);" onmouseout="removeHighlight();"
												onClick="addRating(this);">&#9733;</li>
											<li onmouseover="highlightStar(this);" onmouseout="removeHighlight();"
												onClick="addRating(this);">&#9733;</li>
											<li onmouseover="highlightStar(this);" onmouseout="removeHighlight();"
												onClick="addRating(this);">&#9733;</li>
											<li onmouseover="highlightStar(this);" onmouseout="removeHighlight();"
												onClick="addRating(this);">&#9733;</li>
											<li onmouseover="highlightStar(this);" onmouseout="removeHighlight();"
												onClick="addRating(this);">&#9733;</li>
										</ul>

										<script>
											function highlightStar(obj) {
												removeHighlight();
												$('li').each(function (index) {
													$(this).addClass('highlight');
													if (index == $("li").index(obj)) {
														return false;
													}
												});
											}

											function removeHighlight() {
												$('li').removeClass('selected');
												$('li').removeClass('highlight');
											}

											function addRating(obj) {
												$('li').each(function (index) {
													$(this).addClass('selected');
													$('#rating').val((index + 1));
													if (index == $("li").index(obj)) {
														return false;
													}
												});
											}

											function resetRating() {
												if ($("#rating").val()) {
													$('li').each(function (index) {
														$(this).addClass('selected');
														if ((index + 1) == $("#rating").val()) {
															return false;
														}
													});
												}
											}
										</script>
										<button type="submit" class="btn btn-default pull-right" name="Submit"
											value="Submit" id="Submit">
											Submit
										</button>
									</form>

									<?php

									// Inisialisasi tanggal
									$tanggal = date("Ymd");
									// Inisialisasi waktu
									$time = date("H:i:s");

									if (isset($_POST['Submit'])) {
										// Query untuk menambah data ke dalam tabel
										$query = mysqli_query($dbhandle, "INSERT INTO tb_komentar(nama, website, pesan, tanggal, time) VALUES ('$_POST[nama]', '$_POST[website]', '$_POST[pesan]', '$tanggal', '$time')");
									}

									// Query untuk menampilkan data dari tabel
									$query = mysqli_query($dbhandle, "SELECT * FROM tb_komentar ORDER BY CONCAT(tanggal, ' ', time) DESC");

									while ($d = mysqli_fetch_array($query)) {
										$psn = $d['pesan'];
										echo "<table>";
										echo "<tr><td><b>$d[nama]</b>   $psn</td></tr>";
										echo "<tr><td><b>Produk</b>  <i>$d[website]</i></td></tr>";
										echo "<tr><td align=left>$d[time]: $d[tanggal]</td></tr></table><hr>";
									}
									?>


								</div>
							</div>
						</div>
					</div><!--/category-tab-->
				</div>
			</div>
		</div>
	</section>

	<?php include('footer.php'); ?> <!--footer-->

	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/price-range.js"></script>
	<script src="js/jquery.prettyPhoto.js"></script>
	<script src="js/main.js"></script>
</body>
</html>