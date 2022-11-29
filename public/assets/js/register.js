$(document).ready(function () {
    let dtblUser = $('#dtblUser').DataTable({
        "lengthMenu": [
            [10, 15, 45, 75, -1],
            [10, 15, 45, 75, 'all']
        ],
        "pageLength": 10,
        "bProcessing": true,
        "bServerSide": true,
        "bStateSave": false,
        "bPaginate": true,
        "bLengthChange": false,
        "bFilter": true,
        "bSort": false,
        "bInfo": true,
        "bAutoWidth": false,
        "bDestroy": false,
        "ajax": {

            "url": "user_details",
            "type": "get",
            dataSrc: 'aaData'
        },
        "sDom": "<'row'<'col-xs-4 col-sm-3 'l><'col-lg-1 col-md-12 col-sm-12'><'col-md-4 col-sm-4'>f>t<'row'<'col-lg-6 col-md-12 col-sm-12' <'row' <'col-lg-6 col-md-12 col-sm-12' i>>><'col-lg-6 col-md-12 col-sm-12'p>>",
        "aoColumns": [
            { "data": 'id', "name": "id", "className": "text-center", "sWidth": "10%" },
            { "data": "name", "name": "user_name", "sWidth": "20%" },
            { "data": "email", "name": "email", "sWidth": "20%" },
            { "data": "address", "name": "address", "sWidth": "20%" },
            { "data": "phone_no", "name": "phone_no", "sWidth": "20%" },
            {
                "sName": "action",
                "data": null,
                "className": "text-center",
                "defaultContent": "<button id='edit_user' action ='edit_user'  class='btn btn-info btn-sm'><i class='fa fa-edit' ></i></button>&nbsp;&nbsp<button id='delete_user' action ='delete_user' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>"
            }

        ],

    });



    $('#dtblUser tbody').on('click', 'button[action=edit_user]', function (event) {
        var data = dtblUser.row($(this).parents('tr')).data();
        var oTable = $('#dtblUser').dataTable();
        // console.log(oTable);
        // $(oTable.fnSettings().aaData).each(function() {
        //     $(this.nTr).removeClass('success');

        // });

        var row;
        if (event.target.tagName == "BUTTON")
            row = event.target.parentNode.parentNode;
        else if (event.target.tagName == "I")
            row = event.target.parentNode.parentNode.parentNode;
        $(row).addClass('success');

        //$("#modal_user").html('Edit Group');
        //$("#edit_user").html('<i class="fa fa-edit"></i> Update');
        $("#edit_user").removeAttr('disabled');

        var user_name = oTable.fnGetData(row).name;
        var email = oTable.fnGetData(row).email;
        var address = oTable.fnGetData(row).address;
        var phn_no = oTable.fnGetData(row).phone_no;
        console.log(oTable.fnGetData(row).username);
        $('#user_id').val(oTable.fnGetData(row).id);

        $('#user_name').val(user_name);
        $('#mail_id').val(email);
        $('#addres').val(address);
        $('#mob').val(phn_no);
        $('#exampleModalCenter').modal('show');
    });


    // $('#register').click(function(){
    //     var formData = new FormData($("#form").val()); 
    //     console.log(formData);
    //     $.ajax({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
    //         },
    //         url:"api/submit",

    //         data: formData,
    //         success: function(response) {
    //             if (response.dbStatus == 'SUCCESS') {
    //                 //dtblUser.ajax.reload();
    //                 // Loadcriteriatbl();
    //                 toastr.success(response.dbMessage);
    //             } else if (response.dbStatus == 'FAILURE') {
    //                 toastr.error(response.dbMessage);
    //             }
    //         },
    //         error: function() {
    //             toastr.error('Unable to process Delete Operation');
    //         }
    //     });
    // });
    $('#dtblUser tbody').on('click', 'button[action=delete_user]', function (event) {
        var data = dtblUser.row($(this).parents('tr')).data();
        var oTable = $('#dtblUser').dataTable();

        var row;

        if (event.target.tagName == "BUTTON")
            row = event.target.parentNode.parentNode;
        else if (event.target.tagName == "I")
            row = event.target.parentNode.parentNode.parentNode;
        $(row).addClass('success');
        swal({
            title: 'Are you sure to Delete?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            animation: true
        }).then(function () {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                },
                url: "delete_user",
                type: "get",
                data: { id: data.id },
                success: function (response) {
                    if (response.dbStatus == 'SUCCESS') {
                        dtblUser.ajax.reload();
                        // Loadcriteriatbl();
                        toastr.success(response.dbMessage);
                    } else if (response.dbStatus == 'FAILURE') {
                        toastr.error(response.dbMessage);
                    }
                },
                error: function () {
                    toastr.error('Unable to process Delete Operation');
                }
            });
        }, function (dismiss) { }).done();
    });



})
function edit() {
    var id = $('#user_id').val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "edit_user",
        type: "post",
        data: { id: id },
        success: function (response) {
            alert(response)
            if (response.dbStatus == 'SUCCESS') {
                dtblUser.ajax.reload();
                // Loadcriteriatbl();
                toastr.success(response.dbMessage);
            } else if (response.dbStatus == 'FAILURE') {
                toastr.error(response.dbMessage);
            }
        },
    });
}
function status_change(state) {
    alert(state);
    var id = $('#user_id').val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "status_change",
        type: 'POST',
        data: { id: id, 'state': state },
        success: function (response) {
            //console.log(response)
            var jsonData = JSON.parse(response);
            console.log(jsonData);
            if (jsonData.dbStatus == 'SUCCESS') {
                if (state == 0) {
                    document.getElementById("inactive").disabled = true;
                    document.getElementById("active").disabled = false;
                }
                else {
                    document.getElementById("inactive").disabled = false;
                    document.getElementById("active").disabled = true;
                }

                $("#exampleModalCenter").modal("hide");
                toastr.success(jsonData.dbMessage);
                //alert(jsonData.dbMessage);
            } else {
                toastr.error(jsonData.dbMessage);

                $("#exampleModalCenter").modal("hide");
            }

        }
    });

}