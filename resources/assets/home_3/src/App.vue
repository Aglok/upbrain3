<template>
  <v-app>
    <!--<core-filter />-->

    <core-toolbar />

    <!--<core-drawer />-->
    <core-view :ready="this.$store.state.app.ready"/>
  </v-app>
</template>
<script>
  import {mapMutations, mapState} from 'vuex'
  export default {
    beforeCreate(){
      this.$dataUser.getPostData('/profile/all', (response) => {
        this.setUser(response.data);
        this.setSlots(response.data.slots);
        this.setItems(response.data.items_bag);
        this.setBattles(response.data.battles);
        this.setReady(true);
      }, '');

    },
    methods: {
      //...mapState('app', ['user']),
      ...mapMutations('app', ['setUser', 'setReady', 'setSlots', 'setItems', 'setBattles']),
    }
  }
</script>
<style lang="scss">
//@import './styles/index.scss';

/* Remove in 1.2 */
.v-datatable thead th.column.sortable i {
  vertical-align: unset;
}
</style>
