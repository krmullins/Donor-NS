// file: hooks/Donations-dv.js
// get an instance of AppGiniDetailView class
var dv = AppGiniHelper. DV; 
// hide the id-field
dv.getField("ID").hide();
dv.setTitle('Donation Details');

// create a (full sized) row (width = 12) and
// add a headline "Donation" ("#Donation"), then 
// add fields "ID", "ContactID (MailingName)", then
// beautify label-alignment (sizeLabels(2))
var row_1 = new AppGiniLayout([7])
    .add(1, ["#Donor Info", "ContactID"])
    .sizeLabels(3);


// create a row with two columns. 
// column 1: width = 8/12
// column 2: width = 4/12
// and add headlines (starting with "#") and other fields into columns 1 and 2
var row_2 = new AppGiniLayout([7, 5])
    .add(1, ["#Information", "DonationName", "Description", "Restrictions"])
    .add(2, ["#Details", "Value", "ContactPerson", "ContactPhone", "ItemStatus", "AdditionalInfo"]);
  
  var row_3 = new AppGiniLayout([7, 5])
    .add(1, ["Notes"])
    .add(2, ["#Procurement Contact", "ProcuredBy", "DateProcured"]);

var row_4 = new AppGiniLayout([12])
    .add(1, ["-"]);

var row_5 = new AppGiniLayout([7, 5])
    .add(1, ["#Follow Up","Thanks"])
    .sizeLabels(3);

var row_6 = new AppGiniLayout([12])
    .add(1, ["-"]);

var row_7 = new AppGiniLayout([7, 5])
    .add(1, ["#Catalog Info", "CatalogID"]);


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
