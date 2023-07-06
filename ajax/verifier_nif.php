<?php
  
   // Check if the "nif" parameter is set
   if (isset($_GET['nif'])) {
	   // Get the value of the "nif" parameter
	   $nif = $_GET['nif'];
	   // Set the URL of the page to scrape
	   $url = 'https://nif.mfdgi.gov.dz/nif.asp?Nif=' . urlencode($nif);
	   // Initialize cURL
	   // Create a new cURL resource
	   $curl = curl_init();

	   // Set the cURL options
	   curl_setopt($curl, CURLOPT_URL, $url);
	   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	   curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	   curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

	   // Execute the cURL request
	   $response = curl_exec($curl);

	   // Close the cURL resource
	   curl_close($curl);

	   // Create a new DOM document
	   $dom = new DOMDocument();

	   // Load the HTML response into the DOM document
	   @$dom->loadHTML($response);

	   // Find the table rows
	   $rows = $dom->getElementsByTagName("tr");

	   // Initialize the result array
	   $result = array();

	   // Loop through the table rows
	   foreach ($rows as $row) {
		   // Find the table data cells
		   $cells = $row->getElementsByTagName("td");

		   // Initialize the row data array
		   $row_data = array();

		   // Loop through the table data cells
		   foreach ($cells as $i => $cell) {
			   // Extract the text content of the cell
			   $cell_text = trim($cell->textContent);

			   // Skip empty cells
			   if ($cell_text === "") {
				   continue;
			   }

			   // Check if the cell is the "raison sociale" cell
			   
			   if ($i === 0 && strpos($cell_text, $nif) === 0) {
				   // Add the company name to the row data array
				   $row_data[] = trim($cells[$i+1]->textContent);
				   break; // Stop looping through the cells
			   }
		   }

		   // Add the row data to the result array
		   if (!empty($row_data)) {
			   $result[] = $row_data;
		   }
	   }
   }

   // Output the result array as an HTML table
   if (!empty($result)) {
	   echo "<table>\n";
	   foreach ($result as $row) {
		   echo "<tr>\n";
		   foreach ($row as $cell) {
			   echo "<td>" . $cell . "</td>\n";
		   }
		   echo "</tr>\n";
	   }
	   echo "</table>\n";
   } else {
	   echo "<p>Nif Inéxistant ,Veuillez vous Rapprocher auprés des services fiscaux habilités</p>";
   }
	?>