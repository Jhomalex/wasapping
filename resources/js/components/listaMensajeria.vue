<template>
  <div class="page-container md-layout-row">
    <a class="btn-small waves-effect waves-light z-depth-0 modal-trigger" href="#crearMensajeria">
      <i class="material-icons left">add</i>Nuevo
    </a>
    <div class="row">
      <div class="col s12 m3" v-for="item in todosGrupos" :key="item.id">
        <div class="card teal lighten-1">
          <div class="card-content white-text">
            <span class="card-title" @click="grupoSelected=item.id"><a href="#mostrarMensajeria" class="white-text modal-trigger">{{ item.nombre }}</a></span>
          </div>
          <div class="card-action">
            <a href="#" class="red-text text-lighten-1" @click="eliminarMensaje(item.id)"><i class="fas fa-trash red-text text-lighten-1"></i> Eliminar</a>
          </div>
        </div>
      </div>
    </div>
    <!-- FORMULARIO EDITAR CONTACTO -->
    <div id="crearMensajeria" class="modal modal-fixed-footer modal-grande">
      <div class="modal-content">
        <h4>Crear Mensajería</h4>
        <form method="POST" v-on:submit.prevent="editContacto">
          <div class="row">
            <div class="col s12 m12">
              <input
                id="nombre"
                v-model="nombre"
                type="text"
                placeholder="Escribe el nombre del contacto"
                required
              >
              <label for="nombre">Nombre del contacto</label>
            </div>
            <div class="col s12 m12">
              <v-app>
                <div class="container-fluid">
                  <div class="card-panel">
                    <template>
                      <v-card flat>
                        <v-card-title>
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
                            <td class="text-xs-left">{{ props.item.curso }}</td>
                            <td class="text-xs-left">{{ props.item.celular }}</td>
                            <td class="text-xs-left">{{ props.item.correo }}</td>
                            <td class="text-xs-left">{{ props.item.ubicacion }}</td>
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
              </v-app>
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
        <a @click="storeGrupo()" class="modal-close waves-effect waves-green btn-flat">Aceptar</a>
      </div>
    </div>
    <!-- MENSAJERÍA -->
    <div id="mostrarMensajeria" class="modal modal-fixed-footer modal-grande">
      <div class="modal-content">
        <h4>Enviar mensajes</h4>
        <contactos :grupoId="grupoSelected"></contactos>
      </div>
      <div class="modal-footer">
        <a
          href="#"
          class="modal-close waves-effect waves-red btn-flat"
          @click="limpiarFormulario()"
        >Cerrar</a>
        <a @click="limpiarFormulario()" class="modal-close waves-effect waves-green btn-flat">Aceptar</a>
      </div>
    </div>
  </div>
</template>

<script>
import contactos from "./ContactosFiltrados";
import Swal from "sweetalert2";
export default {
  name: "listaMensajeria",
  components: { contactos },
  data() {
    return {
      selected: [],
      search: "",
      todosGrupos: [],
      todosContactos: [],
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
          text: "curso",
          align: "left",
          sortable: true,
          value: "curso"
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
          text: "Ubicación",
          align: "left",
          sortable: true,
          value: "ubicacion"
        }
      ],
      nombre: "",
      grupoSelected: ""
    };
  },
  created: function() {
    this.listarGrupos();
    this.listarContactos();
  },
  methods: {
    limpiarFormulario: function() {
      this.nombre = "";
      this.selected = [];
    },
    listarGrupos: function() {
      let me = this;
      const fd = new FormData();
      var a = [{ nombre: "" }];
      fd.append("filtros", JSON.stringify(a));
      axios
        .get("/mensajeria/listar")
        .then(function(response) {
          me.todosGrupos = response.data;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    storeGrupo: function() {
      let me = this;
      var a = [];
      for (var i = 0; i < me.selected.length; i++) {
        a.push(me.selected[i].id);
      }
      axios
        .post("/mensajeria/store", {
          nombre: me.nombre,
          descripcion: me.descripcion,
          contactos: a
        })
        .then(function(response) {
          me.limpiarFormulario();
          me.listarGrupos();
          if (response.data == "Ok") {
            M.toast({ html: "Grupo creado con éxito" });
          } else {
            M.toast({ html: "No se pudo guardar." });
          }
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    listarContactos: function() {
      let me = this;
      const fd = new FormData();
      fd.append("filtros", '2');
      axios
        .post("/contactos/listar", fd)
        .then(function(response) {
          me.todosContactos = response.data;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    eliminarMensaje: function(mensajeId){
      let me = this;
      Swal({
        title: "¿Estás seguro de eliminar este grupo?",
        text:
          "Ten en cuenta que se borrará y no podrá recuperarse",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#009688",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, elimínalo",
        cancelButtonText: "Cancelar"
      }).then(result => {
        if (result.value) {
          const fd = new FormData();
          fd.append("mensajeId", mensajeId);
          axios
            .post("/mensajeria/delete", fd)
            .then(function(response) {
              me.listarGrupos();
              if (response.data == "Ok") {
                Swal({
                  position: "top-end",
                  type: "success",
                  title: "Se eliminó el grupo",
                  showConfirmButton: false,
                  timer: 2500
                });
              } else {
                Swal({
                  position: "top-end",
                  type: "error",
                  title:
                    "Ha habido un error al eliminar el grupo, intentalo nuevamente",
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
                  "Ha habido un error al eliminar el grupo, comunícate con nuestro equipo técnico",
                showConfirmButton: false,
                timer: 2500
              });
            });
        }
      });
    },
  }
};
</script>

<style>
.md-app {
  min-height: 350px;
  border: 1px solid rgba(#000, 0.12);
}

.md-drawer {
  width: 230px;
  max-width: calc(100vw - 125px);
}
</style>