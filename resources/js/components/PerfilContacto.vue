<template>
  <div class="container-fluid">
    <div class="card-panel">
      <div class="card-header">
        <h5>Contacto</h5>
      </div>
      <div class="row">
        <div class="col s12 m3 grey lighten-4">
          <div class="col s12 center">
            <img
              :src="'/img/usuarios/boy.png'"
              height="150"
              width="150"
              class="circle responsive-img"
            >
          </div>
          <div class="col s12">
            <b>
              <p style="font-size:12px;margin:0px;" class="grey-text">NOMBRE</p>
            </b>
            <p
              style="font-size:15px;"
              class="blue-grey-text text-darken-4"
              v-text="contacto.nombre"
            ></p>
          </div>
          <div class="col s12">
            <b>
              <p style="font-size:12px;margin:0px;" class="grey-text">DNI</p>
            </b>
            <p style="font-size:15px;" class="blue-grey-text text-darken-4" v-text="contacto.dni"></p>
          </div>
          <div class="col s12">
            <b>
              <p style="font-size:12px;margin:0px;" class="grey-text">RUC</p>
            </b>
            <p style="font-size:15px;" class="blue-grey-text text-darken-4" v-text="contacto.ruc"></p>
          </div>
          <div class="col s12">
            <b>
              <p style="font-size:12px;margin:0px;" class="grey-text">Celular</p>
            </b>
            <p
              style="font-size:15px;"
              class="blue-grey-text text-darken-4"
              v-text="contacto.celular"
            ></p>
          </div>
          <div class="col s12">
            <b>
              <p style="font-size:12px;margin:0px;" class="grey-text">CORREO</p>
            </b>
            <p
              style="font-size:15px;"
              class="blue-grey-text text-darken-4"
              v-text="contacto.correo"
            ></p>
          </div>
          <div class="col s12">
            <b>
              <p style="font-size:12px;margin:0px;" class="grey-text">REFERENCIA</p>
            </b>
            <p
              style="font-size:15px;"
              class="blue-grey-text text-darken-4"
              v-text="contacto.referencia"
            ></p>
          </div>
        </div>
        <div class="col s12 m9">
          <ul id="tabs-swipe-demo" class="tabs">
            <li class="tab col s3">
              <a class="active" href="#test-swipe-1">Actividad</a>
            </li>
          </ul>
          <div>
            <span style="font-size:14px;" class="grey-text text-darken-3">Registrar</span>
            <a
              class="btn-small teal z-depth-0 waves-effect modal-trigger"
              @click="tipoAccion = 1"
              href="#actividadModal"
              style="margin-top:2px"
            >Actividad</a>
          </div>
          <div id="test-swipe-1">
            <v-list two-line>
              <v-list-tile v-for="actividad in todasActividades" :key="actividad.id">
                <v-list-tile-content>
                  <v-list-tile-title v-text="actividad.descripcion"></v-list-tile-title>
                </v-list-tile-content>
                <v-list-tile-action>
                  <div
                    class="font-weight-thin"
                    v-text="convertirDateTimeAFecha(actividad.fechaHoraContactado)"
                  ></div>
                </v-list-tile-action>
                <v-list-tile-action>
                  <a
                    class="dropdown-trigger btn-small btn-floating waves-effect white z-depth-0 modal-trigger"
                    href="#actividadModal"
                    @click="abrirModalActividad(actividad);tipoAccion=2"
                  >
                    <i class="material-icons grey-text text-darken-2">edit</i>
                  </a>
                </v-list-tile-action>
                <v-list-tile-action>
                  <a
                    class="dropdown-trigger btn-small btn-floating waves-effect white z-depth-0"
                    @click="deleteActividad(actividad)"
                  >
                    <i class="material-icons grey-text text-darken-2">delete</i>
                  </a>
                </v-list-tile-action>
              </v-list-tile>

              <v-divider inset></v-divider>
            </v-list>
          </div>

          <!--div id="test-swipe-2">Notas</div-->
        </div>
      </div>
    </div>
    <!-- MODAL ACTIVIDAD -->
    <div id="actividadModal" class="modal modal-fixed-footer">
      <div class="modal-content">
        <h4 v-if="tipoAccion == 1">Crear Actividad</h4>
        <h4 v-if="tipoAccion == 2">Editar Actividad</h4>
        <form method="POST" v-on:submit.prevent="storeActividad">
          <!-- <div class="row">
               <div class="input-field col m6 s12">
                  <select required v-model="tipoActividad">
                     <option disabled>Tipo de actividad</option>
                     <option v-for="option in tipoActividadOptions" :key="option.id" :value="option.id" :selected="option.id===tipoActividad" v-text="option.text"></option>
                  </select>
                  <label for="tipoSangre">Tipo de actividad.</label>
                  <p style="font-size: 12px;">Tipo actividad seleccionado: 
                  <label v-text="tipoActividad"></label></p>
               </div>
          </div>-->
          <div class="row">
            <div class="input-field col m12 s12">
              <textarea
                id="textarea1"
                v-model="descripcion"
                name="descripcion"
                placeholder="Descripción"
                required
                class="materialize-textarea"
              ></textarea>
              <label for="descripcion">Ingrese una descripción.</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col m6 s12">
              <input
                v-model="fechaContactado"
                id="fechaContactado"
                name="fechaContactado"
                required
                type="date"
              >
              <label for="fecha">Fecha contactado.</label>
            </div>
            <div class="input-field col m6 s12">
              <input v-model="horaContactado" id="hora" name="horaContactado" required type="time">
              <label for="hora">Hora contactado.</label>
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
          @click="storeActividad"
          v-if="tipoAccion=='1'"
          class="modal-close waves-effect waves-green btn-flat"
        >Aceptar</a>
        <a
          @click="updateActividad"
          v-if="tipoAccion=='2'"
          class="modal-close waves-effect waves-green btn-flat"
        >Editar</a>
      </div>
    </div>
  </div>
</template>

<script>
import { moment } from "../app";
import Swal from "sweetalert2";
export default {
  props: ["contact"],
  data() {
    return {
      contacto: this.contact[0],
      buscar: "",
      criterio: "",
      todasActividades: [],
      tipoAccion: 0,
      actividad_id: "",
      descripcion: "",
      fechaContactado: "",
      horaContactado: ""
    };
  },

  mounted() {
    this.listarRegistro(this.buscar, this.criterio);
  },

  methods: {
    listarRegistro: function(buscar, criterio) {
      let me = this;
      const fd = new FormData();
      fd.append("contacto_id", me.contacto.id);
      axios
        .post("/actividad/listar", fd)
        .then(function(response) {
          me.todasActividades = response.data;
        })
        .catch(function(error) {
          console.log(error);
        });
    },

    storeActividad: function() {
      let me = this;
      axios
        .post("/actividad/store", {
          descripcion: me.descripcion,
          fechaHoraContactado: me.fechaContactado + " " + me.horaContactado,
          contacto_id: me.contacto.id
        })
        .then(function(response) {
          me.limpiarFormulario();
          if (response.data == "Ok") {
            M.toast({ html: "Actividad creada con éxito" });
          } else {
            M.toast({ html: "No se pudo crear actividad." });
          }
          me.listarRegistro();
        })
        .catch(function(error) {
          console.log(error);
        });
    },

    updateActividad: function() {
      let me = this;
      axios
        .post("/actividad/update", {
          id: me.actividad_id,
          descripcion: me.descripcion,
          fechaHoraContactado: me.fechaContactado + " " + me.horaContactado
        })
        .then(function(response) {
          if (response.data == "Ok") {
            M.toast({ html: "Actividad actualizada con éxito" });
          } else {
            M.toast({ html: "No se pudo actualizar." });
          }
          me.limpiarFormulario();
          me.listarRegistro();
        })
        .catch(function(error) {
          console.log(error);
        });
    },

    limpiarFormulario: function() {
      this.tipoAccion = "";
      this.descripcion = "";
      this.fechaContactado = "";
      this.horaContactado = "";
    },

    abrirModalActividad(actividad) {
      this.descripcion = actividad.descripcion;
      this.fechaContactado = this.convertirDateTimeAFecha(
        actividad.fechaHoraContactado
      );
      this.horaContactado = this.convertirDateTimeAHora(
        actividad.fechaHoraContactado
      );
      this.actividad_id = actividad.id;
    },

    deleteActividad: function(actividad) {
      let me = this;
      Swal({
        title: "¿Estás seguro de eliminar esta actividad?",
        text:
          "Ten en cuenta que se borrará la actividad y no podrá recuperarse",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#009688",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, elimínala",
        cancelButtonText: "Cancelar"
      }).then(result => {
        if (result.value) {
          const fd = new FormData();
          fd.append("id", actividad.id);
          axios
            .post("/actividad/delete", fd)
            .then(function(response) {
              me.listarRegistro();
              if (response.data == "Ok") {
                Swal({
                  position: "top-end",
                  type: "success",
                  title: "Se eliminó la actividad",
                  showConfirmButton: false,
                  timer: 2500
                });
              } else {
                Swal({
                  position: "top-end",
                  type: "error",
                  title:
                    "Ha habido un error al eliminar la actividad, intentalo nuevamente",
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
                  "Ha habido un error al eliminar la actividad, comunícate con nuestro equipo técnico",
                showConfirmButton: false,
                timer: 2500
              });
            });
        }
      });
    },

    convertirDateTimeAHora: function(datetime) {
      return moment(datetime).format("hh:mm");
    },

    convertirDateTimeAFecha: function(datetime) {
      return moment(datetime).format("YYYY-MM-DD");
    }
  }
};
</script>