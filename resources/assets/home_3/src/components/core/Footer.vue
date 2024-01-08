<template>
  <footer id="core-footer">
    <div class="footer-items">
      <span class="game-tool" v-for="link in links" :key="link.title">
        <v-tooltip top dark open-delay="150" transition="ease">
          <template v-slot:activator="{ on }">
            <v-btn :class="link.class" @click.stop="link.dialog = true" class="btn v-btn--icon tertiary--text footer-links" v-on="on"></v-btn>
          </template>
          <span>{{link.title}}</span>
        </v-tooltip>
        <v-dialog v-if="link.class === 'profile'" v-model="link.dialog" style="display: none">
          <div style="position: relative" :class="link.class">
            <profile-window>
              <template v-slot:board-mm>
                <div class="board x-title">{{link.title}}</div>
                <div class="board x-tool" @click="link.dialog=false"></div>
              </template>
              <template v-slot:x-info>
                <profile-inventory></profile-inventory>
              </template>
              <template v-slot:x-toolbar></template>
            </profile-window>
          </div>
        </v-dialog>
        <v-dialog v-if="link.class === 'missions'" v-model="link.dialog" style="display: none">
          <div style="position: relative" :class="link.class">
            <profile-window>
              <template v-slot:board-mm>
                <div class="board x-title">{{link.title}}</div>
                <div class="board x-tool" @click="link.dialog=false"></div>
              </template>
              <template v-slot:x-info>
                <profile-missions></profile-missions>
              </template>
              <template v-slot:x-toolbar></template>
            </profile-window>
          </div>
        </v-dialog>
        <v-dialog v-if="link.class === 'items'" v-model="link.dialog" style="display: none">
          <div style="position: relative" :class="link.class">
            <profile-window>
              <template v-slot:board-mm>
                <div class="board x-title">{{link.title}}</div>
                <div class="board x-tool" @click="link.dialog=false"></div>
              </template>
              <template v-slot:x-info>
                <profile-items></profile-items>
              </template>
              <template v-slot:x-toolbar></template>
            </profile-window>
          </div>
        </v-dialog>
        <v-dialog v-if="link.class === 'progresses'" v-model="link.dialog" style="display: none">
          <div style="position: relative" :class="link.class">
            <profile-window>
              <template v-slot:board-mm>
                <div class="board x-title">{{link.title}}</div>
                <div class="board x-tool" @click="link.dialog=false"></div>
              </template>
              <template v-slot:x-info>
                <profile-progresses></profile-progresses>
              </template>
              <template v-slot:x-toolbar></template>
            </profile-window>
          </div>
        </v-dialog>
      </span>
    </div>
    <v-spacer/>
    <span class="font-weight-light copyright">
      &copy;
      {{ (new Date()).getFullYear() }}
      Designed by <a href="http://upbrain.ru" target="_blank">Upbrain.ru</a>.
    </span>
  </footer>
</template>

<script>
export default {
  data: () => ({
    links: [
      { title: 'Профиль', dialog: false, class: 'profile', link: 'test#/profile'},
      { title: 'Задачи', dialog: false, class: 'missions', link: '#'},
      { title: 'Предметы', dialog: false, class: 'items', link: '#'},
      { title: 'Достижения',dialog: false, class: 'progresses', link: '#'},
    ]
  })
}
</script>

<style>

#core-footer{
  position: absolute;
  right: 1%;
  bottom: 0;
  z-index: 2;
}
#core-footer .btn{
  transform: scale(1.1) translateY(-5px) translateX(-6px);
  filter: drop-shadow(2px 2px 4px black);
  outline: none;
  width: 80px;
  height: 80px;
  position: relative;
  -webkit-transition: 0.5s ease;
  transition: 0.5s ease;
  -webkit-box-shadow: 2px 2px 4px #eeeeee00;
  border: 0;
  border-radius: 12px;
}
#core-footer .v-btn:before {
  transition: none;
}

#core-footer .btn.profile{
  background: url(/images/bg/profile/toolbar/rabbit_t.png) 50% 50% no-repeat;
  background-size: 127%;
}
#core-footer .btn.missions{
  background: url(/images/bg/profile/toolbar/book_t.png) 50% 50% no-repeat;
  background-size: 100%;
}
#core-footer .btn.items{
  background: url(/images/bg/profile/toolbar/helmet_t.png) 50% 50% no-repeat;
  background-size: 88%;
}
#core-footer .btn.progresses{
  background: url(/images/bg/profile/toolbar/cup_t.png) 50% 50% no-repeat;
  background-size: 100%;
}
@media only screen and (max-height: 650px) {
  #core-footer .game-tool:not(:first-child) {
    margin-left: 0;
  }
}
@media only screen and (max-height: 650px) {
  #core-footer .game-tool{
    -webkit-transform: scale(0.67);
    -ms-transform: scale(0.67);
    transform: scale(0.67);
    margin-left: 0;

  }
}

#core-footer .game-tool:not(:first-child) {
  margin-left: 30px;
}

@media screen and (max-width: 768px) {
  #core-footer .btn{
    transform: scale(0.8);
  }
  #core-footer .game-tool:not(:first-child){
    margin-left: 0;
  }
}

@media screen and (max-width: 576px) {
  #core-footer .btn{
    transform: scale(0.5);
  }
}
@media screen and (max-width: 320px) {
  #core-footer .btn{
    transform: scale(0.5);
    width: 60px;
    height: 60px;
  }
}
</style>
