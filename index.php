<?php
 
// Connect to database
// Server - localhost
// Username - root
// Password - empty
// Database name = xmldata
$conn = mysqli_connect("localhost", "root", "", "nwp");
 
$affectedItemRow = 0;

function deleteData ($conn, $table) {
    $sql = "delete from " . $table;
    $result = mysqli_query($conn, $sql);
}

function clearFileContent ($fileContents) {

    // Replace
    $fileContents = str_replace('&nbsp;', '', $fileContents);
    $fileContents = str_replace('&', '', $fileContents);
    $fileContents = str_replace('<>', '&lt;&gt;', $fileContents);

    // Add the CDATA tags //dodati foreach
    $fileContents = str_replace('<TechnicalDescription>', '<TechnicalDescription><![CDATA[', $fileContents);
    $fileContents = str_replace('</TechnicalDescription>', ']]></TechnicalDescription>', $fileContents);
    $fileContents = str_replace('<MarketingDescription>', '<MarketingDescription><![CDATA[', $fileContents);
    $fileContents = str_replace('<MarketingDescription xml:space="preserve">', '<MarketingDescription xml:space="preserve"><![CDATA[', $fileContents);
    $fileContents = str_replace('</MarketingDescription>', ']]></MarketingDescription>', $fileContents);

    return $fileContents;
}

// insert item
function insertItem($conn, $code, $name, $description, $link, $image_link, $condition, $availability, $price, $gtin, $brand, $product_type, $google_product_category, $fb_product_category) {
    $sql = "INSERT INTO price (code, name, description, link, image_link, condition, price, gtin, brand, product_type, google_product_category, fb_product_category) VALUES ('"
    . $code . "','" . $name . "','"  . $description . "','" . $link . "','" . $image_link . "','" . $condition . "','" . $availability . "','" . $price . "','" . $gtin . "','" . $brand . "','" . $product_type . "','" . $google_product_category . "','" . $fb_product_category . "')";

    $result_item = mysqli_query($conn, $sql);

    if (! empty($result_item)) {
        return 1;
    }
    
    return 0;
}

// Get file content as string
$fileItemContents = file_get_contents('https://www.techsavers.hr/storage/app/media/xml/google-hr.xml');

$fileItemContents = clearFileContent ($fileItemContents);

// Load xml file else check connection
$xmlItem = simplexml_load_string($fileItemContents)
    or die("Error: Cannot create object");

// delete data
deleteData($conn, "items");

// Assign values products
foreach ($xmlItem->channel->children()->item as $row) {

    $ns = $row->getNamespaces(true);

    $item = $row->children($ns['g']);
    
    //echo $item->id;

    /*foreach ($child as $out)
    {
        echo $out . "<br />";
    }*/

    $code = $item->id;
    $name = $row->title;
    $description = $row->description;
    $link = $row->link;
    $image_link = $item->image_link;
    $condition = $item->condition;
    $availability = $item->availability;
    $price = strtok($item->price, ' ');
    $currency = strstr($item->price, ' ');
    $gtin = $item->gtin;
    $brand = $item->brand;
    $product_type = $item->product_type;
    $google_product_category = $item->google_product_category;
    $fb_product_category = $row->fb_product_category;

    // SQL query to insert data into xml table 
    $sql = "INSERT INTO items (code, name, description, link, image_link, item_condition, item_availability, price, currency, gtin, brand, product_type, google_product_category, fb_product_category) VALUES ('"
        . $code . "','" . $name . "','"  . $description . "','" . $link . "','" . $image_link . "','" . $condition . "','" . $availability . "','" . $price . "','" . $currency . "','" . $gtin . "','" . $brand . "','" . $product_type . "','" . $google_product_category . "','" . $fb_product_category . "')";

    $result = mysqli_query($conn, $sql);

    if (! empty($result)) {
        $affectedItemRow ++;
        $last_id = $conn->insert_id;
    }
}
?>
 
<center><h2>Pohrana podataka</h2></center>

<?php
if ($affectedItemRow > 0) {
    $message = "Items: " . $affectedItemRow . " records inserted.";
} else {
    $message = "No records inserted";
}
 
?>
<style>
    body { 
        max-width:550px;
        font-family: Arial;
    }
    .affected-row {
        background: #cae4ca;
        padding: 10px;
        margin-bottom: 20px;
        border: #bdd6bd 1px solid;
        border-radius: 2px;
        color: #6e716e;
    }
    .error-message {
        background: #eac0c0;
        padding: 10px;
        margin-bottom: 20px;
        border: #dab2b2 1px solid;
        border-radius: 2px;
        color: #5d5b5b;
    }
</style>
 
<div class="affected-row">
    <?php  echo $message; ?>
</div>
 
<?php if (! empty($error_message)) { ?>
 
<div class="error-message">
    <?php echo nl2br($error_message); ?>
</div>
<?php } ?>