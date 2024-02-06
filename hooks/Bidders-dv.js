// file: hooks/Bidders-dv.js
// get an instance of AppGiniDetailView class
var dv = AppGiniHelper. DV; 
// hide the id-field
dv.getField("ID").hide(); 
dv.setTitle('Bidder Details');

// create a (full sized) row (width = 12) and
// add a headline "Bidder Info" ("#Bidder Info"), then 
// add fields "last_name", "first_name", then
// add a divider-line ("-"), then
// add fields "birth_date" and "age".
// beautify label-alignment (sizeLabels(2))
var row_1 = new AppGiniLayout([1,1,10])
    .add(1, ["#Bidder Info"])
    .add(2, ["ID"])
    .sizeLabels(2);
var row_2 = new AppGiniLayout([7, 5])
    .add(1, ["ContactID"])
    .add(2, ["BidNo"])
    .sizeLabels(2);
var row_3 = new AppGiniLayout([12])
    .add(1, ["-"]);

var row_4 = new AppGiniLayout([7, 5])
    .add(1, ["#Pre-Event", "BidderType", "TablePreference"])
    .add(2, ["#Event", "Card", "CheckedIn", "QuickPay", "TotalBids","TotalOwed","TotalPaid"]);

// create a variable "container" for easier handling of new action buttons
var container = dv. ActionButtons(); 

// create a group named "Links"
var group = container.addGroup("Links"); 

// add some links
group.addLink("Print Invoice", "bidder_invoice.php?BidderID=1", Variation. Warning, "print"); 
group.addLink("Settings", "patients_view.php", null, "cog"); 

// add two buttons for toggling the compact-mode with no text but icons "minus"/"plus"
group.addButton("Hide", function () { dv.compact(); }, null, "minus"); 
group.addButton("Show", function () { dv.compact(false); }, null, "plus"); 
