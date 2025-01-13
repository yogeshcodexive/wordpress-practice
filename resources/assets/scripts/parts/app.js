export class App {
  init() {
    $('section').each(function () {
      var $section = $(this);
      var $spacingTop = $section.prev('.spacing#spacing-top');
      var $spacingBottom = $section.next('.spacing#spacing-bottom');
  
      $section.prepend($spacingTop);
      $section.append($spacingBottom);
  });


  }

}
