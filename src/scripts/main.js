import "/src/styles/main.css"
import {Application, Controller} from '@hotwired/stimulus'
import "@hotwired/turbo"
import naja from "naja"


naja.uiHandler.selector = ':not(.noajax)'
naja.initialize()

const LibStimulus = new Application(document.documentElement)

LibStimulus.start()

LibStimulus.register('body', class extends Controller {
  connect() {
    console.log('Hello stimulus')
  }
})
