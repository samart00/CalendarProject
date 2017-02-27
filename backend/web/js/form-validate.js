// Wait for the DOM to be ready
$(function() {

  $.validator.addMethod(
      "formatDate",
      function(value, element) {
          // put your own logic here, this is just a (crappy) example
          return value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/);
      },
      "กรุณากรอกวันที่ในรูปแบบ dd/mm/yyyy."
  );

  $.validator.addMethod(
      "formatTime",
      function(value, element) {
          // put your own logic here, this is just a (crappy) example
          return value.match(/^(([0-1]?[0-9])|([2][0-3])):([0-5]?[0-9])(:([0-5]?[0-9]))?$/);
      },
      "กรุณากรอกเวลาในรูปแบบ hh:mm"
  );
  // Initialize form validation on the registration form.
  // It has the name attribute "registration"
  $("#event_name").change(function(){
      var value=($(this).val()).trim();
      $(this).val(value);
  });
  $("#comment").change(function(){
      var value=($(this).val()).trim();
      $(this).val(value);
  });
  
  
  $("form[id='validate']").validate({
    // Specify validation rules
    rules: {
      // The key name on the left side is the name attribute
      // of an input field. Validation rules are defined
      // on the right side
      eventName: {
        required : true,
      },
      startDate: {
        required : true,
//        formatDate : true,
//        formatTime: true,
      },
      endDate: {
        required : true,
//        formatDate : true,
//        formatTime: true,
      },
//      email: {
//        required: true,
        // Specify that email should be validated
        // by the built-in "email" rule
//        email: true
//      },
    },
    // Specify validation error messages
    messages: {
    	eventName: "กรุณากรอกชื่อกิจกรรม",
        startdate: {
          required : "กรุณากรอกวันที่",
          formatDate : jQuery.validator.format("กรุณากรอกวันที่ในรูปแบบ dd/mm/yyyy"),
        },
        startDate: {
          required : "กรุณากรอกวันที่เริ่ม",
          formatDate : jQuery.validator.format("กรุณากรอกวันที่ในรูปแบบ dd/mm/yyyy"),
          formatTime : jQuery.validator.format("กรุณากรอกเวลาในรูปแบบ hh:mm"),
        },
        endDate:  {
          required : "กรุณากรอกวันที่สิ้นสุด",
          formatDate : jQuery.validator.format("กรุณากรอกวันที่ในรูปแบบ dd/mm/yyyy"),
          formatTime : jQuery.validator.format("กรุณากรอกเวลาในรูปแบบ hh:mm"),
        },
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      form.submit();
    }
  });
});