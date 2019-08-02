$(document).ready(function() {
	function randomStr(m) {
		var m = m || 9;
		(s = ""), (r = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789");
		for (var i = 0; i < m; i++) {
			s += r.charAt(Math.floor(Math.random() * r.length));
		}
		return s;
	}
	$("#invoice_id").val("OR" + randomStr(8));
	$.uploadPreview({
		input_field: "#image-upload", // Default: .image-upload
		preview_box: "#image-preview", // Default: .image-preview
		label_field: "#image-label", // Default: .image-label
		label_default: "Upload Logo", // Default: Choose File
		label_selected: "Change Logo", // Default: Change File
		no_label: false // Default: false
	});

	$("#to_msg").summernote({
		placeholder: "Enter the Custom Message",
		tabsize: 2,
		height: 200
	});
	// $("input").on("cut copy paste drop", function(e) {
	// 	return false;
	// });

	$('[data-toggle="datepicker"]').datepicker({
		autoPick: true,
		format: "dd-mm-yyyy"
	});

	$("#c_phone , #from_phone").bind("keyup paste", function(e) {
		this.value = this.value.replace(/[^0-9]/g, "");
		if (this.value.length > 10) {
			this.value = this.value.slice(0, 9);
			alert("Invalid Contact Number");
			$(this).focus();
			return false;
		}
	});
	//$("#invoice").disableAutoFill();
	//	$("input").prop("autocomplete", "nope");
});

function ValidateEmail(inputText) {
	if (inputText.value != "") {
		var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		if (inputText.value.match(mailformat)) {
			inputText.focus();
			return true;
		} else {
			alert("You have entered an invalid email address!");
			inputText.focus();
			return false;
		}
	}
}

function checksum(g) {
	let a = 65,
		b = 55,
		c = 36;
	return Array["from"](g).reduce((i, j, k, g) => {
		p =
			(p =
				(j.charCodeAt(0) < a ? parseInt(j) : j.charCodeAt(0) - b) *
				((k % 2) + 1)) > c
				? 1 + (p - c)
				: p;
		return k < 14
			? i + p
			: j == ((c = c - (i % c)) < 10 ? c : String.fromCharCode(c + b));
	}, 0);
}

//define template
if ($("#sections .section")) {
	var sectionsCount = $("#sections .section").length;
}
let sum = 0.0;
var priceMaskOptions = {
	mask: Number,
	radix: ".",
	scale: 2
};
var gstMaskOptions = {
	mask: Number,
	radix: ".",
	scale: 1,
	max: 28,
	min: 0
};
var phoneMaskOptions = {
	mask: "0000000000",
	max: 10,
	min: 10
};
var qtymask = {
	mask: Number,
	min: 1,
	max: 10,
	scale: 0
};
var pricemask = IMask(document.getElementById("price-1"), priceMaskOptions);
var cgst = IMask(document.getElementById("cgst-1"), gstMaskOptions);
var sgst = IMask(document.getElementById("sgst-1"), gstMaskOptions);
var discmask = IMask(document.getElementById("discount"), priceMaskOptions);
var chargmask = IMask(document.getElementById("charges"), priceMaskOptions);
var phone = IMask(document.getElementById("c_phone"), phoneMaskOptions);
var fphone = IMask(document.getElementById("from_phone"), phoneMaskOptions);
var price = new IMask(document.getElementById("quantity-1"), qtymask);
//add new section
$("body").on("click", ".addsection", function() {
	var template = $("#sections .section:first").clone();
	var getRow = $("#sections .section").length;
	var row_id = parseInt(getRow) + 1;
	template.prop("id", "row-" + row_id);
	template.find("td:first").html(row_id);
	//increment
	sectionsCount++;
	//loop through each input
	template.find("a").attr("onclick", "removeRow(" + row_id + ")");
	template.find("a").attr("id", "rem-" + row_id);
	var section = template
		.find(":input")
		.each(function() {
			//set id to store the updated section number
			var newId = this.id.split("-")[0] + "-" + sectionsCount;

			//update for label
			$(this)
				.prev()
				.attr("for", newId);

			//update id
			this.id = newId;
			this.value = "";
			if (this.id.split("-")[0] == "quantity") {
				this.value = 1;
			}
			//masked(sectionsCount);
		})
		.end()

		//inject new section
		.appendTo("#sections");

	setTimeout(() => {
		var items = $('input[name="price[]"]');
		Array.prototype.forEach.call(items, function(element) {
			var price = new IMask(element, priceMaskOptions);
		});
	}, 0);
	setTimeout(() => {
		var items = $('input[name="cgst[]"]');
		Array.prototype.forEach.call(items, function(element) {
			var price = new IMask(element, gstMaskOptions);
		});
	}, 0);
	setTimeout(() => {
		var items = $('input[name="sgst[]"]');
		Array.prototype.forEach.call(items, function(element) {
			var price = new IMask(element, gstMaskOptions);
		});
	}, 0);
	setTimeout(() => {
		var items = $('input[name="quantity[]"]');
		Array.prototype.forEach.call(items, function(element) {
			var price = new IMask(element, qtymask);
		});
	}, 0);
	return false;
});

// function masked(sec) {
// 	IMask(document.getElementById("price-" + sec), priceMaskOptions);
// 	IMask(document.getElementById("cgst-" + sec), gstMaskOptions);
// 	IMask(document.getElementById("sgst-" + sec), gstMaskOptions);
// }

//remove section
function removeRow(row_id) {
	//fade out section
	if ($("#sections .section").length == 1) {
		alert("Add More Rows to remove others");
		return false;
	}
	$("#sections .section:first")
		.find("a")
		.prop("disabled", true);
	$("#row-" + row_id).remove();
	var getRow = 1;
	$("#sections .section")
		.find("td:first")
		.each(function() {
			$(this).html(getRow++);
		});
	updateFinalAmount();
	return false;
}

function updateTotal(val, id) {
	updateSubTotalAmount(val, id.split("-")[0], id.split("-")[1]);
}

function updateQty(val, id) {
	updateSubTotalAmount(val, id.split("-")[0], id.split("-")[1]);
}

function alertData(event, data) {
	if (event.type == "keyup") {
		alert(data);
	}
}

function updateGST(val, id) {
	if (val != "") {
		var sg = $("#sgst-" + id.split("-")[1]).val();
		var cg = $("#cgst-" + id.split("-")[1]).val();
		if (val <= 28) {
			if (id.split("-")[0] == "sgst") {
				if (val !== 0) {
					$("#cgst-" + id.split("-")[1]).val(val);
				}
			}
			if (id.split("-")[0] == "cgst") {
				if (cg != 0 && sg != 0) {
					$("#sgst-" + id.split("-")[1]).val(val);
				}
			}
		} else {
			$("#sgst-" + id.split("-")[1]).val("");
			$("#cgst-" + id.split("-")[1]).val("");
			alertData(event, id.split("-")[0] + " cannot be greater than 28%");
			return false;
		}
		updateSubTotalAmount(val, id.split("-")[0], id.split("-")[1]);
	}
}
var qty = 0;
var amt = 0.0;
var sgst_per = 0.0;
var cgst_per = 0.0;
var full_tax = 0.0;
function updateSubTotalAmount(input_val, input_type, input_id) {
	if (input_type == "price") {
		amt = input_val;
		qty = parseInt($("#quantity-" + input_id).val());
	}
	if (input_type == "quantity") {
		qty = input_val;
		amt =
			$("#price-" + input_id).val() != ""
				? parseFloat($("#price-" + input_id).val())
				: 0.0;
	}
	if (amt == 0.0 || qty == 0) {
		alertData("Please add quantity and price");
		return false;
	} else {
		sgst_per = $("#sgst-" + input_id).val();
		cgst_per = $("#cgst-" + input_id).val();
	}
	if (sgst_per == "" || cgst_per == "") {
		sgst_per = 0.0;
		cgst_per = 0.0;
	}

	let subtotal_row = parseFloat(amt * qty);
	var total_gst_per = (parseFloat(sgst_per) + parseFloat(cgst_per)) / 100;
	let tax_cal = parseFloat(amt * qty) * total_gst_per;
	let total_row = parseFloat(subtotal_row) + parseFloat(tax_cal);
	$("#subtotal-" + input_id).val(total_row.toFixed(2));
	updateFinalAmount();
}

function updatecharges(val, id) {
	updateFinalAmount();
}

function updatedisc(val, id) {
	updateFinalAmount();
}

function updateFinalAmount() {
	var arr = $('input[name="subtotal[]"]')
		.map(function() {
			return this.value || 0.0;
		})
		.get();
	var price_arr = $('input[name="price[]"]')
		.map(function() {
			return this.value || 0.0;
		})
		.get();
	var item_arr = $('input[name="quantity[]"]')
		.map(function() {
			return this.value || 0.0;
		})
		.get();
	var tax_diff_arr = arr.map(function(item, index) {
		return item - price_arr[index] * item_arr[index];
	});
	sum = arr.reduce(function(acc, val) {
		return parseFloat(acc) + parseFloat(val);
	}, 0);

	tax_total = tax_diff_arr.reduce(function(acc, val) {
		return parseFloat(acc) + parseFloat(val);
	}, 0);
	//calculate amount , tax and charges

	let subtotalbdisc = parseFloat(sum) || 0.0;

	let di = $("#discount").val();
	if (di == "") {
		di = 0.0;
	}
	let discount = parseFloat(di);

	let subtotal = parseFloat(subtotalbdisc - discount);
	let taxamt = parseFloat(tax_total);
	let subtotalaftertax = parseFloat(subtotal);
	let ch = $("#charges").val();
	if (ch == "") {
		ch = 0.0;
	}
	let charges = parseFloat(ch);
	let totalbalance = parseFloat(subtotalaftertax + charges);
	// Update Amount

	$("#subtotalbdisc").val(subtotalbdisc.toFixed(2));
	$("#subtotalz").val(subtotal.toFixed(2));
	$("#taxtotal").val(taxamt.toFixed(2));
	$("#totalbalance").val(totalbalance.toFixed(2));
	return false;
}
