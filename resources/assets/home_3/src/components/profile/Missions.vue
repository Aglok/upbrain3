<template>
    <div>
        <v-tabs v-model="subject.tabs" color="white" background-color="transparent" centered class="d-flex justify-center">
            <span class="font-weight-light mx-3" style="align-self: center">Предметы:</span>
            <v-tab class="mr-3" v-for="(value, key, index) in this.$store.state.app.user.subjects" :key="index">
                {{$dataUser.dataSetSubjects[key].name}}
            </v-tab>
        </v-tabs>
        <v-tabs-items v-model="subject.tabs">
            <v-tab-item v-for="(value, subject, index) in this.$store.state.app.user.subjects" :key="index">
                <v-expansion-panels>
                    <v-expansion-panel v-for="(mission, index) in missions(subject)" :key="index">
                        <v-expansion-panel-header>
                            {{mission.name}}
                            <template v-slot:actions>
                                <v-icon v-if="mission.done ==='y'" class="icon icon-check"></v-icon>
                                <v-icon v-else class="icon icon-quest"></v-icon>
                                <v-icon color="primary">$vuetify.icons.expand</v-icon>
                            </template>
                        </v-expansion-panel-header>
                        <v-expansion-panel-content>
                            <v-card>
                                <v-card-text class="common px-2" v-if="mission.description">{{mission.description}}</v-card-text>
                                <div class="v-card__text">
                                    <div class="x-info">
                                        <div class="header">
                                            <div class="image"><img :src="progress(mission, subject).image" :alt="progress(mission, subject).name"></div>
                                            <div class="description">{{progress(mission, subject).description}}</div>
                                        </div>
                                        <div class="header" v-if="artifacts(mission.id, subject).length" v-for="(value, key) in artifacts(mission.id, subject)">
                                            <v-tooltip right>
                                                <template v-slot:activator="{ on }">
                                                    <button v-on="on" class="image">
                                                        <img :src="artifacts(mission.id, subject)[key].image" :alt="artifacts(mission.id, subject)[key].name">
                                                    </button>
                                                </template>
                                                <span v-html="getArtifactHtml(artifacts(mission.id, subject)[key])"></span>
                                            </v-tooltip>
                                            <div class="description">{{artifacts(mission.id, subject)[key].description}}</div>
                                        </div>
                                        <div class="details"><div class="stuff-box">{{progress(mission, subject).name}}</div>
                                        <div class="stuff-box">{{progress(mission, subject).rank}}</div>
                                    </div>
                                    </div>
                                </div>
                                <!--<v-card-text v-html="getProgressHtml(mission, subject)"></v-card-text>-->
                                <router-link :to="{ name: 'Battle', params: {subject: subject, mission_id: mission.id}}" class="text-md-center text-xs-center btn-tool black--text">
                                    К задачам
                                </router-link>
                            </v-card>
                    </v-expansion-panel-content>
                    </v-expansion-panel>
                    <div v-if="!missions(subject)">
                        <div class="yellow--text">Пока нет доступных миссий</div>
                    </div>
                </v-expansion-panels>
            </v-tab-item>
        </v-tabs-items>
    </div>
</template>

<script>
    import {mapMutations, mapState} from 'vuex'
    export default {
        name: "TableTasks",
        data: () => ({
            progresses: [],
            user_missions: [],
            dataSetSubjects:{},
            subject:{
                tabs: 0,
                list: {},//Объект необходим для хранения свойств вкладок таба, активный/неактивный таб
            },
        }),

        methods:{
            ...mapState('app', ['user']),
            missions(subject){
                if(this.$store.state.app.user.subjects[subject].user_missions.length){
                    return this.$store.state.app.user.subjects[subject].user_missions;
                }
            },
            progress(mission, subject){
              return this.$store.state.app.user.progresses.find(p => p.id === mission.id);
            },
            getArtifactHtml(artifact){
              return artifact.info;
            },
            artifacts(mission_id, subject){
              const missions_artifacts = this.$store.state.app.user.subjects[subject].missions_artifacts;

              return missions_artifacts.find(mission_artifacts => mission_artifacts.find(artifact => artifact.mission_id === mission_id));
            },
            mounted() {
                //Динамически генерируется list для subject.tabs предметов
                this.subject.list = this.$dataUser.generateTabList(this.user);
                this.dataSetSubjects = this.$dataUser.dataSetSubjects;
            }
        }
    }
</script>

<style scoped>

</style>