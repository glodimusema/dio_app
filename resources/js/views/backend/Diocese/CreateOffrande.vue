<template>
    
    <v-layout>
        <v-flex md12>

            <VenteDetailUse ref="VenteDetailUse" />

            <v-form ref="form" v-model="valid" lazy-validation>

            <v-layout row wrap> 
                
                 <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                        <v-text-field type="date" label="Date Offrande" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_offrande">
                        </v-text-field>
                    </div>
                </v-flex> 
 
                <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                        <v-autocomplete label="Selectionnez le Type Offrende" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="typeoffrandeList" item-text="nom_type_offrande"
                            item-value="id" dense outlined v-model="svData.refTypeOffrande" chips clearable 
                             >
                        </v-autocomplete>
                    </div>
                </v-flex> 
                             

            </v-layout>

            <v-simple-table>
                <thead>
                    <tr>
                        <th>Chretien</th>
                        <th>Année</th>
                        <th>Montant</th>
                        <th>Devise</th>
                        <th>Autres Details</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in svData.detailData" :key="index">
                        <td class="long-cell">
                            <v-autocomplete v-model="item.refChretien" :items="chretienList"
                                label="Selectionnez le Chretien" :rules="[(v) => !!v || 'Ce champ est requis']"
                                hide-no-data hide-selected item-text="noms_chretien" item-value="id"
                                ></v-autocomplete>
                        </td>
                        <td class="short-cell">
                            <v-autocomplete v-model="item.refAnnee" :items="chretienList"
                                label="Selectionnez l'Année" :rules="[(v) => !!v || 'Ce champ est requis']"
                                hide-no-data hide-selected item-text="name_annee" item-value="id"
                            ></v-autocomplete>
                        </td>
                        <td class="short-cell">
                            <v-text-field v-model="item.montant_offrande" type="number" label="Montant" :rules="[rules.required]"
                                required></v-text-field>
                        </td>
                        <td class="short-cell">
                            <v-autocomplete v-model="item.devise" :items="deviseList"
                                label="Selectionnez la Devise" :rules="[(v) => !!v || 'Ce champ est requis']"
                                hide-no-data hide-selected item-text="designation" item-value="designation"
                            ></v-autocomplete>
                        </td> 
                        <td class="long-cell">
                            <v-text-field v-model="item.autres_details_offrende" label="Autres Details" :rules="[rules.required]"
                                required></v-text-field>
                        </td>                      
                                             
                       
                        <td>
                            <v-btn @click="removeItem(index)" icon>
                                <v-icon color="red">mdi-delete</v-icon>
                            </v-btn>
                        </td>
                    </tr>
                </tbody>
            </v-simple-table>

            <v-btn @click="addItem()" color="primary">Ajouter<v-icon color="white">mdi-cart-plus</v-icon></v-btn>
            <div style="text-align: right; margin-top: 20px;"><strong>Total : {{ svData.totalInvoice }} $</strong></div>
           
            <table>
              <tr>
                  <td>
                      <!-- <div style="text-align: right; margin-top: 20px;"> <v-btn @click="validate" color="success">Enregistrer</v-btn></div> -->
                  </td>
                  <td>
                    <div style="text-align: right; margin-top: 20px;"> <v-btn @click="validate" color="success">Enregistrer</v-btn></div>
                    <v-progress-linear v-if="loadings" :value="progress" indeterminate color="green"></v-progress-linear>                    
                  </td>
              </tr>
          </table>
            

            

            <v-flex md12>
                <!-- <v-layout>
                    <v-flex md6>
                    <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line solo outlined
                        rounded hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>
                    </v-flex>
                    <v-flex md5>


                    </v-flex>
                    <v-flex md1>
                    <v-tooltip bottom color="black">
                        <template v-slot:activator="{ on, attrs }">
                        <span v-bind="attrs" v-on="on">
                            <v-btn @click="dialog = true" fab color="  blue" dark>
                            <v-icon>add</v-icon>
                            </v-btn>
                        </span>
                        </template>
                        <span>Ajouter un Produit</span>
                    </v-tooltip>
                    </v-flex>
                </v-layout> -->
                <br />
                <v-card>
                    <v-card-text>
                    <v-simple-table>
                        <template v-slot:default>
                        <thead>
                            <tr>
                                  <th class="text-left">Chretien</th>
                                  <th class="text-left">TypeOffrande</th>
                                  <th class="text-left">Année</th>
                                  <th class="text-left">DateOffrande</th>                                  
                                  <th class="text-left">Montant($)</th>
                                  <th class="text-left">Devise</th>                                  
                                  <th class="text-left">Taux</th>
                                  <th class="text-left">Author</th>
                                  <th class="text-left">Activé</th>
                                  <th class="text-left">Action</th>                          
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                            <td>

                            <v-menu bottom rounded offset-y transition="scale-transition">
                            <template v-slot:activator="{ on }">
                                <v-btn icon v-on="on" small fab depressed text>
                                <v-icon>more_vert</v-icon>
                                </v-btn>
                            </template>

                            <v-list dense width="">        

                                <v-list-item link @click="editData(item.id)">
                                <v-list-item-icon>
                                    <v-icon color="blue">edit</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Modifier
                                </v-list-item-title>
                                </v-list-item>

                                <v-list-item   
                                link @click="deleteData(item.id)">
                                <v-list-item-icon>
                                    <v-icon color="  red">delete</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Annuler l'Offrande
                                </v-list-item-title>
                                </v-list-item>

                            </v-list>
                            </v-menu>
                            </td>
                            <td>{{ item.noms_chretien }}</td>
                                  <td>{{ item.nom_type_offrande }}</td>
                                  <td>{{ item.name_annee }}</td>
                                  <td>{{ item.date_offrande }}</td>
                                  <td>{{ item.montant_offrande }}</td>
                                  <td>{{ item.devise }}</td>
                                  <td>{{ item.taux }}</td>
                                  <td>{{ item.author }}</td>
                                  <td>
                                    <v-btn
                                      elevation="2"
                                      x-small
                                      class="white--text"
                                      :color="item.active == 'NON' ? '#F13D17' : item.active == 'OUI' ? '#3DA60C' : 'error'"
                                      depressed                            
                                    >
                                      {{ item.active == 'OUI' ? 'Actif' : item.active == 'NON' ? 'Inactif' : 'error' }}
                                    </v-btn>                                  
                                  </td>                           
                            </tr>
                        </tbody>
                        </template>
                    </v-simple-table>
                    <hr />

                    <v-pagination color="  blue" v-model="pagination.current" :length="pagination.total"
                        @input="fetchDataList"></v-pagination>
                    </v-card-text>
                </v-card>
                </v-flex>

            </v-form>
        </v-flex>
    </v-layout>   
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import VenteDetailUse from './VenteDetailUse.vue';


export default {
    components:{
    VenteDetailUse
  },
    data() {
        return {

            title: "Liste des Usages",
            dialog: false,
            dialog2: false,
            edit: false,
            loading: false,
            disabled: false,


            loadings: false,
            progress: 0,

            //'id','refChretien','refTypeOffrande','refAnnee',
    //'montant_offrande','devise','taux','date_offrande','autres_details_offrende',
    //'author','refUser','active'

            svData: {
                id: '',
                date_offrande: "",
                author: "",
                refUser: 0,
                totalInvoice:0,
                totalTVA:0,
                totalTTC:0,
                indexEncours:0,
                refTypeOffrande: 0,
              

               detailData: [{
                    refChretien : 0,                   
                    refAnnee: 0,
                    montant_offrande:0,
                    devise: "",                    
                    autres_details_offrende:0,
                    
                    anneeList: [],
                    deviseList: [],
                    chretienList: []
                }],                
            },
            fetchData: [],
            typeoffrandeList: [],    

            query: "",

            valid: false,
            customerName: '',
            items: [{ name: '', description: '', quantity: 1, price: 0 }],            
            rules: {
                required: value => !!value || 'Required.',
            },
        };
    },
    created() {
        this.fetchDataList();
        this.fetchListTypeOffrande();
        this.fetchListChretien();
        this.fetchListDevise();
        this.fetchListAnnee();
    },
    computed: {
        ...mapGetters(["categoryList", "isloading"]),   
    },
    methods: {
        addItem() {  
            this.updateTotal();         
            this.svData.detailData.push({                
                montant_offrande:0,
                devise: "",
                refChretien : 0,                   
                refAnnee: 0,
                autres_details_offrende:0,
                    
                anneeList: [],
                deviseList: [],
                chretienList: []
            });
            this.fetchListAnnee();
            this.fetchListChretien();
            this.fetchListDevise();
        },
        updateTotal() { 
            this.svData.totalInvoice = this.svData.detailData.reduce((accumulator, current) => {
                return accumulator + current.montant_offrande;
            }, 0);
          
        },
        removeItem(index) {
            this.svData.totalInvoice = this.svData.totalInvoice - this.svData.detailData[index].montant_offrande;
            this.indexEncours = this.indexEncours - index;

            this.svData.detailData.splice(index, 1);
        },
        resetForm() {
                this.svData.detailData = [{
                    montant_offrande:0,
                    devise: "",
                    refChretien : 0,                   
                    refAnnee: 0,
                    autres_details_offrende:0,
                    
                    anneeList: [],
                    deviseList: [],
                    chretienList: []
            }];
            this.$refs.form.reset(); // Reset the form validation state            
            this.fetchListAnnee();
            this.fetchListChretien();
            this.fetchListDevise();
        },
        validate() {


            try
            {
                this.loadings = true;
                this.progress = 0;

                // Simuler un processus d'enregistrement

                if (this.$refs.form.validate()) {
                    this.isLoading(true);
                        this.svData.author = this.userData.name;
                        this.svData.refUser = this.userData.id;
                        this.insertOrUpdate(
                        `${this.apiBaseURL}/insert_dio_offrandes_globale`,
                        JSON.stringify(this.svData)
                        )
                        .then(({ data }) => {
                            this.showMsg(data.data);
                            this.isLoading(false);
                            this.edit = false;
                            this.dialog = false;
                            this.resetObj(this.svData);
                            this.fetchDataList();
                            this.resetForm();
                        })
                        .catch((err) => {
                            this.svErr(), this.isLoading(false);
                        });
            
                }

                //fin processus
                const interval = setInterval(() => {
                    if (this.progress < 100) {
                    this.progress += 10; // Augmentez la progression
                    } else {
                    clearInterval(interval);
                    this.loadings = false; // Arrêtez le chargement lorsque terminé
                    this.progress = 0; // Réinitialisez la progression si nécessaire
                    }
                }, 100); // Ajustez le délai selon vos besoins

            }
            catch (error) {
                // Bloc 5 : Gestion des erreurs
                console.error(`Erreur lors de enregistrement:,`);
                this.loadings = false; // Arrêtez le chargement en cas d'erreur
            }

           
        },
        fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_dio_offrandes?page=`);
        },    
        fetchListTypeOffrande() {
          this.editOrFetch(`${this.apiBaseURL}/fetch_tdio_type_offrande_2`).then(
            ({ data }) => {
              var donnees = data.data;
              this.typeoffrandeList = donnees;
            }
          );
        },
        fetchListChretien() {

             this.editOrFetch(`${this.apiBaseURL}/fetch_list_chretien`).then(
                ({ data }) => {
                    const donnees = data.data;
                    this.svData.detailData = this.svData.detailData.map(item => ({
                        ...item, // Spread existing properties
                        deviseList: donnees // Update 
                    }));
                }
            );
        },
        fetchListDevise() {

             this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_devise_2`).then(
                ({ data }) => {
                    const donnees = data.data;
                    this.svData.detailData = this.svData.detailData.map(item => ({
                        ...item, // Spread existing properties
                        deviseList: donnees // Update 
                    }));
                }
            );
        },
        fetchListAnnee() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_annee2`).then(
                ({ data }) => {
                    const donnees = data.data;
                    this.svData.detailData = this.svData.detailData.map(item => ({
                        ...item, // Spread existing properties
                        anneeList: donnees // Update 
                    }));
                }
            );
        },
        editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_dio_offrandes/${id}`).then(
            ({ data }) => {

            this.titleComponent = "modification des informations";

            this.getSvData(this.svData, data.data[0]);
            this.edit = true;
            this.dialog = true;
            }
        );
        },
        deleteData(id) {
        this.confirmMsg().then(({ res }) => {
            this.delGlobal(`${this.apiBaseURL}/delete_dio_offrandes/${id}`).then(
            ({ data }) => {
                this.showMsg(data.data);
                this.fetchDataList();
            }
            );
        });
        }
        ,


        // VISUALISATION DES DONNEES DES COMMANDES============================================================



    },
};
</script>

<style scoped>
/* Add any necessary styles here */
.short-cell {
        width: 100px;
    }

    .medium-cell {
        width: 150px;
    }

    .long-cell {
        width: 400px;
    }

    table {
        table-layout: auto;
        width: 100%;
    }

    td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>