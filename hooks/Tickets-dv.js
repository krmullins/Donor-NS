// file: hooks/Tickets-dv.js
// get an instance of AppGiniDetailView class
var dv = AppGiniHelper. DV; 

dv.getField("ID").hide();
dv.setTitle('Ticket Details');

//AppGiniHelper.dv.createLayout([6, 6])

var row_1 = new AppGiniLayout([6,6])
    .add(1, ["#Guest Information","UsersName", "BidderID", "TablePreference"])
    .add(2, ["#Table Information", "TableID", "TableName", "SeatingPosition"])
    .sizeLabels(2);

// create a variable "container" for easier handling of new action buttons
var container = dv. ActionButtons(); 

// create a group named "Links"
var group = container.addGroup("Links"); 

// add some links

// add two buttons for toggling the compact-mode with no text but icons "minus"/"plus"
group.addButton("Hide", function () { dv.compact(); }, null, "minus"); 
group.addButton("Show", function () { dv.compact(false); }, null, "plus"); 
