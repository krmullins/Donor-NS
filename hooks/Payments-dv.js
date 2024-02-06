// file: hooks/Payments-dv.js
// get an instance of AppGiniDetailView class
var dv = AppGiniHelper. DV; 
// hide the id-field
dv.getField("ID").hide(); 
dv.setTitle('Payment Details');

// create a (full sized) row (width = 12) and
// add a headline "Bids" ("#Bids"), then 
// beautify label-alignment (sizeLabels(2))
var row_1 = new AppGiniLayout([5,5,2])
    .add(1, ["Date"])
    .add(2, ["BidderID"])
    .sizeLabels(3);
var row_2 = new AppGiniLayout([5,5,2])
    .add(1, ["PaymentAmount"])
    .add(2, ["PaymentType"])








