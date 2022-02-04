jQuery(document).ready(function(){
    jQuery('#my_form_id').on('submit', function(e){
        e.preventDefault();
        var person = document.getElementById('person').value;
        var email = document.getElementById('email').value;
        var tel = document.getElementById('tel').value;
        var message = document.getElementById('message').value;
        var agree = document.getElementById('agree').checked;
        var reg = document.getElementById('reg').checked;
        jQuery.ajax({
            type: "POST",
            url: 'inc/mail.php',
            data: {
                person: person,
                email: email,
                tel: tel,
                message: message,
                agree: agree,
                regpot: reg,
            },
            success: function(data){
                dataAA = jQuery.parseJSON(data);
                if (dataAA.errorForm===0) {
                    jQuery('#formanswer').html(dataAA.Answer);

                    jQuery("#person").removeClass("form_error_class");
                    jQuery("#email").removeClass("form_error_class");
                    jQuery("#message").removeClass("form_error_class");
                    jQuery("#agree_cb").removeClass("form_error_class");

                    document.getElementById('my_form_id').reset();

                } else {
                    jQuery('#formanswer').html(dataAA.Answer);
                    if (dataAA.person===0) {
                        console.log(dataAA.person);
                        jQuery("#person").addClass("form_error_class");
                    } else {
                        jQuery("#person").removeClass("form_error_class");
                    }
                    if (dataAA.email===0) {
                        jQuery("#email").addClass("form_error_class");
                    } else {
                        jQuery("#email").removeClass("form_error_class");
                    }
                    if (dataAA.message===0) {
                        console.log(dataAA.person);
                        jQuery("#message").addClass("form_error_class");
                    } else {
                        jQuery("#message").removeClass("form_error_class");
                    }
                    if (dataAA.agree===0) {
                        console.log(dataAA.person);
                        jQuery("#agree_cb").addClass("form_error_class");
                    } else {
                        jQuery("#agree_cb").removeClass("form_error_class");
                    }
                }
            }
        });
        return false;
    });
    jQuery('#reset_btn').on('click', function(e) {
        // e.preventDefault();
        document.getElementById('my_form_id').reset();
        jQuery('#formanswer').html('');
    });
});