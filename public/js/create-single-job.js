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

    var $form, $uriBox, $uriInput, $pdfBox, $pdfInput, $htmlBox, $htmlInput;

    function toggleInputs()
    {
        if ($uriBox.prop('checked')) {
            $uriInput.slideDown();
            $pdfInput.slideUp();
            $pdfInput.find('input').val('');
            $htmlInput.slideUp();
        } else if ($pdfBox.prop('checked')) {
            $uriInput.slideUp();
            $htmlInput.slideUp();
            $pdfInput.slideDown();
        } else {
            $uriInput.slideUp();
            $pdfInput.slideUp();
            $pdfInput.find('input').val('');
            $htmlInput.slideDown();
        }
    }

    $(function() {
        $form = $('#createsinglejob, #description-descriptionForm-details');
        $uriBox = $form.find('#csj-mode-uri-span input');
        $pdfBox = $form.find('#csj-mode-pdf-span input');
        $htmlBox =  $form.find('#csj-mode-html-span input');
        $uriInput = $form.find('.csj-uri-wrapper');
        $pdfInput = $form.find('.csj-pdf-wrapper');
        $htmlInput = $form.find('.csj-html-wrapper');
        toggleInputs();
        $('#csj-mode-uri-span, #csj-mode-pdf-span, #csj-mode-html-span').click(toggleInputs);
        $('#description-descriptionForm-details .cam-description').hide();
    })
})(jQuery); 
 
