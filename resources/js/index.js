import domtoimage from 'dom-to-image'
import { saveAs } from 'file-saver'

export default function qrPlugin(
  {
    state,
  }
  ) {
  return {
    state,

    // You can define any other Alpine.js properties here.

    init: function() {
      //
    },

    // You can define any other Alpine.js functions here.
  }
};

window.download = function(fileName) {
  var node = document.querySelector('.'+fileName+' svg')
  domtoimage.toBlob(node)
    .then(function(blob) {
      window.saveAs(blob, fileName + '.png')
    })
    .catch(function(error) {
      console.error('oops, something went wrong!', error)
    })
}
