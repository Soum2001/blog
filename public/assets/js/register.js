$(document).ready(function(){
   
    $('#user_table').DataTable({
        "lengthMenu": [
            [10, 15, 45, 75, -1],
            [10, 15, 45, 75,  'all']
        ],
        "pageLength": 10,
        "bProcessing":true,
        "bServerSide": false,
        "bStateSave": false,
        "bPaginate": false,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": false,
        "bInfo": true,
        "bAutoWidth": false,
        "bDestroy": false, 
        "ajax": {
            
            "url": "user_details",
            "type":"get",
             dataSrc:'aaData'
        },
        "sDom":"<'row'<'col-xs-4 col-sm-3 'l><'col-lg-1 col-md-12 col-sm-12'><'col-md-4 col-sm-4'>f>t<'row'<'col-lg-6 col-md-12 col-sm-12' <'row' <'col-lg-6 col-md-12 col-sm-12' i>>><'col-lg-6 col-md-12 col-sm-12'p>>",
        "aoColumns": [
            { "data": 'id', "name": "id", "className": "text-center", "sWidth": "10%" },
            { "data": "username", "name": "user_name", "sWidth": "20%" },
            { "data": "email", "name": "email", "sWidth": "20%" },
            { "data": "address", "name": "address", "sWidth": "20%" },
            { "data": "phone_no", "name": "phone_no", "sWidth": "20%" },
            {
                "sName": "action",
                "data": null,
                "className": "text-center",
                "defaultContent": "<button id='edit_user' action ='edit_user' onclick='edit_user()' class='btn btn-info btn-sm'><i class='fa fa-edit' ></i></button>&nbsp;&nbsp<button id='delete_user' action ='delete_user' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>"
            }
           
        ],

    });
//     $("#register").click(function(){
//         alert('hi');
//         var form = $('#form');
//         console.log(form.serialize());
//         // $.ajax({
//         //     url: "insert",
//         //     type:'POST', 
//         //     data:form.serialize(),
//         //     success:function(response){
//         //         console.log(response);
//         //         var jsonData = JSON.parse(response);
//         //         console.log(jsonData);
//         //         if(jsonData.success){
//         //             alert(jsonData.msg);
//         //         }else{
//         //             alert(jsonData.msg);
//         //         }
//         //     }
//         // });
//     })
 })