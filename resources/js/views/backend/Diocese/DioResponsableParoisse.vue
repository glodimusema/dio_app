<template>
  <v-layout>
    <v-flex md2></v-flex>
    <v-flex md8>
      <v-flex md12>
        <!-- modal -->
        <v-dialog v-model="dialog" max-width="400px" scrollable transition="dialog-bottom-transition">
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                {{ titleComponent }} <v-spacer></v-spacer>
                <v-tooltip bottom color="black">
                  <template v-slot:activator="{ on, attrs }">
                    <span v-bind="attrs" v-on="on">
                      <v-btn @click="dialog = false" text fab depressed>
                        <v-icon>close</v-icon>
                      </v-btn>
                    </span>
                  </template>
                  <span>Fermer</span>
                </v-tooltip></v-card-title>
              <v-card-text>                
                                                  
                  <v-autocomplete label="Selectionnez la Paroisse" prepend-inner-icon="mdi-map" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="ParoisseList" item-text="nom_paroisse" item-value="id"
                      outlined v-model="svData.refParoisse">
                  </v-autocomplete>

                  <v-autocomplete label="Selectionnez le Pretre" prepend-inner-icon="mdi-map"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="AgentList" item-text="noms_agent"
                      item-value="id" dense outlined v-model="svData.serveur_id" chips clearable>
                  </v-autocomplete>

                  <v-text-field label="Autres Détails" prepend-inner-icon="extension" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.autres_details_respo"></v-text-field>

                  <v-text-field type="date" label="Date Début" prepend-inner-icon="extension" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_debut_responsable"></v-text-field>

                  <v-text-field type="number" label="Durée de l  Responsabilité" prepend-inner-icon="extension" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dure_reponsable"></v-text-field>
                  
                  <v-select label="Activé(e)" :items="[
                    { designation: 'OUI' },
                    { designation: 'NON' }
                  ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                    item-text="designation" item-value="designation" v-model="svData.active">
                  </v-select>

              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
                <v-btn color="  blue" dark :loading="loading" @click="validate">
                  {{ edit ? "Modifier" : "Ajouter" }}
                </v-btn>
              </v-card-actions>
            </v-form>
          </v-card>
        </v-dialog>
        <br /><br />
        <!-- fin modal -->

        <!-- bande -->
        <v-layout>
          <v-flex md1>
            <v-tooltip bottom>
              <template v-slot:activator="{ on, attrs }">
                <span v-bind="attrs" v-on="on">
                  <v-btn :loading="loading" fab @click="onPageChange">
                    <v-icon>autorenew</v-icon>
                  </v-btn>
                </span>
              </template>
              <span>Initialiser</span>
            </v-tooltip>
          </v-flex>
          <v-flex md6>
            <v-text-field append-icon="search" label="Recherche..." single-line solo outlined rounded hide-details
              v-model="query" @keyup="onPageChange" clearable></v-text-field>
          </v-flex>

          <v-flex md4></v-flex>

          <v-flex md1>
            <v-tooltip bottom color="black">
              <template v-slot:activator="{ on, attrs }">
                <span v-bind="attrs" v-on="on">
                  <v-btn @click="showModal" fab color="  blue" dark>
                    <v-icon>add</v-icon>
                  </v-btn>
                </span>
              </template>
              <span>Ajouter une opération</span>
            </v-tooltip>
          </v-flex>
        </v-layout>
        <!-- bande -->

        <br />
        <v-card :loading="loading" :disabled="isloading">
          <v-card-text>
            <v-simple-table>
              <template v-slot:default>
                <thead>
                  <tr>                    
                    <th class="text-left">Responsable</th>
                    <th class="text-left">Paroisse</th>
                    <th class="text-left">DateDébut</th>
                    <th class="text-left">Durée(Mois)</th>
                    <th class="text-left">DateFin</th>
                    <th class="text-left">Author</th>
                    <th class="text-left">Activé</th>
                    <th class="text-left">Mise à jour</th>
                    <th class="text-left">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in fetchData" :key="item.id">
                    <td>{{ item.noms_agent }}</td>
                    <td>{{ item.nom_paroisse }}</td>                    
                    <td>{{ item.date_debut_responsable }}</td>
                    <td>{{ item.dure_reponsable }}</td>
                    <td>{{ item.date_fin_responsable }}</td>
                    <td>{{ item.author }}</td>                    
                    <td>{{ item.active }}</td>
                    <td>
                      {{ item.created_at | formatDate }}
                      {{ item.created_at | formatHour }}
                    </td>

                    <td>
                      <v-tooltip top color="black">
                        <template v-slot:activator="{ on, attrs }">
                          <span v-bind="attrs" v-on="on">
                            <v-btn @click="editData(item.id)" fab small><v-icon color="  blue">edit</v-icon></v-btn>
                          </span>
                        </template>
                        <span>Modifier</span>
                      </v-tooltip>

                      <!-- <v-tooltip top   color="black">
                          <template v-slot:activator="{ on, attrs }">
                            <span v-bind="attrs" v-on="on">
                              <v-btn @click="clearP(item.id)" fab small
                                ><v-icon color="  red">delete</v-icon></v-btn
                              >
                            </span>
                          </template>
                          <span>Supprimer</span>
                        </v-tooltip> -->
                    </td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
            <hr />

            <v-pagination color="  blue" v-model="pagination.current" :length="pagination.total" @input="onPageChange"
              :total-visible="7"></v-pagination>
          </v-card-text>
        </v-card>
        <!-- component -->
        <!-- fin component -->
      </v-flex>
    </v-flex>
    <v-flex md2></v-flex>
  </v-layout>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
  components: {},
  data() {
    return {
      title: "Categorie component",
      header: "Crud operation",
      titleComponent: "",
      query: "",
      dialog: false,
      loading: false,
      disabled: false,
      edit: false,
      //'id','refParoisse','refResponsable','autres_details_respo', 'date_debut_responsable',
      // 'dure_reponsable','date_fin_responsable','author','refUser','active'
      svData: {
        id: "",
        refParoisse: 0,
        refResponsable: 0,
        autres_details_respo: "",
        date_debut_responsable: '',
        dure_reponsable: 0,
        // date_fin_responsable: '',
        author: "",
        refUser:0,
        active: ""
      },
      fetchData: null,
      titreModal: "",
      ParoisseList: [],
      AgentList: [],

      inserer: '',
      modifier: '',
      supprimer: '',
      chargement: ''
    };
  },
  computed: {
    ...mapGetters(["roleList", "isloading"]),
  },
  methods: {
    ...mapActions(["getRole"]),

    showModal() {
      this.dialog = true;
      this.titleComponent = "Ajout Quartier";
      this.edit = false;
      this.resetObj(this.svData);
    },

    testTitle() {
      if (this.edit == true) {
        this.titleComponent = "modification des Informations ";
      } else {
        this.titleComponent = "Ajout Quartier";
      }
    }
    ,

    //   searchMember: _.debounce(function () {
    //     this.onPageChange();
    //   }, 300),
    onPageChange() {
      this.fetch_data(`${this.apiBaseURL}/fetch_dio_quartier?page=`);
    },

    validate() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);

        this.svData.author = this.userData.name;
        this.svData.refUser = this.userData.id;

        this.insertOrUpdate(
          `${this.apiBaseURL}/insert_dio_quartier`,
          JSON.stringify(this.svData)
        )
          .then(({ data }) => {
            this.showMsg(data.data);
            this.isLoading(false);
            this.edit = false;
            this.resetObj(this.svData);
            this.onPageChange();

            this.dialog = false;
          })
          .catch((err) => {
            this.svErr(), this.isLoading(false);
          });
      }
    },
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_dio_quartier/${id}`).then(
        ({ data }) => {
          var donnees = data.data;

          donnees.map((item) => {
            this.titleComponent = "modification de " + item.autres_details_respo;
          });

          this.getSvData(this.svData, data.data[0]);
          this.edit = true;
          this.dialog = true;
        }
      );
    },

    clearP(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_dio_quartier/${id}`).then(
          ({ data }) => {
            this.successMsg(data.data);
            this.onPageChange();
          }
        );
      });
    },  
      fetchListParoisse() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_tdio_paroisse_2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.ParoisseList = donnees;
  
          }
        );
      },  
      fetchListAgent() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_list_agent`).then(
          ({ data }) => {
            var donnees = data.data;
            this.AgentList = donnees;
  
          }
        );
      },


  },
  created() {

    this.testTitle();
    this.onPageChange();
    this.fetchListParoisse();
    this.fetchListAgent();
  },
};
</script>