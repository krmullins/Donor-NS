// file: hooks/Catalog-dv.js
// get an instance of AppGiniDetailView class
var dv = AppGiniHelper. DV; 
// hide the id-field
dv.getField("ID").hide(); 
dv.setTitle('Catalog Details');

// create a (full sized) row (width = 12) and
// add a headline "Catalog" ("#Catalog Info"), then 
// beautify label-alignment (sizeLabels(2))
var row_1 = new AppGiniLayout([6,6])
    .add(1, ["#Catalog Info", "CatalogNo", "CatalogTitle"])
    .add(2, ["#Catalog Info", "TypeID", "GroupID"])
    .sizeLabels(3);


// and add headlines (starting with "#") and other fields into columns 1 and 2
var row_2 = new AppGiniLayout([6, 6])
    .add(1, ["#Details","Description","Restrictions", "Quantity"])
    .add(2, ["#Extra", "DonorText", "CatalogValueText", "AdditionalInfo"]);



// create a variable "container" for easier handling of new action buttons
var container = dv. ActionButtons(); 

// create a group named "Links"
var group = container.addGroup("Links"); 

// add some links
group.addLink("Download PDF", "my_custom_page.php", Variation. Primary, "file"); 
group.addLink("Notify Station", "patients_view.php", null, "send"); 
group.addLink("Settings", "patients_view.php", null, "cog"); 

// add two buttons for toggling the compact-mode with no text but icons "minus"/"plus"
group.addButton("Hide", function () { dv.compact(); }, null, "minus"); 
group.addButton("Show", function () { dv.compact(false); }, null, "plus"); 
