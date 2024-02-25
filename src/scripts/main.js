import "/src/styles/main.css"
import "/src/scripts/nittro/nittro.min.js"
import {Application, Controller} from '@hotwired/stimulus'
import "@hotwired/turbo"


const LibStimulus = new Application(document.documentElement)

LibStimulus.start()

LibStimulus.register('body', class extends Controller {
  connect() {
    console.log('Hello stimulus')
  }
})
