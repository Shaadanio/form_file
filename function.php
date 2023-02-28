<?php

/* форма */
add_action( 'wp_ajax_send_form_block', 'send_form_block' );
add_action( 'wp_ajax_nopriv_send_form_block', 'send_form_block' );

function send_form_block(){

	// Проверяем nonce. Если проверкане прошла, то блокируем отправку
	if ( ! wp_verify_nonce( $_POST['_send_form_wpnonce'], '_send_form_wpnonce' ) ) {
		wp_die( 'Данные отправлены с левого адреса' );
	}

	$att_file = array();
	foreach($_POST['file'] as $file){
		$file = json_decode(stripslashes($file));

		$base = explode(',', $file->base64);
        $data = base64_decode($base[1]);
        $f = finfo_open();
        $mime_type = finfo_buffer($f, $data, FILEINFO_MIME_TYPE);
		$path = $_SERVER['DOCUMENT_ROOT'] . "/wp-content/uploads/temp/$file->name";
		file_put_contents($path, $data);


    
        $file_array = [
            'name'     => basename( $path ),
            'tmp_name' => $path,
            'error'    => 0,
            'size'     => filesize($path),
        ];  

		$att_file[] = $path;

	}

	if($att_file != array()){
        $attachments = $att_file;
    }else{
        $attachments = '';
    };

	
    $to = get_field( 'get_mail', 'option' ); // берём e-mail куда слать из поля
    $subject = 'Заполнение формы на сайте';
    $message = '
    <html>
        <head>
            <title>Заполнение формы на сайте</title>
        </head>
        <body>

            <p>Name - ' . $_POST['name'] . '</p>
            <p>Mail - ' . $_POST['mail'] . '</p>
            <p>Message - ' . $_POST['text'] . '</p>

        </body>
    </html>
    ';

    $headers = array(
        'From: >Заполнение формы на сайте <указать e-mail отправки>', // заменить
        'content-type: text/html',
    );

    if(wp_mail( $to, $subject, $message, $headers, $attachments )){
        echo 'send';

		if($att_file != array()){
			foreach($att_file as $atfile){
				unlink($atfile);
			}
        };

    }
    else {
        echo 'nosend';
    }

    wp_die();
}

