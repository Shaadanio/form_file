<form enctype="multipart/form-data" class="uploadform"  method="post">

    <div class="form_input">

        <label class="f_name">
            <input type="text" name="name" placeholder="Name" required="required">
        </label>
        <label class="f_mail">
            <input type="email" name="mail" placeholder="Email" required="required">
        </label>


        <label class="f_textarea">
            <textarea name="text" id="" rows="5" placeholder="Message"></textarea>
        </label>
              

        <div class="form_file">
            <input type="file" name="images" id="imageUpload" multiple style="display: none;"/>

            <input type="hidden" name="file" value="">

            <label for="imageUpload" style="">
                <img src="/wp-content/themes/gb/img/attach_gray.svg" alt="attach">
                <span class="attach">attach file</span> 
                            
            </label>
            <div id="response"></div>
                <ul class="image-list">
            </ul>  
        
        </div>       

        <button type="submit">Send</button>

    </div>
                       

    <input type="hidden" name="action" value="send_form_block">
    <?php wp_nonce_field('_send_form_wpnonce', '_send_form_wpnonce'); ?>

</form>