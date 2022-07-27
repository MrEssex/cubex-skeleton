import {createInertiaApp} from '@inertiajs/inertia-svelte';

const Pages = {
  'Home': import('./Pages/Home.svelte'),
  'About': import('./Pages/About.svelte')
}

export default createInertiaApp({
  resolve: name => Pages[name],
  setup({el, App, props}) {
    new App({target: el, props})
  }
})
