
// multiple handled with value 
var pmdSliderValueRange = document.getElementById('pmd-slider-value-range');

noUiSlider.create(pmdSliderValueRange, {
  start: [ 0, 5000 ], // Handle start position
  connect: true, // Display a colored bar between the handles
  range: { // Slider can select '0' to '100'
    'min': 0,
    'max': 5000
  },
  format: wNumb({
    decimals: 0}),
   step: 10
});

var valueMax = document.getElementById('value-max'),
  valueMin = document.getElementById('value-min');

var pmdSliderValueRange2 = document.getElementById('pmd-slider-value-range2');

  noUiSlider.create(pmdSliderValueRange2, {
    start: 0, // Handle start position
    connect: 'upper', // Display a colored bar between the handles
    range: { // Slider can select '0' to '100'
      'min': 0,
      'max': 5
    },
    format: wNumb({
      decimals: 0}),
     step: 1
  });

  var rangeSliderValueElement = document.getElementById('slider-range-value');

  pmdSliderValueRange2.noUiSlider.on('update', function (values, handle) {
      rangeSliderValueElement.innerHTML = values[handle];
  });

// When the slider value changes, update the input and span
pmdSliderValueRange.noUiSlider.on('update', function( values, handle ) {
  if ( handle ) {
    valueMax.innerHTML = values[handle];
  } else {
    valueMin.innerHTML = values[handle];
  }
});


function change_image(image){

  var container = document.getElementById("main-image");

 container.src = image.src;
}



document.addEventListener("DOMContentLoaded", function(event) {







});
