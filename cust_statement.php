<html>
    <head>
        <title>Statement</title>
        <link rel="stylesheet" type="text/css" href="css/cust_statement.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
        <style>
            body {
                background-color: #ffff; /* Light blue shade */
            }
            #customer_profile .link5 {
                background-color: rgba(5, 21, 71, 0.4);
            }
        </style>
        <?php include 'header.php'; ?>
    </head>
    <body>
        <?php include 'customer_profile_header.php'; ?>
		
        <?php 
        if ($_SESSION['customer_login'] == true) {
            // User is logged in
        } else {
            header('location:customer_login.php');
        }
        ?>
		
        <div class="cust_statement_container_head">
            <label class="heading">Bank Statement</label>
        </div>
        <div class="cust_statement_container">
            <div id="whatToPrint" class="cust_statement">
                <table>
                    <th>#</th>
                    <th>Date</th>
                    <th>Transaction Id</th>
                    <th>Description</th>
                    <th>Cr</th>
                    <th>Dr</th>
                    <th>Balance</th>

                    <?php
                    // Database query and display logic
                    $cust_id = $_SESSION['customer_Id'];
                    $sql = "SELECT * FROM passbook_$cust_id ORDER BY Id ASC"; // Sorting in ascending order
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $Sl_no = 1; 
                        // Output data for each row
                        while ($row = $result->fetch_assoc()) {
                            echo '
                            <tr>
                                <td>' . $Sl_no++ . '</td>
                                <td>' . $row['Transaction_date'] . '</td>
                                <td>' . $row['Transaction_id'] . '</td>
                                <td>' . $row['Description'] . '</td>
                                <td>' . $row['Cr_amount'] . '</td>
                                <td>' . $row['Dr_amount'] . '</td>
                                <td>₹' . $row['Net_Balance'] . '</td>
                            </tr>';
                        }
                    }
                    ?>
                </table>
                <button id="downloadButton" onclick="generatePDF()">Click to download</button>
            </div>
        </div>

        <script>
            async function generatePDF() {
                try {
                    const downloadButton = document.getElementById("downloadButton");
                    downloadButton.innerHTML = "Currently downloading, please wait...";
                    downloadButton.disabled = true;

                    const downloading = document.getElementById("whatToPrint");

                    // Ensure the element has a white background (CSS override for PDF rendering)
                    downloading.style.backgroundColor = "white";

                    // Get the width and height of the entire table content
                    const elementWidth = downloading.scrollWidth;
                    const elementHeight = downloading.scrollHeight;

                    // Adjust the scale and capture the content with a white background
                    const canvas = await html2canvas(downloading, {
                        scale: 3, // Higher scale for better resolution
                        useCORS: true, // Allow cross-origin requests for external images/fonts
                        allowTaint: true, // Include tainted images (e.g., images from external sources)
                        backgroundColor: "#ffffff", // Ensure white background for clarity
                        width: elementWidth,
                        height: elementHeight
                    });

                    // Convert canvas to PNG data URL
                    const imgData = canvas.toDataURL("image/png");

                    // Define the PDF document dimensions (A4 size in points, landscape)
                    const pdfWidth = 842; // A4 width in points for landscape
                    const pdfHeight = 595; // A4 height in points for landscape

                    // Create a new jsPDF instance with landscape orientation
                    const doc = new jsPDF('l', 'pt', [pdfWidth, pdfHeight]);

                    // Add the captured image (canvas) to the PDF
                    let imgHeight = (pdfWidth * elementHeight) / elementWidth; // Maintain aspect ratio for height

                    // Adjust the scale to fit the content within the PDF page
                    if (imgHeight > pdfHeight) {
                        // Scale the image to fit the page vertically
                        imgHeight = pdfHeight;
                    }

                    doc.addImage(imgData, 'PNG', 0, 0, pdfWidth, imgHeight);

                    // Save the generated PDF
                    doc.save("Bank_Statement.pdf");

                    downloadButton.innerHTML = "Click to download";
                    downloadButton.disabled = false;
                } catch (error) {
                    console.error("Error generating PDF:", error);
                    alert("An error occurred while generating the PDF. Please try again.");
                }
            }
        </script>

        <?php include 'footer.php'; ?>
    </body>
</html>
