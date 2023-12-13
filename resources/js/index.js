import domtoimage from 'dom-to-image'
import { saveAs } from 'file-saver'

export default function qrPlugin(
  {
    state,
  }
  ) {
  return {
    state,

    init: function() {
      //
    },
  }
};

window.download = function(fileName) {
  var node = document.querySelector('.'+fileName+' svg')
  domtoimage.toBlob(node)
    .then(function(blob) {
      saveAs(blob, fileName + '.png')
    })
    .catch(function(error) {
      console.error('oops, something went wrong!', error)
    })
}
