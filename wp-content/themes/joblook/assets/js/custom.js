(function($) {

  $("#hamburger-menu").click(function(event) {
    event.stopPropagation();
    $(".header-navigation").addClass("open");

  });

    $(".close-menu").click(function(event) {
    event.stopPropagation();
    $(".header-navigation").removeClass("open");

  });

  $("#hamburger-menu").keypress(function(e) {
    var key = e.which;
    if (key == 13) // the enter key code
    {
      $(".header-navigation").addClass("open");
    }
  });

  $(".close-menu").keypress(function(e) {
    var key = e.which;
    if (key == 13) // the enter key code
    {
      $(".header-navigation").removeClass("open");
    }
  });


$('#job-category').chosen().change( function(obj, result) {
});


})(jQuery);

if (jQuery(window).width() < 991){
  const  joblook_focusableElements =
  'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])';
const joblook_modal = document.querySelector('nav#site-navigation'); 

const joblook_firstFocusableElement = joblook_modal.querySelectorAll(joblook_focusableElements)[0]; 
const joblook_focusableContent = joblook_modal.querySelectorAll(joblook_focusableElements);
const joblook_lastFocusableElement = joblook_focusableContent[joblook_focusableContent.length - 1];


document.addEventListener('keydown', function(e) {
let isTabPressed = e.key === 'Tab' || e.keyCode === 9;

if (!isTabPressed) {
  return;
}

if (e.shiftKey) { // if shift key pressed for shift + tab combination
  if (document.activeElement === joblook_firstFocusableElement) {
    joblook_lastFocusableElement.focus(); // add focus for the last focusable element
    e.preventDefault();
  }
} else { // if tab key is pressed
  if (document.activeElement === joblook_lastFocusableElement) { // if focused has reached to last focusable element then focus first focusable element after pressing tab
    joblook_firstFocusableElement.focus(); // add focus for the first focusable element
    e.preventDefault();
  }
}
});

joblook_firstFocusableElement.focus();}