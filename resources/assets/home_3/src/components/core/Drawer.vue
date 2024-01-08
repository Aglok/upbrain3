<template>
  <v-navigation-drawer
    id="app-drawer"
    v-model="inputValue"
    app
    dark
    floating
    persistent
    mobile-break-point="991"
    width="260"
  >
    <v-img :src="image" height="100%">
      <v-layout class="fill-height" tag="v-list" column>
        <v-list-item avatar>
          <v-list-item-avatar color="white">
            <v-img :src="logo" height="34" contain/>
          </v-list-item-avatar>
          <v-list-item-title class="title">Upbrain</v-list-item-title>
        </v-list-item>
        <v-divider/>
        <v-list-item v-if="responsive">
          <v-text-field
            class="purple-input search-input"
            label="Search..."
            color="purple"
          />
        </v-list-item>
        <v-list-item
          v-for="(link, i) in links"
          :key="i"
          :to=link.to
          :active-class="color"
          avatar
          class="v-list-item"
        >
          <v-list-item-action>
            <v-icon>{{ link.icon }}</v-icon>
          </v-list-item-action>
          <v-list-item-title v-text="link.text"/></v-list-item>
        <!--<v-list-item-->
          <!--disabled-->
          <!--active-class="primary"-->
          <!--class="v-list-item v-list-item&#45;&#45;buy"-->
          <!--to="/upgrade"-->
        <!--&gt;-->
          <!--<v-list-item-action>-->
            <!--<v-icon>mdi-package-up</v-icon>-->
          <!--</v-list-item-action>-->
          <!--<v-list-item-title class="font-weight-light">-->
            <!--Upgrade To PRO-->
          <!--</v-list-item-title>-->
        <!--</v-list-item>-->
      </v-layout>
    </v-img>
  </v-navigation-drawer>
</template>

<script>
// Utilities
import {
  mapMutations,
  mapState
} from 'vuex'

export default {
  data: () => ({
    logo: 'images/bg/header/header_logo_fixed.png',
    links: [
      // {
      //   to: '/dashboard',
      //   icon: 'mdi-view-dashboard',
      //   text: 'Dashboard'
      // },
        {
            to: '/table_exam',
            icon: 'mdi-clipboard-outline',
            text: 'Результаты'
        },
        {
            to: '/profile-test',
            icon: 'mdi-account',
            text: 'Ваш профиль'
        },
      {
        to: '/profile',
        icon: 'mdi-account',
        text: 'Ваш профиль'
      },
      // {
      //   to: '/typography',
      //   icon: 'mdi-format-font',
      //   text: 'Typography'
      // },
      // {
      //   to: '/icons',
      //   icon: 'mdi-chart-bubble',
      //   text: 'Icons'
      // },
      // {
      //   to: '/maps',
      //   icon: 'mdi-map-marker',
      //   text: 'Maps'
      // },
      // {
      //   to: '/notifications',
      //   icon: 'mdi-bell',
      //   text: 'Notifications'
      // }
    ],
    responsive: false
  }),
  computed: {
    ...mapState('app', ['image', 'color']),
    inputValue: {
      get () {
        return this.$store.state.app.drawer
      },
      set (val) {
        this.setDrawer(val)
      }
    },
    items () {
      return this.$t('Layout.View.items')
    }
  },
  mounted () {
    this.onResponsiveInverted()
    window.addEventListener('resize', this.onResponsiveInverted)
  },
  beforeDestroy () {
    window.removeEventListener('resize', this.onResponsiveInverted)
  },
  methods: {
    ...mapMutations('app', ['setDrawer', 'toggleDrawer']),
    onResponsiveInverted () {
      if (window.innerWidth < 991) {
        this.responsive = true
      } else {
        this.responsive = false
      }
    }
  }
}
</script>

<style lang="scss">
  #app-drawer {
    .v-list-item {
      border-radius: 4px;

      &--buy {
        margin-top: auto;
        margin-bottom: 17px;
      }
    }

    .v-image__image--contain {
      top: 9px;
      height: 60%;
    }

    .search-input {
      margin-bottom: 30px !important;
      padding-left: 15px;
      padding-right: 15px;
    }
  }
</style>
