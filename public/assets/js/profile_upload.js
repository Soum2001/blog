
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
           //alert(type);
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                  
                    $('#crop_img').attr('src', e.target.result);
                    //$('#img_body').attr('src', e.target.result);
                };
                /*
                
                */
                //var cropper = image.data('cropper');
                //console.log('abcdd');
                
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
        load_custom:function(input,type){
            crop_class.crop(type);
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                  
                    //$('#crop_img').attr('src', e.target.result);
                    //$('#img_body').attr('src', e.target.result);
                };
                /*
                
                */
                //var cropper = image.data('cropper');
                //console.log('abcdd');
                
                reader.readAsDataURL(input.files[0]);
                //$("#profile_image").attr("src", $("#preview").attr("src"));
            }  
    
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
            
            // $('#crop-form').submit(function(){
            //     crop_class.crop(type);
            // })
    
        },
        crop:function(type){
            
            $('#crop-form').on('submit',function(e){
                alert('hi');
                e.preventDefault();
                crop_class.cropper.getCroppedCanvas().toBlob((blob) => {
                    const form_data = new FormData($('#crop-form')[0]);
                    form_data.append('profile_imgupload', blob);
                    form_data.append('type', type);
                    console.log(form_data);
                    
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Accept': 'application/json', 
                        },
                        async: true,
                        crossDomain: true,
                        type:'POST',
                        url:'image_upload',
                        enctype: 'multipart/form-data',
                        data:form_data,
                        processData: false,
                        contentType: false,
                        success:function(response){
                            
                            var jsonData=JSON.parse(JSON.stringify(response));
        
                            console.log(jsonData);
                            if(jsonData.success)
                            {
                                $("#crop_image").modal("hide");
                                //toastr.options.fadeout = 3000
                                toastr.success(jsonData.msg,{ fadeOut:3000 });
                                return false;

                            } 
                        
                        }
                        
                    });
                });

            });  
            $('#crop-custom-img').on('click',function(e){
              //  e.preventDefault();
               
                var property=$('#custom_img').prop('files')[0];
                const form_data = new FormData();

                form_data.append('profile_imgupload',property);
                //form_data.append('custom_img', property);
                 form_data.append('type', type);
                // console.log(property);
                
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json', 
                    },
                    async: true,
                    crossDomain: true,
                    type:'POST',
                    url:'image_upload',
                    enctype: 'multipart/form-data',
                    data:form_data,
                    processData: false,
                    contentType: false,
                    success:function(response){
                            
                        var jsonData=JSON.parse(JSON.stringify(response));
    
                        console.log(jsonData);
                        if(jsonData.success)
                        {
                           // $("#crop_image").modal("hide");
                            //toastr.options.fadeout = 3000
                            toastr.success(jsonData.msg,{ fadeOut:3000 });
                            select_image(type);
                            

                        } 
                    
                    }
                    
                })

            }); 
    
            }
        }
       
        function new_gallery(){
            var gallery_name=$("#gallery_name").val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json', 
                },
                url:'add_new_gallery',
                type:'post',
                data:{new_gallery_name:gallery_name},
                success:function(response){
                   
                    var jsonData = JSON.parse(JSON.stringify(response));
                   
                    if(jsonData.dbStatus)
                    {
                        $('#add_gallery_modal').modal('hide');
                        toastr.success(jsonData.dbMessage);
                        $("#gallery_name").val('');

                    }
                    else{
                        $('#add_gallery_modal').modal('hide');
                        toastr.error(jsonData.dbMessage);
                        $("#gallery_name").val('');
                    }
                }
            });
        }
    function set_profile_pic(id){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json', 
            },
            url:'set_profile_pic',
            type:'post',
            data:{pic_id:id},
            success:function(response){
               
                var jsonData = JSON.parse(JSON.stringify(response));
               
                if(jsonData.dbStatus)
                {
                    toastr.success(jsonData.dbMessage);
                }
                else{
                    toastr.error(jsonData.dbMessage);
                }
            }
        });
    }
    function select_image(gallery_id)
    {     
        $.ajax({
            type:'get',
            url:'load_images',
            data:{gallery_id:gallery_id},
            success:function(response){
                //console.log(response);

                jQuery('#image_body').html(response);  
                //     var jsonData=JSON.parse(JSON.stringify(response));
                //     var no_of_img = jsonData.img_path.length;
                
                
                // const image_body = document.querySelector("#image_body");

                    // if(no_of_img==0)
                    // {
                    //     var p = document.createElement("p");
                    //     p.style.width = "100%";
                    //     p.style.height = "100px";
                    //     p.style.textAlign = "center";
                    //     // p.style.background = "white";
                    //     p.style.color = "black";
                    //     p.style.fontSize = "30px";
                    //     p.innerHTML = "No image found.Please add ";
                        
                    //     image_body.append(p);
                    // }
                    // for(var i=0;i<no_of_img;i++)
                    // {
                    
                    // const img = document.createElement("img");
                    
                    // img.src = jsonData.img_path[i];
                    
                    // img. style. width = '250px';
                    // img.style.height  = '250px';
                    // img.style.padding ="5px";
                    // img.style.margin  ='5';
                    // img.style.margin = "auto";
                    
                    // image_body.append(img);
                    
                    // //console.log(jsonData.img_path[0]);
                    // //$("#img_field").attr('src', jsonData.img_path[i]);
                    
                    // }
                // if(jsonData.success)
                // {
                //     alert(jsonData.msg);
                // } 
            
            }
            
        });
    }
    function remove_pic(id,gallery_id)
    {
        swal({
            title: 'Are you sure to Delete?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            animation: true
        }).then(function() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json', 
                },
                type:'POST',
                url:'remove_pic',
                enctype: 'multipart/form-data',
                data:{pic_id : id},
                success:function(response){
                   console.log(response);
                    var jsonData=JSON.parse(JSON.stringify(response));
                    console.log(jsonData);
                    if(jsonData.dbStatus)
                    {
                        //$('#image_body').load(location.href + ' #image_body');
                        toastr.success(jsonData.dbMessage);
                        select_image(gallery_id);

                    }else{
                        toastr.error(jsonData.dbMessage);
                    }
                
                }
                
            });
        }, function(dismiss) {}).done();
    }
    function select_user_profile(id)
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json', 
            },
            type:'GET',
            url:'upload_gallery',
            enctype: 'multipart/form-data',
            data:{user_id : id},
            // success:function(response){
            //    console.log(response);
            //     var jsonData=JSON.parse(JSON.stringify(response));
            //     console.log(jsonData);
            //     if(jsonData.success)
            //     {
            //         $('#image_body').load(location.href + ' #image_body');
            //         toastr.success(jsonData.dbMessage);
            //     }else{
            //         toastr.error(jsonData.dbMessage);
            //     }
            
            // }
        })
    }
      $(document).ready(function(){

  
        $('#add_gallery').click(function(){ 
          
            $('#add_gallery_modal').modal('show');
        });
        // $('#send_to_slack').click(function(){ 
        //     var checked = document.querySelectorAll(".delete-checkbox:checked");
        //     var arr = [];
        //     checked.forEach((elem) => {
        //         console.log(elem.id);
        //         arr.push(elem.id);
        //     })
        //     $.ajax({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        //             'Accept': 'application/json', 
        //         },
        //         type:'POST',
        //         url:'send_to_slack',
        //         enctype: 'multipart/form-data',
        //         data:{delete_id : arr},
        //         success:function(response){
        //            console.log(response);
        //             var jsonData=JSON.parse(JSON.stringify(response));
        //             console.log(jsonData);
        //             if(jsonData.dbStatus)
        //             {
        //                 toastr.success(jsonData.dbMessage);
        //             }else{
        //                 toastr.error(jsonData.dbMessage);
        //             }
                
        //         }
                
        //     });
        // });
        $('#remove_pic').click(function(){ 
            var checked = document.querySelectorAll(".delete-checkbox:checked");
            var arr = [];
            checked.forEach((elem) => {
                console.log(elem.id);
                arr.push(elem.id);
            })
            swal({
                title: 'Are you sure to Delete?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                animation: true
            }).then(function() {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json', 
                    },
                    type:'POST',
                    url:'delete_photos',
                    enctype: 'multipart/form-data',
                    data:{delete_id : arr},
                    success:function(response){
                       console.log(response);
                        var jsonData=JSON.parse(JSON.stringify(response));
                        console.log(jsonData);
                        if(jsonData.dbStatus)
                        {
                            toastr.success(jsonData.dbMessage);
                            select_image(gallery_id);
                        }else{
                            toastr.error(jsonData.dbMessage);
                        }
                    
                    }
                    
                });
            }, function(dismiss) {}).done();
        });
        $('#send_to_wp').click(function(){ 
            var checked = document.querySelectorAll(".delete-checkbox:checked");
            var arr = [];
            checked.forEach((elem) => {
                console.log(elem.id);
                arr.push(elem.id);
            })
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json', 
                },
                type:'GET',
                url:'send_to_wp',
                data:{pic_id : arr},
            })
            
        });
    
      })  
      function edit_user()
      {
        $('#exampleModalCenter').modal('show');
      }   
      function edit_user_details(id) {
  
        var name = $('#user_name').val();
        var email = $('#mail_id').val();
        var phn_no = $('#mob').val();
        var address = $('#addres').val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "edit_user_details",
            type: "post",
            data: {id:id ,name:name ,email:email ,phn_no:phn_no ,address:address},
            success: function (response) {
                var jsonData = JSON.parse(JSON.stringify(response));
                if(jsonData.dbStatus)
                {
                    $('#exampleModalCenter').modal('hide');
                    toastr.success(jsonData.dbMessage);
                    window.location.reload();
                }else{
                    toastr.error(jsonData.dbMessage);
                }
            },
        });
    }


