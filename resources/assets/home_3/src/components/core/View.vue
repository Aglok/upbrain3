<template>
  <div v-if="!ready" class="progress-bar">
    <v-progress-circular :size="70" :width="7" color="yellow" indeterminate></v-progress-circular>
  </div>
  <v-content v-else>
    <div id="core-view" >
      <v-fade-transition mode="out-in">
        <router-view />
      </v-fade-transition>
    </div>
    <core-footer v-if="$route.name !== 'Maps'" />
  </v-content>
</template>

<script>
export default {
  props: ['ready'],
  metaInfo () {
    return {
      title: 'Личный кабинет'
    }
  }
}
</script>

<style>
#core-view {
  padding-bottom: 100px;
}
</style>
