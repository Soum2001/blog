
    $('#profileupload').click(function(){

        $('#profile_imgupload').trigger('click');
    });
    $('#banner_btn').click(function(){
        $('#banner_imgupload').trigger('click');
    });
    
    
    var crop_class = {
        cropper : {},
        loadprofile_img:function(input,type){
            crop_class.init(type);
           // alert(type);
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#crop_img').attr('src', e.target.result);
                    //$('#img_body').attr('src', e.target.result);
                };
                /*
                
                */
                //var cropper = image.data('cropper');
                console.log('abcdd');
                
                reader.readAsDataURL(input.files[0]);
                $("#profile_image").attr("src", $("#preview").attr("src"));
                $('#crop_image').on('hidden.bs.modal', function () {
                    location.reload();
                })
            }  
            var modal = $('#crop_image');
            modal.modal("show");
    
        },
        loadbanner_img:function(input,type){
            crop_class.init(type);
           // alert(type);
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#crop_img').attr('src', e.target.result);
                    //$('#img_body').attr('src', e.target.result);
                };
                
                /*
                
                */
                
                //var cropper = image.data('cropper');
                console.log('abcdd');
                
                reader.readAsDataURL(input.files[0]);
                
                $('#crop_image').on('hidden.bs.modal', function () {
                    location.reload();
                })
            }  
            var modal = $('#crop_image');
            modal.modal("show");
        },
        init:function(type){
    
            var modal = $('#crop_image');
            
            var image=$("#crop_img");
            modal.on('shown.bs.modal', function() {
                /*
                crop_class.cropper = image.cropper({
                    aspectRatio: 1,
                    viewMode: 3,
                    preview:'.preview'
                });
                */
               console.log(image);
                image.cropper({
                    aspectRatio: 16 / 9,
                    crop: function(event) {
                      console.log(event.detail.x);
                    }
                  });
    
                  crop_class.cropper = image.data('cropper');
    
            }).on('hidden.bs.modal', function(){
                crop_class.cropper.destroy();
                   cropper = null;
            });
    
            $('#crop').click(function () {
                crop_class.crop(type);
            });
            
            $('#crop-form').submit(function(){
                crop_class.crop(type);
            })
    
        },
        crop:function(type){
    
            crop_class.cropper.crop();
            alert('hii..');
            const form_data = new FormData();
            console.log(form_data);
            crop_class.cropper.getCroppedCanvas().toBlob((blob) => {
               // const form_data = new FormData();
                form_data.append('profile_imgupload', blob);
                form_data.append('profile_imgupload', type);
                console.log(blob);
                console.log('after bolb');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type:'POST',
                    url:'user_profile_upload',
                    enctype: 'multipart/form-data',
                    data:form_data,
                    processData: false,
                    contentType: true,
                    // success:function(response){
                    //     console.log(response);
                    //     var jsonData=JSON.parse(response);
    
                    //     console.log(jsonData);
                    //     if(jsonData.success)
                    //     {
                    //         $("#crop_image").modal("hide");
                    //         alert(jsonData.msg);
                    //     } 
                      
                    // }
                });
                
            });
    
            }
        }
    
            // $(document).ready(function(){
            //     $("#crop-form").on("submit", function(event){
            //         event.preventDefault();
             
            //         var formValues= $(this).serialize();
             
            //         $.ajax({
            //             url: "/xyz",
            //             type:"POST",
            //             data:{
            //                 name:'hiiiiii',
            //                 _token: _token,
            //                 _method: "PUT",
            //             },
            //             success:function(response){
            //                 console.log(response);
            //             },
            //         });
            //     });
            // });

// function load_custom(input,id)
// {
//     if (input.files && input.files[0]) {
//         var reader = new FileReader();
//         reader.onload = function (e) {

//         };
//         reader.readAsDataURL(input.files[0]);
//         var property=$('#custom_img').prop('files')[0];
//         var form_data=new FormData();
//         form_data.append('custom_img',property);
//         form_data.append('custom_img',id);

//         console.log(form_data);
       
//         $.ajax({
//             url:'custom_upload.php',
//             type:'POST',
//             enctype: 'multipart/form-data',
//             data:form_data,
//             processData: false,
//             contentType: false,
//             success:function(response){
//                 console.log(response);
//                 var jsonData = JSON.parse(response);
//                 console.log(jsonData);
//                 if(jsonData.success){
//                     alert(jsonData.msg);
//                     window.location.reload();
//                 }else{
//                     alert(jsonData.msg);
//                 }
                
//             }
//         });

//     }
// }

