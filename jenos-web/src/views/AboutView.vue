<template>
  <div class="about">
    <h1>This is an about page {{ title }}</h1>
  </div>
</template>

<script setup>
const title = "Hello bonjour"
</script>
<style>
@media (min-width: 1024px) {
  .about {
    min-height: 100vh;
    display: flex;
    align-items: center;
  }
}
</style>
