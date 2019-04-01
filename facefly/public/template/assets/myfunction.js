// ẩn hiện 1 thẻ html
function myFunction() {
    document.getElementById("hide").style.display = document.getElementById("hide").style.display = "block";
}
function myFunction1() {
    document.getElementById("hide").style.display = document.getElementById("hide").style.display = "none";
}

// validate
function validateForm() {
    //& validateTime()
    if (validateCity()) {
        return true;
    } else {
        return false;
    }
}

function validateCity() {
    var form = $('#from').val();
    var to = $('#to').val();

    if (form == to)
    {
        alert("Điểm khởi hành phải khác điểm đến, xin chọn lại!");
        return false;
    } else
    {
        return true;
    }


}
//departure
function validateTime() {
    var time_departure = $('#departure').val();
    var time_return = $('#return').val();

    var da = Date.parse(time_departure);
    var date = new Date(da);
    var d = new Date();

    if (d.getTime() < date)
    {
        return true;
    } else
    {
        alert(d.getTime() + "===" + da);
        return false;
    }


}
