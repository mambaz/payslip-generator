function updateCounter() {
    var numberOfChecked = $("input[name='empIDs[]']:checked").length;
    var totalCheckboxes = $("input[name='empIDs[]']:checkbox").length;
    if (totalCheckboxes === numberOfChecked) {
        $(".selectAll").prop("checked", true);
    } else {
        $(".selectAll").prop("checked", false);
    }
    $('.countValue').html(numberOfChecked);
}
$(document).ready(function() {

    $('#empTable').DataTable({
        paging: false,
        ordering: false
    });
    updateCounter();
    $('.select_all').change(function() {
        $('input[name="empIDs[]"]:checkbox').not(this).prop('checked', this.checked);
        updateCounter();
    });

    $("input[name='empIDs[]']:checkbox").on("change", function() {
        updateCounter();
    });
    $('.zipDownloadBtn').click(function() {
        var totalIds = $("input[name='empIDs[]']:checked").length;
        if (totalIds > 0) {
            downloadFile('zip');
        }
    });
    $('.sendAllMailBtn').click(function() {
        var totalIds = $("input[name='empIDs[]']:checked").length;
        if (totalIds > 0) {
            downloadFile('email');
        }
    });
});

function downloadFile(type, id) {
    var loading = '<p class="text-center text-color-dodger-blue"><i class="fas fa-spin fa-truck-loading"></i> Generating '+ type +', please wait...</p>';
    $('.modal-body').html(loading);
    $('#empModal').modal('show');

    var empIDs;
    if (!id) {
        empIDs = $("input[name='empIDs[]']:checkbox:checked").map(function() {
            return $(this).val();
        }).get();
    } else {
        empIDs = [id];
    }
    // var zipName = $('#payslipPeriod').val().replace(/\W/g, '');

    $.ajax({
        url: "download.php",
        method: "POST",
        data: {
            actionType: type,
            item: empIDs,
            period: $('#payslipPeriod').val()
        },
        success: function(response) {
            if (response.type !== 'email') {
                downloadURI(response);
            }
            var modalContent = generateButton(response);
            $('.modal-body').html(modalContent);
        },
        error: function() {
            $('.modal-body').html('<div class="alert alert-danger" role="alert"> Error! Please try again. </div>');
        }
    });
}

function downloadURI(data) {
    var link = document.createElement("a");
    link.download = data.name;
    link.href = data.path;
    link.click();
}

function generateButton(data) {
    var htmlText = '';
    if (data.status) {
        var obj = data.status;
        var i = 1;
        htmlText = '<div class="modal-table-wrap"><table class="table table-bordered">';
        htmlText += '<tr><th>S.no</th><th>Email</th><th>Status</th></tr>';
        $.each(obj, function( key, value ) {
            var checked = value ? '<span class="text-color-late-blue"><i class="fa fa-check"></i></span>' : '<span class="text-color-Tomato"><i class="fa fa-times-circle"></i></span>';
            htmlText += "<tr><td>"+i+"</td>"+"<td>"+key+"</td>"+"<td>"+checked+"</td></tr>";
            i++;
        });
        htmlText += '</table></div>';
    } else if (data.path && data.name) {
        htmlText = '<p class="text-center">The '+data.type+' for your payslip is ready to be downloaded.<a href="' + data.path + '" download="' + data.name + '" class="btn btn-primary"><i class="fa fa-download"></i> Download<a></p>';
    } else {
        htmlText = '<div class="alert alert-danger" role="alert"> Error! Please try again. </div>';
    }
    return htmlText;
}
