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
              <a
                class="btn-small waves-effect waves-light z-depth-0 modal-trigger"
                href="#CrearContactosModal"
              >
                <i class="material-icons left">add</i>Nuevo
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
                <td class="text-xs-left">{{ props.item.celular }} - {{ props.item.horamax }}</td>
                <td class="text-xs-left">{{ props.item.correo }}</td>
                <td class="text-xs-center">
                  <v-btn
                    flat
                    icon
                    color="warning"
                    @click="idMensajeriaEditar=props.item.id;
                    mensaje=props.item.mensaje;
                    campania=props.item.campania;
                    nuevaRespuesta.mensajeriaId=props.item.id
                    listarRespuesta(props.item.id);"
                    href="#modalEditarMensajeria"
                    class="modal-trigger"
                  >
                    <v-icon>edit</v-icon>
                  </v-btn>
                  <v-btn flat icon color="red" @click="deleteMensaje(props.item.id)">
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
    <!-- FORMULARIO CREAR CONTACTO -->
    <div id="CrearContactosModal" class="modal modal-fixed-footer">
      <div class="modal-content">
        <h4 v-text="tituloModal"></h4>
        <form method="POST" v-on:submit.prevent="storeContactos">
          <div class="row">
            <h5>Crear Contacto</h5>
          </div>
          <div class="row">
            <div class="col s12 m12">
              <md-field>
                <label>Selecciona el excel con la lista de tus contactos</label>
                <md-file v-model="nombreArchivo" @change="onFileSelected()"/>
              </md-field>
              <label for="archivo">El archivo debe estar en formato xlsx* y no debe exceder los 2MB</label>
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
        <a @click="storeContactos()" class="modal-close waves-effect waves-green btn-flat">Aceptar</a>
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
      nombreArchivo: "",
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
    listarContactos: function() {
      let me = this;
      const fd = new FormData();
      var a = [{ nombre: "A" }];
      console.log(a);
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

    enviarMensaje: function(mensaje) {
      for (var i = 0; i < this.selected.length; i++) {
        var url = "https://wa.me/" + this.selected[i].celular + "?text=";
        var mensaje = this.prepararMsj(mensaje, this.selected[i].nombre);
        var url = url + mensaje;
        window.open(url, "_blank");
      }
    },

    prepararMsj: function(mensajeSinPreparar, nombreContacto) {
      var mensajePreparado = "";
      var i;
      for (i = 0; i < mensajeSinPreparar.length + 1; i++) {
        if (mensajeSinPreparar.substring(i, i + 1) == " ") {
          mensajePreparado += "%20";
        } else {
          if (mensajeSinPreparar.substring(i, i + 1) == "@") {
            mensajePreparado += nombreContacto;
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
