<script>
  import {Link} from '@inertiajs/inertia-svelte';

  export let title;
  $: {
    document.title = title;
  }
</script>

<div>
  <nav class="py-6 mb-6 border-b">
    <Link class="mr-4" href="/">Home</Link>
    <Link class="mr-4" href="/about">About</Link>
  </nav>
  
  <slot/>
</div>
