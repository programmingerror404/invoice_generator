<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
date_default_timezone_set("Asia/Kolkata");
$data = $_POST;
$img_str = '';
if (isset($_FILES["image"])) {
    if ($_FILES["image"]["error"] != 0) {
        echo "Error: " . $_FILES["image"]["error"] . "<br>";
    } else {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        $bin_string = file_get_contents($_FILES["image"]["tmp_name"]);
        $hex_string = base64_encode($bin_string);
        $img_str = "data:" . $check['mime'] . ";base64," . $hex_string;
    }
}
$i = count($data["service"]) - 1;
$disc = $data["discount"] == '' ? 0.00 : $data["discount"];
$char = $data["charges"] == '' ? 0.00 : $data["charges"];
$msg = $data['to_msg'] == '' ? "" : $data["to_msg"];
$rows = '';
$j = 0;
$k = 0;
$l = 0;
$m = 0;
$n = 0;
$o = 0;
$c = 1;
while ($i-- >= 0) {
    $rows .= '<tr>
    <td>' . $c++ . ' </td>
    <td>' . $data["service"][$j++] . ' </td>
    <td align="center">' . $data["quantity"][$k++] . '</td>
    <td class="cost">' . $data["price"][$l++] . '</td>
    <td class="cost">' . $data["sgst"][$n++] . '</td>
    <td class="cost">' . $data["cgst"][$o++] . '</td>
    <td class="cost">' . $data["subtotal"][$m++] . '</td>
</tr>';
}

$html = '<html>

    <head>
        <style>
            body {font-family: arial;
                font-size: 10pt;
            }
            p {	margin: 0pt; }
            table.items {
                border: 0.1mm solid #000000;
            }
            td { vertical-align: top; }
            .items td {
                border:0.1mm solid #000000;

            }
            table thead td { background-color: #000;
                text-align: center;
                color:#B28A51;
                border: 0.1mm solid #000000;
                font-variant: small-caps;
            }
            .summary td.blanktotal {
                background-color: #EEEEEE;
                background-color: #FFFFFF;
                border: 0mm;

                text-align: center;
                        vertical-align: middle;
            }
            .summary td.totals {
                text-align: right;

                padding: 5px 20px;
            }
            .summary td.totals.cost {
                text-align: right;
                padding: 5px 20px;
                border-left: 0.1mm solid #000000;
            }

            table.summary {
                float: right;
                border-top: 0.1mm solid #000000;
                width: 100%;
                margin-bottom: 20px;
                border-collapse: collapse;
            }
            .summary tr.last {
                border-top: 1px solid #000;
                border-bottom: 1px solid #000;
            }

            .items tr:nth-child(even) {
                background-color: #ddd;
            }

            .items tbody td:last-child {
                background-color: #fff;
            }
        </style>
    </head>

    <body style="padding:10px 10px;margin-bottom:20px;">
        <table width="100%" cellpadding="10">
            <tr>
                <td width="40%" style="border: 0">
                    <img src="' . $img_str . '" alt="Logo" style="width: 200px;">
                </td>
                <td width="60%" style="border: 0;text-align:right">
                <span style="font-size: 16px;"> <strong>GST No.</strong> - <span class="text-dark">29AAHPE9060FIZO</span></span>
                <br/> <span style="font-size: 16px;"><strong>Invoice ID - </strong>
                        <span>' . $data["invoice_id"] . '</span></span><br />
                    <span style="font-size: 16px;"><strong>Invoice Date - </strong>
                        <span>' . $data["invoice_date"] . '</span>
                        </span>

                </td>
            </tr>
        </table>
        <br />
        <br />
        <table width="100%" cellpadding="10">
            <tr>
                <td width="45%" style="border: 0"><span style="font-size: 18px;">Bill
                        To
                    </span><br />
                    <address>
                        <strong>' . $data["c_name"] . '</strong><br>
                        ' . $data["c_addr"] . '<br>
                        ' . $data["c_addr2"] . '<br>
                        ' . $data["c_phone"] . '<br>
                        ' . $data["c_email"] . '
                    </address>
                </td>
                <td width="55%" style="border: 0;text-align:right;"><span style="font-size: 18px;">Bill
                        From
                    </span><br />
                    <address class="text-md-right">
                        <strong>' . $data["from_name"] . '</strong><br>
                        ' . $data["from_addr"] . '<br>
                        ' . $data["from_addr2"] . '<br>
                        ' . $data["from_phone"] . '<br>
                        ' . $data["from_email"] . '
                    </address>
                    </td>
            </tr>
        </table>

        <br />

        <br />
                <table class="items" width="100%" style="font-size: 12pt; border-collapse: collapse; " cellpadding="8">
            <thead>
                <tr>
                    <th style="width:5%;border: 1px solid;">SNo.</th>
                    <th style="width:40%;border: 1px solid;">Description</th>
                    <th style="width:5%;border: 1px solid;">Quantity</th>
                    <th style="width:15%;border: 1px solid;">Price</th>
                    <th style="width:10%;border: 1px solid;">SGST(%)</th>
                    <th style="width:10%;border: 1px solid;">CGST(%)</th>
                    <th style="width:15%;border: 1px solid;">Subtotal</th>
                </tr>
            </thead>
            <tbody>' . $rows . '


            </tbody>
        </table>

        <table class="summary">

                <tr class="sum">
                <td class="blanktotal" width="60%" rowspan="9">' . $msg . '</td>
                    <td class="totals" width="20%">Subtotal:</td>
                    <td class="totals cost" width="20%" colspan="2">INR ' . $data["subtotalbdisc"] . '</td>
                </tr>
                <tr>
                    <td class="totals">Total Tax:</td>
                    <td class="totals cost" colspan="2">INR ' . $data["taxtotal"] . '</td>
                </tr>
                <tr>
                    <td class="totals">Discount:</td>
                    <td class="totals cost" colspan="2">INR ' . $disc . '</td>
                </tr>
                <tr>
                    <td class="totals"><b>Subtotal:</b></td>
                    <td class="totals cost" colspan="2"><b>INR ' . $data["subtotalz"] . '</b></td>
                </tr>

                <tr>
                    <td class="totals">Additional Charges:</td>
                    <td class="totals cost" colspan="2">INR ' . $char . '</td>
                </tr>
                <tr class="last">
                    <td class="totals" style="color:#B28A51;"><b>Total:</b></td>
                    <td class="totals cost" colspan="2" style="background-color:#ddd;"><b>INR ' . $data["totalbalance"] . '</b></td>
                </tr>
        </table>
    </body>
</html>';
echo $html;

require 'vendor/autoload.php';


$mpdf = new \Mpdf\Mpdf([
    'margin_left' => 20,
    'margin_right' => 15,
    'margin_top' => 18,
    'margin_bottom' => 25,
    'margin_header' => 10,
    'margin_footer' => 10
]);
$location = $_SERVER['DOCUMENT_ROOT'] . '/' . 'invoice/';
$mpdf->SetProtection(array('print'));
$mpdf->SetTitle($data["from_name"] . " - Invoice");
$mpdf->SetAuthor($data["from_name"]);
$mpdf->SetWatermarkText("Paid");
$mpdf->showWatermarkText = false;
$mpdf->watermarkTextAlpha = 0.1;
$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML(utf8_encode($html));
//$mpdf->Output('invoice.pdf', 'I');
$content = $mpdf->Output('', 'S');

$attachment = new Swift_Attachment($content, 'invoice.pdf', 'application/pdf');
$message = new Swift_Message;
$message->setSubject('Invoice-' . $data["invoice_id"]);
$message->setFrom(array($data['sender_email'] => $data['sender_name']));
//$message->setTo(array('deepanshu@canvasdigital.net' => 'Deepanshu Srivastava'));
$message->setTo(array($data['rec_email'] => $data["rec_name"]));
$email_c = '<html>

    <head>
        <style>
            body {font-family: arial;
                font-size: 10pt;
            }
            p {	margin: 0pt; }
            table.items {
                border: 0.1mm solid #000000;
            }
            td { vertical-align: top; }
            .items td {
                border:0.1mm solid #000000;

            }
            table thead td { background-color: #000;
                text-align: center;
                color:#B28A51;
                border: 0.1mm solid #000000;
                font-variant: small-caps;
            }
            .summary td.blanktotal {
                background-color: #EEEEEE;
                background-color: #FFFFFF;
                border: 0mm;

                text-align: center;
                        vertical-align: middle;
            }
            .summary td.totals {
                text-align: right;

                padding: 5px 20px;
            }
            .summary td.totals.cost {
                text-align: right;
                padding: 5px 20px;
                border-left: 0.1mm solid #000000;
            }

            table.summary {
                float: right;
                border-top: 0.1mm solid #000000;
                width: 100%;
                margin-bottom: 20px;
                border-collapse: collapse;
            }
            .summary tr.last {
                border-top: 1px solid #000;
                border-bottom: 1px solid #000;
            }

            .items tr:nth-child(even) {
                background-color: #ddd;
            }

            .items tbody td:last-child {
                background-color: #fff;
            }
        </style>
    </head>

    <body style="padding:10px 10px;margin-bottom:20px;">
    <div>Hello ' . $data["c_name"] . ',</div>
    <br />
    <div>' . $msg . '</div>
    <br />
    <br />

        <table width="100%" cellpadding="10">
            <tr>
                <td width="45%" style="border: 0"><span style="font-size: 18px;">Bill
                        To
                    </span><br />
                    <address>
                        <strong>' . $data["c_name"] . '</strong><br>
                        ' . $data["c_addr"] . '<br>
                        ' . $data["c_addr2"] . '<br>
                        ' . $data["c_phone"] . '<br>
                        ' . $data["c_email"] . '
                    </address>
</td>
                <td width="55%" style="border: 0;text-align:right;"><span style="font-size: 18px;">Bill
                        From
                    </span><br />
                    <address class="text-md-right">
                        <strong>' . $data["from_name"] . '</strong><br>
                        ' . $data["from_addr"] . '<br>
                        ' . $data["from_addr2"] . '<br>
                        ' . $data["from_phone"] . '<br>
                        ' . $data["from_email"] . '
                    </address>
                    </td>
            </tr>
        </table>

        <br />

        <br />
                <table class="items" width="100%" style="font-size: 12pt; border-collapse: collapse; " cellpadding="8">
            <thead>
                <tr>
                    <th style="width:5%;border: 1px solid;">SNo.</th>
                    <th style="width:40%;border: 1px solid;">Description</th>
                    <th style="width:5%;border: 1px solid;">Quantity</th>
                    <th style="width:15%;border: 1px solid;">Price</th>
                    <th style="width:10%;border: 1px solid;">SGST(%)</th>
                    <th style="width:10%;border: 1px solid;">CGST(%)</th>
                    <th style="width:15%;border: 1px solid;">Subtotal</th>
                </tr>
            </thead>
            <tbody>' . $rows . '


            </tbody>
        </table>

        <table class="summary" style="text-align:right">
                <tr class="sum">
                    <td class="totals" width="20%">Subtotal:</td>
                    <td class="totals cost" width="20%" colspan="2">INR ' . $data["subtotalbdisc"] . '</td>
                </tr>
                <tr>
                    <td class="totals">Total Tax:</td>
                    <td class="totals cost" colspan="2">INR ' . $data["taxtotal"] . '</td>
                </tr>
                <tr>
                    <td class="totals">Discount:</td>
                    <td class="totals cost" colspan="2">INR ' . $disc . '</td>
                </tr>
                <tr>
                    <td class="totals"><b>Subtotal:</b></td>
                    <td class="totals cost" colspan="2"><b>INR ' . $data["subtotalz"] . '</b></td>
                </tr>

                <tr>
                    <td class="totals">Additional Charges:</td>
                    <td class="totals cost" colspan="2">INR ' . $char . '</td>
                </tr>
                <tr class="last">
                    <td class="totals" style="color:#B28A51;"><b>Total:</b></td>
                    <td class="totals cost" colspan="2" style="background-color:#ddd;"><b>INR ' . $data["totalbalance"] . '</b></td>
                </tr>
        </table>
        <div>Thanks</div>
    <br />
    </body>
</html>';
$message->setBody($email_c, 'text/html');
$message->attach($attachment);
$transport = (new Swift_SmtpTransport('sg3plcpnl0005.prod.sin3.secureserver.net', 465, 'ssl'))
    ->setUsername('invoices@canvasdigital.net')
    ->setPassword('QagiXGhu4CaBXmT');
// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);
$mailer->send($message);
// Then, you can send PDF to the browser
$mpdf->Output('invoice.pdf', 'I');
