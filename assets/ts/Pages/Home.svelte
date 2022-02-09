<script lang="ts">
    import Layout from '../Shared/Layout.svelte';

    export let name;
</script>

<Layout title="Home">
  <h1 class="text-4xl">Home</h1>
  <p class="mt-4">Welcome home, { name }</p>
</Layout>

<style lang="scss">
  $color: red;

  h1 {
    color: $color;
  }
</style>
