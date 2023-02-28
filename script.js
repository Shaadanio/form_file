jQuery(document).ready(function() {

    function readURL(input) {
        for(let i = 0; i < input.files.length; i++ ){
            let file = input.files[i];
            let reader = new FileReader();
            reader.readAsDataURL(file);

            console.log(file.type);
            reader.onload = function() {
                json = {
                    name: file.name,
                    base64: reader.result,
                };
                let type;
                if(file.type == 'image/svg+xml'){
                    type = 'img';
                }else if(file.type == 'image/png'){
                    type = 'img';
                }else if(file.type == 'image/jpeg'){
                    type = 'img';
                }else if(file.type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || file.type == 'application/msword'){
                    type = 'word';
                }else if(file.type == 'application/vnd.ms-excel' || file.type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'){
                    type = 'excel';
                }else if(file.type == 'application/pdf'){
                    type = 'pdf';
                }else if(file.type == 'application/x-zip-compressed'){
                    type = 'zip';
                }else{
                    type = 'all';
                };
                $( ".image-list" ).append( `<li class="load_file load_file_${i}"><input type="hidden" name="file[${i}]" value='${JSON.stringify(json)}'><img src="/wp-content/themes/gb/img/form/${type}.svg"> ${file.name.substr(-20, 10)}... <span class="drop_file drop_${i}"> <span>х</span> </span></li>` );
            };
        }
    }

    $("#imageUpload").change(function() {
        readURL(this);
    });

    $(document).on('click', '.drop_file', function () {
        $(this).parent('.load_file').remove();
    });

    $('.uploadform').submit(function(e){

        e.preventDefault();
        $('.forb_block').addClass('active');
        $('.preloader').addClass('active');
        let ajaxurl = send_object.url;
        $.ajax({
            url: ajaxurl,
            type: "POST",
            data: $($(this)).serialize(),
            success: function(response) {
                if(response == 'send'){

                    function popuMy() {
                        location.reload();
                    }
                   // setTimeout(popuMy, 2000);

                }
            },
            error: function(response) {
            $('#result_col_form').html('<div class="ColOff">Ошибка. Данные не отправлены.</div>');
        }
        });
    });

    $(document).on('click', '.drop_mmod_c', function () {
        $('.forb_block_mod').removeClass('active');
        $('.forb_block').removeClass('active');
        $('.form_input input').val('');
        $('.form_input textarea').val('');
        $('.load_file').remove();
    });


});

