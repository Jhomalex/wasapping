<template>
  <v-app>
    <div class="container-fluid">
     <div class="card-panel">
         <form v-on:submit.prevent="storeMensaje()">
            <div class="row">
              <div class="input-field col s12 m12">
                <input id="campania" v-model="campania" type="text" placeholder="Escribe el nombre de la campaña" required>
                <label for="nombre_campania">Nombre de la campaña</label>
              </div>
              <div class="input-field col s12 m12">
                <textarea id="mensaje" v-model="mensaje" class="materialize-textarea" placeholder="Escribe el mensaje a enviar a tus contactos" required data-length="300"></textarea>
                <label for="mensaje">Mensaje a enviar</label>
              </div>
              <div class="col s12 m12">
                <md-field>
                  <label>Selecciona el excel con la lista de contactos y sus números</label>
                  <md-file v-model="nombreArchivo" @change="onFileSelected()"/>
                </md-field>
                <label for="archivo">El archivo debe estar en formato xlsx* y no debe exceder los 2MB</label>
              </div>
              <div class="row">
                <div class="input-field col s12 m6">
                  <v-dialog
                    ref="dialog"
                    v-model="modal"
                    :return-value.sync="fecha"
                    persistent
                    lazy
                    full-width
                    width="290px"
                    color="success"
                  >
                    <v-text-field
                      slot="activator"
                      v-model="fecha"
                      label="Selecciona la fecha en la que deseas que se envíe el mensaje"
                      prepend-icon="event"
                      readonly
                    ></v-text-field>
                    <v-date-picker v-model="fecha" :min="hoy" color="teal" scrollable>
                      <v-spacer></v-spacer>
                      <v-btn flat color="primary" @click="modal = false">Cancelar</v-btn>
                      <v-btn flat color="primary" @click="$refs.dialog.save(fecha);seleccionHora()">OK</v-btn>
                    </v-date-picker>
                  </v-dialog>
                </div>
                <div class="input-field col s12 m6">
                  <v-select
                    :items="itemsHoras"
                    v-model="horaMin"
                    label="Selecciona la hora mínima en la que deseas que se envíe el mensaje"
                  ></v-select>
                </div>
                <label for="archivo">Nuestra experiencia determina que estos horarios son los mejores para usar wasapping. Si deseas enviar a otro horario envíanos un correo a <a href="mailto:'soporte@wasapping.com'">soporte@wasapping.com</a></label>
              </div>
              <!-- <div class="input-field col s12 m6">
                <v-dialog
                  ref="dialog2"
                  v-model="modal2"
                  :return-value.sync="horaMin"
                  persistent
                  lazy
                  full-width
                  width="290px"
                >
                  <v-text-field
                    slot="activator"
                    v-model="horaMin"
                    label="Selecciona una hora mínima para el envío de los mensajes"
                    prepend-icon="access_time"
                    readonly
                  ></v-text-field>
                  <v-time-picker
                    v-if="modal2"
                    v-model="horaMin"
                    :min="ahora"
                    full-width
                    format="24hr"
                    color="teal"
                  >
                    <v-spacer></v-spacer>
                    <v-btn flat color="primary" @click="modal2 = false">Cancelar</v-btn>
                    <v-btn flat color="primary" @click="$refs.dialog2.save(horaMin);seleccionHora2()">OK</v-btn>
                  </v-time-picker>
                </v-dialog>
              </div>
              <div class="input-field col s12 m6">
                <v-dialog
                  ref="dialog3"
                  v-model="modal3"
                  :return-value.sync="horaMax"
                  persistent
                  lazy
                  full-width
                  width="290px"
                >
                  <v-text-field
                    slot="activator"
                    v-model="horaMax"
                    label="Selecciona una hora máxima para el envío de los mensajes"
                    prepend-icon="access_time"
                    readonly
                  ></v-text-field>
                  <v-time-picker
                    v-if="modal3"
                    v-model="horaMax"
                    :min="horaMax_min"
                    full-width
                    format="24hr"
                    color="teal"
                  >
                    <v-spacer></v-spacer>
                    <v-btn flat color="primary" @click="modal3 = false">Cancelar</v-btn>
                    <v-btn flat color="primary" @click="$refs.dialog3.save(horaMax)">OK</v-btn>
                  </v-time-picker>
                </v-dialog>
              </div> -->
            </div>
            <div class="row center">
               <v-btn depressed large block :loading="loading" :disabled="loading" color="teal white--text" @click="loader = 'loading';storeMensaje()">Enviar</v-btn>
            </div>
         </form>
     </div>
  </div>
  </v-app>
</template>

<script>
import Swal from 'sweetalert2'
import moment from 'moment'
import colors from 'vuetify/es5/util/colors'

export default {
  data() {
    return {
      selected: [],
      itemsHoras: ['08:30 AM', '02:30 PM', '08:30 PM'],
      loader: null,
      loading: false,
      campania:'',
      mensaje:'',
      caso: 0,
      archivo:null,
      nombreArchivo:'',
      fecha:'',
      horaMin:'00:00',
      horaMax:'00:00',
      ahora:'',
      hoy:moment().format('YYYY-MM-DD'),
      modal:false,
      modal2:false,
      modal3:false,
      horaMax_min:moment(this.horaMin).add(1,'H').format('HH:mm'),
    };
  },
  watch: {
    loader () {
      const l = this.loader
      this[l] = !this[l]

      setTimeout(() => (this[l] = false), 3000)

      this.loader = null
    }
  },
  methods:{
    storeMensaje: function(){
      let me = this;
      const fd=new FormData();
      fd.append('archivo',me.archivo);
      fd.append('campania',me.campania);
      fd.append('mensaje',me.mensaje);
      fd.append('fecha',me.fecha);
      fd.append('horamin',moment(me.horaMin, 'HH:mm').format('HH:mm'));
      fd.append('horamax',moment(me.horaMin, 'HH:mm').add(2,'H').format('HH:mm'));
      axios.post('/mensajeria/store', fd
      ).then(function(response){
        console.log(response.data);
        if(response.data=='Ok'){
          Swal({
            position: 'top-end',
            type: 'success',
            title: 'Se enviarán los mensajes con éxito',
            showConfirmButton: false,
            timer: 2500
          });
          location.href ="/dashboard";
        }else{
          if(response.data=='Exceso'){
            Swal({
            position: 'top-end',
            type: 'error',
            title: 'Has excedido tu cuota de mensajes. Por favor reduce la cantidad de mensajes o adquiere un nuevo plan',
            showConfirmButton: false,
            timer: 3500
          })
          }else{
            Swal({
            position: 'top-end',
            type: 'error',
            title: 'Ha habido un error al registrar, intentalo nuevamente',
            showConfirmButton: false,
            timer: 2500
          })
          }
        }
      }).catch(function(error){
          console.log(error);
          Swal({
            position: 'top-end',
            type: 'error',
            title: 'Ha habido un error al registrar, intentalo nuevamente',
            showConfirmButton: false,
            timer: 2500
          })
      });
    },
    seleccionHora : function(){
      //this.ahora=moment().add(2,'H').format('HH:mm');
      this.ahora=moment().format('HH:mm');

      var horaManiana = moment('06:30', 'HH:mm').format('HH:mm');
      var horaTarde = moment('12:30', 'HH:mm').format('HH:mm');
      var horaNoche = moment('18:30', 'HH:mm').format('HH:mm');

      console.log(moment(this.ahora,'HH:mm').diff(moment(horaManiana,'HH:mm')));

      if(this.fecha==this.hoy){
        if(moment(this.ahora,'HH:mm').diff(moment(horaManiana,'HH:mm'))>0){
          if(moment(this.ahora,'HH:mm').diff(moment(horaTarde,'HH:mm'))>0){
            if(moment(this.ahora,'HH:mm').diff(moment(horaNoche,'HH:mm'))>0){
              this.itemsHoras= [];
            }else{
              this.itemsHoras= ['08:30 PM'];
            }
          }else{
            this.itemsHoras= ['02:30 PM', '08:30 PM'];
          }
        }else{
          this.itemsHoras= ['08:30 AM', '02:30 PM', '08:30 PM'];
        }
      }else{
        this.itemsHoras= ['08:30 AM', '02:30 PM', '08:30 PM'];
      }
    },
    // seleccionHora : function(){
    //   if(this.fecha==this.hoy){
    //     this.ahora=moment().add(2,'H').format('HH:mm');
    //     this.horaMin=this.ahora;
    //   }else{
    //     this.ahora="";
    //   }
    // },
    // seleccionHora2 : function(){
    //   this.horaMax_min=moment(this.horaMin,'HH:mm').add(1,'H').format('HH:mm');
    //   this.horaMax=this.horaMax_min;
    // },
    onFileSelected : function(){
      this.archivo = event.target.files[0];
    },
  }
};

</script>
