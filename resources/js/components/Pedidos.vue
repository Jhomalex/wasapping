<template>
  <v-app>
    <div class="container-fluid">
     <div class="card-panel">
        <template>
          <v-card flat>
              <v-card-title>
                <h5>Lista de mensajerías</h5>
                <v-spacer></v-spacer>
                <v-text-field
                v-model="search"
                append-icon="search"
                label="Buscar"
                single-line
                hide-details
                ></v-text-field>
              </v-card-title>
              <v-data-table
                :headers="headers"
                :items="todasMensajerias"
                :search="search"
              >
                <template slot="items" slot-scope="props">
                <td class="text-xs-left">{{ props.item.campania }}</td>
                <td class="text-xs-left">{{ props.item.mensaje }}</td>
                <td class="text-xs-left">{{ props.item.fecha }}</td>
                <td class="text-xs-left">{{ props.item.horamin }} - {{ props.item.horamax }}</td>
                <td class="text-xs-left">{{ props.item.usuario }}</td>
                <td class="text-xs-center">
                  <v-btn flat icon color="teal" class="modal-trigger" href="#modalContactos" @click="procesarContactos(props.item.id);mensaje=props.item.mensaje"><v-icon>mail</v-icon></v-btn>
                  <v-btn flat icon color="warning"
                    @click="idMensajeriaEditar=props.item.id;
                    mensaje=props.item.mensaje;
                    campania=props.item.campania;
                    nuevaRespuesta.mensajeriaId=props.item.id
                    listarRespuesta(props.item.id);"
                    href="#modalEditarMensajeria" class="modal-trigger"><v-icon>edit</v-icon>
                  </v-btn>
                  <v-btn flat icon color="red" @click="deleteMensaje(props.item.id)"><v-icon>delete</v-icon></v-btn>
                </td>
                </template>
                <v-alert slot="no-results" :value="true" color="error" icon="warning">
                No encontramos "{{ search }}" que buscabas.
                </v-alert>
              </v-data-table>
          </v-card>
        </template>
     </div>
  </div>
  <div id="modalContactos" class="modal modal-grande">
    <div class="modal-content">
      <h4>Contactos</h4>
      <template>
        <v-data-table v-model="selected" :headers="headers2" :items="contactos" :pagination.sync="pagination"
          select-all item-key="nombre" class="elevation-2">
          <template slot="headers" slot-scope="props">
            <tr>
              <th>
                <v-checkbox :input-value="props.all" :indeterminate="props.indeterminate"
                  primary hide-details @click="toggleAll"></v-checkbox>
              </th>
              <th v-for="header2 in props.headers" :key="header2.text"
                :class="['column sortable', pagination.descending ? 'desc' : 'asc', header2.value === pagination.sortBy ? 'active' : '']"
                @click="changeSort(header2.value)">
                <v-icon small>arrow_upward</v-icon>
                {{ header2.text }}
              </th>
            </tr>
          </template>
          <template slot="items" slot-scope="props">
            <tr :active="props.selected" @click="props.selected = !props.selected">
              <td>
                <v-checkbox :input-value="props.selected" primary hide-details></v-checkbox>
              </td>
              <td class="text-xs-left">{{ props.item.nombre }}</td>
              <td class="text-xs-left">{{ props.item.celular }}</td>
            </tr>
          </template>
        </v-data-table>
      </template>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-red btn-flat" @click="selected=[]">Cerrar</a>
      <a href="#!" class="waves-effect waves-green btn-flat" @click="enviarMensaje()">Enviar</a>
    </div>
  </div>

    <div id="modalEditarMensajeria" class="modal modal-grande">
      <div class="modal-content">
        <h5>Editar contacto</h5>
        <div class="row">
          <div class="input-field col s5">
            <input placeholder="Campaña" id="campania" v-model="campania" type="text" class="validate">
            <label for="campania">Campania</label>
          </div>
          <div class="input-field col s7">
            <input placeholder="Mensaje" id="mensaje" type="text" v-model="mensaje" class="validate">
            <label for="mensaje">Mensaje</label>
          </div>
        </div>
        <h6>RESPUESTAS:</h6>
        <div class="row right">
          <div class="col s2">
            <input placeholder="Contacto" id="contacto" type="text" v-model="nuevaRespuesta.contacto">
            <label for="contacto">Nombre</label>
          </div>
          <div class="col s2">
            <input placeholder="Celular" id="celular" maxlength="9" type="text" v-model="nuevaRespuesta.celular">
            <label for="celular">Celular</label>
          </div>
          <div class="col s6">
            <input placeholder="Respuesta" id="respuesta" type="text" v-model="nuevaRespuesta.respuesta">
            <label for="respuesta">Respuesta</label>
          </div>
          <div class="col s2">
            <v-btn small color="teal" @click="storeRespuesta()" dark>Nueva respuesta</v-btn>
          </div>
          <div class="col s12">
            <template>
              <v-card flat>
                  <v-data-table
                    :headers="headers3"
                    :items="todasRespuestas"
                    :search="search2"
                  >
                    <template slot="items" slot-scope="props">
                    <td class="text-xs-center">{{ props.item.contacto }}</td>
                    <td class="text-xs-center">{{ props.item.celular }}</td>
                    <td class="text-xs-center">{{ props.item.respuesta }}</td>
                    <td class="text-xs-center">
                      <v-btn flat icon color="red" @click="deleteRespuesta(props.item.id)"><v-icon>delete</v-icon></v-btn>
                    </td>
                    </template>
                    <v-alert slot="no-results" :value="true" color="error" icon="warning">
                    No encontramos "{{ search }}" que buscabas.
                    </v-alert>
                  </v-data-table>
              </v-card>
            </template>
          </div>
        </div>
      </div>
      <div class="modal-footer right">
        <a href="#!" class="modal-close waves-effect waves-red btn-flat">Cerrar</a>
        <a href="#!" class="modal-close waves-effect waves-green btn-flat" @click="editMensaje()">Editar</a>
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
      pagination: {
        sortBy: 'nombre'
      },
      selected: [],
      headers2: [
        { text: 'Nombre', align: 'center', value: 'nombre' },
        { text: 'Celular', align: 'center', value: 'celular' },
      ],
      headers3: [
        { text: 'Contacto', align: 'center', value: 'nombre' },
        { text: 'Celular', align: 'center', value: 'celular' },
        { text: 'Respuesta', align: 'center', value: 'respuesta' },
        { text: 'Opciones', align: 'center', value: 'opciones' }
      ],
      contactos: [
        {
          value: false,
          nombre: 'Jhomalex el demoledor B)',
          celular: 7051995,
        },
      ],

      search: '',
      search2: '',
      todasRespuestas:[],
      mensaje: '',
      campania: '',
      nuevaRespuesta : {contacto: '', celular: '', respuesta: '', mensajeriaId: ''},
      idMensajeriaEditar: '',
      todasMensajerias:[],
        headers: [
          {
            text: 'Campaña',
            align: 'left',
            sortable: true,
            value: 'campania'
          },
          {
            text: 'Mensaje',
            align: 'left',
            sortable: true,
            value: 'mensaje'
          },,
          {
            text: 'Fecha',
            align: 'left',
            sortable: true,
            value: 'fecha'
          },
          {
            text: 'Hora',
            align: 'left',
            sortable: true,
            value: 'hora'
          },
          {
            text: 'Usuario',
            align: 'left',
            sortable: true,
            value: 'usuario'
          },
          {
            text: 'Opciones',
            align: 'center',
            value: 'opciones'
          },
        ],
    };
  },
  created: function () {
     this.listarAgenda();
  },

  methods:{
    toggleAll () {
        if (this.selected.length) this.selected = []
      else this.selected = this.contactos.slice()
    },
    changeSort (column) {
      if (this.pagination.sortBy === column) {
        this.pagination.descending = !this.pagination.descending
      } else {
        this.pagination.sortBy = column
        this.pagination.descending = false
      }
    },

    listarAgenda: function() {
        let me = this;
        var url = "/administrador/listar";
          //"/agenda/listar?buscar=" + buscar + "&criterio=" + criterio + "&fecha=" + this.fechaSelected;
        axios.get(url).then(response => {
          me.todasMensajerias = response.data;
          console.log(response.data);
        });
    },
    editMensaje: function(){
      let me = this;
      const fd=new FormData();
      fd.append('id',me.idMensajeriaEditar);
      fd.append('campania',me.campania);
      fd.append('mensaje',me.mensaje);
      axios.post('/mensajeria/edit', fd
      ).then(function(response){
        me.listarAgenda();
        if(response.data=='Ok'){
          Swal({
            position: 'top-end',
            type: 'success',
            title: 'Se editó la mensajería con éxito',

            showConfirmButton: false,
            timer: 2500
          });
        }else{
          Swal({
            position: 'top-end',
            type: 'error',
            title: 'Ha habido un error al editar la mensajería, intentalo nuevamente',
            showConfirmButton: false,
            timer: 2500
          })
        }
      }).catch(function(error){
          console.log(error);
          Swal({
            position: 'top-end',
            type: 'error',
            title: 'Ha habido un error al editar la mensajería, comunícate con Jhonatan Malara',
            showConfirmButton: false,
            timer: 2500
          })
      });
    },
    deleteMensaje: function(mensajeriaId){
      let me = this;
      Swal({
        title: '¿Estás seguro de eliminar la mensajería?',
        text: "Ten en cuenta que se borrará esta mensajería y no podrá recuperarse",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#009688',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, elimínala',
        cancelButtonText: 'Cancelar',
      }).then((result) => {
        if (result.value) {
          const fd=new FormData();
          fd.append('id',mensajeriaId);
          axios.post('/mensajeria/delete', fd
          ).then(function(response){
            me.listarAgenda();
            if(response.data=='Ok'){
              Swal({
                position: 'top-end',
                type: 'success',
                title: 'Se eliminó la mensajería',
                showConfirmButton: false,
                timer: 2500
              });
            }else{
              Swal({
                position: 'top-end',
                type: 'error',
                title: 'Ha habido un error al eliminar la mensajería, intentalo nuevamente',
                showConfirmButton: false,
                timer: 2500
              })
            }
          }).catch(function(error){
            console.log(error);
            Swal({
              position: 'top-end',
              type: 'error',
              title: 'Ha habido un error al eliminar la mensajería, comunícate con Jhonatan Malara',
              showConfirmButton: false,
              timer: 2500
            })
          });
        }
      });
    },

    listarRespuesta: function(mensajeriaId) {
      let me = this;
      var url = "/administrador/listarRespuesta/" + mensajeriaId;
      axios.get(url).then(response => {
        me.todasRespuestas = response.data;
      });
    },
    
    storeRespuesta: function(){
      let me = this;
      const fd=new FormData();
      fd.append('mensajeria_id',me.nuevaRespuesta.mensajeriaId);
      fd.append('contacto',me.nuevaRespuesta.contacto);
      fd.append('celular',me.nuevaRespuesta.celular);
      fd.append('respuesta',me.nuevaRespuesta.respuesta);
      axios.post('/administrador/storeRespuesta', fd
      ).then(function(response){
        me.listarRespuesta(me.nuevaRespuesta.mensajeriaId);
        if(response.data=='Ok'){
          Swal({
            position: 'top-end',
            type: 'success',
            title: 'Se guardó la respuesta',
            showConfirmButton: false,
            timer: 2500
          });
          me.nuevaRespuesta.respuesta = '';
          me.nuevaRespuesta.contacto = '';
          me.nuevaRespuesta.celular = '';
        }else{
          Swal({
            position: 'top-end',
            type: 'error',
            title: 'Ha habido un error al guardar la respuesta, intentalo nuevamente',
            showConfirmButton: false,
            timer: 2500
          })
        }
      }).catch(function(error){
          console.log(error);
          Swal({
            position: 'top-end',
            type: 'error',
            title: 'Ha habido un error al guardar la respuesta, comunícate con Jhonatan Malara',
            showConfirmButton: false,
            timer: 2500
          })
      });
    },

    deleteRespuesta: function(respuestaId){
      let me = this;
      Swal({
        title: '¿Estás seguro de eliminar la respuesta?',
        text: "Ten en cuenta que se borrará esta respuesta y no podrá recuperarse",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#009688',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, elimínala',
        cancelButtonText: 'Cancelar',
      }).then((result) => {
        if (result.value) {
          const fd=new FormData();
          fd.append('id',respuestaId);
          axios.post('/administrador/deleteRespuesta', fd
          ).then(function(response){
            me.listarRespuesta();
            if(response.data=='Ok'){
              Swal({
                position: 'top-end',
                type: 'success',
                title: 'Se eliminó la respuesta',
                showConfirmButton: false,
                timer: 2500
              });
            }else{
              Swal({
                position: 'top-end',
                type: 'error',
                title: 'Ha habido un error al eliminar la respuesta, intentalo nuevamente',
                showConfirmButton: false,
                timer: 2500
              })
            }
          }).catch(function(error){
            console.log(error);
            Swal({
              position: 'top-end',
              type: 'error',
              title: 'Ha habido un error al eliminar la respuesta, comunícate con Jhonatan Malara',
              showConfirmButton: false,
              timer: 2500
            })
          });
        }
      });
    },

    /*

    */
    procesarContactos: function(mensajeria_id){
      let me = this;
      axios.post('/administrador/mostrarcontactos',{
      'mensajeria_id': mensajeria_id,
      }).then(function(response){
        var arrayContacto = response.data[0];
        var arrayNuevo =[];
        for(var i=1;i<arrayContacto.length;i++){
          arrayNuevo.push({value:false,nombre:arrayContacto[i][0],celular:arrayContacto[i][1]});
        }
        me.contactos = arrayNuevo;
      }).catch(function(error){
          console.log(error);
      });
    },

    enviarMensaje:function(){
      for(var i=0;i<this.selected.length;i++){
        var url = 'https://wa.me/'+this.selected[i].celular+'?text=';
        var mensaje= this.prepararMsj(this.mensaje,this.selected[i].nombre);
        var url = url+mensaje;
        window.open(url, '_blank');
      }
    },

    prepararMsj :function(mensajeSinPreparar,nombreContacto){
      var mensajePreparado="";
      var i;
      for(i=0;i<mensajeSinPreparar.length+1;i++){
        if(mensajeSinPreparar.substring(i,i+1)==" "){
            mensajePreparado += "%20";
        }else{
            if(mensajeSinPreparar.substring(i,i+1)=="@"){
              mensajePreparado += nombreContacto;
            }else{
              if(mensajeSinPreparar.substring(i,i+1)!="@"){
                mensajePreparado += mensajeSinPreparar.substring(i,i+1);
              }
            }
        }
      }
      return(mensajePreparado);
    },

    seleccionHora : function(){
      if(this.fecha==this.hoy){
        this.ahora=moment().add(2,'H').format('HH:mm');
        this.horaMin=this.ahora;
      }else{
        this.ahora="";
      }
    },
    seleccionHora2 : function(){
      this.horaMax_min=moment(this.horaMin,'HH:mm').add(1,'H').format('HH:mm');
      this.horaMax=this.horaMax_min;
    },
    onFileSelected : function(){
      this.archivo = event.target.files[0];
    },
  }
};

</script>
