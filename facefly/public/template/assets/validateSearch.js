$(document).ready(function () {
    $('#btnSearch').on('click', function (e) {
        e.preventDefault;
        var from = $('#from option:selected').text();
        var to = $('#to option:selected').text();
        var departure = $('#departure').val();
        var way_type = $("input[name='flight_type']:checked").val();
        var return_day = $('#return_day').val();
        var flight_class = $('#flight_class option:selected').val();
        var total_person = $('#total_person option:selected').val();
        if (from && to && departure && way_type && return_day && flight_class && total_person) {
            if (from == to) {
                alert("Nơi đi và nơi đến không được trùng nhau !");
                return false;
            }
            else if(return_day < departure) {
                alert("Ngày về phải lớn hơn ngày đi !");
                return false;
            }
            else
                $('#search').submit();
        } else {
            alert("Vui lòng điền đầy đủ thông tin yêu cầu !");
            return false;
        }
    });
});