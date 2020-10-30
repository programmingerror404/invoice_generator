<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
	<!--<![endif]-->

	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>Invoice Tool</title>
		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no" />
		<link rel="apple-touch-icon" href="apple-touch-icon.png" />

		<link rel="stylesheet" href="css/normalize.min.css" />

		<link href="https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/flatly/bootstrap.min.css" rel="stylesheet" />
		<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.css" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/datepicker.min.css"
			integrity="sha256-b88RdwbRJEzRx95nCuuva+hO5ExvXXnpX+78h8DjyOE=" crossorigin="anonymous" />
		<link rel="stylesheet" href="css/main.min.css" />
	</head>

	<body>
		<!--[if lt IE 8]>
			<p class="browserupgrade">
				You are using an <strong>outdated</strong> browser. Please
				<a href="http://browsehappy.com/">upgrade your browser</a> to improve
				your experience.
			</p>
		<![endif]-->

		<nav class="navbar navbar-expand navbar-dark bg-danger mb-5">
			<a class="navbar-brand text-center w-100" href="#">Invoice Generator</a>
		</nav>
		<div class="container-fluid">
			<!-- Email Details -->
			<form name="invoice" id="invoice" autocomplete="nope" action="generated_invoice.php" method="POST"
				enctype="multipart/form-data">
				<div class="row">
					<!-- Senders -->
					<div class="col-sm-6">
						<div class="card border-none logo-border mb-3">
							<div class="card-header">Sender's Details</div>
							<div class="card-body">
								<!-- Name -->
								<div class="form-group row">
									<div class="col-sm-12">
										<input type="text" class="form-control" id="sender_name"
											placeholder="Sender's Name" name="sender_name" />
									</div>
								</div>
								<!-- Email -->
								<div class="form-group row">
									<div class="col-sm-12 ">
										<input type="email" class="form-control" id="sender_email"
											onchange="ValidateEmail(this)" placeholder="Sender's Email"
											name="sender_email" />
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- Senders -->
					<!-- Receivers -->
					<div class="col-sm-6">
						<div class="card border-none logo-border mb-3">
							<div class="card-header">Recipient Details</div>
							<div class="card-body">
								<!-- Name -->
								<div class="form-group row">
									<div class="col-sm-12">
										<input type="text" class="form-control" id="rec_name"
											placeholder="Recipient Name" name="rec_name" />
									</div>
								</div>
								<!-- Email -->
								<div class="form-group row">
									<div class="col-sm-12">
										<input type="email" onchange="ValidateEmail(this)" class="form-control"
											id="rec_email" placeholder="Recipient Email" name="rec_email" />
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- Receivers -->
				</div>
				<!-- Email Details End -->
				<hr style="border-top: 1px solid #000;height: 1px;
    width: 100%;">
				<!-- Invoice logo & Details -->
				<div class="row">
					<!-- logo -->

					<div class="col-md-6 col-sm-6">
						<div class="card border-none logo-border mb-3" style="width:220px;">
							<div class="card-body mx-auto w-100">
								<div id="image-preview">
									<label for="image-upload" id="image-label">Upload Logo</label>
									<input type="file" name="image" id="image-upload" />
								</div>
							</div>
						</div>
					</div>
					<!-- Logo -->
					<!-- Invoice id , gstin , date -->
					<div class="col-md-6 col-sm-6">
						<div class="card border-none logo-border mb-3">
							<div class="card-body">
								<div class="form-group">
									<input type="text" name="invoice_date" class="form-control" id="invoice_date"
										placeholder="Invoice Date" data-toggle="datepicker" />
								</div>
								<div class="form-group">
									<input type="text" name="invoice_id" class="form-control" id="invoice_id"
										placeholder="Invoice No." />
								</div>
								<div class="form-group">
									<input type="text" class="form-control" id="gstin" name="gstin" placeholder="GSTIN"
										onchange="chechsum(this.value)" />
								</div>
							</div>
						</div>
					</div>
					<!-- Receivers -->
				</div>
				<!-- Invoice logo & Details End -->
				<!-- Billing and user details -->
				<div class="row">
					<!-- Receivers -->
					<div class="col-sm-6">
						<div class="card border-none logo-border mb-3">
							<div class="card-header">Bill To</div>
							<div class="card-body">
								<address>
									<input type="text" placeholder="Client Name" value=""
										class="form-control form-control-sm mb-1" name="c_name" id="c_name" required>
									<input type="text" placeholder="Address 1" value=""
										class="form-control form-control-sm mb-1" name="c_addr" id="c_addr" required>
									<input type="text" placeholder="Address 2" value=""
										class="form-control form-control-sm mb-1" name="c_addr2" id="c_addr2" required>
									<input type="text" placeholder="Client Phone" value=""
										class="form-control form-control-sm  mb-1" name="c_phone" id="c_phone" required
										pattern="[0-9]{10}">
									<input type="email" placeholder="Client Email" value=""
										class="form-control form-control-sm" name="c_email" id="c_email"
										onchange="ValidateEmail(this)">

								</address>
							</div>
						</div>
					</div>
					<!-- Receivers -->
					<!-- Sender -->
					<div class="col-sm-6">
						<div class="card border-none logo-border mb-3">
							<div class="card-header">Bill From</div>
							<div class="card-body">
								<address>
									<input type="text" placeholder="Name" value=""
										class="form-control form-control-sm mb-1" name="from_name" id="from_name"
										required>
									<input type="text" placeholder="Address 1" value=""
										class="form-control form-control-sm mb-1" name="from_addr" id="from_addr"
										required>
									<input type="text" placeholder="Address 2" value=""
										class="form-control form-control-sm mb-1" name="from_addr2" id="from_addr2"
										required>
									<input type="text" placeholder="Phone" value=""
										class="form-control form-control-sm  mb-1" name="from_phone" id="from_phone"
										required>
									<input type="email" placeholder="Email" value=""
										class="form-control form-control-sm" name="from_email" id="from_email"
										onchange="ValidateEmail(this)">
								</address>
							</div>
						</div>
					</div>
					<!-- Sender -->
				</div>
				<!-- Billing and user details End -->
				<!-- list table data  -->
				<div class="row">
					<div class="col-12 table-responsive">
						<table class="table table-condensed">
							<thead class="thead-dark">
								<tr>
									<th>SNo.</th>
									<th>Description</th>
									<th>Quantity</th>
									<th>Price</th>
									<th>SGST(%)</th>
									<th>CGST(%)</th>
									<th>Subtotal</th>
									<th style="text-align:center">
									</th>
								</tr>
							</thead>
							<tbody id="sections">

								<tr class="section" id="row-1">

									<td style="width:5%;">1</td>
									<td style="width:35%;"><input type="text" placeholder="Service" value=""
											class="form-control form-control-sm" name="service[]" id="service-1"
											required>
									</td>

									<td style="width:5%;"><input type="text" placeholder="Qty" min="1" value="1"
											onchange="updateQty(this.value,this.id)"
											onkeyup="updateQty(this.value,this.id)" name="quantity[]" id="quantity-1"
											class="form-control form-control-sm" required>
									</td>
									<td style="width:15%;"><input type="text" placeholder="Price" value=""
											name="price[]" onchange="updateTotal(this.value,this.id)"
											onkeyup="updateTotal(this.value,this.id)" id="price-1"
											class="form-control form-control-sm" required>
									</td>
									<td style="width:7.5%;"><input type="text" placeholder="SGST" value="" name="sgst[]"
											onkeyup="updateGST(this.value,this.id)" id="sgst-1"
											class="form-control form-control-sm" required>
									</td>
									<td style="width:7.5%;"><input type="text" placeholder="CGST" value="" name="cgst[]"
											onkeyup="updateGST(this.value,this.id)" id="cgst-1"
											class="form-control form-control-sm" required>
									</td>
									<td style="width:15%;"><input type="text" placeholder="Total" value=""
											name="subtotal[]" readonly id="subtotal-1"
											class="form-control form-control-sm">
									</td>
									<td style="text-align:center;color:red">
										<a href="javascript:void(0);" class="remove text-center text-danger"
											onclick="removeRow(1)" id="rem-1"><i class="fas fa-times fa-2x"></i></a>
									</td>

								</tr>
							</tbody>
						</table>
						<div><a href="javascript:void(0);" class="addsection btn btn-primary btn-sm">
								<i class="fas fa-plus mr-2"></i>Add New Item</a></div>
					</div>
				</div>

				<!-- list table data end -->
				<div class="row my-5">
					<div class="col-md-6">
						<div class="form-group">
							<label for="to_msg">Enter the Custom Message: -</label>
							<textarea type="text" class="form-control" name="to_msg" id="to_msg"></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<!-- <p class="lead">Amount Due 10/11/2018</p> -->
						<div class="table-responsive">
							<table class="table billing_summary">
								<tr>
									<th style="width:50%">Total:</th>
									<td> <span><input type="text" placeholder="Total" value="0.00" readonly
												name="subtotalbdisc" id="subtotalbdisc"
												class="form-control form-control-sm"></span>
									</td>
								</tr>
								<tr>
									<th>Tax(inclusive):</th>
									<td> <span><input type="text" placeholder="taxtotal" value="0.00" name="taxtotal"
												readonly id="taxtotal" class="form-control form-control-sm"></span>
									</td>
								</tr>
								<tr>
									<th>Discount</th>
									<td> <input type="text" placeholder="0.00" onchange="updatedisc(this.value,this.id)"
											onkeyup="updatedisc(this.value,this.id)" value="" name="discount"
											id="discount" class="form-control  form-control-sm">
									</td>
								</tr>
								<tr>
									<th style="width:50%">Subtotal:</th>
									<td> <span><input type="text" placeholder="subtotal" value="0.00" name="subtotalz"
												readonly id="subtotalz" class="form-control form-control-sm"></span>
									</td>
								</tr>

								<tr>
									<th>Additional Charges:</th>
									<td> <input type="text" placeholder="0.00" value="" name="charges" id="charges"
											class="form-control form-control-sm"
											onchange="updatecharges(this.value,this.id)"
											onkeyup="updatecharges(this.value,this.id)">
									</td>
								</tr>
								<tr>
									<th>Total INR: </th>
									<td> <span><input type="text" readonly placeholder="totalbalance" value="0.00"
												name="totalbalance" id="totalbalance"
												class="form-control form-control-sm"></span>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<!-- close amount summary -->
				<div class="row">
					<div class="col-12">
						<button type="submit" id="generate-pdf"
							class="btn btn-outline-info ml-auto float-right mr-2 mb-5"><i class="fas fa-download"></i>
							Generate
							Invoice</button>
					</div>
				</div>
			</form>
		</div>
		<script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.4.1.min.js"
			integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
		<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
		<script type="text/javascript" src="js/jquery.uploadPreview.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/datepicker.min.js"
			integrity="sha256-/7FLTdzP6CfC1VBAj/rsp3Rinuuu9leMRGd354hvk0k=" crossorigin="anonymous"></script>
		<script src="https://unpkg.com/imask"></script>

		<script src="js/plugins.js"></script>
		<script src="js/main.js"></script>

		<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
		<script>
			(function (b, o, i, l, e, r) {
				b.GoogleAnalyticsObject = l;
				b[l] ||
					(b[l] = function () {
						(b[l].q = b[l].q || []).push(arguments);
					});
				b[l].l = +new Date();
				e = o.createElement(i);
				r = o.getElementsByTagName(i)[0];
				e.src = "//www.google-analytics.com/analytics.js";
				r.parentNode.insertBefore(e, r);
			})(window, document, "script", "ga");
			ga("create", "UA-XXXXX-X", "auto");
			ga("send", "pageview");
		</script>
	</body>

</html>
