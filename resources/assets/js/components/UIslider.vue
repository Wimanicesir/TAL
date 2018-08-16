<template>
    <div class="slidercontainer">
        <h2>PRICE</h2>
        <div id="slider"></div>
        <div id="slider-snap-value-lower"></div>
        <div id="slider-snap-value-upper"></div>
    </div>
</template>
<script>
  import $ from 'jquery';

  export default {
    mounted() {
      var noUiSlider = window.NoUISlider;
      var slider = document.getElementById('slider');

      noUiSlider.create(slider, {
        start: [0, 100],
        connect: true,
        range: {
          'min': 0,
          'max': 100
        }
      });
      var snapValues = [
        document.getElementById('slider-snap-value-lower'),
        document.getElementById('slider-snap-value-upper')
      ];

      slider.noUiSlider.on('update', function (values, handle) {
        snapValues[handle].innerHTML = '€' + values[handle];
      });

    }
  }
</script>