$(document).ready(function () {
    const progressBar = $('.progress-bar');
    progressBar.css({width: '0%'}).attr('aria-valuenow', 0);
  
    $('.next-step').click(function (event) {
      event.preventDefault();
  
      const currentStep = $(this).closest('fieldset');
      const nextStep = $('#' + $(this).data('step'));
  
      let isValid = true;
      $('input, textarea,select', currentStep).each(function () {
        if (!this.validity.valid) {
          isValid = false;
          $(this).addClass('is-invalid');
        } else {
          $(this).removeClass('is-invalid');
        }
      });
  
      if (isValid) {
        currentStep.fadeOut(400, function () {
          progressBar.css({width: nextStep.data('progress') + '%'}).attr('aria-valuenow', nextStep.data('progress'));
          nextStep.fadeIn();
        });
      }
    });
  
    $('.prev-step').click(function (event) {
      event.preventDefault();
  
      const currentStep = $(this).closest('fieldset');
      const prevStep = $('#' + $(this).data('step'));
  
      currentStep.fadeOut(400, function () {
        progressBar.css({width: prevStep.data('progress') + '%'}).attr('aria-valuenow', prevStep.data('progress'));
        prevStep.fadeIn();
      });
    });
  });
  