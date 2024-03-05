import domtoimage from 'dom-to-image'
import { saveAs } from 'file-saver'

export default function qrPlugin(
  {
    state,
  },
) {
  return {
    state,

    init: function() {
      //
    },

    download: function(fileName, downType) {
      var node = this.$refs.qr

      if (downType === 'svg') {
        domtoimage.toSvg(node)
          .then(function(blob) {
            saveAs(blob, fileName + '.svg')
          })
          .catch(function(error) {
            console.error('oops, something went wrong!', error)
          })
      } else {
        domtoimage.toPng(node)
          .then(function(blob) {
            saveAs(blob, fileName + '.png')
          })
          .catch(function(error) {
            console.error('oops, something went wrong!', error)
          })
      }
    }
  }
};
