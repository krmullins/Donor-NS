// file: hooks/Transactions-dv.js
// get an instance of AppGiniDetailView class
var dv = AppGiniHelper. DV; 
// hide the id-field
dv.getField("ID").hide(); 
dv.setTitle('Bid Information');

// create a (full sized) row (width = 12) and
// add a headline "Bids" ("#Bids"), then 
// beautify label-alignment (sizeLabels(2))
var row_1 = new AppGiniLayout([4,4,2])
    .add(1, ["CatalogID"])
    .add(2, ["BidderID"])
    .sizeLabels(3);
var row_2 = new AppGiniLayout([4,4,2])
    .add(1, ["Price"])
    .add(2, ["Quantity"])
    .add(3, ["Total"])
    .sizeLabels(3);







