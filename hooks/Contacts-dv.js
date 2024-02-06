// file: hooks/Contacts-dv.js
// get an instance of AppGiniDetailView class
var dv = AppGiniHelper. DV;

dv.getField("ID").hide();
dv.getField("TotalDonated").hide();
dv.setTitle('Supporter Details');

//AppGiniHelper.dv.createLayout([6, 6])

var row_1 = new AppGiniLayout([4,4,4])
    .add(1, ["FirstName"])
    .add(2, ["LastName"])
    .add(3, ["SpouseName"]);

var row_2 = new AppGiniLayout([12])
    .add(1, ["-"]);

var row_3 = new AppGiniLayout([4, 4, 4])
    .add(1, ["#Address Info","Address1","Address2","City","State","Zip"])
    .add(2, ["#Contact Info","Business","Cell","Phone","Email"])
    .add(3, [ "#Other Info","Status", "ContactMethod",]);

// create a variable "container" for easier handling of new action buttons
var container = dv. ActionButtons(); 

// create a group named "Links"
var group = container.addGroup("Links"); 

// add some links

// add two buttons for toggling the compact-mode with no text but icons "minus"/"plus"
group.addButton("Hide", function () { dv.compact(); }, null, "minus"); 
group.addButton("Show", function () { dv.compact(false); }, null, "plus"); 



//AppGiniHelper.dv.createLayout([6, 6])

 //   .add(1, ["FirstName", "SpouseName", "Address1", "City", "Zip", "Phone", "Email", "TotalDonated"])

 //   .add(2, ["LastName", "Business","Address2", "State", "Cell", "Status", "ContactMethod"]);