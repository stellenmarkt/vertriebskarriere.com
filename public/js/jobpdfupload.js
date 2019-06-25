/**
 * YAWIK
 *
 * License: MIT
 * (c) 2013 - 2018 CROSS Solution <http://cross-solution.de>
 */

/**
 *
 * Author: Mathias Gelhausen <gelhausen@cross-solution.de>
 */
;(function ($) {

    $(function() {
       $('form.file-upload').each(function() {
           var $form = $(this);
           $form.find('input[type="file"]').each(function() {
               var $input = $(this);
               $input.fileupload({
                   dropZone: $input,
                   maxNumberOfFiles: 1,
                   url: basePath + "?ajax=jobdetailsupload",
                   add: function (e, data) {

                       var $context = $('#' + $input.attr('id') + '-span');
                       $context.find('.file-working, .file-info, .errors *').remove();
                       data.context = $('<div class="file-working">Bitte warten...</div><div class="file-info"></div>');
                       data.context.appendTo($context);
                       $('#' + $input.attr('id')).hide();
                       data.submit();

                       //data.submit();
                       // $form.one('yk:forms:start.file-upload', function(event) {
                       //     event.preventSubmit = true;
                       //     data.submit().success(function(result) {
                       //         $form.form('clearErrors', $form);
                       //         if ('valid' in result && !result.valid) {
                       //             $form.form('displayErrors', $form, result.errors);
                       //         } else {
                       //             $form.trigger('yk.forms.done', {data: result}); // DEPRECATED EVENT USE NEXT
                       //             $form.trigger('done.yk.core.forms', {data: result}); //DEPRECATED EVENT USE NEXT
                       //             $form.trigger('yk:forms:success', {data: result});
                       //             $form.trigger('ajax.ready', {'data': result});
                       //         }
                       //         $form.find('[type="submit"]').attr('disabled', false);
                       //     });
                       // });
                   },
                   progress: function(e, data)
                   {
                       var progress = parseInt(data.loaded / data.total * 100, 10);
                       $('#' + $input.attr('id') + '-span .file-working').text(progress + '% ...');
                   },
                   done: function (e, data)
                   {
                        var $context = $('#' + $input.attr('id') + '-span');
                        if (data.result.valid) {
                            $context.find('.file-working').hide();
                            $context.find('.file-info').html(data.result.content);
                            $context.find('.file-delete').on('click', function(e) {
                                $.get($(e.currentTarget).attr('href')).always(function() {
                                    $context.find('.file-working, .file-info, .errors *').remove();
                                    $('#' + $input.attr('id')).show();
                                });
                                return false;
                            });

                        } else {
                            $context.find('.file-working').hide();
                            $form.form('displayErrors', $form, data.result.errors);
                        }
                   },
                   fail: function (e, data)
                   {
                       var $context = $('#' + $input.attr('id') + '-span');
                       $context.find('.file-working').hide();
                       $context.find('.file-info').html('<p class="text-warning">Fehler beim Upload.</p>');
                   }
               });
               $input.parent().find('.file-info .file-delete').one('click', function(e) {
                  $.get($(e.currentTarget).attr('href')).always(function() {
                      $input.parent().find('.file-info').remove();
                      $('#' + $input.attr('id')).show();
                  });
                  return false;
               });
           });
       });

        $('#description-descriptionForm-details').on('yk:forms:success.jobpdfupload', function(e) {
            var iframeUrl;
            if ($(e.currentTarget).find('#csj-mode-uri').prop('checked')) {
                iframeUrl = $('#details-uri').val();
            } else if ($(e.currentTarget).find('#csj-mode-pdf').prop('checked')) {
                iframeUrl = $(e.currentTarget).find('input[name="pdf_uri"]').val();
            } else {
                iframeUrl = basePath + '/' + lang + '/job/view?id=' + $(e.currentTarget).find('input[name="job"]').val()
                + '&snapshot=' + $(e.currentTarget).find('input[name="snapshot"]').val();
            }

            $('#previewJob').attr('src', iframeUrl);
        }).find('#details-description-span, #details-logo-span').parent().hide()



    });

})(jQuery); 
 
