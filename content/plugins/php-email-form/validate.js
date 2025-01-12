/**
* PHP Email Form Validation - v2.0
* URL: https://bootstrapmade.com/php-email-form/
* Author: BootstrapMade.com
*/
!(function($) {
  "use strict";

  $('form.php-email-form').submit(function(e) {
    e.preventDefault();
    
    var f = $(this).find('.wpcf7-form-control-wrap'),
      ferror = false,
      emailExp = /^[^\s()<>@,;:\/]+@\w[\w\.-]+\.[a-z]{2,}$/i,
      phoneExp = /^(?:\+?(?:\d(?:\(\d{3}\)|-\d{3})-\d{3}-(?:\d{2}-\d{2}|\d{4})|\d{11})|\d{10})$/;
    var allowedFileTypes = ['image/jpeg', 'image/png', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

    f.children('input').each(function() { // run all inputs
     
      var i = $(this); // current input
      var rule = i.attr('data-rule');

      if (rule !== undefined) {
        var ierror = false; // error flag for current input
        var pos = rule.indexOf(':', 0);
        if (pos >= 0) {
          var exp = rule.substr(pos + 1, rule.length);
          rule = rule.substr(0, pos);
        } else {
          rule = rule.substr(pos + 1, rule.length);
        }

        switch (rule) {
          case 'required':
            if (i.val() === '') {
              ferror = ierror = true;
            }
            break;

          case 'minlen':
            if (i.val().length < parseInt(exp)) {
              ferror = ierror = true;
            }
            break;

          case 'email':
            if (!emailExp.test(i.val())) {
              ferror = ierror = true;
            }
            break;
          case 'phone':
              if (!phoneExp.test(i.val())) {
                ferror = ierror = true;
              }
              break;
          case 'checked':
            if (! i.is(':checked')) {
              ferror = ierror = true;
            }
            break;

          case 'regexp':
            exp = new RegExp(exp);
            if (!exp.test(i.val())) {
              ferror = ierror = true;
            }
            break;
        }
        i.parent().parent().next('.validate').html((ierror ? (i.attr('data-msg') !== undefined ? i.attr('data-msg') : 'wrong Input') : '')).show('blind');
      }
    });
    f.children('textarea').each(function() { // run all inputs

      var i = $(this); // current input
      var rule = i.attr('data-rule');

      if (rule !== undefined) {
        var ierror = false; // error flag for current input
        var pos = rule.indexOf(':', 0);
        if (pos >= 0) {
          var exp = rule.substr(pos + 1, rule.length);
          rule = rule.substr(0, pos);
        } else {
          rule = rule.substr(pos + 1, rule.length);
        }

        switch (rule) {
          case 'required':
            if (i.val() === '') {
              ferror = ierror = true;
            }
            break;

          case 'minlen':
            if (i.val().length < parseInt(exp)) {
              ferror = ierror = true;
            }
            break;
        }
        i.parent().parent().next('.validate').html((ierror ? (i.attr('data-msg') != undefined ? i.attr('data-msg') : 'wrong Input') : '')).show('blind');
      }
    });
    f.children('select').each(function() {
      var i = $(this); // current select element
      var rule = i.attr('data-rule');

      if (rule !== undefined && rule === 'required') {
          var ierror = false;
          if (i.val() === '' || i.val() === null || i.val() === 'default') { 
              ferror = ierror = true;
          }

          i.parent().parent().next('.validate').html((ierror ? (i.attr('data-msg') != undefined ? i.attr('data-msg') : 'Please select an option') : '')).show('blind');
      }
    });
    f.children('input[type="file"]').each(function() {
      var i = $(this); // current file input
      var rule = i.attr('data-rule');
      var ierror = false; // error flag for current file input

      if (rule !== undefined && rule === 'required') {
          if (i[0].files.length === 0) { // No file selected
              ferror = ierror = true;
          }
      }
      var file = i[0].files[0];
      if (file && !allowedFileTypes.includes(file.type)) {
          ferror = ierror = true;
        }
      i.parent().parent().next('.validate').html((ierror ? (i.attr('data-msg') !== undefined ? i.attr('data-msg') : 'Invalid file type. Please upload a valid file. Allowed file types are: jpeg, png, pdf, doc, docx.') : '')).show('blind');
    });
    if (ferror) {
      $('#clear-form').prop('disabled', false);
      return false;
    }

    var this_form = $(this);
    var action = $(this).attr('action');

    if(!action) {
      this_form.find('.loading').slideUp();
      this_form.find('.error-message').slideDown().html('The form action property is not set!');
      setTimeout(function() {
        this_form.find('.error-message').slideUp();
      }, 5000);
      return false;
    }
    
    this_form.find('.sent-message').slideUp();
    this_form.find('.error-message').slideUp();
    this_form.find('.loading').slideDown();

    if ( $(this).data('recaptcha-site-key') ) {
      var recaptcha_site_key = $(this).data('recaptcha-site-key');
      grecaptcha.ready(function() {
        grecaptcha.execute(recaptcha_site_key, {action: 'php_email_form_submit'}).then(function(token) {
          php_email_form_submit(this_form,action,new FormData(this) + '&recaptcha-response=' + token);
        });
      });
    } else {
      php_email_form_submit(this_form,action,new FormData(this));
    }
    
    return true;
  });

  function php_email_form_submit(this_form, action, data) {
    $.ajax({
      type: "POST",
      url: action,
      data: data,
      contentType: false,
      processData: false,
      timeout: 40000
    }).done( function(msg){
      if (msg == 'OK') {
        this_form.find('.loading').slideUp();
        this_form.find('.sent-message').slideDown();
        this_form.find("input:not(input[type=submit],input[type=button]), select, textarea").val('');
        setTimeout(function() {
          this_form.find('.sent-message').slideUp();
        }, 5000);
      } else {
        this_form.find('.loading').slideUp();
        if(!msg) {
          msg = 'Form submission failed and no error message returned from: ' + action + '<br>';
        }
        this_form.find('.error-message').slideDown().html(msg);
        setTimeout(function() {
          this_form.find('.error-message').slideUp();
        }, 5000);
      }
    }).fail( function(data){
      console.log(data);
      var error_msg = "Form submission failed!<br>";
      if(data.statusText || data.status) {
        error_msg += 'Status:';
        if(data.statusText) {
          error_msg += ' ' + data.statusText;
        }
        if(data.status) {
          error_msg += ' ' + data.status;
        }
        error_msg += '<br>';
      }
      if(data.responseText) {
        error_msg += data.responseText;
      }
      this_form.find('.loading').slideUp();
      this_form.find('.error-message').slideDown().html(error_msg);
      setTimeout(function() {
        this_form.find('.error-message').slideUp();
      }, 5000);
    });
  }

  $('#clear-form').on('click',function(e){
    $('#clear-form').prop('disabled', true);
    $(this).parent().parent().parent().parent().find('.validate').each(function() {
      $(this).empty();
      $(this).removeAttr("style");
    })
  });
})(jQuery);
