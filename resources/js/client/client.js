import '../bootstrap'
import { createApp } from 'vue'
import axios from 'axios'
import PortfolioApp from './PortfolioApp.vue'

const root = document.getElementById('portfolio-app')
const appName = root?.dataset.appName ?? 'Portfolio'

const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
if (token) {
  axios.defaults.headers.common['X-CSRF-TOKEN'] = token
}

if (root) {
  createApp(PortfolioApp, { appName }).mount(root)
}
