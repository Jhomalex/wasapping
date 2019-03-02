<template>
  <v-app>
    <div class="container-fluid">
      <div class="card-panel">
        <div class="card-header">
          <h5>Contactos</h5>
        </div>
        <template>
          <v-card flat>
            <v-card-title>
              <a class="btn-small waves-effect waves-light z-depth-0 modal-trigger" href="#CrearContactosModal">
                <i class="material-icons left">add</i>Nuevo
              </a>
              <a class="btn-small waves-effect waves-light z-depth-0 red lighten-2" @click="deleteContactos(selected)">
                <i class="material-icons left">delete</i>Eliminar
              </a>
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
              v-model="selected"
              :headers="headers"
              :items="todosContactos"
              item-key="celular"
              select-all
              :search="search"
              rows-per-page-text="Contactos por página"
            >
              <template slot="items" slot-scope="props">
                <td>
                  <v-checkbox v-model="props.selected" primary hide-details></v-checkbox>
                </td>
                <td class="text-xs-left">{{ props.item.nombre }}</td>
                <td class="text-xs-left">{{ props.item.dni }}</td>
                <td class="text-xs-left">{{ props.item.ruc }}</td>
                <td class="text-xs-left">{{ props.item.celular }}</td>
                <td class="text-xs-left">{{ props.item.correo }}</td>
                <td class="text-xs-center">
                  <v-btn flat icon color="primary" @click="irPerfilContacto(props.item.id)">
                    <v-icon>person</v-icon>
                  </v-btn>
                  <v-btn
                    flat
                    icon
                    color="warning"
                    @click="mostrarModalEditar(props.item)"
                    href="#EditarContactosModal"
                    class="modal-trigger"
                  >
                    <v-icon>edit</v-icon>
                  </v-btn>
                  <v-btn flat icon color="red" @click="deleteContacto(props.item.id)">
                    <v-icon>delete</v-icon>
                  </v-btn>
                </td>
              </template>
              <v-alert
                slot="no-results"
                :value="true"
                color="error"
                icon="warning"
              >No encontramos "{{ search }}" que buscabas.</v-alert>
            </v-data-table>
          </v-card>
        </template>
      </div>
    </div>
    <!-- FORMULARIO CREAR CONTACTOS -->
    <div id="CrearContactosModal" class="modal modal-fixed-footer">
      <div class="modal-content">
        <h4>Crear Contacto</h4>
        <form method="POST" v-on:submit.prevent="storeContactos">
          <div class="row">
            <div class="col s12 m12">
              <md-field>
                <label>Selecciona el excel con la lista de tus contactos</label>
                <md-file v-model="nombreArchivo" @change="onFileSelected()"/>
              </md-field>
              <label for="archivo">
                  El archivo debe estar en formato xlsx* y no debe exceder los 2MB. Descargar formato
                  <a href="/archivos/Formato_contactos_wasapping.xlsx" download="Formato wasapping.xlsx">
                      aquí.
                  </a>
                </label>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <a
          href="#"
          class="modal-close waves-effect waves-red btn-flat"
          @click="limpiarFormulario()"
        >Cancelar</a>
        <a
          @click="storeContactos();limpiarFormulario()"
          class="modal-close waves-effect waves-green btn-flat"
        >Aceptar</a>
      </div>
    </div>

    <!-- FORMULARIO EDITAR CONTACTO -->
    <div id="EditarContactosModal" class="modal modal-fixed-footer">
      <div class="modal-content">
        <h4>Editar Contacto</h4>
        <form method="POST" v-on:submit.prevent="editContacto">
          <div class="row">
            <div class="col s12 m6">
              <input
                id="nombre"
                v-model="nombre"
                type="text"
                placeholder="Escribe el nombre del contacto"
                required
              >
              <label for="nombre">Nombre del contacto</label>
            </div>
            <div class="col s12 m6">
              <input
                id="celular"
                v-model="celular"
                type="text"
                maxlength="9"
                placeholder="Escribe el celular del contacto"
                required
              >
              <label for="celular">Celular del contacto</label>
            </div>
          </div>
          <div class="row">
            <div class="col s12 m6">
              <input
                id="dni"
                v-model="dni"
                maxlength="8"
                type="text"
                placeholder="Escribe el DNI del contacto"
                required
              >
              <label for="dni">DNI del contacto</label>
            </div>
            <div class="col s12 m6">
              <input
                id="ruc"
                v-model="ruc"
                maxlength="11"
                type="text"
                placeholder="Escribe el RUC del contacto"
                required
              >
              <label for="ruc">RUC del contacto</label>
            </div>
            <div class="row">
              <div class="col s12 m6">
                <input
                  id="correo"
                  v-model="correo"
                  type="text"
                  placeholder="Escribe el correo del contacto"
                  required
                >
                <label for="correo">Correo del contacto</label>
              </div>
            </div>
            <div class="row">
              <div class="col s12 m12">
                <textarea
                  id="referencia"
                  v-model="referencia"
                  class="materialize-textarea"
                  placeholder="Escribe alguna referencia del contacto"
                  data-length="300"
                ></textarea>
                <label for="referencia">Referencia del contacto</label>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <a
          href="#"
          class="modal-close waves-effect waves-red btn-flat"
          @click="limpiarFormulario()"
        >Cancelar</a>
        <a
          @click="editContacto()"
          class="modal-close waves-effect waves-green btn-flat"
        >Aceptar</a>
      </div>
    </div>
    <!-- BOTÓN FLOTANTE PARA ENVIAR MENSAJES -->
    <div class="fixed-action-btn">
      <a class="btn-floating btn-large teal z-depth-3" @click="mensajeModal()">
        <i class="large material-icons">send</i>
      </a>
    </div>
  </v-app>
</template>

<script>
import Swal from "sweetalert2";
import moment from "moment";
import colors from "vuetify/es5/util/colors";

export default {
  data() {
    return {
      pagination: {
        sortBy: "nombre"
      },
      selected: [],
      search: "",
      todosContactos: [],
      idContacto:'',
      nombre:'',
      celular:'',
      dni:'',
      ruc:'',
      correo:'',
      referencia:'',
      nombreArchivo: "",
      archivo: null,
      headers: [
        {
          text: "Nombre",
          align: "left",
          sortable: true,
          value: "nombre"
        },
        {
          text: "DNI",
          align: "left",
          sortable: true,
          value: "dni"
        },
        ,
        {
          text: "RUC",
          align: "left",
          sortable: true,
          value: "ruc"
        },
        {
          text: "Celular",
          align: "left",
          sortable: true,
          value: "celular"
        },
        {
          text: "Correo",
          align: "left",
          sortable: true,
          value: "correo"
        },
        {
          text: "Opciones",
          align: "center",
          value: "opciones"
        }
      ]
    };
  },
  created: function() {
    this.listarContactos();
  },

  methods: {
    limpiarFormulario: function() {
      let me = this;
      me.nombre = '';
      me.celular = '';
      me.dni = '';
      me.ruc = '';
      me.correo = '';
      me.referencia = '';
    },
    listarContactos: function() {
      let me = this;
      const fd = new FormData();
      var a = [{ nombre: "" }];
      fd.append("filtros", JSON.stringify(a));
      axios
        .post("/contactos/listar", fd)
        .then(function(response) {
          me.todosContactos = response.data;
        })
        .catch(function(error) {
          console.log(error);
        });
    },

    storeContactos: function() {
      let me = this;
      const fd = new FormData();
      fd.append("archivo", me.archivo);
      axios
        .post("/contactos/storevarios", fd)
        .then(function(response) {
          console.log(response.data);
          if (response.data == "Ok") {
            Swal({
              position: "top-end",
              type: "success",
              title: "Los contactos han sido creados con éxito",
              showConfirmButton: false,
              timer: 2500
            });
            me.listarContactos();
          } else {
            Swal({
              position: "top-end",
              type: "error",
              title:
                "Ha habido un error al registrar los contactos, intentalo nuevamente",
              showConfirmButton: false,
              timer: 2500
            });
          }
        })
        .catch(function(error) {
          console.log(error);
          Swal({
            position: "top-end",
            type: "error",
            title:
              "Ha habido un error al registrar los contactos, intentalo nuevamente",
            showConfirmButton: false,
            timer: 2500
          });
        });
    },

    mostrarModalEditar : function (contacto) {
        this.idContacto = contacto.id;
        this.nombre = contacto.nombre;
        this.celular = contacto.celular;
        this.dni = contacto.dni;
        this.ruc = contacto.ruc;
        this.correo = contacto.correo;
        this.referencia = contacto.referencia;
    },

    editContacto: function(){
      let me = this;
      const fd=new FormData();
      fd.append('id',me.idContacto);
      fd.append('nombre',me.nombre);
      fd.append('celular',me.celular);
      fd.append('dni',me.dni);
      fd.append('ruc',me.ruc);
      fd.append('correo',me.correo);
      fd.append('referencia',me.referencia);
      axios.post('/contactos/update', fd
      ).then(function(response){
        me.listarContactos();
        me.limpiarFormulario();
        if(response.data=='Ok'){
          Swal({
            position: 'top-end',
            type: 'success',
            title: 'Se editó el contacto con éxito',

            showConfirmButton: false,
            timer: 2500
          });
        }else{
          Swal({
            position: 'top-end',
            type: 'error',
            title: 'Ha habido un error al editar el contacto, intentalo nuevamente',
            showConfirmButton: false,
            timer: 2500
          })
        }
      }).catch(function(error){
          console.log(error);
          Swal({
            position: 'top-end',
            type: 'error',
            title: 'Ha habido un error al editar el contacto, comunícate con nuestro equipo técnico',
            showConfirmButton: false,
            timer: 2500
          })
      });
    },

    irPerfilContacto: function(contacto_id) {
      var url = "/contactos/perfil/" + contacto_id;
      location.href = url;
    },

    deleteContacto: function(contacto_id) {
      let me = this;
      Swal({
        title: "¿Estás seguro de eliminar este contacto?",
        text:
          "Ten en cuenta que se borrará este contacto y no podrá recuperarse",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#009688",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, elimínalo",
        cancelButtonText: "Cancelar"
      }).then(result => {
        if (result.value) {
          const fd = new FormData();
          fd.append("id", contacto_id);
          axios
            .post("/contactos/delete", fd)
            .then(function(response) {
              me.listarContactos();
              if (response.data == "Ok") {
                Swal({
                  position: "top-end",
                  type: "success",
                  title: "Se eliminó el contacto",
                  showConfirmButton: false,
                  timer: 2500
                });
              } else {
                Swal({
                  position: "top-end",
                  type: "error",
                  title:
                    "Ha habido un error al eliminar el contacto, intentalo nuevamente",
                  showConfirmButton: false,
                  timer: 2500
                });
              }
            })
            .catch(function(error) {
              console.log(error);
              Swal({
                position: "top-end",
                type: "error",
                title:
                  "Ha habido un error al eliminar el contacto, comunícate con nuestro equipo técnico",
                showConfirmButton: false,
                timer: 2500
              });
            });
        }
      });
    },

    deleteContactos: function(contactos) {
      let me = this;
      Swal({
        title: "¿Estás seguro de eliminar estos contactos?",
        text:
          "Ten en cuenta que se borrarán éstos contactos y no podrán recuperarse",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#009688",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, elimínalo",
        cancelButtonText: "Cancelar"
      }).then(result => {
        if (result.value) {
          const fd = new FormData();
          fd.append("contactos", JSON.stringify(contactos));
          axios
            .post("/contactos/deletevarios", fd)
            .then(function(response) {
              me.listarContactos();
              console.log(response.data);
              if (response.data == "Ok") {
                Swal({
                  position: "top-end",
                  type: "success",
                  title: "Se eliminaron los contactos",
                  showConfirmButton: false,
                  timer: 2500
                });
              } else {
                Swal({
                  position: "top-end",
                  type: "error",
                  title:
                    "Ha habido un error al eliminar los contactos, intentalo nuevamente",
                  showConfirmButton: false,
                  timer: 2500
                });
              }
            })
            .catch(function(error) {
              console.log(error);
              Swal({
                position: "top-end",
                type: "error",
                title:
                  "Ha habido un error al eliminar el contacto, comunícate con nuestro equipo técnico",
                showConfirmButton: false,
                timer: 2500
              });
            });
        }
      });
    },


    mensajeModal: function() {
      let me = this;
      Swal.fire({
        title: "Escribe el mensaje que deseas enviar:",
        input: "text",
        inputAttributes: {
          autocapitalize: "off"
        },
        showCancelButton: true,
        confirmButtonText: "Enviar",
        cancelButtonText: "Cancelar"
      }).then(result => {
        if (result.value) {
          me.enviarMensaje(result.value);
        }
      });
    },

    enviarMensaje: function(mensajeSinPreparar) {
      for (var i = 0; i < this.selected.length; i++) {
        var nombreContacto = this.selected[i].nombre;
        var url = "https://wa.me/" + this.selected[i].celular + "?text=";
        var mensaje = this.prepararMsj(mensajeSinPreparar, nombreContacto);
        var url = url + mensaje;
        window.open(url, "_blank");
      }
    },

    prepararMsj: function(mensajeSinPreparar, nombreContacto) {
      var mensajePreparado = "";
      for (var i = 0; i < mensajeSinPreparar.length + 1; i++) {
        if (mensajeSinPreparar.substring(i, i + 1) == " ") {
          mensajePreparado += "%20";
        } else {
          if (mensajeSinPreparar.substring(i, i + 1) == "@") {
            mensajePreparado += nombreContacto;
            // console.log(mensajePreparado);
          } else {
            if (mensajeSinPreparar.substring(i, i + 1) != "@") {
              mensajePreparado += mensajeSinPreparar.substring(i, i + 1);
            }
          }
        }
      }
      return mensajePreparado;
    },


    seleccionHora: function() {
      if (this.fecha == this.hoy) {
        this.ahora = moment()
          .add(2, "H")
          .format("HH:mm");
        this.horaMin = this.ahora;
      } else {
        this.ahora = "";
      }
    },
    seleccionHora2: function() {
      this.horaMax_min = moment(this.horaMin, "HH:mm")
        .add(1, "H")
        .format("HH:mm");
      this.horaMax = this.horaMax_min;
    },
    onFileSelected: function() {
      this.archivo = event.target.files[0];
    },

    toggleAll() {
      if (this.selected.length) this.selected = [];
      else this.selected = this.contactos.slice();
    },
    changeSort(column) {
      if (this.pagination.sortBy === column) {
        this.pagination.descending = !this.pagination.descending;
      } else {
        this.pagination.sortBy = column;
        this.pagination.descending = false;
      }
    }
  }
};
</script>
