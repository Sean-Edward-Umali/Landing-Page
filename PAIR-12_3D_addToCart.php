<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
	<title>Shopping Cart Test</title>
	<style type="text/css">
		body{
			background-color:#2C7873;
			font-family:Tahoma;
			color:#6FB98F;
		}
		.cover{
			background-color:#004445;
			border: 3px solid #021C1E;
			font-family:Tahoma;
			color:#6FB98F;
		}
		thead,tfoot{
			border: 3px solid #021C1E;
		}
		.btn {
		  border: 3px solid black;
		  background-color: #004445;
		  color: black;
		  font-size: 16px;
		  padding: 10px;
		  cursor: pointer;
		  font-size:10px;
		}
		.colorButton{
			border-color: #6FB98F;
			color: #6FB98F;
		}
		.colorButton:hover{
			background-color: #6FB98F;
			color: white;
		}
	</style>
</head>
<body class="m-5">
	<div class="container">
			<form action="PAIR-12_3D_addToCart.php" method="post">
				<table class="table cover w-50 mx-auto">
					<tr> 
						<th class="text-center p-4" style="border: 3px solid #021C1E;" colspan="10">ITEMS AVAILABLE</th>
					</tr>
					<tr>
						<th class="border-0 text-center">Item</th>
						<th class="border-0 text-center">Quantity</th>
					</tr>
					<tr>
						<td class="border-0 text-center">Apples</td>
						<td class="border-0 text-center"><input type="text" class="text-center" name="apples" size="15"></td>
					</tr>
					<tr>
						<td class="border-0 text-center">Bananas</td>
						<td class="border-0 text-center"><input type="text" class="text-center" name="bananas" size="15"></td>
					</tr>
					<tr><td class="border-0"></td>
					<tr>	
						<td class="border-0"></td>
						<td class="border-0"><input type="submit" class="btn colorButton float-end" value="Click to add to cart"></td>
					</tr>
					<tr><td class="border-0"></td>
				</table>
			</form>
		<br><br><br>
		
		<?php
			//The code lists two products - apples and bananas - and provides a 
			//text box to indicate the quantity of each you want to place in the shopping cart.
			
			/* 
			This section uses PHP code to check whether the form has already been submitted. If the site visitor has submitted the form, the PHP code checks to see which (if any) of the products had been selected for purchase. If either one had been selected, the PHP code stores the new quantity number in the cart session cookie for that product:
			*/
			
			//code for apples
			if(isset($_POST['apples'])){
				if(is_numeric($_POST['apples'])){
					$_SESSION['cart']['apples'] = $_POST['apples'];
				}
			
			
			/* Because there are two forms on the web page, you need to add some more code to check if a Remove button has been clicked by the shopper. That was added to the code that checks for the other form data:*/
				elseif($_POST['apples'] == "Remove"){
					unset($_SESSION['cart']['apples']);
				}
			}
			
			//code for bananas 
			if(isset($_POST['bananas'])){
				if(is_numeric($_POST['bananas'])){
					$_SESSION['cart']['bananas'] = $_POST['bananas'];
				}
				elseif($_POST['bananas'] == "Remove"){
					unset($_SESSION['cart']['bananas']);
				}
			}
		?>
		
		<fieldset class="w-50 mx-auto">
			<!-- Next, the code shows the shopping cart status. If there isn't a shopping cart session cookie, one is created:-->
			<?php
				if(!isset($_SESSION['cart'])){
					$_SESSION['cart'] = array();
					echo "Your shopping cart is empty\n";
				}
				
				/*If a shopping cart session cookie exists, the program creates a form containing the shopping cart items, along with a remove button. */
				else{
					echo "<form action=\"PAIR-12_3D_addToCart.php\" method=\"post\">\n";
					echo "<table class=\"table cover\">\n";
					echo "<thead>";
					echo "<tr>";
					echo "<th class=\"text-center p-4\" style=\"border: 3px solid #021C1E;\" colspan=\"10\">Your Shopping Cart</th>";
					echo "</tr>";
				echo "<tr><th colspan=\"2\" class=\"text-center\">Item</th><th colspan=\"2\" class=\"text-center\">Quantity</th><th colspan=\"3\" class=\"text-start\">Total Amount</th><tr>\n";
					echo "</thead>";
					
					/*The foreach statement is used to iterate through each of the items in the shopping cart: */
					$Appletotal = 0;
					$Bananatotal = 0;
					foreach($_SESSION['cart'] as $key => $value){
						if($key == 'apples'){
							$price = $value * 25.75;
							$Appletotal += $price;
						}
						if($key == 'bananas'){
							$price = $value * 15.50;
							$Bananatotal += $price;
						}
						echo "<tbody>";
						echo "<tr><td colspan=\"2\" class=\"text-center cover\">".($key)."</td><td colspan=\"2\" class=\"text-center cover\">$value</td><td colspan=\"2\" class=\"text-end cover\">₱".number_format($price, 2, ".", ",")."</td>\n";
						echo "<td colspan =\"5\" class=\"text-center cover\"><input type=\"submit\" name=\"$key\" value=\"Remove\"</td></tr>\n";
						echo "</tbody>";
					}
					$total = $Appletotal + $Bananatotal;
					$vatSales =  $total/ 1.12;
					$vat = $total - $vatSales;
					$totalSale = $vatSales + $vat;
					echo "<tfoot>";
					echo "<tr>";
					echo "<td colspan=\"2\" class=\"text-center\">Overall Amount:</td>";
					echo "<td colspan=\"2\"></td>";
					echo "<td colspan=\"2\"></td>";
					echo "<td colspan=\"2\">₱".number_format($totalSale, 2, ".", ",")."</td>";
					echo "</tr>";
					echo "</tfoot>";
					echo "</table>\n";
					echo "</form>\n";
				}
			?>
		</fieldset>
	</div>
</body>
</html>