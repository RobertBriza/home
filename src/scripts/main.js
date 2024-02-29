import "/src/styles/main.css"
import {Application, Controller} from '@hotwired/stimulus'
import "@hotwired/turbo"
import naja from "naja"


naja.uiHandler.selector = ':not(.noajax)'
naja.initialize()

naja.addEventListener('error', (event) => {
  const error = event.detail.error

  if (typeof error.status === 'undefined') {
    console.log(`Error: ${error}`)
    return
  }

  console.log(`Error ${error.response.status}: ${error.response.statusText} at ${error.response.url}`)
});

naja.snippetHandler.addEventListener('afterUpdate', (event) => {
  const {snippet} = event.detail

  if (snippet.id === 'snippet--flashes') {
    setTimeout(() => {
      snippet.innerHTML = ''
    }, 3000)
  }
});

const LibStimulus = new Application(document.documentElement)

LibStimulus.start()

LibStimulus.register('body', class extends Controller {
  connect() {

  }
})

